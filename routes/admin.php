<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Search as AdminSearch;
use App\Http\Controllers\Admin\Home as AdminHome;
use App\Http\Controllers\Admin\Post as AdminPost;
use App\Http\Controllers\Admin\Tag as AdminTag;
use App\Http\Controllers\Admin\User as AdminUser;
use App\Http\Controllers\Admin\Comment as AdminComment;
use App\Http\Controllers\Admin\Appeal as AdminAppeal;


Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'admin'])
    ->group(function () {
        //Search
        Route::prefix('search')->name('search.')
            ->group(function () {
                Route::get('/', AdminSearch\IndexController::class)->name('index');
            });

        //Home
        Route::prefix('home')->name('home.')
            ->group(function () {
                Route::get('/', AdminHome\IndexController::class)->name('index');
            });

        //Posts
        Route::prefix('posts')->name('post.')
            ->group(function () {
                Route::get('/', AdminPost\IndexController::class)->name('index');
                Route::get('/create', AdminPost\CreateController::class)->name('create');
                Route::get('{post}', AdminPost\ShowController::class)->name('show');
                Route::post('/', AdminPost\StoreController::class)->name('store');
                Route::get('{post}/edit', AdminPost\EditController::class)->name('edit');
                Route::patch('{post}', AdminPost\UpdateController::class)->name('update');
                Route::delete('{post}', AdminPost\DeleteController::class)->name('delete');
                Route::post('{post}/restore', AdminPost\RestoreController::class)->name('restore');
            });

        //Tags
        Route::prefix('tags')->name('tag.')
            ->group(function () {
                Route::get('/', AdminTag\IndexController::class)->name('index');
                Route::get('/create', AdminTag\CreateController::class)->name('create');
                Route::get('{tag}', AdminTag\ShowController::class)->name('show');
                Route::post('/', AdminTag\StoreController::class)->name('store');
                Route::get('{tag}/edit', AdminTag\EditController::class)->name('edit');
                Route::patch('{tag}', AdminTag\UpdateController::class)->name('update');
                Route::delete('{tag}', AdminTag\DeleteController::class)->name('delete');
                Route::post('{tag}/restore', AdminTag\RestoreController::class)->name('restore');
            });

        //Users
        Route::prefix('users')->name('user.')
            ->group(function () {
                Route::get('/', AdminUser\IndexController::class)->name('index');
                Route::get('/create', AdminUser\CreateController::class)->name('create');
                Route::get('{user}', AdminUser\ShowController::class)->name('show');
                Route::post('/', AdminUser\StoreController::class)->name('store');
                Route::get('{user}/edit', AdminUser\EditController::class)->name('edit');
                Route::patch('{user}', AdminUser\UpdateController::class)->name('update');
                Route::delete('{user}', AdminUser\DeleteController::class)->name('delete');
                Route::post('{user}/restore', AdminUser\RestoreController::class)->name('restore');
            });

        //Comments
        Route::prefix('comments')->name('comment.')
            ->group(function () {
                Route::get('/', AdminComment\IndexController::class)->name('index');
                Route::get('{comment}', AdminComment\ShowController::class)->name('show');
                Route::get('{comment}/edit', AdminComment\EditController::class)->name('edit');
                Route::patch('{comment}', AdminComment\UpdateController::class)->name('update');
                Route::delete('{comment}', AdminComment\DeleteController::class)->name('delete');
                Route::post('{comment}/restore', AdminComment\RestoreController::class)->name('restore');
            });

        //Appeals
        Route::prefix('appeals')->name('appeal.')
            ->group(function () {
                Route::get('/', AdminAppeal\IndexController::class)->name('index');
                Route::get('{appeal}', AdminAppeal\ShowController::class)->name('show');
                Route::get('{appeal}/edit', AdminAppeal\EditController::class)->name('edit');
                Route::patch('{appeal}', AdminAppeal\UpdateController::class)->name('update');
                Route::patch('{appeal}/approve', AdminAppeal\ApproveController::class)->name('approve');
                Route::patch('{appeal}/reject', AdminAppeal\RejectController::class)->name('reject');
                Route::delete('{appeal}', AdminAppeal\DeleteController::class)->name('delete');
            });
    });
