<script src="{{ asset('assets') }}/js/jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <body>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        @if(session('success'))
        <script>
        Swal.fire({
            icon: 'success',
            position: "top-end",
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
        </script>
        @endif
        
        @if(session('error'))
        <script>
        Swal.fire({
            icon: 'error',
            position: "top-end",
            title: 'Error!',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000
        });
        </script>
        @endif
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Stock Level Enquiry'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid pxsae-2 px-md-4">
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
                                   
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Stock Levels Enquiry</h6>
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
                        <form method="POST" action="{{ route('enquire-stock') }}">
                          @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="product_id">Select Product to Check Stock Level</label>
                                    <select name="product_id" class="form-control border border-2 p-2" style="border: 2px solid #dee2e6; border-radius: 6px;" required>
                                        <option value="">-- Select a Product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ (isset($selectedProduct) && $selectedProduct->id == $product->id) ? 'selected' : '' }}>
                                                {{ $product->name }} ({{ $product->unit_of_measurement }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn bg-gradient-primary btn-block">
                                        <i class="fas fa-search"></i> Check Stock Level
                                    </button>
                                </div>
                            </div>
                        </div>
                        </form>

                        @if(isset($selectedProduct))
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-boxes text-primary"></i> 
                                            Stock Level Information for: <strong>{{ $selectedProduct->name }}</strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card text-center bg-gradient-primary">
                                                    <div class="card-body">
                                                        <i class="fas fa-cubes fa-2x text-white mb-2"></i>
                                                        <h4 class="text-white mb-0">{{ $stockLevel ?? 0 }}</h4>
                                                        <p class="text-white text-sm mb-0">Current Stock</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card text-center bg-gradient-success">
                                                    <div class="card-body">
                                                        <i class="fas fa-dollar-sign fa-2x text-white mb-2"></i>
                                                        <h4 class="text-white mb-0">${{ number_format($selectedProduct->price ?? 0, 2) }}</h4>
                                                        <p class="text-white text-sm mb-0">Unit Price</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card text-center bg-gradient-info">
                                                    <div class="card-body">
                                                        <i class="fas fa-balance-scale fa-2x text-white mb-2"></i>
                                                        <h4 class="text-white mb-0">{{ $selectedProduct->unit_of_measurement ?? 'N/A' }}</h4>
                                                        <p class="text-white text-sm mb-0">Unit of Measurement</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card text-center bg-gradient-warning">
                                                    <div class="card-body">
                                                        <i class="fas fa-calculator fa-2x text-white mb-2"></i>
                                                        <h4 class="text-white mb-0">${{ number_format(($stockLevel ?? 0) * ($selectedProduct->price ?? 0), 2) }}</h4>
                                                        <p class="text-white text-sm mb-0">Total Value</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6><i class="fas fa-info-circle text-info"></i> Product Details</h6>
                                                        <table class="table table-sm">
                                                            <tr>
                                                                <td><strong>Product Name:</strong></td>
                                                                <td>{{ $selectedProduct->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Category:</strong></td>
                                                                <td>{{ $selectedProduct->cattegory->cattegory_name ?? 'N/A' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Price:</strong></td>
                                                                <td>${{ number_format($selectedProduct->price ?? 0, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td><strong>Unit:</strong></td>
                                                                <td>{{ $selectedProduct->unit_of_measurement ?? 'N/A' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h6><i class="fas fa-chart-line text-success"></i> Stock Status</h6>
                                                        @php
                                                            $stockStatus = 'Unknown';
                                                            $statusClass = 'secondary';
                                                            $statusIcon = 'question';
                                                            
                                                            if(isset($stockLevel)) {
                                                                if($stockLevel > 50) {
                                                                    $stockStatus = 'High Stock';
                                                                    $statusClass = 'success';
                                                                    $statusIcon = 'check-circle';
                                                                } elseif($stockLevel > 10) {
                                                                    $stockStatus = 'Medium Stock';
                                                                    $statusClass = 'warning';
                                                                    $statusIcon = 'exclamation-triangle';
                                                                } elseif($stockLevel > 0) {
                                                                    $stockStatus = 'Low Stock';
                                                                    $statusClass = 'danger';
                                                                    $statusIcon = 'exclamation-circle';
                                                                } else {
                                                                    $stockStatus = 'Out of Stock';
                                                                    $statusClass = 'danger';
                                                                    $statusIcon = 'times-circle';
                                                                }
                                                            }
                                                        @endphp
                                                        
                                                        <div class="alert alert-{{ $statusClass }} text-center">
                                                            <i class="fas fa-{{ $statusIcon }} fa-2x mb-2"></i>
                                                            <h5 class="mb-1">{{ $stockStatus }}</h5>
                                                            <p class="mb-0">Current stock level: {{ $stockLevel ?? 0 }} {{ $selectedProduct->unit_of_measurement ?? 'units' }}</p>
                                                        </div>

                                                        @if(isset($stockLevel) && $stockLevel <= 10)
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-bell"></i> 
                                                            <strong>Reorder Alert:</strong> Stock level is getting low. Consider restocking soon.
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12 text-center">
                                                <a href="{{ route('stock-enquiry') }}" class="btn btn-outline-secondary">
                                                    <i class="fas fa-search"></i> Check Another Product
                                                </a>
                                                <a href="{{ route('viewall-stock') }}" class="btn btn-primary ms-2">
                                                    <i class="fas fa-list"></i> View All Stock
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
       
    </div>
    </body>
    <x-plugins></x-plugins>

</x-layout>