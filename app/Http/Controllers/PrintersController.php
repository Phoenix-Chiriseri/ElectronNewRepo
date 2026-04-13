<?php

namespace App\Http\Controllers;

use App\Models\Printers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrintersController extends Controller
{
    public function index()
    {
        // Get installed windows printers using PowerShell
        $printersOutput = shell_exec('powershell -Command "(Get-CimInstance Win32_Printer).Name"');
        $systemPrinters = array_filter(array_map('trim', explode("\n", $printersOutput)));
        $savedPrinter = Printers::first();
        return view('pages.configure-printers')->with("systemPrinters", $systemPrinters)->with("savedPrinter", $savedPrinter);
    }

    public function store(Request $request)
    {
        $request->validate([
            'printer_name' => 'required|string|max:255',
        ]);
        // Keep only one active printer for simplicity
        Printers::truncate();
        $printer = new Printers();
        $printer->name = $request->printer_name;
        $printer->save();
        return redirect()->back()->with('success', 'Printer saved successfully!');
    }
}
