<?php
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\user\homecontroller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::post('/contactstore', [App\Http\Controllers\contactusController::class, 'store'])->name('contact.store');
Route::get('/contactus/{obj_id}', [App\Http\Controllers\contactusController::class, 'delete']);
Route::post('/save-timezone', [App\Http\Controllers\ObjDefController::class, 'saveTimeZone']);
Auth::routes();
Route::middleware('auth','isvisit:admin')->group(function () {
    Route::get('/home/{pObjId}', [App\Http\Controllers\ObjDefController::class, 'getHierarchyAsJson']);
    Route::get('/admin', [App\Http\Controllers\ObjDefController::class, 'getdata'])->name('admin.home');
    Route::post('/objDef/store', [App\Http\Controllers\ObjDefController::class, 'store'])->name('objDef.store');
    Route::post('/objtype/store', [App\Http\Controllers\ObjTypeController::class, 'store'])->name('objtype.store');
    Route::post('/objhierarchy/store', [App\Http\Controllers\ObjHierarchyController::class, 'store'])->name('objhierarchy.store');
    Route::put('/objhierarchy/{id}', [App\Http\Controllers\ObjHierarchyController::class, 'update'])->name('objhierarchy.update');
    Route::get('/items/{obj_id}', [App\Http\Controllers\ObjDefController::class, 'delete']);
    // Route::get('/image/{obj_id}', [App\Http\Controllers\ObjHierarchyController::class, 'delimage']);
    Route::get('/edit/{obj_id}', [App\Http\Controllers\ObjDefController::class, 'ajaxedit']);
    Route::put('/objDef/{id}', [App\Http\Controllers\ObjDefController::class, 'update'])->name('objDef.update');
    Route::get('/image/{obj_id}', [App\Http\Controllers\ObjHierarchyController::class, 'deleteimage']);
    Route::get('/bgimage/{obj_id}', [App\Http\Controllers\ObjHierarchyController::class, 'deletebgimage']);

    Route::get('/get-data/{id}',  [App\Http\Controllers\ObjDefController::class, 'ajax'])->name('get-data');
    Route::get('/career/{obj_id}', [App\Http\Controllers\CareersController::class, 'delete']);
    Route::get('/contactus', [App\Http\Controllers\contactusController::class, 'index']);
    Route::get('/contactedit/{obj_id}', [App\Http\Controllers\contactusController::class, 'edit']);
    Route::get('/contactupdate/{obj_id}', [App\Http\Controllers\contactusController::class, 'update']);

    //------- Profile related modification start -------
    Route::get('/profile', [PasswordController::class, 'index'])->name('profile.edit'); 
    Route::post('/profile/update-password', [PasswordController::class, 'updatePassword'])->name('profile.updatePassword');
    //------- Profile related modification end -------

});


Route::redirect('/', '/admin');










