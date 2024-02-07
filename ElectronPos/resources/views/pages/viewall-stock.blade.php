<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css">
<!-- Include Noty.js JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @if(count($flashMessages) > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var messages = {!! json_encode($flashMessages) !!};
    
                // Display each flash message as a Noty notification
                messages.forEach(function(message) {
                    new Noty({
                        type: 'error', // Set notification type
                        text: message, // Set notification message
                        layout: 'topRight', // Set notification position
                        timeout: 5000, // Adjust the timeout as needed
                        animation: {
                            open: 'animated bounceInRight', // Set open animation
                            close: 'animated bounceOutRight' // Set close animation
                        },
                        // Custom CSS style for the text color
                        css: {
                            textAlign: 'center',
                            color: 'black', // Set text color to black
                        }
                    }).show();
                });
            });
        </script>
    @endif  <!-- Navbar -->
        <x-navbars.navs.auth titlePage="All Stock Items"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <script>
            $(document).ready(function () {
                $("#exportStock").on("click", function () {
                    // Clone the printable content
                    var stockTable = $("#stockTable").clone();
                    
                    // Remove any unwanted elements (e.g., buttons, input fields)
                    stockTable.find("button, input").remove();
        
                    // Remove specific columns (Edit and Delete) from the cloned table
                    stockTable.find('th:nth-child(6), td:nth-child(6), th:nth-child(6), td:nth-child(6)').remove();
        
                    // Convert the content to PDF with landscape orientation
                    html2pdf(stockTable[0], {
                        margin: 10,
                        filename: 'StockList.pdf',
                        jsPDF: { 
                            orientation: 'landscape' 
                        }
                    });
                });
            });
        </script> 
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Available Stock</h6>
                            </div>
                            <hr>
                            <button class="btn btn-info" id="exportStock">Export To Pdf</button>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="stockTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Product Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Product Code
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                               Cattegory Name
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                               Selling Price
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Stock Count
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>        
                                        @foreach($stocks as $stock)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$stock->product_name}}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$stock->barcode}}</p>
                                            </td>
                                            
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$stock->cattegory_name}}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$stock->selling_price}}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$stock->total_quantity}}</p>
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
