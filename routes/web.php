<?php

use App\Models\{
    User,
    Preference,
    Course,
    Permission,
    Image,
    Comment,
    Tag
};
use Illuminate\Support\Facades\Route;

Route::get('/many-to-many-polymorphic', function () {
    // $course = Course::first();
    // Tag::create(['name' => 'tag1', 'color' => 'blue']);
    // Tag::create(['name' => 'tag2', 'color' => 'red']);
    // Tag::create(['name' => 'tag3', 'color' => 'green']);

    // $course->tags()->attach(3);

    // dd($course->tags);

    $tag = Tag::find(1);
    // $tag = Tag::where('name', 'tag3')->first();

    dd($tag->courses);
});

Route::get('/one-to-many-polymorphic', function () {
    // $course = Course::first();

    // $course->comments()->create([
    //     'subject' => 'New Comment 02',
    //     'content' => 'Just any comment'
    // ]);

    // dd($course->comments);

    $comment = Comment::find(1);

    dd($comment->commentable);
});

Route::get('/one-to-one-polymorphic', function () {
    $user = User::first();

    $data = ['path' => 'path/nome-image-02.png'];

    if ($user->image) {
        $user->image()->update($data);
    } else {
        $user->image()->create($data);
    }

    // $user->image->delete();

    dd($user->image->path);
});

Route::get('/many-to-many-pivot', function () {
    $user = User::with('permissions')->find(8);

    // $user->permissions()->attach([
    //     1 => ['active' => false],
    //     3 => ['active' => false],
    // ]);

    echo "<b>{$user->name}</b><br>";
    foreach($user->permissions as $permission) {
        echo "{$permission->name} - {$permission->pivot->active} <br>";
    }
});

Route::get('/many-to-many', function () {
    // dd(Permission::create(['name' => 'menu_03']));
    $user = User::with('permissions')->find(5);

    $permission = Permission::first();
    // $user->permissions()->save($permission);
    // $user->permissions()->saveMany([
    //     Permission::find(1),
    //     Permission::find(3),
    // ]);
    // $user->permissions()->sync([1]);
    // $user->permissions()->attach([3]);
    $user->permissions()->detach([1,3]);

    $user->refresh();

    dd($user->permissions);
});

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
