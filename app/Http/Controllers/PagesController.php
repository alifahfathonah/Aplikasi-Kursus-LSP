<?php

namespace App\Http\Controllers;

use App\Pages;
use App\Blog;
use App\Social;

class PagesController extends Controller
{

    public function home(Pages $pages)
    {
        if ($pages->exists == false) {
            $pages = '';
        }
        
        $blogs = Blog::all()->reverse();
        return view('index')
            ->with(compact('pages'))
            ->with(compact('blogs'));
    }

    public function about(Pages $pages)
    {
        if ($pages->exists == false) {
            $pages = '';
        }
        return view('about', compact('pages'));
    }

    public function contact(Pages $pages)
    {
        if ($pages->exists == false) {
            $pages = '';
            $social = '';
        }else{
            $social = Social::where('user_id', $pages->id)->first();
        }
        return view('contact')
            ->with(compact('pages'))
            ->with(compact('social'));
    }

    public function jasa(Pages $pages)
    {
        if ($pages->exists == false) {
            $pages = '';
        }

        return view('projects.jasa.index', compact('pages'));
    }


    public function testimony(Pages $pages)
    {
        if ($pages->exists == false) {
            $pages = '';
        }
        return view('testimony')
            ->with(compact('pages'));
    }

}
