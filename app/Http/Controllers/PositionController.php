<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\PositionPosition;
use App\Http\Requests\StorePosition;
use App\Http\Requests\UpdatePosition;
use Illuminate\Http\Request;
use DB;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Position::get();
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
    public function store(StorePosition $request)
    {
        DB::beginTransaction();
        try {
            Position::create([
                'position' => mb_strtoupper($request->input('position')),
            ]);
            DB::commit();
            return redirect()->back()->with('message', 'Position Registered');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $position = Position::find($id);
        $first_position = $this->getRoot($position);
        return view('position.edit',compact('position','first_position'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePosition $request, Position $position)
    {
        DB::beginTransaction();
        try {
            $position->position = mb_strtoupper($request->input('position'));
            $position->save();
            if($request->input('positions'))
            {
                $position->positions()->syncWithoutDetaching($request->input('positions'));
            }
            DB::commit();
            return redirect()->back()->with('message', 'Position Updated');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        //
    }

    public function destroyPivot($id)
    {
        DB::beginTransaction();
        try {
            PositionPosition::find($id)->delete();
            DB::commit();
            return redirect()->back()->with('message', 'Position Deleted');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function getOrganigram()
    {
        $first_position = Position::find(1);
        $positions_array = collect([]);
        $models = collect([]);
        $first_position = $this->getRoot($first_position);
        $this->tree($positions_array, $first_position, $models);
        $position = Position::find(1);
        $objeto = (object) '';
        $objeto->id = (string) $first_position->id;
        $objeto->name = $first_position->position;
        $objeto->color = 'red';
        $objeto->label_color = 'white';
        $positions_array->push($objeto);
        return $positions_array;
    }  

    public function tree($positions_array, Position $position, $models)
    {
        $positions = $position->positions->whereNotIn('position',$models);
        if($positions->isEmpty())
        {
            if($position->upper_position)
            {
                $models->push($position->position);
                $objeto = (object) '';
                $objeto->id = (string) $position->id;
                $objeto->name = $position->position;
                $objeto->parent = (string) $position->upper_position->id;
                $positions_array->push($objeto);
                $this->tree($positions_array, $position->upper_position, $models);
            }else{
                return $positions_array;
            }
        }
        if($positions->isNotEmpty()) //si se encuentran hijas
        {
            $this->tree($positions_array, $positions->last(), $models);
        }
    }

    public function getRoot(Position $position)
    {
        if($position->upper_position)
            return $this->getRoot($position->upper_position);
        return $position;
    }
}
