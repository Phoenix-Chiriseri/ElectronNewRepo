<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddPrinterController extends Controller
{
    //screen to add a new printer
    public function addPrinter(){

        return view("pages.add-printer");
    }
}
