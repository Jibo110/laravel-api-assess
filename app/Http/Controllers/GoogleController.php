<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite; // Import Socialite

class GoogleController extends Controller
{
    // Redirect to Google OAuth
    public function redirect()
    {
        return Socialite::driver('google')->redirect(); // Redirect to Google for authentication
    }

    // Handle the callback from Google
    public function callback()
    {
        $user = Socialite::driver('google')->user(); // Get user data from Google

        // Handle the user data (e.g., save to database, create session, etc.)
        // Example:
        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            auth()->login($existingUser); // Log in the user
        } else {
            $newUser = User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'google_id' => $user->getId(),
            ]);
            auth()->login($newUser); // Log in the newly created user
        }

        return redirect()->to('/home'); // Redirect to a protected page after login
    }
}
