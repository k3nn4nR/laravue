<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Person;
use App\Exports\PeopleExport;

class ExportsController extends Controller
{
    public function pdfExport ()
    {
        $pdf = PDF::loadView('exports.people.people_pdf',['people'=> Person::whereHas('contracts')->get()]);
        return $pdf->download('people.pdf');
    }

    public function excelExport()
    {
        return Excel::download(new PeopleExport, 'people.xlsx');
    }
}
