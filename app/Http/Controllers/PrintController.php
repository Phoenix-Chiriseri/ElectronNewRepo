<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Illuminate\Support\Facades\Log;

class PrintController extends Controller
{
    public function printReceipt(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric',
            'amountPaid' => 'required|numeric',
            'change' => 'required|numeric',
            'paymentMethod' => 'required|string',
        ]);

        try {
            // Set your printer name here
            $connector = new WindowsPrintConnector('POS-58');
            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("Electron Point Of Sale\n");
            $printer->text(date('Y-m-d H:i:s') . "\n\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("--------------------------------\n");
            $printer->text("Item        Qty   Price   Total\n");
            $printer->text("--------------------------------\n");

            foreach ($data['items'] as $item) {
                $line = sprintf("%-10s %3d %7.2f %7.2f\n",
                    $item['name'],
                    $item['quantity'],
                    $item['unitPrice'],
                    $item['total'] * $item['quantity']
                );
                $printer->text($line);
            }

            $printer->text("--------------------------------\n");
            $printer->setEmphasis(true);
            $printer->text(sprintf("Total:      %7.2f\n", $data['total']));
            $printer->setEmphasis(false);
            $printer->text(sprintf("Amount Paid:%7.2f\n", $data['amountPaid']));
            $printer->text(sprintf("Change:     %7.2f\n", $data['change']));
            $printer->text("Payment:    " . $data['paymentMethod'] . "\n");
            $printer->text("\nThank you for your business!\n\n");
            $printer->cut();
            $printer->close();

            return response()->json(['success' => true, 'message' => 'Receipt printed successfully.']);
        } catch (\Exception $e) {
            Log::error('Print error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to print receipt.'], 500);
        }
    }
}
