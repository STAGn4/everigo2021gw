<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyRepository
{
    public function getCompanyDetail($company_category_no)
    {
        return Company::select (
            'company.name',
            'company.value',
        )
            ->where('company.company_category_no', $company_category_no)
            ->first();
    }

    // public function getRecruit()
    // {
    //     return Company::select (
    //         'company.name',
    //         'company.value',
    //         'company.u_stamp as update_date'
    //     )
    //         ->where('company.company_category_no', '4')
    //         ->first();
    // }

    // public function getCompanyInfo()
    // {
    //     return Company::select (
    //         'company.name',
    //         'company.value',
    //         'company.u_stamp as update_date'
    //     )
    //         ->where('company.company_category_no', '2')
    //         ->first();
    // }
}
