<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Products"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <script>
            $(document).ready(function () {

                //search the customers
                $("#searchInput").on("keyup", function () {
                 var value = $(this).val().toLowerCase();   
                 console.log(value);     
                $("#customersTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                });

                $("#exportCustomers").on("click", function () {
                    // Clone the printable content
                    var customersTable = $("#customersTable").clone();
        
                    // Remove any unwanted elements (e.g., buttons, input fields)
                    customersTable.find("button, input").remove();
        
                    // Remove specific columns (edit and delete) from the cloned table
                    customersTable.find('th:nth-child(n+6), td:nth-child(n+6)').remove();
        
                    // Convert the content to PDF with landscape orientation
                    html2pdf(customersTable[0], {
                        margin: 10,
                        filename: 'CustomerList.pdf',
                        jsPDF: { 
                            orientation: 'landscape' 
                        }
                    });
                });
            });
        </script>
        <div class="container-fluid py-4">
            @if(session('success'))
            <script>
            Swal.fire({
                icon: 'success',
                position: "top-end",
                title: 'Success!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1000 // Adjust the timer as needed
            });
            </script>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Customers</h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Customers {{$numberOfCustomers}}</h6>
                            </div>
                            <hr>
                            <button class = "btn btn-info" id="exportCustomers"><i class = "fa fa-print"></i>Generate PDF</button>
                            <a class="btn btn-danger" href="{{ route('create-customers') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">Add New Customer</span>
                            </a>
                            <div>
                                <input type="text" id="searchInput" class="form-control border border-2 p-2" placeholder="Search Customer...">
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center" id="customersTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 150px;">
                                                Customer Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                                Customer Code
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 100px;">
                                                Created By
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 150px;">
                                                Customer Vat Number
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                                Customer Tin Number
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 200px;">
                                                Customer Address
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 150px;">
                                                Customer Phone Number
                                            </th>  
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                                Customer Status
                                            </th>  
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 100px;">
                                                Edit Customer
                                            </th> 
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 100px;">
                                                Delete Customer
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customers as $customer)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                   
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$customer->customer_name}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$customer->code}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$customer->name}}</h6>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$customer->customer_vatnumber}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0 text-sm">{{$customer->customer_tinnumber}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0 text-sm">{{$customer->customer_address}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0 text-sm">{{$customer->customer_phonenumber}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0 text-sm">{{$customer->customer_status}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('edit-customer',$customer->id) }}">Edit Customer</a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('delete-customer',$customer->id) }}">Delete Customer</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $customers->links('vendor.pagination.bootstrap-4') }}
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
