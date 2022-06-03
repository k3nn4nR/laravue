<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Events\PersonRegisteredEvent;
use App\Http\Requests\StorePerson;
use Illuminate\Http\Request;
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
        return Person::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $person = Person::create([
                'first_surname' => mb_strtoupper($request->input('first_surname')),
                'second_surname' => ($request->input('second_surname')!=null)?mb_strtoupper($request->input('second_surname')):null,
                'name' => mb_strtoupper($request->input('name'))
            ]);
            DB::commit();
            PersonRegisteredEvent::dispatch();
            return response()->json([
                'message' => 'Person Registrada',
                'code' => 200,
                'error' => false
            ], 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'code' => 500,
                'error' => true
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        //
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
    public function update(Request $request, Person $person)
    {
        //
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
