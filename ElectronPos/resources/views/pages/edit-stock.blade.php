
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    //Bind the event listener to both costPrice and markup input fields
    $("#price, #quantity").on("input", function() {
    const price = parseFloat($('#price').val());
    const quantity = parseFloat($('#quantity').val());
    console.log(price+quantity);
    if (!isNaN(price) && !isNaN(quantity)) {
           const totalPrice = price*quantity;
           $("#total").val(totalPrice); 
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
                                <h6 class="mb-3">Add Product To Stock</h6>
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
                        <form method="POST" action="{{ route('submit.stock') }}">
                            @csrf
                            <div class="form-group">
                                <label for="supplier_id">Select Supplier</label>
                                <select name="supplier_id" class="form-control border border-2 p-2" required>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        <div class="row">
              <div class="mb-3 col-md-6">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control border border-2 p-2" value="{{$stock->date}}" required>
            @error('date')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror            
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Due Date</label>
            <input type="date" class="form-control border border-2 p-2" name="due_date" value="{{$stock->due_date}}" required>
            @error('name')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Stock Date</label>
            <input type="date" class="form-control border border-2 p-2" name="stock_date" value="{{$stock->stock_date}}"required>
            @error('name')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Quantity</label>
            <input type="text" id = "quantity" name="quantity" class="form-control border border-2 p-2" required value="{{$stock->quantity}}">
            @error('description')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Price</label>
            <input type="number" name="price" id = 'price' value="{{$stock->price}}" class="form-control border border-2 p-2" required>
            @error('price')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-3 col-md-6">
            <label class="form-label">Total</label>
            <input type="number" name="total" id = 'total' class="form-control border border-2 p-2" required readonly>
            @error('markup')
                <p class="text-danger inputerror">{{ $message }}</p>
            @enderror
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
