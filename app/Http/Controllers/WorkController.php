<?php

namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\WorkWork;
use App\Models\Workable;
use App\Models\Status;
use App\Models\Statusable;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWork;
use App\Http\Requests\UpdateWork;
use App\Http\Requests\StorePeopleToWork;
use App\Events\WorkRegisteredEvent;
use DB;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $inactives = Work::whereIn('id',Statusable::where('status_id',1)->where('statusable_type','App\Models\Work')->get('statusable_id'))->get();
        $actives = Work::whereIn('id',Statusable::whereIn('status_id',[2,4])->where('statusable_type','App\Models\Work')->get('statusable_id'))->get();
        $in_progress = Work::whereIn('id',Statusable::where('status_id',6)->where('statusable_type','App\Models\Work')->get('statusable_id'))->get();
        $finished = Work::whereIn('id',Statusable::where('status_id',7)->where('statusable_type','App\Models\Work')->get('statusable_id'))->get();
        return compact(['inactives','actives','in_progress','finished']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('work.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWork $request)
    {
        DB::beginTransaction();
        try {
            $status = Status::where('weighting',1)->get()->first();
            if(!$request->input('work_id')){
                $work = Work::create([
                    'work' => mb_strtoupper($request->input('work')),
                ]);
                $work->status()->attach($status);
            }
            if($request->input('work_id')){
                $work = Work::find($request->input('work_id'));
                $work_work = Work::create([
                    'work' => mb_strtoupper($request->input('work')),
                ]);
                $work_work->status()->attach($status);
                WorkWork::create([
                    'work_id'   => $work->id,
                    'works_work_id' => $work_work->id,
                ]);
            }
            broadcast(new WorkRegisteredEvent());
            DB::commit();
            return redirect()->back()->with('message', 'Work Registered');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $work = Work::find($id);
        return view('work.edit',compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function edit(Work $work)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWork $request, Work $work)
    {
        DB::beginTransaction();
        try {
            $work->work = mb_strtoupper($request->input('work'));
            $work->save();
            if($request->input('started_at') && !$work->dates){
                $work->dates()->create([
                    'started_at' => $request->input('started_at'),
                    'due_date' => $request->input('due_date'),
                ]);
            }
            if($request->input('started_at')){
                $work->dates()->update([
                    'started_at' => $request->input('started_at'),
                    'due_date' => $request->input('due_date'),
                ]);
            }
            if($work->status->last()->id != $request->input('status'))
            {
                $status = Status::find($request->input('status'));
                Statusable::where('status_id',$work->status->last()->pivot->status_id)
                    ->where('statusable_id',$work->status->last()->pivot->statusable_id)
                    ->where('statusable_type',$work->status->last()->pivot->statusable_type)
                    ->get()->first()->delete();
                $work->status()->attach($status);
            }
            DB::commit();
            return redirect()->back()->with('message', 'Work Updated');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Work  $work
     * @return \Illuminate\Http\Response
     */
    public function destroy(Work $work)
    {
        //
    }

    public function storePeople(StorePeopleToWork $request)
    {
        DB::beginTransaction();
        try {
            foreach($request->input('people') as $person)
            {
                Workable::create([
                    'work_id'   => $request->input('work_id'),
                    'workable_type' => 'App\Models\Person',
                    'workable_id'   => $person,
                ]);
            }
            DB::commit();
            return redirect()->back()->with('message', 'People added to Work');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}
