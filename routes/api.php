<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\userController;
use App\Http\Controllers\masyarakatController;
use App\Http\Controllers\petugasController;
use App\Http\Controllers\barangController;
use App\Http\Controllers\lelangController;
use App\Http\Controllers\HlelangController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[AuthController::class,'login']);
Route::post('user/add',[userController::class,'store']);
Route::post('user/adds/',[userController::class,'storeMasyarakat']);
Route::post('masyarakat/store',[masyarakatController::class,'store']);


Route::group(['middleware' => ['jwt.verify:admin,petugas,masyarakat']], function() {
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('getuser',[AuthController::class,'getUser']);
    Route::get('login/check',[AuthController::class,'loginCheck']); 
    
    Route::get('user/',[userController::class,'index']);
    Route::get('user/petugas',[userController::class,'onlyPetugas']);
    Route::get('user/all',[userController::class,'getAll']);
    Route::get('user/allid/petugas/{id}',[userController::class,'getIdPetugas']);
    Route::get('user/allid/masyarakat/{id}',[userController::class,'getIdMasyarakat']);
    Route::get('user/allid/petugas/',[userController::class,'getallPetugas']);
    Route::get('user/allid/masyarakat/',[userController::class,'getallMasyarakat']);
    Route::get('user/show/{id}',[userController::class,'show']);


    Route::get('transaksi',[TransaksiController::class,'join']);
    Route::get('transaksi/joinonly/{id}',[TransaksiController::class,'joinonly']);
    
    Route::get('transaksi/{id}',[TransaksiController::class,'selectjoin']);
    Route::delete('transaksi/delete',[TransaksiController::class,'destroy']);

    Route::get('barang',[barangController::class,'index']);
    Route::get('barang/{id}',[barangController::class,'show']);

    Route::get('hlelang',[HlelangController::class,'index']);
    Route::get('hlelang/all',[HlelangController::class,'getAll']);
    Route::get('hlelang/{id}',[HlelangController::class,'show']);
    Route::get('hlelang/id/{id}',[HlelangController::class,'getId']);
    Route::get('hlelang/max/{id}',[HlelangController::class,'maxPenawaran']);

    Route::get('masyarakat',[masyarakatController::class,'index']);
    Route::get('masyarakat/{id}',[masyarakatController::class,'show']);
    Route::get('masyarakat/maxid/{id}',[masyarakatController::class,'maxID']);
    
    Route::get('petugas/',[petugasController::class,'index']);
    Route::get('petugas/{id}',[petugasController::class,'show']);
    Route::get('petugas/maxid/{id}',[petugasController::class,'maxID']);

    Route::get('lelang',[lelangController::class,'index']);
    Route::get('lelang/available',[lelangController::class,'available']);
    Route::get('lelang/{id}',[lelangController::class,'show']);
    Route::put('lelang/update/hargamasyarakat/{id}',[lelangController::class,'updateHargaMasyarakat']);
});

Route::group(['middleware' => ['jwt.verify:admin,masyarakat']], function()
{
    //ROUTE KHUSUS ADMIN DAN MASYARAKAT

    Route::put('masyarakat/update',[masyarakatController::class,'update']);
    Route::delete('masyarakat/delete',[masyarakatController::class,'destroy']);

    Route::delete('user/delete/{id}',[userController::class,'destroy']);
    Route::put('user/update/petugas/{id}',[userController::class,'updatePetugas']);
    Route::put('user/update/masyarakat/{id}',[userController::class,'updateMasyarakat']);

    /* List user, password & level

    admin   adminadmin  admin
    npc     npcnpc      masyarakat
    worker  workerworker petugas

    */
    
});

Route::group(['middleware' => ['jwt.verify:admin,petugas']], function()
{
    //ROUTE KHUSUS ADMIN DAN PETUGAS    
    Route::post('barang/store',[barangController::class,'store']);
    Route::put('barang/update/{id}',[barangController::class,'update']);
    Route::delete('barang/delete/{id}',[barangController::class,'destroy']);

    Route::post('/report',[TransaksiController::class,'report']);

});

Route::group(['middleware' => ['jwt.verify:masyarakat']], function()
{
    //ROUTE KHUSUS MASYARAKAT
    Route::post('hlelang/store',[HlelangController::class,'store']);
    Route::put('hlelang/update',[HlelangController::class,'update']);
    Route::delete('hlelang/delete',[HlelangController::class,'destroy']);
});

Route::group(['middleware' => ['jwt.verify:petugas']], function()
{
    //ROUTE KHUSUS PETUGAS
    Route::post('lelang/store',[lelangController::class,'store']);
    Route::put('lelang/status/{id}',[lelangController::class,'changeStatus']);
    Route::put('lelang/update/{id}',[lelangController::class,'update']);
    Route::delete('lelang/delete/{id}',[lelangController::class,'destroy']);

    Route::post('transaksi/store',[TransaksiController::class,'store']);
    Route::put('transaksi/status/{id}',[TransaksiController::class,'status']);
    Route::put('transaksi/update',[TransaksiController::class,'update']);
    Route::post('transaksi/status/{id}',[TransaksiController::class,'status']);


});

Route::group(['middleware' => ['jwt.verify:admin']], function()
{
    //ROUTE KHUSUS ADMIM

    Route::post('petugas/store',[petugasController::class,'store']);
    Route::put('petugas/update/{id}',[petugasController::class,'update']);
    Route::delete('petugas/delete/{id}',[petugasController::class,'destroy']);
});