<?php

use App\Models\{
    User,
    Preference,
    Course
};
use Illuminate\Support\Facades\Route;

Route::get('/one-to-many', function () {
    // $course = Course::create(['name' => 'Curso de Laravel']);
    $course = Course::with('modules.lessons')->first();

    echo $course->name . "<br>";
    foreach($course->modules as $module) {
        echo "<li>" . $module->name . "</li>";

        foreach($module->lessons as $lesson) {
            echo "<li>" . $lesson->name . "</li>";
        }
    }

    // return $course;
    // dd($course);

    // $data = [
    //     'name' => 'Módulo 02',
    // ];
    // $course->modules()->create($data);

    // dd($course->modules()->get());
});

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
