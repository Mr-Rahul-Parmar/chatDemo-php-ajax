<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Nexmo\Laravel\Facade\Nexmo;
use Mail;
use App\Mail\NotifyMail;
use RealRashid\SweetAlert\Facades\Alert;


class LoginController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);


        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect("chat-buddy")->with('success', 'You have Successfully loggedin');
        }

        //sweetAlert popupBox
//        Alert::error('Failed', 'Oppes! You have entered invalid credentials');
//        return back();
        return redirect("login")->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function register()
    {
        return view('admin.auth.register');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'retypePassword' => 'required|min:6',
            'avatar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $register = new User();
        $register->name = $request->name;
        $register->email = $request->email;
        if ($request->hasFile('avatar')) {
            $imageName = time() . '.' . $request->avatar->extension();
            $request->avatar->move(public_path('avatars'), $imageName);
            $register->avatar = $imageName;
        }
        if ($request->password == $request->retypePassword) {
            $register->password = Hash::make($request->password);
        } else {
            return redirect()->intended('register')->with('error', 'Password missmatch');
        }

        $register->save();

        return redirect()->intended('login')->withSuccess('Register Successfully');

    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->intended('login')->withSuccess('Logout Successfully');
    }

    public function onlineUser()
    {
        $param['OnlineUsers'] = User::select("*")
            ->whereNotNull('last_seen')
            ->orderBy('last_seen', 'DESC')
            ->paginate(10);

        return view('admin.layouts.partials.left-sidebar', $param);
    }

    public function otpLogin()
    {
        return view('admin.auth.otpLogin');
    }

    public function verifyOtp()
    {
        return view('admin.auth.verification');
    }

    public function requestOtp(Request $request)
    {
        $otp = rand(1000, 9999);
        Log::info("otp = " . $otp);
        $register = new User();
        $register->name = $request->name;
        $register->email = $request->email;
        $register->otp = $otp;
        if ($request->password == $request->retypePassword) {
            $register->password = Hash::make($request->password);
        } else {
            return redirect()->intended('email-verification')->with('error', 'Password missmatch');
        }

        $register->save();

//        $user = User::where('email', '=', $request->email)->update(['otp' => $otp]);;
        $email = $request->email;

        if ($register) {

            $mail_details = [
                'subject' => 'Testing Application OTP',
                'body' => 'Your OTP is : ' . $otp
            ];

            \Mail::to($email)->send(new \App\Mail\EmailVerify($mail_details));

            return view('admin.auth.emailOtpEnter');
//            return response(["status" => 200, "message" => "OTP sent successfully"]);
        } else {
            return redirect()->intended('email-verification')->with('error', 'Something went to wrong');
            //return response(["status" => 401, 'message' => 'Invalid']);
        }
    }


    public function emailVerify()
    {
        return view('admin.auth.emailVerify');
    }

    public function verifyEmailOtp(Request $request)
    {

        $user = User::where([['email', '=', $request->email], ['otp', '=', $request->otp]])->first();
        if ($user) {
            auth()->login($user, true);
            User::where('email', '=', $request->email)->update(['otp' => null, 'email_verified_at' => now()]);
            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            return redirect()->intended('login')->withSuccess('Register Successfully');
//            return response(["status" => 200, "message" => "Success", 'user' => auth()->user(), 'access_token' => $accessToken]);
        } else {
            return redirect()->intended('verify-email-otp')->with('error', 'Something went to wrong');

        }
    }


}
