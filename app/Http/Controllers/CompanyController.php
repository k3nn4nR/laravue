<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Provider;
use App\Models\Status;
use App\Models\Person;
use App\Models\PersonDocument;
use App\Http\Requests\StoreProvider;
use App\Http\Requests\UpdateCompany;
use DB;

class CompanyController extends Controller
{
    public function getCompanies()
    {
    }
    
    public function getClients()
    {
        $companies = Company::whereHas('contracts')->with('status','id_number')->get();
        $message = "Data Loaded";
        return view('person.client.list',compact(['companies','message']));
    }
    
    public function getProviders()
    {
        $providers = Provider::with('company.id_number','status')->get();
        $message = 'Data Loaded';
        return view('person.provider.list',compact(['providers','message']));
    }

    public function storeCompanies()
    {

    }

    public function storeClients()
    {
        
    }

    public function storeProviders(StoreProvider $request)
    {
        DB::beginTransaction();
        try {
            $person = Person::create([
                'first_surname' => mb_strtoupper($request->input('company')),
                'second_surname' => mb_strtoupper($request->input('company')),
                'name' => mb_strtoupper($request->input('company')),
            ]);
            $person->person_documents()->create([
                'document_type_id' => $request->input('document_type_id'),
                'id_number' => mb_strtoupper($request->input('id_number')),
            ]);
            $company = Company::create([
                'person_id' => $person->id,
                'company' => mb_strtoupper($request->input('company')),
                'acronym' => mb_strtoupper($request->input('acronym')),
            ]);
            $company->provider()->create([]);
            $status = Status::where('weighting',1)->get()->first();
            $company->provider->status()->attach($status);
            DB::commit();
            return redirect()->back()->with('message', 'Company Registered');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function createClients()
    {
        return view('person.client.create');
    }

    public function createProviders()
    {
        return view('person.provider.create');
    }

    public function show($id_number)
    {
        try {
            $company = PersonDocument::where('id_number',$id_number)->get()->first()->company;
            if(!$company)
                return redirect()->back();    
            $documents = $company->load('person.person_documents.document_type')->person->person_documents;
            $contracts = $company->contracts()->withTrashed()->get();
            return view('person.company.edit',compact('company','documents','contracts'));
        } catch(\Exception $e) {
            return redirect()->back();
        }        
    }

    public function update(UpdateCompany $request, Company $company)
    {
        dd($company);
        dd($request->all());
    }
}
