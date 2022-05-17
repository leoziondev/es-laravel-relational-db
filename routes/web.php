<?php

use App\Models\Preference;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/one-to-one', function () {
    $user = User::with('preference')->find(2);
    $preference = $user->preference;

    $data = [
        'theme_bg' => '#fff',
    ];

    if ($user->preference) {
        $user->preference->update($data);
    } else {
        // $user->preference()->create($data);

        // Use save method
        $preference = new Preference($data);
        $user->preference()->save($preference);
    }

    // Delete
    // $user->preference->delete();

    $user->refresh();

    dd($user->preference);
});

Route::get('/', function () {
    return view('welcome');
});
