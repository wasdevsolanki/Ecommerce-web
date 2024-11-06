<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Activitylog\Models\Activity;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public  function  login(){
        return view('admin.auth.signin');
    }
    public  function LoginDashboard(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => [
                'required',
                'regex:/^(?=.*[!@#$%^&*()\-_=+{};:,<.>])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9!@#$%^&*()\-_=+{};:,<.>]{8,}$/',
            ],
        ]);
        
        if ($validator->fails()) {
            return redirect()->route('login')->with('toast_error' , __('Password is not matched'));
        }

        $user = User::where('email', $request->email)->first();
        if($user->status == INACTIVE) {
            return redirect()->route('login')->with('toast_error' , __('User is blocked by admin.'));
        }

        $ipAddress = $request->ip();
        // $ipAddress = '175.107.244.178';

        $ch = curl_init("http://ip-api.com/json/{$ipAddress}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response) {
            $data = json_decode($response, true);

            // Check if the user's city is allowed
            if (!$this->isLocationAllowed($data)) {
                return redirect()->route('login')->with('toast_error' , __('Access denied from this location.'));
            }
        }


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,'is_admin'=>1])) {
            if(Auth::user()->is_admin == 1){

                // User Activity
                $causer = auth()->user();
                Activity::create([
                    'log_name' => 'Login',
                    'description' => "logged in from IP: {$request->ip()}",
                    'subject_id' => $causer->id,
                    'subject_type' => get_class($causer),
                    'causer_id' => auth()->id(),
                    'causer_type' => get_class(auth()->user()),
                ]);

                return redirect()->route('admin.dashboard');
            }else{
                Auth::logout();
                return redirect()->back()->with('toast_error', __('Something went wrong!'));
            }
        }
        return  redirect()->route('login')->with('toast_error' , __('Wrong Credential'));
    }

    protected function isLocationAllowed($data)
    {
        $allowedCity = Location::where('city', $data['city'])
            ->where('status', 1)
            ->exists();
            
        return $allowedCity;
    }

    public function logout(){
        if (Auth::check()) {

            // User Activity
            $causer = auth()->user();
            Activity::create([
                'log_name' => 'Logout',
                'description' => "logged out",
                'subject_id' => $causer->id,
                'subject_type' => get_class($causer),
                'causer_id' => auth()->id(),
                'causer_type' => get_class(auth()->user()),
            ]);

            Auth::logout();
            return redirect()->route('login');
        }
        return redirect()->back()->with('error', __('Something went wrong!'));
    }

}
