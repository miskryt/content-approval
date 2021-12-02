<?php

use App\Http\Controllers\AssetController;
use App\Models\Asset;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CampaignController;
use App\Http\Middleware\VerifyCampaignExist;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/users', [UserController::class, 'index'])
    ->middleware(['auth'])
    ->middleware(['can:viewAny, App\Model\User'])
    ->name('users.index');

Route::get('/users/show/{id}', [UserController::class, 'show'])
    ->middleware(['auth'])
    ->middleware('can:view, App\Model\User')
    ->name('users.show');

Route::get('/users/create', [UserController::class, 'create'])
    ->middleware(['auth'])
    ->middleware('can:create, App\Model\User')
    ->name('users.create');

Route::get('/users/edit/{id}', [UserController::class, 'edit'])
    ->middleware(['auth'])
    ->middleware('can:update, App\Model\User')
    ->name('users.edit');

Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])
    ->middleware(['auth'])
    ->middleware('can:delete, App\Model\User')
    ->name('users.destroy');

Route::get('/users/destroy/{id}', function (){
    return redirect()->route('dashboard');
});

Route::post('/users/store', [UserController::class, 'store'])
    ->middleware(['auth'])
    ->middleware('can:create, App\Model\User')
    ->name('users.store');

Route::put('/users/update/{id}', [UserController::class, 'update'])
    ->middleware(['auth'])
    ->middleware(['can:update, App\Model\User'])
    ->name('users.update');



Route::get('/campaigns', [CampaignController::class, 'index'])
    ->middleware(['auth'])
    ->middleware(['can:viewAny, App\Model\Campaign'])
    ->name('campaigns.index');

Route::get('/campaigns/create', [CampaignController::class, 'create'])
    ->middleware(['auth'])
    ->middleware(['can:create, App\Model\Campaign'])
    ->name('campaigns.create');

Route::post('/campaigns/store', [CampaignController::class, 'store'])
    ->middleware(['auth'])
    ->middleware(['can:create, App\Model\Campaign'])
    ->name('campaigns.store');

Route::put('/campaigns/update/{id}', [CampaignController::class, 'update'])
    ->middleware(['auth'])
    ->middleware(['can:update, App\Model\Campaign'])
    ->name('campaigns.update');

Route::get('/campaigns/show/{id}', [CampaignController::class, 'show'])
    ->middleware(['auth'])
    ->middleware('can:view, App\Model\Campaign')
    ->name('campaigns.show');

Route::get('/campaigns/edit/{id}', [CampaignController::class, 'edit'])
    ->middleware(['auth'])
    ->middleware('can:update, App\Model\Campaign')
    ->name('campaigns.edit');

Route::delete('/campaigns/destroy/{id}', [CampaignController::class, 'destroy'])
    ->middleware(['auth'])
    ->middleware('can:delete, App\Model\Campaign')
    ->name('campaigns.destroy');

Route::get('/campaigns/destroy/{id}', function (){
    return redirect()->route('dashboard');
});


Route::get('/campaigns/addmembers/{id}', [CampaignController::class, 'addMembersView'])
    ->middleware(['auth'])
    ->middleware('can:update, App\Model\Campaign')
    ->name('campaigns.addmembers');

Route::post('/campaigns/addmembers/{id}', [CampaignController::class, 'addMembersView'])
    ->middleware(['auth'])
    ->middleware('can:update, App\Model\Campaign')
    ->name('campaigns.addmembers');

Route::post('/campaigns/addmembers/{id}', [CampaignController::class, 'addMembers'])
    ->middleware(['auth'])
    ->middleware('can:update, App\Model\Campaign')
    ->name('campaigns.addmembers');

Route::post('/campaigns/removemembers/{id}', [CampaignController::class, 'removeMembers'])
    ->middleware(['auth'])
    ->middleware('can:update, App\Model\Campaign')
    ->name('campaigns.removemembers');

Route::get('/campaigns/addclients/{id}', [CampaignController::class, 'addClientsView'])
    ->middleware(['auth'])
    ->middleware('can:update, App\Model\Campaign')
    ->name('campaigns.addclients');

Route::post('/campaigns/addclients/{id}', [CampaignController::class, 'addClients'])
    ->middleware(['auth'])
    ->middleware('can:addMembers, App\Model\Campaign')
    ->name('campaigns.addclients');

Route::post('/campaigns/removeclients/{id}', [CampaignController::class, 'removeClients'])
    ->middleware(['auth'])
    ->middleware('can:removeMembers, App\Model\Campaign')
    ->name('campaigns.removeclients');

Route::get('/campaigns/members/assets/show/{id}/{uid}', [CampaignController::class, 'showMemberAssetsView'])
    ->middleware(['auth'])
    ->middleware('can:update, App\Model\Asset')
    ->name('campaigns.showMemberAssets');


Route::get('/campaigns/members/assets/create/{cid}', [CampaignController::class, 'createMemberAssets'])
    ->middleware(['auth'])
    ->middleware('can:create, App\Model\Asset')
    ->name('member.asset.create');

Route::post('/assets/store', [AssetController::class, 'store'])
    ->middleware(['auth'])
    ->middleware(['can:store, App\Model\Asset'])
    ->name('assets.store');

Route::get('/campaigns/assets/edit/{id}/{c_id}/{u_id}', [AssetController::class, 'edit'])
    ->middleware(['auth'])
    ->middleware(['can:edit, App\Model\Asset'])
    ->name('assets.edit');

Route::post('/assets/update/{id}', [AssetController::class, 'update'])
    ->middleware(['auth'])
    ->middleware(['can:update, App\Model\Asset'])
    ->name('assets.update');

Route::delete('/assets/destroy/{id}/{cid}/{uid}', [AssetController::class, 'destroy'])
    ->middleware(['auth'])
    ->middleware('can:delete, App\Model\Asset')
    ->name('assets.destroy');

Route::get('/assets/show/{id}/{cid}', [AssetController::class, 'show'])
    ->middleware(['auth'])
    ->middleware(['can:show, App\Model\Asset'])
    ->name('assets.show');



require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
