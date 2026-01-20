<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display user profile.
     */
    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    /**
     * Show the form for editing the user profile.
     */
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    /**
     * Update user profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
            
            $image = $request->file('avatar');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/avatars'), $imageName);
            $validated['avatar'] = 'images/avatars/' . $imageName;
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}
