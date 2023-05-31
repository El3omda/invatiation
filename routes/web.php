<?php

use App\Http\Controllers\InvitesController;
use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'Done';
});
Route::get('/fix', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return 'Done';
});

Route::redirect('/', '/ar');

// About Page
Route::get('/about/{lang}', [PagesController::class, 'about'])->name('aboutPage');

// Contact Page
Route::get('/contact/{lang}', [PagesController::class, 'contact'])->name('contact');

# Create Invite
Route::get('/add/{lang}', [InvitesController::class, 'create']);

# Edit Invite
Route::get('/invite/{link}/edit/{lang}', [InvitesController::class, 'edit'])->name('invEdit');

# Show Invite
Route::get('/{link}/{lang}', [InvitesController::class, 'show'])->name('invShow');

Route::group(['prefix' => '{lang}'], function () {

    // Home Page
    Route::get('/', function () {
        return view('pages.index');
    });


    //-----> Invites <-----//

    # Delete Invite Owner Photo
    Route::get('/photo/{link}/delete', [InvitesController::class, 'destroyPhoto'])->name('destroyPhoto');

    # Store Invite
    Route::post('/invite/store', [InvitesController::class, 'store'])->name('invStore');

    # Edit Invite
    Route::put('/invite/{link}/update', [InvitesController::class, 'update'])->name('invUpdate');

    # Show Invite
    Route::delete('/inv/{link}/delete', [InvitesController::class, 'destroy'])->name('invDelete');

    # Create PDF OF The Invitation
    Route::get('/inv/{link}/pdf', [InvitesController::class, 'createPDF'])->name('invPDF');
    Route::get('/inv/{link}/pdf/show', [InvitesController::class, 'PDF']);

    // Contact Page
    Route::get('/date/{m}/{d}/{y}', [InvitesController::class, 'HijriToJD']);
});
