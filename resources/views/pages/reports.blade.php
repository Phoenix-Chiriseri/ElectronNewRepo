<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="reports"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <x-navbars.navs.auth titlePage='Reports'></x-navbars.navs.auth>
        
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-200 border-radius-xl mt-4" style="background: linear-gradient(135deg,rgb(234, 117, 102) 0%,rgb(233, 51, 6) 100%);">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
           <script>
            $(document).ready(function () {
            $('#download-reports').on('click', function () {
            
            const { jsPDF } = window.jspdf;
            html2canvas(document.querySelector("#report-content")).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const pdf = new jsPDF("p", "pt", "a4");
                
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pageWidth - 40;
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                let position = 20;

                pdf.addImage(imgData, "PNG", 20, position, pdfWidth, pdfHeight);
                pdf.save("report.pdf");
                    });
                });
                });
        </script>      
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row mb-4">
                    <div class="col-12">
                        <h4 class="mb-0">Electron Pos Reports</h4>
                        <p class="text-sm mb-0">Generate your reports</p>
                    </div>
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
                                <a href="{{ route('reports.daily') }}" class="btn btn-primary btn-sm">Generate</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-calendar-week fa-3x text-success mb-3"></i>
                                <h5>Weekly Sales Report</h5>
                                <p class="text-sm">Weekly sales summary and trends</p>
                                <a href="{{ route('reports.weekly') }}" class="btn btn-success btn-sm">Generate</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-cash-register fa-3x text-warning mb-3"></i>
                                <h5>Z Report</h5>
                                <p class="text-sm">End of day cash register report</p>
                                <a href="{{ route('reports.z-report') }}" class="btn btn-warning btn-sm">Generate</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-receipt fa-3x text-info mb-3"></i>
                                <h5>Tax Report</h5>
                                <p class="text-sm">Tax summary and calculations</p>
                                <a href="{{ route('reports.tax') }}" class="btn btn-info btn-sm">Generate</a>
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
                                <a href="#" class="btn btn-success btn-sm">Generate</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                                <h5>Supplier Report</h5>
                                <p class="text-sm">Supplier performance and purchases</p>
                                <a href="#" class="btn btn-primary btn-sm">Generate</a>
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
                                <a href="{{ route('reports.inventory-valuation') }}" class="btn btn-dark btn-sm">Generate</a>
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
                                <a href="#" class="btn btn-info btn-sm">Generate</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Report Display Area -->
                @if(isset($reportData))
                <div class="row mt-4" id = "report-content">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">{{ $reportTitle }}</h5>
                                <div>
                                    <button onclick="window.print()" class="btn btn-outline-primary btn-sm me-2">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                    @if(isset($reportType))
                                    <a href="{{ route('reports.download', ['type' => $reportType]) }}" id = "download-reports" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> Download PDF
                                    </a>
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