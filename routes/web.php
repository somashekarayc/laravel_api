<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup', function (Request $request) {
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'password',
    ];

    if (!Auth::attempt($credentials)) {
        $user = new User();

        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);

        $user->save();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $adminToken = $request->user()->createToken('admin-token', ['create', 'update', 'delete'])->plainTextToken;
            $updateToken = $request->user()->createToken('update-token', ['create', 'update'])->plainTextToken;
            $basicToken = $request->user()->createToken('basic-token')->plainTextToken;


            return [
                'admin' => $adminToken,
                'update' => $updateToken,
                'basic' => $basicToken,
            ];
        }
    }
});
