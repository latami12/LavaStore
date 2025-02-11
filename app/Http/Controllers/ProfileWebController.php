<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use App\User;
use Illuminate\Http\Request;
use Hash;

class ProfileWebController extends Controller
{
    public function index()
    {
        $user = User::all();

        return view('profile.index', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'password'  => 'confirmed',
        ]);

        $user = User::where('id', $id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->alamat = $request->alamat;
        $user->umur = $request->umur;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->update();
        // return $this->sendResponse('Success', 'profile anda telah di upgrade', [$user], 200);
        return redirect(route('profile.index'))->with(['Success' => 'Profile DIupdate!']);
    }

    public function destroy($id)
    {
        $profile = User::find($id);
        if (!empty($profile)) {
            $profile->delete();
            return redirect(route('profile.index'))->with(['Success' => 'Profile Dihapus!']);
        }
        return redirect(route('profile.index'))->with(['Error' => 'Profile Ini Memiliki Anak Kategori!']);
    }

    public function show($id)
    {
    }

    public function search(Request $request)
    {

        $search = $request->get('search');
        $user = DB::table('user')->where('name', 'LIKE', '%' . $search . '%')->paginate();

        return view('profile.index', compact('user'));
    }
}
