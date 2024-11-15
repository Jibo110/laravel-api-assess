<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    // Redirect to Google for authentication
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    // Handle callback from Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Check if user already exists
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create a new user
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt('defaultpassword'), // You can manage this differently
                ]);
            }

            // Generate token
            $token = $user->createToken('GoogleToken')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }
}
