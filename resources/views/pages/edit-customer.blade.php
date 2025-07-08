<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='User Profile'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1592488874899-35c8ed86d2e3?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
                
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('assets') }}/img/posMachine.jpg" alt="profile_image"
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
                                    <a class="btn btn-info" href="{{ route('view-customers') }}"
                                        role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">View Customers</span>
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
                                <h6 class="mb-3">Edit Customer</h6>
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
                        <form action="{{ route('update-customer', $customer) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="customer_name">Customer Name</label>
                                <input type="text" name="customer_name" id="customer_name" value="{{$customer->customer_name}}" class="form-control border border-2 p-2" required>
                            </div>
                            <div class="form-group">
                                <label for="code">Customer Code</label>
                                <input type="text" name="code" id="code" value="{{$customer->code}}" class="form-control border border-2 p-2" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_taxnumber">Customer TIN Number</label>
                                <input type="text" name="customer_tinnumber" value="{{$customer->customer_tinnumber}}"  maxlength="10" id="supplier_taxnumber" class="form-control border border-2 p-2" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_taxnumber">Customer VAT Number</label>
                                <input type="text" name="customer_vatnumber" value="{{$customer->customer_vatnumber}}" id="supplier_taxnumber" class="form-control border border-2 p-2" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_address">Customer Address</label>
                                <input type="text" name="customer_address" value="{{$customer->customer_address}}" id="customer_address" class="form-control border border-2 p-2" required>
                            </div>
                            <div class="form-group">
                                <label for="supplier_status">Type</label>
                                <select name="supplier_type" class="form-control border border-2 p-2" required>
                                <option value="cash">Cash</option>
                                <option value="credit">Credit</option>
                                </select>
                            <hr>
                            <div class="form-group">
                                <label for="customer_phonenumber">Customer Phone Number</label>
                                <input type="text" name="customer_phonenumber" value="{{$customer->customer_phonenumber}}" id="customer_phonenumber" class="form-control border border-2 p-2" required>
                            </div>
                            <div class="form-group">
                                <label for="customer_status">Status</label>
                                <select name="customer_status" class="form-control border border-2 p-2" required>
                                <option value="active">Active</option>
                                <option value="not_active">Not Active</option>
                                </select>
                            <hr>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update Customer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-plugins></x-plugins>
</x-layout>
