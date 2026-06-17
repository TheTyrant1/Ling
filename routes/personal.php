<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Personal\Search as PersonalSearch;

use App\Http\Controllers\Personal\Profile as PersonalProfile;
use App\Http\Controllers\Personal\Notification as PersonalNotification;
use App\Http\Controllers\Personal\Follow as PersonalFollow;

use App\Http\Controllers\Personal\History as PersonalHistory;
use App\Http\Controllers\Personal\History\View as PersonalHistoryView;
use App\Http\Controllers\Personal\History\Like as PersonalHistoryLike;
use App\Http\Controllers\Personal\History\Save as PersonalHistorySave;
use App\Http\Controllers\Personal\History\Comment as PersonalHistoryComment;
use App\Http\Controllers\Personal\History\Post as PersonalHistoryPost;
use App\Http\Controllers\Personal\History\Appeal as PersonalHistoryAppeal;
use App\Http\Controllers\Personal\History\Report as PersonalHistoryReport;

use App\Http\Controllers\Personal\Post as PersonalPost;
use App\Http\Controllers\Personal\Appeal as PersonalAppeal;
use App\Http\Controllers\Personal\Trash\Post as PersonalTrashPost;

Route::get('personal/profile/restore', PersonalProfile\RestoreController::class)
    ->name('personal.profile.restore')
    ->middleware('signed');

Route::prefix('personal')->name('personal.')->middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/search', PersonalSearch\IndexController::class)->name('search.index');

        //User profile
        Route::prefix('profile')->name('profile.')
            ->group(function () {
                Route::get('edit', PersonalProfile\EditController::class)->name('edit');
                Route::patch('{user}', PersonalProfile\UpdateController::class)->name('update');
                Route::delete('{user}', PersonalProfile\DeleteController::class)->name('delete')->middleware('password.confirm');
            });

        //User notifications
        Route::prefix('notifications')->name('notification.')
            ->group(function () {
                Route::get('/', PersonalNotification\IndexController::class)->name('index');
                Route::delete('{notification}', PersonalNotification\DeleteController::class)->name('delete');
            });

        //User following
        Route::prefix('following')->name('following.')
            ->group(function () {
                Route::get('/', PersonalFollow\IndexController::class)->name('index');
            });

        //User history
        Route::prefix('history')->name('history.')
            ->group(function () {
                Route::get('/', PersonalHistory\IndexController::class)->name('index');

                //Views
                Route::prefix('views')->name('view.')
                    ->group(function () {
                        Route::get('/', PersonalHistoryView\IndexController::class)->name('index');
                        Route::get('{post}', PersonalHistoryView\ShowController::class)->name('show');
                        Route::delete('{post}', PersonalHistoryView\DeleteController::class)->name('delete');
                    });

                //Likes
                Route::prefix('likes')->name('like.')
                    ->group(function () {
                        Route::get('/', PersonalHistoryLike\IndexController::class)->name('index');
                        Route::get('{post}', PersonalHistoryLike\ShowController::class)->name('show');
                        Route::delete('{post}', PersonalHistoryLike\DeleteController::class)->name('delete');
                    });

                //Saves
                Route::prefix('saves')->name('save.')
                    ->group(function () {
                        Route::get('/', PersonalHistorySave\IndexController::class)->name('index');
                        Route::get('{post}', PersonalHistorySave\ShowController::class)->name('show');
                        Route::delete('{post}', PersonalHistorySave\DeleteController::class)->name('delete');
                    });

                //Comments
                Route::prefix('comments')->name('comment.')
                    ->group(function () {
                        Route::get('/', PersonalHistoryComment\IndexController::class)->name('index');
                        Route::get('{comment}', PersonalHistoryComment\ShowController::class)->name('show');
                        Route::delete('{comment}', PersonalHistoryComment\DeleteController::class)->name('delete');
                    });

                //Posts
                Route::prefix('posts')->name('post.')
                    ->group(function () {
                        Route::get('/', PersonalHistoryPost\IndexController::class)->name('index');
                        Route::get('{post}', PersonalHistoryPost\ShowController::class)->name('show');
                        Route::get('{post}/edit', PersonalHistoryPost\EditController::class)->name('edit');
                        Route::patch('{post}', PersonalHistoryPost\UpdateController::class)->name('update');
                        Route::delete('{post}', PersonalHistoryPost\DeleteController::class)->name('delete');
                    });

                //Appeals
                Route::prefix('appeals')->name('appeal.')
                    ->group(function () {
                        Route::get('/', PersonalHistoryAppeal\IndexController::class)->name('index');
                        Route::get('{appeal}', PersonalHistoryAppeal\ShowController::class)->name('show');
                        Route::get('{appeal}/edit', PersonalHistoryAppeal\EditController::class)->name('edit');
                        Route::patch('{appeal}', PersonalHistoryAppeal\UpdateController::class)->name('update');
                        Route::delete('{appeal}', PersonalHistoryAppeal\DeleteController::class)->name('delete');
                    });

                //Reports
                Route::prefix('reports')->name('report.')->group(function () {
                    Route::get('/', PersonalHistoryReport\IndexController::class)->name('index');
                });
            });

        //User posts
        Route::prefix('posts')->name('post.')->middleware('status.check')
            ->group(function () {
                Route::get('/', PersonalPost\IndexController::class)->name('index');
                Route::get('/create', PersonalPost\CreateController::class)->name('create');
                Route::get('{post}', PersonalPost\ShowController::class)->name('show');
                Route::post('/', PersonalPost\StoreController::class)->name('store');
                Route::get('{post}/edit', PersonalPost\EditController::class)->name('edit');
                Route::patch('{post}', PersonalPost\UpdateController::class)->name('update');
                Route::delete('{post}', PersonalPost\DeleteController::class)->name('delete');
            });

        //User appeals
        Route::prefix('appeals')->name('appeal.')
            ->group(function () {
                Route::get('/', PersonalAppeal\IndexController::class)->name('index');
                Route::get('/create', PersonalAppeal\CreateController::class)->name('create');
                Route::post('/', PersonalAppeal\StoreController::class)->name('store');
                Route::get('{appeal}', PersonalAppeal\ShowController::class)->name('show');
                Route::get('{appeal}/edit', PersonalAppeal\EditController::class)->name('edit');
                Route::patch('{appeal}', PersonalAppeal\UpdateController::class)->name('update');
                Route::delete('{appeal}', PersonalAppeal\DeleteController::class)->name('delete');
            });

        //User trash
        Route::prefix('trash')->name('trash.')->middleware('status.check')
            ->group(function () {
                //User trashed posts
                Route::prefix('posts')->name('post.')
                    ->group(function () {
                        Route::get('/', PersonalTrashPost\IndexController::class)->name('index');
                        Route::get('{post}', PersonalTrashPost\ShowController::class)->name('show');
                        Route::delete('{post}/force-delete', PersonalTrashPost\ForceDeleteController::class)->name('force.delete');
                        Route::delete('/massive-delete', PersonalTrashPost\MassiveDeleteController::class)->name('massive.delete');
                        Route::post('{post}/restore', PersonalTrashPost\RestoreController::class)->name('restore');
                    });
            });
    });
