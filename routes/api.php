<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
/**
 * @name 小程序接口
 * @author  iHammer
 * @description
 *  1、->middleware('auth.wx_user') //鉴定登录
 */
Route::group(['namespace'=>'Applet','prefix'=>'applet'],function (){
//    Route::get('/login', 'LoginController@index');
    //款式
    Route::get('/', 'StyleController@index');//款式 @iHammer 1
    Route::get('/{style}/color', 'StyleController@getColorList');//颜色 @iHammer 1
    Route::get('/{color}/pattern', 'StyleController@getPatternList');//位置 @iHammer 1
    Route::get('/{style}/sizetotexture', 'StyleController@getSizeToTextureList');//尺寸大小 @iHammer 1
    Route::get('/limited', 'StyleController@Limited');///限量款 @iHammer 1

    //用户
    Route::any('/user/auth', 'UserController@AppletAuthUser');//用户登录 @iHammer 1
    Route::get('/user/check', 'UserController@AppletAuthUserCheck');//验证用用户是否登录接口 @iHammer
    Route::get('/user/{user_id}/address', 'UserController@getUserAddress');//收货地址接口 @iHammer 1
    Route::post('/user/{user_id}/address/store', 'UserController@addUserAddress');//添加收货地址接口 @iHammer 1
    Route::get('/user/address/default', 'UserController@SetUserAddressDefault');//设置默认地址 @iHammer  1
    Route::get('/user/address/del', 'UserController@DelUserAddress');//删除收货地址接口 @iHammer 1
    Route::post('/user/address/edit', 'UserController@editUserAddress');//编辑收货地址接口 @iHammer 1
    //订单
    Route::get('/order/list', 'OrderController@orderList');//订单列表接口 @iHammer 1
    Route::any('/order/create', 'OrderController@orderCreate');//生成订单数据 @iHammer 1
    Route::get('/order/{order_id}/info', 'OrderController@orderInfo');//查看订单数据 @iHammer 1
    Route::any('/order/{order_id}/generate', 'OrderController@orderGenerate');//生成下单数据 @iHammer 1
    //其他定义--杂项 predefine
    Route::post('/upload', 'CommonController@UpLoad');//上传接口 @ihammer 1
    Route::get('/region', 'CommonController@regionList');//城市接口（三级联动数据） @iHammer 1
});