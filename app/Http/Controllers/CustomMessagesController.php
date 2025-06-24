<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomMessagesController extends Controller
{
    // public function getContacts()
    // {
    //     $userId = auth()->id();

    //     // Example: get users who have chatted with the current user
    //     $contacts = DB::table('ch_messages')
    //         ->select(DB::raw('IF(from_id = '.$userId.', to_id, from_id) as user_id'))
    //         ->where('from_id', $userId)
    //         ->orWhere('to_id', $userId)
    //         ->groupBy('user_id')
    //         ->get();

    //     // Load actual user info
    //     $users = DB::table('users')
    //         ->whereIn('id', $contacts->pluck('user_id'))
    //         ->get();


    //     dd($users);
    //     return response()->json($users);
    // }
    public function index($id = null)
    {
        $userId = auth()->id();

        $contacts = DB::table('ch_messages')
            ->select(DB::raw('IF(from_id = '.$userId.', to_id, from_id) as user_id'))
            ->where('from_id', $userId)
            ->orWhere('to_id', $userId)
            ->groupBy('user_id')
            ->get();

        $users = DB::table('users')
            ->whereIn('id', $contacts->pluck('user_id'))
            ->get();

        return view('Chatify::pages.app', [
            'id' => $id,
            'contacts' => $users,
            'routeName' => 'user',
        ]);
    }
    public function getContacts()
{
    $userId = auth()->id();

    // Get users who have chatted with the current user
    $contacts = DB::table('ch_messages')
        ->select(DB::raw('IF(from_id = '.$userId.', to_id, from_id) as user_id'))
        ->where('from_id', $userId)
        ->orWhere('to_id', $userId)
        ->groupBy('user_id')
        ->get();

    // Load actual user info
    $users = DB::table('users')
        ->whereIn('id', $contacts->pluck('user_id'))
        ->get();

    // Pass $users to the Blade view
    return view('vendor.Chatify.pages.app', [
        'contacts' => $users ?? collect()
    ]);
}
}
