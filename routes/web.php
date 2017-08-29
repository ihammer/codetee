<?php

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
//Web处理
Route::group(['namespace'=>'Web'],function (){
    Route::get('/', function (){
       dd('谢谢访问！');
    });
    //微信 //->middleware('auth:web')
    Route::get('/auth/weixin', 'WechatController@WechatUrl');
    Route::get('/auth/weixin/callback', 'WechatController@WechatCallback');
});
//后台文件
include_once 'admin.php';
