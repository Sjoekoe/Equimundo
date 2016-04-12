<?php
namespace EQM\Http\Controllers\Companies;

use EQM\Core\Info\Info;
use EQM\Http\Controllers\Controller;
use EQM\Models\Companies\Company;

class CompanyController extends Controller
{
    public function show(Info $info, Company $company)
    {
        $info->flash([
            'company' => $company->slug(),
            'latitude' => $company->address()->latitude(),
            'longitude' => $company->address()->longitude(),
        ]);

        return view('companies.show', compact('company'));
    }
}
