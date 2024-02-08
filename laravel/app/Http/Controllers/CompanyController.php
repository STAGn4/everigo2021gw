<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CompanyRepository;
use Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    protected $company_repository;

    public function __construct(CompanyRepository $company_repository)
    {
        $this->company_repository = $company_repository;
    }

    // public function company($company_category_no)
    // {
    //     $company = $this->company_repository->getCompanyDetail($company_category_no);
    //     if (is_null($company)) {
    //         abort(404);
    //     }
    //     return view('company.company', ['company' => $company]);
    // }

    public function index()
    {
        $company = $this->company_repository->getCompanyDetail(config('company.index.category'));
        if (is_null($company)) {
            abort(404);
        }
        return view('company.company',['company' => $company]);
        // return $this->company('2');
    }

    public function recruit(){
        $company = $this->company_repository->getCompanyDetail(config('company.recruit.category'));
        if (is_null($company)) {
            abort(404);
        }
        return view('company.company',['company' => $company]);
        // return $this->company('4');
    }

    public function privacy(){
        $company = $this->company_repository->getCompanyDetail(config('company.privacy.category'));
        if (is_null($company)) {
            abort(404);
        }
        return view('company.company',['company' => $company]);
        // return $this->company('3');
    }

    public function contact(){
        return view('company.contact');
    }

    public function confirm(Request $request){
        $request->validate([
            'email' => 'email|required',
            'title' => 'min:3|required',
            'value' => 'max:500|required'
        ]);
        return view('company.confirm',['contact_data' => $request]);
    }

    public function send(Request $request)
    {
        $request->validate(['email'=>'required|email','title'=>'required','value'=>'required']);
        DB::table('contact')->insert([
            'email' => $request->input('email'),
            'title' => $request->input('title'),
            'value' => $request->input('value'),
        ]);
        Mail::to(config('address.to'))->send(new ContactMail($request));
        $request->session()->regenerateToken();
        return view('company.send',['contact_data' => $request]);
    }
}
