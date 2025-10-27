<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the user profile settings.
     */
    public function show(): View
    {
        $user = Auth::user();
        $currencies = \App\Models\User::getAvailableCurrencies();
        
        return view('profile.settings', compact('user', 'currencies'));
    }

    /**
     * Update the user's profile settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'preferred_currency' => 'required|string|in:' . implode(',', array_keys(\App\Models\User::getAvailableCurrencies())),
            'timezone' => 'required|string|max:255',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update basic profile information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->preferred_currency = $validated['preferred_currency'];
        $user->timezone = $validated['timezone'];

        // Update password if provided
        if (!empty($validated['password'])) {
            if (empty($validated['current_password']) || !Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The current password is incorrect.',
                ]);
            }
            
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.settings')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the password change form.
     */
    public function showPasswordForm(): View
    {
        return view('profile.password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('profile.settings')->with('success', 'Password updated successfully!');
    }
}