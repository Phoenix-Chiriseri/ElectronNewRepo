<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class AddPrinterController extends Controller
{
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
 
private function getPrinters()
    {
        $output = [];
        $os = PHP_OS_FAMILY;
        if ($os === 'Windows') {
            $result = shell_exec('wmic printer get name');
            $printers = explode("\n", $result);
            foreach ($printers as $printer) {
                $printer = trim($printer);
                if (!empty($printer) && $printer !== 'Name') {
                    $output[] = $printer;
                }
            }
        } elseif ($os === 'Linux') {
            $result = shell_exec('lpstat -p');
            $printers = explode("\n", $result);
            foreach ($printers as $printer) {
                if (preg_match('/^printer\s+(\S+)/', $printer, $matches)) {
                    $output[] = $matches[1];
                }
            }
        }

        return $output;
    }

    public function showPrinters()
    {
        // Get list of printers
        $printers = $this->getPrinters();
        return view('pages.printers', compact('printers'));
    }

    private function printToPrinter($printerName)
    {
        $os = PHP_OS_FAMILY;
        if ($os === 'Windows') {
            $connector = new WindowsPrintConnector($printerName);
        } elseif ($os === 'Linux') {
            $connector = new FilePrintConnector("/dev/usb/lp0");
        } else {
            throw new Exception('Unsupported OS');
        }

        $printer = new Printer($connector);
        $printer->text("Test Page\n");
        $printer->text("-------------------\n");
        $printer->text("Hello, this is a test print.\n");
        $printer->text("-------------------\n");

        $printer->cut();
        $printer->close();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'connection_mode' => 'required|string',
            'device_id' => 'nullable|string',
            'status' => 'required|string'
        ]);

        // Here you would typically save to database
        // For now, we'll just return success
         Printer::create($validated);
        return redirect()->back()->with('success', 'Printer configured successfully!');
    }
}
?>