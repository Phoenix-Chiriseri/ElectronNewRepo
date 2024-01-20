<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function(){
    $("#searchSelectedProd").on("keydown", function (event) {
    if (event.which == 13) {
        event.preventDefault();
        var productName = $(this).val();
        console.log('Search Term:', productName);
        // Load the products with the productName
        //loadProduct(productName);
        }
    });
});
</script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Create Product'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid pxsae-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('assets') }}/img/bruce-mars.jpg" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->name }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                Electron Point Of Sale
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="btn btn-info" href="{{ route('create-grn') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">View GRNS</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Goods Received Note</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @if (session('status'))
                        <div class="row">
                            <div class="alert alert-success alert-dismissible text-white" role="alert">
                                <span class="text-sm">{{ Session::get('status') }}</span>
                                <button type="button" class="btn-close text-lg py-3 opacity-10"
                                    data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                        @endif
                        @if (Session::has('demo'))
                                <div class="row">
                                    <div class="alert alert-danger alert-dismissible text-white" role="alert">
                                        <span class="text-sm">{{ Session::get('demo') }}</span>
                                        <button type="button" class="btn-close text-lg py-3 opacity-10"
                                            data-bs-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                        @endif
                        <form method="POST" action="#">
                          @csrf
                        <div class="row">
                            <div class="form-group">
                                <label for="supplier_id">Select Supplier</label>
                                <select name="supplier_id" class="form-control border border-2 p-2" required>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
            
                            <div class="form-group">
                                <label for="shop_id">Select Shop</label>
                                <select name="shop_id" class="form-control border border-2 p-2" required>
                                    @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}">{{ $shop->shop_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Grn Date</label>
                                <input type="date" name="grn_date" class="form-control border border-2 p-2" required>
                                <label class="form-label mt-3">Payment Method</label>
                                <select name="payment_method" class="form-control border border-2 p-2" required>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="credit">Credit</option>
                                </select>                            
                                @error('barcode')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Additional Information</label>
                                <textarea type="text" rows="8" name="description" class="form-control border border-2 p-2" required>
                                @error('description')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                @enderror
                                </textarea>
                            </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Supplier Invoice Number</label>
            <input type="text" name="description" class="form-control border border-2 p-2" required>
            @error('description')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Add Aditional Costs</label>
            <input type="text" name="description" class="form-control border border-2 p-2" required>
            @error('description')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="container-fluid px-1 px-md-3">
        <div class="row">
            <div class="col-md-8">
                <div class="row mb-2">
                    <div class="col">
                    </div>
                </div>
                <div class="user-cart">
                    <div class="card">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Measurement</th>
                                    <th>Grn Quantity</th>
                                    <th>Unit Cost</th>
                                    <th>Total Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-centre" id="total-value">Total:</div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Add your content for the second column here -->
                <div className="mb-2">
                 <input
                     type="text"
                     class="form-control border border-2 p-2"
                     placeholder="Search Product"
                     onChange=""
                     onKeyDown=""
                     id = "searchSelectedProd"
                 />
             </div>
             @if(session('error'))
             <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert" style="color: white;">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                // Automatically dismiss the alert after 5000 milliseconds (5 seconds)
                setTimeout(function() {
                    $("#errorAlert").alert('close');
                }, 1500);
            </script>
            @endif
             <hr>
            </div>
        </div>
    </div>
    <hr>
    <button type="submit" class="btn bg-gradient-dark">Submit</button>
</form>

                    </div>
                </div>
            </div>

        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>

</x-layout>
