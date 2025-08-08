<script src="{{ asset('assets') }}/js/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="reports"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <x-navbars.navs.auth titlePage='Reports'></x-navbars.navs.auth>
        
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-200 border-radius-xl mt-4" style="background: linear-gradient(135deg,rgb(234, 117, 102) 0%,rgb(233, 51, 6) 100%);">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
           
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row mb-4">
                    <div class="col-12">
                        <h4 class="mb-0">Electron Pos Reports</h4>
                        <p class="text-sm mb-0">Generate your reports</p>
                    </div>
                </div>

                <!-- Payment Method Filter -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">Filter by Payment Method</h6>
                                <form id="payment-filter-form">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="global_payment_method" class="form-label">Select Payment Method:</label>
                                                <div class="position-relative">
                                                    <select id="global_payment_method" class="form-control" style="border: 2px solid #141618ff; border-radius: 6px; padding: 8px 12px; padding-right: 40px; appearance: none; background-color: white;">
                                                        <option value="">All Payment Methods</option>
                                                        @if(isset($paymentMethods))
                                                            @foreach($paymentMethods as $method)
                                                                <option value="{{ $method->id }}">{{ $method->payment_name }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="cash">Cash</option>
                                                            <option value="card">Card</option>
                                                            <option value="mobile_money">Mobile Money</option>
                                                            <option value="bank_transfer">Bank Transfer</option>
                                                        @endif
                                                    </select>
                                                    <i class="fas fa-chevron-down position-absolute" style="right: 12px; top: 50%; transform: translateY(-50%); pointer-events: none; color: #141618ff;"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="d-grid">
                                                <button type="button" onclick="applyPaymentFilter()" class="btn btn-primary btn-sm">
                                                    Apply Filter
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <small style="color:#000">Select a payment method and click "Apply Filter", then generate any report to see filtered results.</small>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="mb-3">Quick Actions</h6>
                                <div class="d-grid gap-2">
                                    <button onclick="clearPaymentFilter()" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times"></i> Clear Filter
                                    </button>
                                    <button onclick="downloadAllReports()" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> Download All Reports
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <!-- Sales Reports Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-primary">Sales Reports</h5>
                        <hr>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-day fa-3x text-primary mb-3"></i>
                                <h5>Daily Sales Report</h5>
                                <p class="text-sm">Sales breakdown by payment type for today</p>
                                <div class="btn-group" role="group">
                                    <a href="#" onclick="generateReport('daily')" class="btn btn-danger btn-sm">Generate</a>
                                    <a href="#" onclick="downloadReport('daily')" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-week fa-3x text-success mb-3"></i>
                                <h5>Weekly Sales Report</h5>
                                <p class="text-sm">Weekly sales summary and trends</p>
                                <div class="btn-group" role="group">
                                    <a href="#" onclick="generateReport('weekly')" class="btn btn-danger btn-sm">Generate</a>
                                    <a href="#" onclick="downloadReport('weekly')" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-cash-register fa-3x text-warning mb-3"></i>
                                <h5>Z Report</h5>
                                <p class="text-sm">End of day cash register report</p>
                                <div class="btn-group" role="group">
                                    <a href="#" onclick="generateReport('z-report')" class="btn btn-danger btn-sm">Generate</a>
                                    <a href="#" onclick="downloadReport('z-report')" class="btn btn-outline-warning btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-receipt fa-3x text-info mb-3"></i>
                                <h5>Tax Report</h5>
                                <p class="text-sm">Tax summary and calculations</p>
                                <div class="btn-group" role="group">
                                    <a href="#" onclick="generateReport('tax')" class="btn btn-danger btn-sm">Generate</a>
                                    <a href="#" onclick="downloadReport('tax')" class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second row of Sales Reports -->
                <div class="row mb-5">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-alt fa-3x text-danger mb-3"></i>
                                <h5>Yearly Sales Report</h5>
                                <p class="text-sm">Comprehensive yearly sales analysis</p>
                                <div class="btn-group" role="group">
                                    <a href="#" onclick="generateReport('yearly')" class="btn btn-danger btn-sm">Generate</a>
                                    <a href="#" onclick="downloadReport('yearly')" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-times fa-3x text-secondary mb-3"></i>
                                <h5>Quarterly Sales Report</h5>
                                <p class="text-sm">Quarterly sales breakdown and trends</p>
                                <div class="btn-group" role="group">
                                    <a href="#" onclick="generateReport('quarterly')" class="btn btn-danger btn-sm">Generate</a>
                                    <a href="#" onclick="downloadReport('quarterly')" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-3x text-success mb-3"></i>
                                <h5>Employee Shift Report</h5>
                                <p class="text-sm">Employee performance and shift details</p>
                                <div class="btn-group" role="group">
                                    <a href="#" onclick="generateReport('employee-shift')" class="btn btn-danger btn-sm">Generate</a>
                                    <a href="#" onclick="downloadReport('employee-shift')" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Purchase Reports Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-success">Purchase Reports</h5>
                        <hr>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-shopping-cart fa-3x text-success mb-3"></i>
                                <h5>Purchase Orders</h5>
                                <p class="text-sm">View all purchase orders</p>
                                <a href="#" class="btn btn-danger btn-sm">Generate</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                                <h5>Supplier Report</h5>
                                <p class="text-sm">Supplier performance and purchases</p>
                                <a href="#" class="btn btn-danger btn-sm">Generate</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Control Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="text-warning">Stock Control</h5>
                        <hr>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-boxes fa-3x text-dark mb-3"></i>
                                <h5>Inventory Valuation</h5>
                                <p class="text-sm">Stock valuation and profit margins</p>
                                <div class="btn-group" role="group">
                                    <a href="#" onclick="generateReport('inventory-valuation')" class="btn btn-danger btn-sm">Generate</a>
                                    <a href="#" onclick="downloadReport('inventory-valuation')" class="btn btn-outline-dark btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                                <h5>Low Stock Report</h5>
                                <p class="text-sm">Items running low on stock</p>
                                <a href="#" class="btn btn-danger btn-sm">Generate</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-chart-line fa-3x text-info mb-3"></i>
                                <h5>Stock Movement</h5>
                                <p class="text-sm">Track stock in and out movements</p>
                                <a href="#" class="btn btn-danger btn-sm">Generate</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Report Display Area -->
                @if(isset($reportData))
                <div class="row mt-4" id="report-content">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0">{{ $reportTitle }}</h5>
                                    <small class="text-muted">Generated on: {{ date('Y-m-d H:i:s') }}</small>
                                </div>
                                <div>
                                    <button onclick="window.print()" class="btn btn-outline-primary btn-sm me-2">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                    @if(isset($reportType))
                                    <button onclick="downloadPDF('{{ $reportType }}', '{{ $reportTitle }}')" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> Download PDF
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                @include('reports.partials.' . $reportType, ['data' => $reportData])
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>
</x-layout>

<script>
function downloadPDF(reportType, reportTitle) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    doc.setFontSize(16);
    doc.text(reportTitle, 20, 20);
    
    doc.setFontSize(10);
    doc.text('Generated on: ' + new Date().toLocaleString(), 20, 35);
    
    const table = document.querySelector('.table');
    if (table) {
        let yPos = 50;
        const rows = table.querySelectorAll('tr');
        
        rows.forEach((row, index) => {
            const cells = row.querySelectorAll('th, td');
            let xPos = 20;
            
            cells.forEach(cell => {
                doc.setFontSize(index === 0 ? 12 : 10);
                doc.text(cell.textContent.trim(), xPos, yPos);
                xPos += 40;
            });
            yPos += 10;
        });
    }
    
    doc.save(reportType + '-report.pdf');
}

// Payment Method Filtering Functions
function applyPaymentFilter() {
    const paymentMethodSelect = document.getElementById('global_payment_method');
    const paymentMethod = paymentMethodSelect.value;
    const paymentMethodName = paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text;
    
    console.log("paymentMethod", paymentMethod);
    console.log("paymentMethodName", paymentMethodName);
    
    if (!paymentMethod) {
        alert('Please select a payment method first');
        return;
    }
    
    updatePaymentMethod();
    
    // Show success message
    const successMessage = document.createElement('div');
    successMessage.className = 'alert alert-success alert-dismissible fade show mt-3';
    successMessage.innerHTML = `
        <div style="color: white;">
            <i class="fas fa-check-circle"></i> 
            <strong>Filter Applied!</strong> Payment method filter set to <strong>${paymentMethodName}</strong>. 
            Now click "Generate" on any report to see filtered results.
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert after the filter form
    const filterForm = document.getElementById('payment-filter-form');
    if (filterForm) {
        filterForm.after(successMessage);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (successMessage.parentNode) {
                successMessage.remove();
            }
        }, 5000);
    }
}

function updatePaymentMethod() {
    const paymentMethodSelect = document.getElementById('global_payment_method');
    const paymentMethod = paymentMethodSelect.value;
    const paymentMethodName = paymentMethod ? paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text : '';
    
    // Update all report cards to show current filter
    document.querySelectorAll('.card').forEach(card => {
        const existingBadge = card.querySelector('.payment-filter-badge');
        if (existingBadge) {
            existingBadge.remove();
        }
        
        // Only add badges to report cards (cards with Generate buttons)
        if (card.querySelector('a[onclick*="generateReport"]')) {
            if (paymentMethod) {
                const badge = document.createElement('span');
                badge.className = 'badge bg-info payment-filter-badge position-absolute top-0 start-100 translate-middle';
                badge.style.zIndex = '1';
                badge.textContent = paymentMethodName;
                card.style.position = 'relative';
                card.appendChild(badge);
            }
        }
    });
    
    // Update the status message
    const statusMessage = document.getElementById('filter-status');
    if (statusMessage) {
        statusMessage.remove();
    }
    
    if (paymentMethod) {
        const newStatus = document.createElement('div');
        newStatus.id = 'filter-status';
        newStatus.className = 'alert alert-info';
        newStatus.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div style="color: white;">
                    <i class="fas fa-filter"></i> 
                    <strong>Filter Active:</strong> Reports will show data for <strong>${paymentMethodName}</strong> payment method only.
                </div>
                <button onclick="clearPaymentFilter()" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-times"></i> Clear Filter
                </button>
            </div>
        `;
        
        // Insert after the payment method filter row
        const filterRow = document.querySelector('.row.mb-4:has(#payment-filter-form)');
        if (filterRow) {
            filterRow.after(newStatus);
        }
    }
}

function clearPaymentFilter() {
    document.getElementById('global_payment_method').value = '';
    updatePaymentMethod();
    
    // Clear any existing status messages
    const statusMessage = document.getElementById('filter-status');
    if (statusMessage) {
        statusMessage.remove();
    }
    
    // Clear any success messages
    document.querySelectorAll('.alert-success').forEach(alert => {
        if (alert.textContent.includes('Filter Applied')) {
            alert.remove();
        }
    });
    
    // Show cleared message
    const clearedMessage = document.createElement('div');
    clearedMessage.className = 'alert alert-secondary alert-dismissible fade show';
    clearedMessage.innerHTML = `
        <i class="fas fa-info-circle"></i> 
        <strong>Filter Cleared!</strong> All reports will now show data for all payment methods.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Insert after the filter form
    const filterForm = document.getElementById('payment-filter-form');
    if (filterForm) {
        filterForm.after(clearedMessage);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            if (clearedMessage.parentNode) {
                clearedMessage.remove();
            }
        }, 3000);
    }
    
    console.log('Payment filter cleared');
}

function generateReport(reportType) {
    const paymentMethodSelect = document.getElementById('global_payment_method');
    const paymentMethod = paymentMethodSelect.value;
    const paymentMethodName = paymentMethod ? paymentMethodSelect.options[paymentMethodSelect.selectedIndex].text : '';
    let url;
    
    // Build URL with payment method parameter
    switch(reportType) {
        case 'daily':
            url = '{{ route("reports.daily") }}';
            break;
        case 'weekly':
            url = '{{ route("reports.weekly") }}';
            break;
        case 'yearly':
            url = '{{ route("reports.yearly") }}';
            break;
        case 'quarterly':
            url = '{{ route("reports.quarterly") }}';
            break;
        case 'z-report':
            url = '{{ route("reports.z-report") }}';
            break;
        case 'tax':
            url = '{{ route("reports.tax") }}';
            break;
        case 'employee-shift':
            url = '{{ route("reports.employee-shift") }}';
            break;
        case 'inventory-valuation':
            url = '{{ route("reports.inventory-valuation") }}';
            break;
        default:
            alert('Invalid report type');
            return;
    }
    
    // Add payment method parameter if selected
    if (paymentMethod) {
        url += (url.includes('?') ? '&' : '?') + 'payment_method=' + encodeURIComponent(paymentMethod);
        console.log('Generating report with payment method:', paymentMethod);
        console.log('Final URL:', url);
    }
    
    // Show loading indicator
    const loadingMessage = document.createElement('div');
    loadingMessage.innerHTML = `
        <div class="alert alert-info">
            <i class="fas fa-spinner fa-spin"></i> 
            Generating ${reportType} report${paymentMethod ? ' for payment method: ' + paymentMethodName : ''}...
        </div>
    `;

    // Insert loading message before report content if it exists
    const reportContent = document.getElementById('report-content');
    if (reportContent) {
        reportContent.innerHTML = loadingMessage.innerHTML;
    }
    
    // Scroll to bottom of the page with smooth animation
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });
    
    // Navigate to the report
    window.location.href = url;
}

function downloadAllReports() {
    const paymentMethod = document.getElementById('global_payment_method').value;
    
    if (!paymentMethod) {
        alert('Please select a payment method first');
        return;
    }
    
    const reportTypes = ['daily', 'weekly', 'yearly', 'quarterly', 'z-report', 'tax', 'employee-shift'];
    const today = new Date().toISOString().split('T')[0];
    
    reportTypes.forEach((type, index) => {
        setTimeout(() => {
            const url = `{{ route('reports.download-payment', ['type' => 'TYPE_PLACEHOLDER']) }}`.replace('TYPE_PLACEHOLDER', type) + `?payment_method=${paymentMethod}&date=${today}`;
            window.open(url, '_blank');
        }, index * 1000); // Stagger downloads by 1 second
    });
}

// Individual report download function
function downloadReport(reportType) {
    const paymentMethod = document.getElementById('global_payment_method').value;
    const today = new Date().toISOString().split('T')[0];
    
    if (paymentMethod) {
        // Use payment-specific download route
        const url = `{{ route('reports.download-payment', ['type' => 'TYPE_PLACEHOLDER']) }}`.replace('TYPE_PLACEHOLDER', reportType) + `?payment_method=${paymentMethod}&date=${today}`;
        window.open(url, '_blank');
    } else {
        // Use regular download route
        const url = `{{ route('reports.download', ['type' => 'TYPE_PLACEHOLDER']) }}`.replace('TYPE_PLACEHOLDER', reportType) + `?date=${today}`;
        window.open(url, '_blank');
    }
}
</script>