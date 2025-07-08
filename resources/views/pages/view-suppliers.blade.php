
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script><x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- gi -->
        <x-navbars.navs.auth titlePage="View Suppliers"></x-navbars.navs.auth>
        <!-- End Navbar -->
         <script>
            $(document).ready(function () {

                $("#searchInput").on("keyup", function () {
                 var value = $(this).val().toLowerCase();        
                $("#suppliersTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                });
                
                $("#exportSuppliers").on("click", function () {
                    // Clone the printable content
                    var suppliersTable = $("#suppliersTable").clone();
        
                    // Remove any unwanted elements (e.g., buttons, input fields)
                    suppliersTable.find("button, input").remove();
        
                    // Remove specific columns (edit and delete) from the cloned table
                    suppliersTable.find('th:nth-child(n+6), td:nth-child(n+6)').remove();
        
                    // Convert the content to PDF with landscape orientation
                    html2pdf(suppliersTable[0], {
                        margin: 10,
                        filename: 'SuppliersList.pdf',
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
                                <h6 class="text-white text-capitalize ps-3">Suppliers</h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Suppliers {{$numberOfSuppliers}}</h6>
                            </div>
                            <hr>
                            <button class = "btn btn-info" id="exportSuppliers"><i class = "fa fa-print"></i>Generate PDF</button>
                            <a class="btn btn-danger" href="{{ route('create-suppliers') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">Add New Supplier</span>
                            </a>
                            <div>
                                <input type="text" id="searchInput" class="form-control border border-2 p-2" placeholder="Search Supplier...">
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0" id="suppliersTable">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                                Supplier Name</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                               Supplier Tin Number</th>
                                               <th
                                               class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                               Supplier Vat Number</th>  
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                               Created By</th>
                                           
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Supplier Address</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Supplier Phone Number</th>  
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Supplier Status</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Supplier Type</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Edit Supplier</th> 
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder">
                                                Delete Supplier</th>  
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($suppliers as $supplier)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$supplier->supplier_name}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$supplier->supplier_tinnumber}}</h6>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$supplier->supplier_vatnumber}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$supplier->name}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0 text-sm">{{$supplier->supplier_address}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0 text-sm">{{$supplier->supplier_phonenumber}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0 text-sm">{{$supplier->supplier_status}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0 text-sm">{{$supplier->type}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('edit-supplier',$supplier->id) }}">Edit Supplier</a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('delete-supplier',$supplier->id) }}">Delete Supplier</a>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $suppliers->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
