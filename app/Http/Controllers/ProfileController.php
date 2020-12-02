<?php

namespace App\Http\Controllers;

use Auth;
use Alert;
use App\User;
use Illuminate\Http\Request;
use Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return $this->sendResponse('Succes', 'Ini profile anda', [$user], 200);
        // return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'password'  => 'confirmed',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->alamat = $request->alamat;
        $user->umur = $request->umur;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        // $user->save();

        $user->update();
        return $this->sendResponse('Success', 'profile anda telah di upgrade', [$user], 200);
    }

    
}
