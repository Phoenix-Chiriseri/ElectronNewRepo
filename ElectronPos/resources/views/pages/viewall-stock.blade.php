<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Products"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Stock Report</h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Items In Stock {{ $stockCount }}</h6>
                                <h6 class="text-white text-capitalize ps-3">Total Amount {{ $totalStock[0]->total }}</h6>
                            </div>
                            <hr>
                            <button class="btn btn-info" onclick="generatePDF()">Export To Pdf</button>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0" id="stockTable">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Product Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Quantity
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Stock Value
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Unit Of Measurement
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stocks as $stock)
                                            <tr>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $stock->name }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $stock->quantity }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <h6 class="mb-0 text-sm">{{ $stock->price }}</h6>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <h6 class="mb-0 text-sm">{{ $stock->measurement }}</h6>
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
