<script src="{{ asset('assets') }}/css/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    // Handling input changes for cost price and selling price to calculate markup
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
    <x-navbars.sidebar activePage="fiscal-device-registration"></x-navbars.sidebar>

    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
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

        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Register Fiscal Device'></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1592488874899-35c8ed86d2e3?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('assets') }}/img/fiscalDevice.jpg" alt="Fiscal Device Image"
                            class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->name }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                Fiscal Device Registration Portal
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Register Fiscal Device</h6>
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

                        <form method="POST" action="{{ route('registerDevice') }}">
                            @csrf
                            <div class="row">
                                <!-- Device Name -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Device Name</label>
                                    <input type="text" name="device_name" class="form-control border border-2 p-2" required>
                                    @error('device_name')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Device Serial Number -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Device Serial Number</label>
                                    <input type="text" name="serial_number" class="form-control border border-2 p-2" required>
                                    @error('serial_number')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Manufacturer -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Manufacturer</label>
                                    <input type="text" name="manufacturer" class="form-control border border-2 p-2" required>
                                    @error('manufacturer')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Device Type -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Device Type</label>
                                    <select name="device_type" class="form-control border border-2 p-2" required>
                                        <option value="fiscal_printer">Fiscal Printer</option>
                                        <option value="cash_register">Cash Register</option>
                                        <option value="software">Software Solution</option>
                                    </select>
                                    @error('device_type')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date of Registration -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Date of Registration</label>
                                    <input type="date" name="registration_date" class="form-control border border-2 p-2" required>
                                    @error('registration_date')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Device Activation Status -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Device Activation Status</label>
                                    <select name="activation_status" class="form-control border border-2 p-2" required>
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    @error('activation_status')
                                    <p class="text-danger inputerror">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <button type="submit" class="btn bg-gradient-dark">Register Device</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <x-footers.auth></x-footers.auth>
    </div>

    <x-plugins></x-plugins>
</x-layout>
