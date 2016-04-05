<?php
namespace EQM\Http\Controllers\Admin;

use EQM\Http\Controllers\Controller;

class AdvertisementController extends Controller
{
    public function index()
    {
        return view('admin.advertisements.index');
    }
}
