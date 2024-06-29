<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <!-- End Navbar -->
        <script>
            $(document).ready(function () {

                $("#searchInput").on("keyup", function () {
                 var value = $(this).val().toLowerCase();        
                $("#cattegoriesTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                });

                
                $("#exportCattegories").on("click", function () {
                    // Clone the printable content
                    var cattegoryTable = $("#catteggoryTable").clone();
                    
                    // Remove any unwanted elements (e.g., buttons, input fields)
                    cattegoryTable.find("button, input").remove();
        
                    // Remove specific columns (Edit and Delete) from the cloned table
                    cattegoryTable.find('th:nth-child(3), td:nth-child(3), th:nth-child(4), td:nth-child(4)').remove();
        
                    // Convert the content to PDF with landscape orientation
                    html2pdf(cattegoryTable[0], {
                        margin: 10,
                        filename: 'CattegoriesList.pdf',
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
                                <h6 class="text-white text-capitalize ps-3">Cattegories</h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Payment Types{{$numberOfPaymentTypes}}</h6>
                            </div>
                            <hr>
                            <button class = "btn btn-info" id="exportCattegories"><i class = "fa fa-print"></i>Generate PDF</button>
                            <a class="btn btn-danger" href="{{ route('create-cattegory') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">Add New Payment Type</span>
                            </a>
                        </div>
                        <div>
                            <input type="text" id="searchInput" class="form-control border border-2 p-2" placeholder="Search Payment Types...">
                        </div>
                        <hr>   
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0" id="cattegoriesTable">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                                Name</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paymentTypes as $type)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$type->payment_name}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                           
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $paymentTypes->links() }}
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
