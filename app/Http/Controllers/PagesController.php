<?php

namespace App\Http\Controllers;

use App\Pages;
use App\Blog;
use App\Social;
use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function home()
    {
        $pages = 0;
        $blogs = Blog::all()->reverse();
        return view('index')
            ->with(compact('pages'))
            ->with(compact('blogs'));
    }

    public function home_user(Pages $pages)
    {
        $blogs = Blog::all()->reverse();
        return view('index')
            ->with(compact('pages'))
            ->with(compact('blogs'));
    }

    public function about()
    {
        $pages = 0;
        return view('about', compact('pages'));
    }

    public function about_user(Pages $pages)
    {
        return view('about', compact('pages'));
    }

    public function contact()
    {   
        $pages = '';
        $social = '';
        return view('contact')
         ->with(compact('pages'))
         ->with(compact('social'));
    }

    public function contact_user(Pages $pages)
    {
        $social = Social::where('user_id', $pages->id)->first();
        return view('contact')
         ->with(compact('pages'))
         ->with(compact('social'));
    }

    public function jasa()
    {
        $pages = 0;
        return view('projects.jasa.index', compact('pages'));
    }

    public function jasa_user(Pages $pages)
    {

        return view('projects.jasa.index', compact('pages'));
    }

    public function testimony()
    {
        $pages = 0;
        return view('testimony')
        ->with(compact('pages'));
    }

    public function testimony_user(Pages $pages)
    {
        return view('testimony')
        ->with(compact('pages'));
    }
}
