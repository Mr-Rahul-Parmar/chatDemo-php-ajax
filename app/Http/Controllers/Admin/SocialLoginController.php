<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class SocialLoginController extends Controller
{
    public function redirectToFB()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function  handleCallbackFB()
    {

        try {

            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('social_id', $user->id)->first();

            if($finduser){

                Auth::login($finduser);

                return redirect("chat-buddy")->with('success', 'You have Successfully loggedin');

            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'social_type'=> 'facebook',
                    'is_email_verified' => 1,
                    'password' => encrypt('my-facebook')
                ]);

                Auth::login($newUser);

                return redirect("chat-buddy")->with('success', 'You have Successfully loggedin');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect('/')->with('error', 'Something went to wrong');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallbackGoogle()
    {
        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::where('social_id', $user->id)->first();
            if($finduser){

                Auth::login($finduser);

                return redirect("chat-buddy")->with('success', 'You have Successfully loggedin');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'social_id'=> $user->id,
                    'social_type'=> 'google',
                    'is_email_verified' => 1,
                    'password' => Hash::make('3rd@123')
                ]);

                Auth::login($newUser);

                return redirect("chat-buddy")->with('success', 'You have Successfully loggedin');
            }

        } catch (Exception $e) {
            //dd($e->getMessage());
            return redirect('/')->with('error', 'Something went to wrong');;
        }
    }

    public function redirectToTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function handleCallbackTwitter()
    {

        try {

            $user = Socialite::driver('twitter')->user();

            $finduser = User::where('social_id', $user->id)->first();
            if($finduser){

                Auth::login($finduser);

                return redirect("chat-buddy")->with('success', 'You have Successfully loggedin');
            }else{
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'social_id'=> $user->id,
                    'social_type'=> 'twitter',
                    'is_email_verified' => 1,
                    'password' => Hash::make('3rd@123')
                ]);

                Auth::login($newUser);

                return redirect("chat-buddy")->with('success', 'You have Successfully loggedin');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect('/')->with('error', 'Something went to wrong');;
        }
    }
}
