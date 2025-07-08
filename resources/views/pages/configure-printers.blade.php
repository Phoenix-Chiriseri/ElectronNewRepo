<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electron Point Of Sale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #e91e63 0%, #ad1457 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(233, 30, 99, 0.3);
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 18px;
            opacity: 0.9;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
        }

        .stat-icon.printers {
            background: linear-gradient(135deg, #2196F3, #1976D2);
        }

        .stat-icon.prints {
            background: linear-gradient(135deg, #4CAF50, #388E3C);
        }

        .stat-icon.errors {
            background: linear-gradient(135deg, #FF9800, #F57C00);
        }

        .stat-content h3 {
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-content p {
            color: #666;
            font-size: 14px;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #e91e63;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #e91e63;
            background: white;
            box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.1);
        }

        .btn {
            background: linear-gradient(135deg, #e91e63, #ad1457);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(233, 30, 99, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(233, 30, 99, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, #4CAF50, #388E3C);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-success:hover {
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
        }

        .btn-info {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        }

        .btn-info:hover {
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
        }

        .btn-warning {
            background: linear-gradient(135deg, #FF9800, #F57C00);
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
        }

        .btn-warning:hover {
            box-shadow: 0 6px 20px rgba(255, 152, 0, 0.4);
        }

        .printers-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            grid-column: 1 / -1;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .section-header h2 {
            color: #333;
            font-size: 24px;
            margin: 0;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .actions-row {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-box input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 16px;
            background: #fafafa;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: #e91e63;
            background: white;
            box-shadow: 0 0 0 3px rgba(233, 30, 99, 0.1);
        }

        .search-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 18px;
        }

        .printer-item {
            background: #fafafa;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .printer-item:hover {
            border-color: #e91e63;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .printer-info {
            flex: 1;
        }

        .printer-info h3 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .printer-info p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .printer-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-online {
            background: #d4edda;
            color: #155724;
        }

        .status-offline {
            background: #f8d7da;
            color: #721c24;
        }

        .status-testing {
            background: #fff3cd;
            color: #856404;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 64px;
            margin-bottom: 20px;
            color: #ddd;
        }

        .empty-state h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .test-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            grid-column: 1 / -1;
        }

        .receipt-preview {
            background: #f8f9fa;
            border: 2px dashed #e91e63;
            border-radius: 10px;
            padding: 30px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            max-width: 350px;
            margin: 20px auto;
            text-align: center;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
        }

        .pagination button {
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .pagination button:hover {
            border-color: #e91e63;
            background: #e91e63;
            color: white;
        }

        .pagination button.active {
            background: #e91e63;
            color: white;
            border-color: #e91e63;
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }
            
            .section-header {
                flex-direction: column;
                align-items: stretch;
            }
            
            .actions-row {
                flex-direction: column;
            }
            
            .search-box {
                max-width: none;
            }
            
            .printer-item {
                flex-direction: column;
                align-items: stretch;
                gap: 20px;
            }
            
            .printer-actions {
                justify-content: center;
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-print"></i>Electron Point Of Sale</h1>
            <p>Manage your thermal printers and print receipts directly from your POS system</p>
            <br>
            <a class="btn btn-info" href="{{ route('dashboard') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">Dashboard</span>
            </a>
        </div>
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon printers">
                    <i class="fas fa-print"></i>
                </div>
                <div class="stat-content">
                    <h3 id="printerCount">0</h3>
                    <p>Active Printers</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon prints">
                    <i class="fas fa-receipt"></i>
                </div>
                <div class="stat-content">
                    <h3 id="printCount">0</h3>
                    <p>Prints Today</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon errors">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h3 id="errorCount">0</h3>
                    <p>Print Errors</p>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="card">
                <h2><i class="fas fa-plus-circle"></i> Add New Printer</h2>
                <form id="addPrinterForm">
                    <div class="form-group">
                        <label for="printerName">Printer Name</label>
                        <input type="text" id="printerName" placeholder="e.g., Main Counter Printer" required>
                    </div>
                    <div class="form-group">
                        <label for="printerType">Printer Type</label>
                        <select id="printerType" required>
                            <option value="">Select Printer Type</option>
                            <option value="thermal">Thermal Receipt Printer</option>
                            <option value="network">Network Printer</option>
                            <option value="usb">USB Printer</option>
                            <option value="bluetooth">Bluetooth Printer</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="printerIP">IP Address (Network Printers)</label>
                        <input type="text" id="printerIP" placeholder="192.168.1.100">
                    </div>
                    <div class="form-group">
                        <label for="printerPort">Port</label>
                        <input type="text" id="printerPort" placeholder="9100">
                    </div>
                    <div class="form-group">
                        <label for="paperWidth">Paper Width (mm)</label>
                        <select id="paperWidth">
                            <option value="80">80mm (Standard)</option>
                            <option value="58">58mm (Compact)</option>
                            <option value="110">110mm (Wide)</option>
                        </select>
                    </div>
                    <button type="submit" class="btn">
                        <i class="fas fa-plus"></i> Add Printer
                    </button>
                </form>
            </div>

            <div class="card">
                <h2><i class="fas fa-vial"></i> Quick Test Print</h2>
                <div class="form-group">
                    <label for="testPrinter">Select Printer</label>
                    <select id="testPrinter">
                        <option value="">Choose a printer...</option>
                    </select>
                </div>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <button class="btn btn-success" onclick="testPrint()">
                        <i class="fas fa-print"></i> Test Print
                    </button>
                    <button class="btn btn-info" onclick="printReceipt()">
                        <i class="fas fa-receipt"></i> Print Sample Receipt
                    </button>
                </div>
            </div>
            </div>
            <div class="test-section">
            <h2><i class="fas fa-eye"></i> Sample Receipt Preview</h2>
            <div class="receipt-preview">
                <div style="font-weight: bold;">
                    ================================<br>
                    YOUR BUSINESS NAME<br>
                    ================================<br>
                    TIN: 123456789<br>
                    VAT: VAT123456<br>
                    Phone: +1-234-567-8900<br>
                    --------------------------------<br>
                    Item 1              2   $10.00<br>
                    Item 2              1   $15.00<br>
                    --------------------------------<br>
                    Subtotal:                $25.00<br>
                    VAT (16%):                $4.00<br>
                    Total:                   $29.00<br>
                    ================================<br>
                    Thank you for shopping with us!<br>
                    ================================
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPrinters = [];
        let printCount = 0;
        let errorCount = 0;

        document.getElementById('addPrinterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalHtml = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = '<div class="spinner"></div> Adding...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                const printer = {
                    name: document.getElementById('printerName').value,
                    type: document.getElementById('printerType').value,
                    ip_address: document.getElementById('printerIP').value,
                    port: document.getElementById('printerPort').value,
                    paper_width: document.getElementById('paperWidth').value
                };
                
                addPrinter(printer);
                
                // Reset button
                submitBtn.innerHTML = originalHtml;
                submitBtn.disabled = false;
                
                // Clear form
                this.reset();
                
                showNotification('success', 'Printer added successfully!');
            }, 1000);
        });

        function addPrinter(printer) {
            const newPrinter = {
                id: Date.now(),
                ...printer,
                status: 'online',
                created_at: new Date().toLocaleDateString()
            };
            
            currentPrinters.push(newPrinter);
            updatePrintersList();
            updatePrinterSelect();
            updateStats();
        }

        function updatePrintersList() {
            const container = document.getElementById('printersList');
            
            if (currentPrinters.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-print"></i>
                        <h3>No Printers Configured</h3>
                        <p>Add your first printer using the form above to get started</p>
                    </div>
                `;
                return;
            }
            
            container.innerHTML = currentPrinters.map(printer => `
                <div class="printer-item fade-in">
                    <div class="printer-info">
                        <h3><i class="fas fa-print"></i> ${printer.name}</h3>
                        <p><strong>Type:</strong> ${capitalizeFirst(printer.type)}</p>
                        <p><strong>Address:</strong> ${printer.ip_address || 'Local Connection'}</p>
                        <p><strong>Port:</strong> ${printer.port || 'Default'}</p>
                        <p><strong>Paper Width:</strong> ${printer.paper_width}mm</p>
                        <p><strong>Created:</strong> ${printer.created_at}</p>
                    </div>
                    <div class="printer-actions">
                        <span class="status-badge status-${printer.status}">
                            <i class="fas fa-circle"></i> ${capitalizeFirst(printer.status)}
                        </span>
                        <button class="btn btn-info" onclick="testPrinterConnection(${printer.id})">
                            <i class="fas fa-check"></i> Test
                        </button>
                        <button class="btn btn-warning" onclick="editPrinter(${printer.id})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn" onclick="removePrinter(${printer.id})">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function updatePrinterSelect() {
            const select = document.getElementById('testPrinter');
            select.innerHTML = '<option value="">Choose a printer...</option>';
            
            currentPrinters.forEach(printer => {
                const option = document.createElement('option');
                option.value = printer.id;
                option.textContent = `${printer.name} (${capitalizeFirst(printer.type)})`;
                select.appendChild(option);
            });
        }

        function updateStats() {
            document.getElementById('printerCount').textContent = currentPrinters.length;
            document.getElementById('printCount').textContent = printCount;
            document.getElementById('errorCount').textContent = errorCount;
        }

        function testPrint() {
            const printerId = document.getElementById('testPrinter').value;
            if (!printerId) {
                showNotification('error', 'Please select a printer first.');
                return;
            }
            
            const printer = currentPrinters.find(p => p.id == printerId);
            showNotification('info', `Test print sent to ${printer.name}!`);
            printCount++;
            updateStats();
        }

        function printReceipt() {
            const printerId = document.getElementById('testPrinter').value;
            if (!printerId) {
                showNotification('error', 'Please select a printer first.');
                return;
            }
            
            const printer = currentPrinters.find(p => p.id == printerId);
            
            // Create print window
            const receiptContent = document.querySelector('.receipt-preview').innerHTML;
            const printWindow = window.open('', '', 'width=350,height=700');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Receipt Print</title>
                        <style>
                            body { 
                                font-family: 'Courier New', monospace; 
                                font-size: 12px; 
                                margin: 10px; 
                                padding: 20px;
                            }
                            @page { size: 80mm; margin: 0; }
                            @media print {
                                body { margin: 0; padding: 10px; }
                            }
                        </style>
                    </head>
                    <body>${receiptContent}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
            
            showNotification('success', `Receipt printed on ${printer.name}!`);
            printCount++;
            updateStats();
        }

        function testPrinterConnection(printerId) {
            const printer = currentPrinters.find(p => p.id === printerId);
            printer.status = 'testing';
            updatePrintersList();
            
            showNotification('info', `Testing connection to ${printer.name}...`);
            
            setTimeout(() => {
                printer.status = Math.random() > 0.2 ? 'online' : 'offline';
                updatePrintersList();
                
                if (printer.status === 'online') {
                    showNotification('success', `Connection test successful for ${printer.name}!`);
                } else {
                    showNotification('error', `Connection failed for ${printer.name}!`);
                    errorCount++;
                    updateStats();
                }
            }, 2000);
        }

        function editPrinter(printerId) {
            const printer = currentPrinters.find(p => p.id === printerId);
            showNotification('info', `Edit functionality for ${printer.name} would open here.`);
        }

        function removePrinter(printerId) {
            const printer = currentPrinters.find(p => p.id === printerId);
            if (confirm(`Are you sure you want to remove "${printer.name}"?`)) {
                currentPrinters = currentPrinters.filter(p => p.id !== printerId);
                updatePrintersList();
                updatePrinterSelect();
                updateStats();
                showNotification('success', `${printer.name} removed successfully!`);
            }
        }

        function exportPrinters() {
            showNotification('info', 'PDF export functionality would be implemented here.');
        }

        function capitalizeFirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function showNotification(type, message) {
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 10px;
                color: white;
                font-weight: 600;
                z-index: 1000;
                animation: slideIn 0.3s ease;
            `;
            
            const colors = {
                success: '#4CAF50',
                error: '#f44336',
                info: '#2196F3',
                warning: '#FF9800'
            };
            
            notification.style.backgroundColor = colors[type];
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const printerItems = document.querySelectorAll('.printer-item');
            
            printerItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(searchTerm) ? 'flex' : 'none';
            });
        });

        // Add CSS for animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        `;
        document.head.appendChild(style);

        // Initialize
        updatePrintersList();
        updateStats();
    </script>
</body>
</html>