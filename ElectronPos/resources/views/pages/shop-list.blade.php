<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <!-- End Navbar -->
        <script>
            $(document).ready(function () {
                $("#exportShops").on("click", function () {
                    // Clone the printable content
                    var shopTable = $("#shopTable").clone();
        
                    // Remove any unwanted elements (e.g., buttons, input fields)
                    shopTable.find("button, input").remove();
        
                    // Remove specific columns (edit and delete) from the cloned table
                    shopTable.find('th:nth-child(n+6), td:nth-child(n+6)').remove();
        
                    // Convert the content to PDF with landscape orientation
                    html2pdf(shopTable[0], {
                        margin: 10,
                        filename: 'ShopsList.pdf',
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
                                <h6 class="text-white text-capitalize ps-3">Shops</h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Shops {{$numberOfShops}}</h6>
                            </div>
                            <hr>
                            <button class="btn btn-info" id="exportShops">Export To Pdf</button>
                            <a class="btn btn-danger" href="{{ route('view-shop') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">Add New Shop</span>
                            </a>
                        </div>
                       
                        <hr>   
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="shopTable">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                                Shop Name</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                                Shop Address</th>
                                            <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            City</th>
                                            <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Created By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($shops as $shop)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$shop->shop_name}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td><div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$shop->shop_address}}</h6>
                                            </div></td>
                                            <td><div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$shop->shop_city}}</h6>
                                            </div></td>
                                            <td><div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$shop->name}}</h6>
                                            </div></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$shops->links()}}
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
