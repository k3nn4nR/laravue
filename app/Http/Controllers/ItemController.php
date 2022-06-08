<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Brand;
use App\Models\Status;
use App\Models\Design;
use App\Models\Code;
use App\Http\Requests\StoreItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Events\ItemRegisteredEvent;
use App\Events\ItemUpdatedEvent;

use DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('code')->get();
        return $items;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::with('designs')->get();
        return view('item.create',compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItem $request)
    {
        DB::beginTransaction();
        try {
            $item = Item::create([
                'item' => mb_strtoupper($request->input('item')),
            ]);
            $item->code()->save(new Code(['code' => mb_strtoupper($request->input('code'))]));
            DB::commit();
            broadcast(new ItemRegisteredEvent());
            return response()->json([
                'message' => 'Item Registered',
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
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $code = Code::whereHasMorph(
            'codeable',
            [Item::class],
        )->get()->where('code',$code)->first();
        $item = Item::find($code->codeable_id)->load('code','brands','designs');
        $brands = $item->load('brands.code')->brands;
        $models = $item->load('designs.code')->designs;
        $item = Item::find($code->codeable_id)->load('code');
        return compact('item','brands','models');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit($code)
    {
        return view('item.edit',compact('code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        dd($item);
        broadcast(new ItemUpdatedEvent());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }

    public function designIndex()
    {

    }
    
    public function designStore()
    {

    }
    
    public function designUpdate()
    {

    }
    
    public function designShow($design)
    {
        $design = Design::find($design);
        return view('item.design.edit',compact('design'));
    }
}
