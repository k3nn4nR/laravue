<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\PersonDocument;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Requests\StorePerson;
use App\Http\Requests\UpdatePerson;
use App\Events\PersonRegisteredEvent;
use DB;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = Person::whereHas('person_documents', function ($query) {
            $query->wherein('document_type_id', [1]);
        })->with((['person_documents' => function ($query) {
            $query->wherein('document_type_id', [1]);
        }]))->with('status')->get();
        return $people;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePerson $request)
    {
        DB::beginTransaction();
        try {
            $status = Status::where('weighting',0)->get()->first();
            $person = Person::create([
                'first_surname' => mb_strtoupper($request->input('first_surname')),
                'second_surname' => ($request->input('second_surname')!=null)?mb_strtoupper($request->input('second_surname')):null,
                'name' => mb_strtoupper($request->input('name'))
            ]);
            $person->person_documents()->create([
                'document_type_id' => $request->input('document_type'),
                'id_number' => mb_strtoupper($request->input('id_number')),
            ]);
            $person->status()->attach($status);
            DB::commit();
            broadcast(new PersonRegisteredEvent());
            return response()->json([
                'message' => 'Person Registered',
                'code' => 200,
                'error' => false
            ],201);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
                'error' => false
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show($id_number)
    {
        $person = PersonDocument::where('id_number',$id_number)->get()->first()->person;
        $documents = $person->load('person_documents.document_type')->person_documents;
        $contracts = $person->contracts()->with('incomes','positions')->withTrashed()->get();
        return view('person.edit',compact('person','documents','contracts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePerson $request, Person $person)
    {
        dd($person);
        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
}
