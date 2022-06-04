<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaArea;
use App\Http\Requests\StoreArea;
use App\Http\Requests\UpdateArea;
use Illuminate\Http\Request;
use DB;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Area::get();
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
    public function store(StoreArea $request)
    {
        DB::beginTransaction();
        try {
            Area::create([
                'area' => mb_strtoupper($request->input('area')),
            ]);
            DB::commit();
            return redirect()->back()->with('message', 'Area Registered');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $area = Area::find($id);
        $first_area = $this->getRoot($area);
        return view('area.edit',compact('area','first_area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArea $request, Area $area)
    {
        DB::beginTransaction();
        try {
            $area->area = mb_strtoupper($request->input('area'));
            $area->save();
            if($request->input('areas'))
            {
                $area->areas()->syncWithoutDetaching($request->input('areas'));
            }
            if($request->input('positions'))
            {
                $area->positions()->syncWithoutDetaching($request->input('positions'));
            }
            DB::commit();
            return redirect()->back()->with('message', 'Area Registered');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        //
    }

    public function destroyPivot($id)
    {
        dd(AreaArea::find($id));
        DB::beginTransaction();
        try {
            AreaArea::find($id)->delete();
            DB::commit();
            return redirect()->back()->with('message', 'Area Deleted');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    public function getOrganigram()
    {
        $first_area = Area::find(1);
        $areas_array = collect([]);
        $models = collect([]);
        $first_area = $this->getRoot($first_area);
        $this->tree($areas_array, $first_area, $models);
        $area = Area::find(1);
        $objeto = (object) '';
        $objeto->id = (string) $first_area->id;
        $objeto->name = $first_area->area;
        $objeto->color = 'red';
        $objeto->label_color = 'white';
        $areas_array->push($objeto);
        return $areas_array;
    }

    /**
     * @param  $areas_arra \App\Models\Area  $models $limit
     * $areas_array => array of areas un a single array or vector
     * \App\Models\Area father
     */
    public function tree($areas_array, Area $area, $models)
    {

        $areas = $area->areas->whereNotIn('area',$models);
        if($areas->isEmpty())
        {
            if($area->upper_area)
            {
                $models->push($area->area);
                $objeto = (object) '';
                $objeto->id = (string) $area->id;
                $objeto->name = $area->area;
                $objeto->parent = (string) $area->upper_area->id;
                $areas_array->push($objeto);
                $this->tree($areas_array, $area->upper_area, $models);
            }else{
                return $areas_array;
            }
        }
        if($areas->isNotEmpty()) //si se encuentran hijas
        {
            $this->tree($areas_array, $areas->last(), $models);
        }
    }

    public function getRoot(Area $area)
    {
        if($area->upper_area)
            return $this->getRoot($area->upper_area);
        return $area;
    }

    public function positions()
    {

    }
}
