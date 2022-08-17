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

Route::get('/', function () {
    return redirect('all-post');
});

Route::get('/all-post/{status?}', function ($status = 'publish') {
    
    return Inertia::render('Posts', [
        'status' => $status
    ]);
})->name('allpost');

Route::get('/post/create', function ($id=null) {
        return Inertia::render('AddPosts');   
});

Route::get('/post/{id?}/update', function ($id=null) {
        return Inertia::render('AddPosts', [
            'post' => Posts::find($id),
            'id' => $id
        ]);
}); 

Route::get('/preview', function () {
    return Inertia::render('PreviewPosts');
});
// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
