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


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Keep only one active printer for simplicity
        Printers::truncate();
        
        $printer = new Printers();
        $printer->name = $request->name;
        $printer->save();

        return redirect()->back()->with('success', 'Printer saved successfully!');
    }

    public function printReceipt(Request $request)
    {
        try {
            $printerSettings = Printers::first();
            if (!$printerSettings) {
                return response()->json(['success' => false, 'message' => 'No printer configured.']);
            }

            $connector = new WindowsPrintConnector($printerSettings->name);
            $printer = new Printer($connector);
            
            $items = $request->input('items', []);
            $total = $request->input('total', 0);
            $amountPaid = $request->input('amountPaid', 0);
            $change = $request->input('change', 0);
            
            // Header
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Electron Point Of Sale\n");
            $printer->text("Receipt\n");
            $printer->text(date('Y-m-d H:i:s') . "\n\n");
            
            // Items
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($items as $item) {
                $line = sprintf("%-20s %d x $%.2f\n", substr($item['name'], 0, 20), $item['quantity'], $item['unitPrice']);
                $printer->text($line);
            }
            $printer->text("--------------------------------\n");
            
            // Totals
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text(sprintf("Total: $%.2f\n", $total));
            $printer->text(sprintf("Paid: $%.2f\n", $amountPaid));
            $printer->text(sprintf("Change: $%.2f\n", $change));
            $printer->text("\n");
            
            // Footer
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Thank you for your business!\n");
            
            $printer->cut();
            $printer->close();

            return response()->json(['success' => true, 'message' => 'Print job sent successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function printTest(Request $request)
    {
    
      try {
        $printerSettings = Printers::first();
        if (!$printerSettings) {
            return response()->json(['success' => false, 'message' => 'No printer configured.']);
        }

        $connector = new WindowsPrintConnector($printerSettings->name);
        $printer = new Printer($connector);
        $printer->text("*** Test Page ***\nHello from Laravel Bluetooth Printer!\n");
        $printer->cut();
        $printer->close();

        return response()->json(['success' => true, 'message' => 'Print job sent.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}
?>