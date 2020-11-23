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

    public function update(Request $request)
    {
        $this->validate($request, [
            'password'  => 'confirmed',
        ]);

        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->nomor_telpon = $request->nomor_telpon;
        $user->alamat = $request->alamat;
        $user->tanggal = $request->tanggal;
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->update();
        // return $this->sendResponse('Success', 'profile anda telah di upgrade', [$user], 200);
        return view('profile.edit', compact('user'));
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
}
