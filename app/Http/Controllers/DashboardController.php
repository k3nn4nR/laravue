<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\Work;
use App\Models\Area;
use App\Models\Position;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function people()
    {
        $new_people = Person::where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $total = Person::get()->count();
        $people_count = Person::orderBy('created_at')->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m');
        })->map(function ($item, $key) {
            return $item->count();
        })->values();
        $people_keys = Person::orderBy('created_at')->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m');
        })->keys();
        return compact('total','new_people','people_count','people_keys');
    }

    public function works()
    {
        $new_works = Work::whereDoesntHave('predecessors')->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
        $total = Work::whereDoesntHave('predecessors')->get()->count();
        $works_count = Work::whereDoesntHave('predecessors')->orderBy('created_at')->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m');
        })->map(function ($item, $key) {
            return $item->count();
        })->values();
        $works_keys = Work::whereDoesntHave('predecessors')->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m');
        })->keys();
        return view('dashboard.work',compact('total','new_works','works_count','works_keys'));
    }
}
