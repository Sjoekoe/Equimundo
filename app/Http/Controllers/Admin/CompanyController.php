<?php
namespace EQM\Http\Controllers\Admin;

use EQM\Core\Info\Info;
use EQM\Http\Controllers\Controller;
use EQM\Models\Advertising\Companies\AdvertisingCompany;

class CompanyController extends Controller
{
    public function index()
    {
        return view('admin.advertisements.companies.index');
    }

    public function create()
    {
        return view('admin.advertisements.companies.create');
    }

    public function show(AdvertisingCompany $company, Info $info)
    {
        $info->flash([
            'advertising_company' => $company->id()
        ]);
        
        return view('admin.advertisements.companies.show', compact('company'));
    }
}
