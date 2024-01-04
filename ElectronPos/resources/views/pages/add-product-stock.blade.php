
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    //Bind the event listener to both costPrice and markup input fields
    $("#costPrice, #sellingPrice").on("input", function() {
    const costPrice = parseFloat($('#costPrice').val());
    const sellingPrice = parseFloat($('#sellingPrice').val());
    if (!isNaN(costPrice) && !isNaN(sellingPrice)) {
        var markup = ((sellingPrice - costPrice) / costPrice) * 100;
        var roundedMarkup = markup.toFixed(1);
        $('#viewMarkup').val(roundedMarkup);
    } else {
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
        <div class="container-fluid px-2 px-md-4">
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
                                
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="btn btn-info" href="{{ route('view-products') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">View Products</span>
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
                                <h6 class="mb-3">Add Product</h6>
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
                        <form method="POST" action="{{ route('submit-product') }}">
                          @csrf
                        <div class="row">
         <div class="mb-3 col-md-6">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control border border-2 p-2" required>
            @error('name')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Product Quantity</label>
            <input type="number" class="form-control border border-2 p-2" name="quantity" required>
            @error('name')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Barcode</label>
            <input type="text" name="barcode" class="form-control border border-2 p-2" required>
            @error('barcode')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Description</label>
            <input type="text" name="description" class="form-control border border-2 p-2" required>
            @error('description')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Cost Price</label>
            <input type="number" name="price" id = 'costPrice' class="form-control border border-2 p-2" required>
            @error('price')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Markup %</label>
            <input type="number" name="markup" id = 'viewMarkup' class="form-control border border-2 p-2" required readonly>
            @error('markup')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Selling Price</label>
            <input type="number" name="selling_price" id = 'sellingPrice' class="form-control border border-2 p-2" required>
            @error('selling_price')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-12">
            <label class="form-label">Unit Of Measurement</label>
            <input type="number" name="unit_of_measurement" class="form-control border border-2 p-2" required>
            @error('unit_of_measurement')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="category_id">Select Category</label>
            <select name="category_id" class="form-control border border-2 p-2" required>
                @foreach ($cattegories as $category)
                    <option value="{{ $category->id }}">{{ $category->cattegory_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3 col-md-12">
            <label for="quantity">Quantity</label>
            <input class="form-control border border-2 p-2" name="quantity" rows="4" cols="50" required>
            @error('quantity')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <fieldset>
                <legend class="form-label">Product Status</legend>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="product_status" value="Active" id="independently_mobile">
                    <label class="form-check-label">Active</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="product_status" value="Inactive" id="mobility_with_support">
                    <label class="form-check-label">Inactive</label>
                </div>
            </fieldset>
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
