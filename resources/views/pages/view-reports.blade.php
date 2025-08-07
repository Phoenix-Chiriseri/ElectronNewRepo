<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Reports"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Reports</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Report Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Payment Method</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Date Range</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Download Report</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Products Report -->
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Products Report</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span class="text-xs text-secondary">All Products</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span class="text-xs text-secondary">Current</span>
                                                </div>
                                            </td>   
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <a href="{{ route('view-productRpt') }}" class="btn btn-warning btn-sm">View Report</a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Daily Sales Reports by Payment Method -->
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Daily Sales - Cash</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span class="badge bg-success">Cash</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <input type="date" id="daily_cash_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <button onclick="downloadPaymentReport('daily', 'cash', 'daily_cash_date')" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> Download
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Daily Sales - Card</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span class="badge bg-info">Card</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <input type="date" id="daily_card_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <button onclick="downloadPaymentReport('daily', 'card', 'daily_card_date')" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> Download
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Daily Sales - Mobile Money</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span class="badge bg-warning">Mobile Money</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <input type="date" id="daily_mobile_date" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <button onclick="downloadPaymentReport('daily', 'mobile_money', 'daily_mobile_date')" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> Download
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Weekly Sales Reports by Payment Method -->
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Weekly Sales - Cash</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span class="badge bg-success">Cash</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="row g-1">
                                                        <div class="col-6">
                                                            <input type="date" id="weekly_cash_start" class="form-control form-control-sm" value="{{ now()->startOfWeek()->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="date" id="weekly_cash_end" class="form-control form-control-sm" value="{{ now()->endOfWeek()->format('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <button onclick="downloadPaymentReportRange('weekly', 'cash', 'weekly_cash_start', 'weekly_cash_end')" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> Download
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Weekly Sales - Card</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span class="badge bg-info">Card</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="row g-1">
                                                        <div class="col-6">
                                                            <input type="date" id="weekly_card_start" class="form-control form-control-sm" value="{{ now()->startOfWeek()->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="date" id="weekly_card_end" class="form-control form-control-sm" value="{{ now()->endOfWeek()->format('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <button onclick="downloadPaymentReportRange('weekly', 'card', 'weekly_card_start', 'weekly_card_end')" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> Download
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Monthly Sales Reports by Payment Method -->
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Monthly Sales - Cash</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span class="badge bg-success">Cash</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="row g-1">
                                                        <div class="col-6">
                                                            <input type="date" id="monthly_cash_start" class="form-control form-control-sm" value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="date" id="monthly_cash_end" class="form-control form-control-sm" value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <button onclick="downloadPaymentReportRange('monthly', 'cash', 'monthly_cash_start', 'monthly_cash_end')" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> Download
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">Monthly Sales - Card</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <span class="badge bg-info">Card</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="row g-1">
                                                        <div class="col-6">
                                                            <input type="date" id="monthly_card_start" class="form-control form-control-sm" value="{{ now()->startOfMonth()->format('Y-m-d') }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="date" id="monthly_card_end" class="form-control form-control-sm" value="{{ now()->endOfMonth()->format('Y-m-d') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <button onclick="downloadPaymentReportRange('monthly', 'card', 'monthly_card_start', 'monthly_card_end')" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-download"></i> Download
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footers.auth></x-footers.auth>
        </div>
    </main>
    <x-plugins></x-plugins>

    <!-- JavaScript for Payment Method Report Downloads -->
    <script>
        function downloadPaymentReport(reportType, paymentMethod, dateInputId) {
            const date = document.getElementById(dateInputId).value;
            if (!date) {
                alert('Please select a date');
                return;
            }
            
            const url = `/reports/download-payment/${reportType}?payment_method=${paymentMethod}&date=${date}`;
            window.open(url, '_blank');
        }

        function downloadPaymentReportRange(reportType, paymentMethod, startDateId, endDateId) {
            const startDate = document.getElementById(startDateId).value;
            const endDate = document.getElementById(endDateId).value;
            
            if (!startDate || !endDate) {
                alert('Please select both start and end dates');
                return;
            }
            
            if (new Date(startDate) > new Date(endDate)) {
                alert('Start date cannot be after end date');
                return;
            }
            
            const url = `/reports/download-payment/${reportType}?payment_method=${paymentMethod}&start_date=${startDate}&end_date=${endDate}`;
            window.open(url, '_blank');
        }
    </script>

</layout>
