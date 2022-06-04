<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\PersonDocument;
use App\Models\Status;
use App\Models\Statusable;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContract;
use DB;
use Carbon\Carbon;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = Contract::get();
        $message = 'Data Loaded';
        return view('contracts.list',compact(['contracts','message']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contracts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContract $request)
    {
        DB::beginTransaction();
        try {
            $person = PersonDocument::where('id_number',$request->person)->get()->first()->person;
            $contract = Contract::create([
                'person_id' => $person->id,
                'start_at' => Carbon::create(explode(' - ',$request->range)[0])->toDateString(),
                'due_date' => Carbon::create(explode(' - ',$request->range)[1])->toDateString(),
            ]);
            if($request->payment_switch){
                $contract->incomes()->create([
                    'contract_id'   => $contract->id,
                    'wage'  => $request->wage,
                    'payment'   => $request->payment,
                ]);
            }
            if($request->position_switch){
                $contract->positions()->create([
                    'contract_id'  => $contract->id,
                    'position_id'  => $request->position,
                ]);
            }
            $status = Status::where('weighting',1)->get()->first();
            
            if($person->status->isNotEmpty())
            {
                Statusable::where('status_id',$person->status->last()->pivot->status_id)
                    ->where('statusable_id',$person->status->last()->pivot->statusable_id)
                    ->where('statusable_type',$person->status->last()->pivot->statusable_type)
                    ->get()->first()->delete();
                $person->status()->attach($status);
            }else{
                $person->company->status()->attach($status);
            }
            DB::commit();
            return redirect()->back()->with('message', 'Contract Registered');
        } catch(\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function show($id_number, $contract)
    {
        $contract = Contract::find($contract);
        return view('contracts.edit',compact('id_number','contract'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function edit(Contracts $contracts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contracts $contracts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contracts  $contracts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contracts $contracts)
    {
        //
    }
}
