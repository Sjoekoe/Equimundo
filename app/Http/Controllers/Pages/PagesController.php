<?php 
namespace HorseStories\Http\Controllers\Pages;
  
use HorseStories\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }
}