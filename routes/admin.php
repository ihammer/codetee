<?php
/**
 * Created by PhpStorm.
 * User: xiaowu
 * Date: 2017/7/21
 * Time: 0:27
 * Name: 后台管理
 */
Route::group(['namespace'=>'Admin','prefix'=>'admin'],function (){

    //登陆操作
    Route::get('/login', 'LoginController@index');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');

    //首页
    Route::group(['middleware'=> 'auth.admin:admin'],function (){
        Route::get('/home','HomeController@index');

        //用户管理
        Route::get('/users','UsersController@index');
        Route::get('/users/{user_id}/address','UsersController@address');

        //产品管理
        Route::get('/goods','GoodsController@goods');//款式列表
        Route::get('/goods/create','GoodsController@goodCreate');//创建展示
        Route::post('/goods/store','GoodsController@goodStore');//存储
        Route::get('/goods/{id}/edit','GoodsController@goodEdit');//编辑
        Route::post('/goods/{id}/storeEdit','GoodsController@goodStoreEdit');//更新数据
        Route::get('/goods/{id}/{status}/goodsStatus','GoodsController@goodsStatus');//状态

        Route::get('/color','GoodsController@Color');//款式颜色
        Route::get('/color/create','GoodsController@colorCreate');//创建展示
        Route::post('/color/store','GoodsController@colorStore');//存储
        Route::get('/color/{id}/create','GoodsController@getColorById');//列表
        Route::get('/color/{id}/edit','GoodsController@colorEdit');//编辑
        Route::post('/color/{id}/storeEdit','GoodsController@colorStoreEdit');//更新数据
        Route::get('/color/{id}/delete','GoodsController@colorDelete');//删除

        Route::get('/pattern','GoodsController@pattern');//款式图案
        Route::get('/pattern/create','GoodsController@patternCreate');//创建展示
        Route::post('/pattern/store','GoodsController@patternStore');//存储
        Route::get('/pattern/{id}/edit','GoodsController@patternEdit');//编辑
        Route::post('/pattern/{id}/storeEdit','GoodsController@patternStoreEdit');//更新数据
        Route::get('/pattern/{id}/delete','GoodsController@patternDelete');//删除

        Route::get('/texture','GoodsController@texture');//材质列表
        Route::get('/texture/create','GoodsController@textureCreate');// 创建展示
        Route::post('/texture/store','GoodsController@textureStore');// 存储

        Route::get('/size','GoodsController@size');//尺寸列表
        Route::get('/size/create','GoodsController@sizeCreate');//创建展示
        Route::post('/size/store','GoodsController@sizeStore');//存储

        Route::get('/express','GoodsController@express');//快递列表
        Route::get('/express/create','GoodsController@expressCreate');//创建展示
        Route::post('/express/store','GoodsController@expressStore');//存储

        // 订单管理
        Route::get('/order','OrderController@index');//订单列表
        Route::get('/code','OrderController@QRCode');// 订单二维码列表
        Route::get('/code/{order_no}/see','OrderController@QRCodeContent');// 查看二维码
        Route::get('/code/{id}/edit','OrderController@QRCodeEdit');//二维码修改

        //管理员管理
        Route::get('/admin_users','AdminUsersController@index');
        Route::get('/admin_users/create','AdminUsersController@create');
        Route::post('/admin_users/store','AdminUsersController@store');
        Route::get('/admin_users/{user}/role', 'AdminUsersController@role');
        Route::post('/admin_users/{user}/role', 'AdminUsersController@storeRole');

        // 角色管理
        Route::get('/roles', 'RoleController@index');
        Route::get('/roles/create', 'RoleController@create');
        Route::post('/roles/store', 'RoleController@store');
        Route::get('/roles/{role}/permission', 'RoleController@permission');
        Route::post('/roles/{role}/permission', 'RoleController@storePermission');
        //
        // 权限管理
        Route::get('/permissions', 'PermissionController@index');
        Route::get('/permissions/create', 'PermissionController@create');
        Route::post('/permissions/store', 'PermissionController@store');
    });

});