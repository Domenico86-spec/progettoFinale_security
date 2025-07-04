<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // UNSECURE
        $data = $request->all();

        
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        // SECURE
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        //     'password' => 'nullable|string|min:8|confirmed',
        // ]);
        
        // $user->update([
        //     'name'=> $request->name,
        //     'email'=> $request->email,
        // ]);

        // Se viene fornita una nuova password, la aggiorna (criptandola)
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

         $user->save();

        return redirect()->back()->with('success', 'Profilo aggiornato con successo.');
    }
}
    

