<?php
/**
 * Created by PhpStorm.
 * User: xiaowu
 * Date: 2017/7/21
 * Time: 1:04
 */

namespace App\Http\Controllers\Admin;


class HomeController extends Controller
{
    public function index(){
        return view('admin.home.index');
    }
}