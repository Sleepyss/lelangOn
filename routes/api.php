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

Route::get('user/',[userController::class,'index']);


Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
Route::post('getuser',[AuthController::class,'getUser']);
Route::get('login/check',[AuthController::class,'loginCheck']);


Route::post('transaksi/store',[TransaksiController::class,'store']);
Route::get('transaksi',[TransaksiController::class,'join']);
Route::get('transaksi/{id}',[TransaksiController::class,'selectjoin']);
Route::put('transaksi/update',[TransaksiController::class,'update']);
Route::delete('transaksi/delete',[TransaksiController::class,'destroy']);

Route::get('barang',[barangController::class,'index']);
Route::get('barang/{id}',[barangController::class,'show']);

Route::get('hlelang',[HlelangController::class,'index']);
Route::get('hlelang/{id}',[HlelangController::class,'show']);

Route::get('masyarakat',[masyarakatController::class,'index']);
Route::get('masyarakat/{id}',[masyarakatController::class,'show']);

Route::get('lelang',[lelangController::class,'index']);
Route::get('lelang/{id}',[lelangController::class,'show']);

Route::group(['middleware' => ['jwt.verify:admin,masyarakat']], function()
{
    //ROUTE KHUSUS ADMIN DAN MASYARAKAT
    Route::post('user/add',[userController::class,'store']);

    Route::post('masyarakat/store',[masyarakatController::class,'store']);
    Route::put('masyarakat/update',[masyarakatController::class,'update']);
    Route::delete('masyarakat/delete',[masyarakatController::class,'destroy']);

    

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
Route::put('lelang/update/{id}',[lelangController::class,'update']);
    Route::delete('lelang/delete/{id}',[lelangController::class,'destroy']);
});

Route::group(['middleware' => ['jwt.verify:admin']], function()
{
    //ROUTE KHUSUS ADMIN
    Route::get('user/show/{id}',[userController::class,'show']);
    Route::put('user/update/{id}',[userController::class,'update']);
    Route::delete('user/delete/{id}',[userController::class,'destroy']);
});