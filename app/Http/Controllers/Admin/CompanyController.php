<?php
namespace EQM\Http\Controllers\Admin;

use EQM\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        return view('admin.advertisements.companies.index');
    }
}
