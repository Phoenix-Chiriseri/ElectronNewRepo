<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Create GRV"></x-navbars.navs.auth>
        <script>
            $(document).ready(function () {
                $("#searchInput").on("keyup", function () {
                 var value = $(this).val().toLowerCase();        
                $("#grnTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                });
                $("#exportGrn").on("click", function () {
                    // Clone the printable content
                    var grnTable = $("#grnTable").clone();
        
                    // Remove any unwanted elements (e.g., buttons, input fields)
                    grnTable.find("button, input").remove();
        
                    // Remove specific columns (6th and 7th) from the cloned table
                    grnTable.find('th:nth-child(n+6), td:nth-child(n+6)').remove();
        
                    // Convert the content to PDF with landscape orientation
                    html2pdf(grnTable[0], {
                        margin: 10,
                        filename: 'GoodsReceivedNotes.pdf',
                        jsPDF: { 
                            orientation: 'landscape' 
                        }
                    });
                });
            });
        </script>
        <!-- End Navbar -->
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
                                <h6 class="text-white text-capitalize ps-3">Quotations<s></s></h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Quotations {{$numberOfQuotes}}</h6>
                                <h6 class="text-white text-capitalize ps-3">Total Quote Value {{$totalQuotesValue}}</h6>
                            </div>
                            <br>
                            <button class = "btn btn-info" id="exportGrn"><i class = "fa fa-print"></i>Generate PDF</button>
                            <a class="btn btn-danger brn-lg" href="{{ route('quote-customers') }}"
                            role="tab" aria-selected="true">Create Quotation</a>
                        </div>
                        <div>
                            <input type="text" id="searchInput" class="form-control border border-2 p-2" placeholder="Search Quote...">
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">      
                              <i class="material-icons text-lg position-relative"></i>
                                </a>
                                <table class="table align-items-center mb-0" id="grnTable">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder" style="color:black;">
                                                Quote Number</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ps-2" style="color:black;">
                                                Quote Date</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="color:black;">
                                                Total</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="color:black;">
                                                Created At</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="color: black;">
                                                Customer Name</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="color:black;">
                                                Created By</th>
                                                <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                View Quote</th>
                                                <!--<th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Update GRV</th>!-->
                                              
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($quotations as $quote)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                   
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">CQ-{{$quote->id}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                   
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$quote->quote_date}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                   
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$quote->total}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                   
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$quote->created_at}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                   
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$quote->customer_name}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                   
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$quote->username}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('quote.show',$quote->id) }}">View Quote</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $quotations->links('vendor.pagination.bootstrap-4') }}
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
