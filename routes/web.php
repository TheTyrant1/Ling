<?php

use App\Http\Controllers\Web\Search as WebSearch;

use App\Http\Controllers\Web\Post as WebPost;
use App\Http\Controllers\Web\Post\Like as WebPostLike;
use App\Http\Controllers\Web\Post\Save as WebPostSave;
use App\Http\Controllers\Web\Post\Report as WebPostReport;

use App\Http\Controllers\Web\Comment as WebComment;
use App\Http\Controllers\Web\Comment\Like as WebCommentLike;
use App\Http\Controllers\Web\Comment\Report as WebCommentReport;

use App\Http\Controllers\Web\Tag as WebTag;

use App\Http\Controllers\Web\User as WebUser;
use App\Http\Controllers\Web\User\Follow as WebUserFollow;
use App\Http\Controllers\Web\User\Report as WebUserReport;

use Illuminate\Support\Facades\Route;

//Search
Route::get('/search', WebSearch\IndexController::class)->name('search.index');

//Posts
Route::get('/', WebPost\IndexController::class)->name('post.index');

Route::prefix('posts/{post}')->name('post.')
    ->group(function () {
        Route::get('', WebPost\ShowController::class)->name('show');

        //Post activity
        Route::middleware(['auth', 'verified'])
            ->group(function () {
                Route::post('/like', WebPostLike\StoreController::class)->name('like.store');
                Route::post('/save', WebPostSave\StoreController::class)->name('save.store');
                Route::post('/report', WebPostReport\StoreController::class)->name('report.store');
            });
    });

//Posts in one tag
Route::prefix('tags')->name('tag.')
    ->group(function () {
        Route::get('{tag}/posts', WebTag\IndexController::class)->name('index');
    });

//Comment
Route::prefix('comments')->name('comment.')->middleware(['auth', 'verified'])
    ->group(function () {
        Route::post('/', WebComment\StoreController::class)->name('store')->middleware('status.check');
        Route::post('{comment}/like', WebCommentLike\StoreController::class)->name('like.store');
        Route::post('{comment}/report', WebCommentReport\StoreController::class)->name('report.store');
    });


//Users
Route::prefix('users')->name('user.')
    ->group(function () {
        Route::get('{user}', WebUser\ShowController::class)->name('show');

        Route::post('{user}/follow', WebUserFollow\StoreController::class)->name('follow.store');

        Route::post('{user}/report', WebUserReport\StoreController::class)->name('report.store');
    });

require __DIR__ . '/auth.php';
require __DIR__ . '/personal.php';
require __DIR__ . '/admin.php';

