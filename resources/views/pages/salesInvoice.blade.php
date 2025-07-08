<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .receipt-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .receipt-container:hover {
            transform: translateY(-5px);
        }

        .receipt {
            width: 85mm;
            padding: 0;
            background: white;
            position: relative;
        }

        .receipt-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 15px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .receipt-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
            opacity: 0.1;
        }

        .receipt-header h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
        }

        .receipt-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 15px;
            background: white;
            border-radius: 15px 15px 0 0;
        }

        .receipt-body {
            padding: 20px 15px;
        }

        .receipt-details {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }

        .receipt-details p {
            margin: 6px 0;
            font-size: 12px;
            color: #555;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .receipt-details p strong {
            color: #333;
            font-weight: 600;
        }

        .info-label {
            font-weight: 500;
            color: #667eea;
        }

        .receipt-items {
            margin-bottom: 20px;
        }

        .receipt-items table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .receipt-items th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .receipt-items td {
            padding: 10px 8px;
            font-size: 11px;
            border-bottom: 1px solid #f0f0f0;
            color: #555;
        }

        .receipt-items tr:last-child td {
            border-bottom: none;
        }

        .receipt-items tr:hover {
            background: #f8f9fa;
        }

        .receipt-totals {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }

        .receipt-totals p {
            margin: 8px 0;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .receipt-totals p:last-child {
            font-weight: 700;
            font-size: 14px;
            color: #667eea;
            border-top: 2px solid #667eea;
            padding-top: 8px;
            margin-top: 10px;
        }

        .receipt-totals span {
            font-weight: 600;
            color: #333;
        }

        .receipt-footer {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px dashed #667eea;
            margin-bottom: 20px;
        }

        .receipt-footer p {
            font-size: 13px;
            color: #667eea;
            font-weight: 600;
            margin: 0;
        }

        .hidden-print {
            text-align: center;
            padding: 20px;
            background: white;
        }

        .hidden-print button {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .hidden-print button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .hidden-print button:active {
            transform: translateY(0);
        }

        /* Decorative elements */
        .receipt-header::before {
            content: '🧾';
            font-size: 24px;
            position: absolute;
            top: -10px;
            right: -10px;
            opacity: 0.2;
        }

        /* Print styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            body * {
                visibility: hidden;
            }
            
            .receipt-container, .receipt-container * {
                visibility: visible;
            }
            
            .receipt-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none;
                border-radius: 0;
            }
            
            .hidden-print {
                display: none;
            }
        }

        /* Mobile responsiveness */
        @media (max-width: 480px) {
            .receipt {
                width: 100%;
                max-width: 350px;
            }
            
            body {
                padding: 10px;
            }
        }
    </style>
    <script>
        function printReceipt() {
            window.print();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add subtle animation
            const receipt = document.querySelector('.receipt-container');
            receipt.style.opacity = '0';
            receipt.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                receipt.style.transition = 'all 0.5s ease';
                receipt.style.opacity = '1';
                receipt.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt">
            <div class="receipt-header">
                <h4>{{ $details->name }}</h4>
            </div>
            <div class="receipt-body">
                <div class="receipt-details">
                    <p><span class="info-label">TIN:</span> <strong>{{ $details->tinnumber }}</strong></p>
                    <p><span class="info-label">VAT:</span> <strong>{{ $details->vatnumber }}</strong></p>
                    <p><span class="info-label">Phone:</span> <strong>{{ $details->phone_number }}</strong></p>
                    <p><span class="info-label">Email:</span> <strong>{{ $details->email }}</strong></p>
                    <p><span class="info-label">Payment:</span> <strong>{{ $paymentMethod }}</strong></p>
                    <p><span class="info-label">Invoice #:</span> <strong>{{ $sale->id }}</strong></p>
                    <p><span class="info-label">Date:</span> <strong>{{ date('d/m/y') }}</strong></p>
                </div>
                
                <div class="receipt-items">
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>${{ number_format($item['unitPrice'], 2) }}</td>
                                <td>${{ number_format($item['total'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="receipt-totals">
                    <p><span>Total Excluding VAT:</span> <span>${{ number_format($sale->total - $sale->total * 0.16, 2) }}</span></p>
                    <p><span>VAT Total (16%):</span> <span>${{ number_format($sale->total * 0.16, 2) }}</span></p>
                    <p><span>Sub Total:</span> <span>${{ number_format($sale->total, 2) }}</span></p>
                    <p><span>Amount Paid:</span> <span>${{ number_format($amountPaid, 2) }}</span></p>
                </div>
                
                <div class="receipt-footer">
                    <p>✨ Thank you for shopping with us! ✨</p>
                </div>
            </div>
        </div>
        
        <div class="hidden-print">
            <button onclick="printReceipt()">Print Receipt</button>
        </div>
    </div>
</body>
</html>