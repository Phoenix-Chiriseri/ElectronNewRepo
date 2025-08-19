<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use App\Models\Printers;
use Barryvdh\DomPDF\Facade\Pdf;


class AddPrinterController extends Controller
{
    
    public function testPrint()
    {
        $data = [
            'customer' => 'John Doe',
            'items' => [
                ['name' => 'Product A', 'price' => 10],
                ['name' => 'Product B', 'price' => 20],
            ],
            'total' => 30,
        ];

        try {
            $pdf = Pdf::loadView('receipt', $data);
            $pdfPath = storage_path('app/public/receipt.pdf');
            $saved = $pdf->save($pdfPath);

            if ($saved) {
                // Print using SumatraPDF (silent)
                $sumatraPath = 'C:\\SumatraPDF.exe'; // Adjust if installed elsewhere
                $printerName = 'HS-88AI'; // Change to your printer name
                $cmd = '"' . $sumatraPath . '" -print-to "' . $printerName . '" -silent "' . $pdfPath . '"';
                exec($cmd, $output, $resultCode);

                if ($resultCode === 0) {
                    echo "saved and sent to printer";
                } else {
                    echo "saved but print failed";
                }
            } else {
                echo "not saved";
            }
        } catch (\Exception $e) {
            echo "Exception: " . $e->getMessage();
        }
    }
    
    //screen to add a new printer
    public function addPrinter(){
 
        return view("pages.add-printer");
 
    }


    public function printTest(Request $request)
    {
   
      try {
        // Replace 'HS-88AI' with your actual printer name
        $connector = new WindowsPrintConnector("HS-88AI");
        $printer = new Printer($connector);
        $printer->text("*** Test Page ***\nHello from Laravel USB Printer!\n");
        $printer->cut();
        $printer->close();

        return response()->json(['success' => true, 'message' => 'Print job sent.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}
?>