<?php
namespace App\Services;

use Auth;
use App\Models\Post;
use App\Models\Newsbars;
use App\Models\User;
use DB;

class MenuService
{
    public function getMenuItems()
    {
        return DB::table('posts')
        ->select([
            'menus.menu_id',
            'menus.status as menu_status',
            'menus.title as menu_title',
            'posts.post_id',
            'posts.title as post_title',
            'posts.status as post_status'
        ])
        ->join('menus', 'menus.post_id', '=', 'posts.post_id')
        ->get();
;
    }
    public function getSubMenuItems()
    {
        return DB::table('posts')
        ->select([
            'submenus.menu_id',
            'submenus.status as submenu_status',
            'submenus.title as submenu_title',
            'posts.post_id',
            'posts.title as post_title',
            'posts.status as post_status'
        ])
        ->join('submenus', 'submenus.post_id', '=', 'posts.post_id')
        ->get();
;
    }
    public function getNews()
    {
        return Newsbars::where('status',1)->get();
    }

    public function getUser()
    {
        return Auth::guard('customer')->user();
    }


    public function getAdminUser()
    {
        return User::where('status',1)->where('type',1)->first();
    }
}
