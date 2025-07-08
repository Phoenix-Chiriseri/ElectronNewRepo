<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="All Sales"></x-navbars.navs.auth>
        <script>
            $(document).ready(function () {
                $("#exportSales").on("click", function () {
                    // Clone the printable content
                    var salesTable = $("#salesTable").clone();
                    
                    // Remove any unwanted elements (e.g., buttons, input fields)
                    salesTable.find("button, input").remove();
        
                    // Remove specific columns (edit and delete) from the cloned table
                    salesTable.find('th:nth-child(9), td:nth-child(9), th:nth-child(10), td:nth-child(10)').remove();
        
                    // Convert the content to PDF with landscape orientation
                    html2pdf(salesTable[0], {
                        margin: 10,
                        filename: 'SalesList.pdf',
                        jsPDF: { 
                            orientation: 'landscape' 
                        }
                    });
                });
            });
        </script>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Sales</h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Sales {{$numberOfSales}}</h6>
                            </div>
                            <hr>
                            <button class = "btn btn-info" id="exportSales"><i class = "fa fa-print"></i>Generate PDF</button>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="salesTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Cashier
                                             </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                               Total
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Change
                                             </th>
                                             <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Created At
                                             </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sales as $sale)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-0">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$sale->username}}</h6>
                                                    </div>
                                                </div>
                                            </td>  
                                            <td>
                                                <div class="d-flex px-2 py-0">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$sale->total}}</h6>
                                                    </div>
                                                </div>
                                            </td>  
                                            <td>
                                                <div class="d-flex px-2 py-0">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$sale->change}}</h6>
                                                    </div>
                                                </div>
                                            </td>  
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$sale->created_at}}</h6>
                                                    </div>
                                                </div>
                                            </td>  
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                   {{$sales->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
    <script>
        function generatePDF() {
            var doc = new jsPDF();
            var htmlContent = document.getElementById('stockTable').innerHTML;
            doc.text('Stock Report', 20, 20);
            doc.fromHTML(htmlContent, 10, 20, { width: 190 });
            doc.save('Stock.pdf');
        }
    </script>
</x-layout>
