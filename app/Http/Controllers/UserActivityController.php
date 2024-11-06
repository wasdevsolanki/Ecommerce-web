<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;

class UserActivityController extends Controller
{
    public function index(User $user)
    {
        $activityLogs = Activity::where('causer_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
        return view('user.activity_logs', compact('user', 'activityLogs'));
    }


    public function list()
    {
        $users = User::all();
        return view('admin.pages.user_activity.list', compact('users'));
    }

    public function show(User $user){

        $activityLogs = Activity::where('causer_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('admin.pages.user_activity.activity_logs', compact('user', 'activityLogs'));
    }
}
