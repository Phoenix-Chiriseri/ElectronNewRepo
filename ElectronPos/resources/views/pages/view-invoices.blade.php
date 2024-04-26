<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="All Sales"></x-navbars.navs.auth>
        <script>
            $(document).ready(function () {
                
                //button that will print the invoice
                $("#printInvoice").on("click",function(){
                    window.invoicesTable.print();
                });
                
                $("#searchInput").on("keyup", function () {
                 var value = $(this).val().toLowerCase();        
                $("#invoicesTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                });
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
                        filename: 'InvoiceList.pdf',
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
                                <h6 class="text-white text-capitalize ps-3">Invoices</h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Invoices {{$numberOfInvoices}}</h6>
                            </div>
                            <hr>
                            <button class = "btn btn-info" id="exportSales"><i class = "fa fa-print"></i>Generate PDF</button>
                            <button class = "btn btn-secondary" id="printInvoice"><i class = "fa fa-print"></i>Print Invoice</button>
                        </div>
                        <input type="text" id="searchInput" class="form-control border border-2 p-2" placeholder="Search Invoice...">
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="invoicesTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                               Invoice Number
                                            </th>
                                             <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Created At
                                             </th>
                                             <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Created By
                                             </th>
                                             <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                View Invoice
                                             </th>
                                             
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $invoice)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-0">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$invoice->id}}</h6>
                                                    </div>
                                                </div>
                                            </td>  
                                           
                                            <td>
                                                <div class="d-flex px-2 py-0">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$invoice->created_at}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="d-flex px-2 py-0">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$invoice->name}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="d-flex px-2 py-0">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href="{{ route('invoice.show', ['id' => $invoice->invoice_id]) }}" class="btn btn-danger">View Invoice</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                   {{$invoices->links()}}
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
