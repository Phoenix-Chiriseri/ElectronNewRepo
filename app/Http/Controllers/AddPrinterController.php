<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddPrinterController extends Controller
{
    //screen to add a new printer
    public function addPrinter(){
        return view("pages.add-printer");
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
}
