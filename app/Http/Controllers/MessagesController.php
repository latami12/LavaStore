<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;

class MessagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // select all user except logged in user
        // $users = User::where('id', '!=', Auth::id())->get();
        // count how many message are unreadfrom the selected user
        // $users = DB::select("select users.id, users.name, users.avatar, users.email, count(is_read) as unread from users LEFT JOIN messages ON users.id = messages.from 
        // and is_read = 0 and messages.to = ". Auth::id(). "
        // where users.id != ". Auth::id() ."
        // group by users.id, users.name, users.avatar, users.email");

        $my_id = Auth::user()->id;

        $from = User::select('users.id', 'users.name', 'users.image')->distinct()
            ->join('messages', 'users.id', '=', 'messages.to')
            ->where('users.id', '!=', $my_id)
            ->where('messages.from', '=', $my_id)->get()->toArray();

        $to = User::select('users.id', 'users.name', 'users.image')->distinct()
            ->join('messages', 'users.id', '=', 'messages.from')
            ->where('users.id', '!=', $my_id)
            ->where('messages.to', '=', $my_id)->get()->toArray();

        $data = array_unique(array_merge($from, $to), SORT_REGULAR);
        $user = array_values($data);

        return $this->sendResponse('Success', 'kontak ada', $user, 200);
    }
    //     return view('home', ['users' => $users]);
    // }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();
        // when click to see message selected user's message will be read, update
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // getting all message for selected user
        // getting those message which is from = Auth::id() and to = user_id OR from = user_id and to = Auth::id()
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->orWhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->get();

        // return view('messages.index', ['messages' => $messages]);
        return $this->sendResponse('Success', 'ada pesan', $messages, 200);
    }

    public function sendMessage(Request $request, $id)
    {
        $from = Auth::id();
        $to = $id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();

        
        // pusher 
        $options = [
            'cluster' => 'ap1',
            'useTLS' => true
        ];
        
        $pusher = new Pusher(
            'c01e3f5990542d7306ec',
            '988d4408bfe6d3a6b357',
            '1116993',
            $options
        );
        
        // $data = ['from' => $from, 'to' => $to]; //sending from and to user id when pressed enter
        $pusher->trigger('my-channel', 'my-event', $data);
        return $this->sendResponse('Success', 'pesan terkirim', $data, 200);
    }
}
