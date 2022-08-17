<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Models\Posts;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{status?}', function ($status = null) {
    return Inertia::render('Posts', [
        // 'canLogin' => Route::has('login'),
        // 'canRegister' => Route::has('register'),
        // 'laravelVersion' => Application::VERSION,
        // 'phpVersion' => PHP_VERSION,
        'status' => $status
    ]);
});

Route::get('/add-post', function ($id=null) {
    
        return Inertia::render('AddPosts');
            
});

// Route::get('/add-post/{id?}', function ($id=null) {
//     if ($id) {
//         return Inertia::render('AddPosts', [
//             'post' => Posts::find($id),
//             'id' => $id
//         ]);
//     } else {
//         return Inertia::render('AddPosts');
//     }
    
// });


Route::get('/preview', function () {
    return Inertia::render('AddPosts');
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
