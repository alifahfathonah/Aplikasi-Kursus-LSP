<?php

namespace App\Http\Controllers;

use App\Pages;
use App\Blog;
use App\Social;
use App\User;

class PagesController extends Controller
{

    public function home(Pages $pages)
    {
        $adminPages = '';
        if ($pages->exists == false) {
            $pages = '';
            $adminPages = User::where('username', 'admin')->first();
        }
        $blogs = Blog::all()->reverse();
        return view('index')
            ->with(compact('adminPages'))
            ->with(compact('pages'))
            ->with(compact('blogs'));
    }

    public function about(Pages $pages)
    {
        $adminPages = '';
        if ($pages->exists == false) {
            $pages = '';
            $adminPages = User::where('username', 'admin')->first();
        }
        return view('about', compact('pages', 'adminPages'));
    }

    public function contact(Pages $pages)
    {
        $adminPages = '';
        if ($pages->exists == false) {
            $pages = '';
            $adminPages = User::where('username', 'admin')->first();
            $social = Social::where('user_id', 1)->first();
        }else{
            $social = Social::where('user_id', $pages->id)->first();
        }
        return view('contact')
            ->with(compact('adminPages'))
            ->with(compact('pages'))
            ->with(compact('social'));
    }

    public function service(Pages $pages)
    {
        $adminPages = '';
        if ($pages->exists == false) {
            $pages = '';
            $adminPages = User::where('username', 'admin')->first();
        }

        return view('projects.jasa.index', compact('pages', 'adminPages'));
    }


    public function testimony(Pages $pages)
    {
        $adminPages = '';
        if ($pages->exists == false) {
            $pages = '';
            $adminPages = User::where('username', 'admin')->first();
        }
        return view('testimony')
            ->with(compact('pages'))
            ->with(compact('adminPages'));
    }

}
