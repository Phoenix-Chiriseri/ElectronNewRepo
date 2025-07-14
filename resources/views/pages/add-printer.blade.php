<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        @if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    position: "top-end",
    title: 'Success!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 1000
});
</script>
@endif
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Add Printers'></x-navbars.navs.auth>
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
                                    
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3"></h6>
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
                        
                        <!-- Printer Detection Section -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6>Detect Connected Printers</h6>
                                    </div>
                                    <div class="card-body">
                                        <button type="button" id="detectPrinters" class="btn btn-info">
                                            <i class="fas fa-search"></i> Detect USB Printers
                                        </button>
                                        <div id="printerList" class="mt-3" style="display: none;">
                                            <h6>Available Printers:</h6>
                                            <div id="availablePrinters"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method='POST' action="{{ route('add-printer') }}" id="printerForm">
                            @csrf
                            <div class="row">       
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Printer Name</label>
                                    <input type="text" name="name" id="printerName" class="form-control border border-2 p-2" required>
                                    @error('name')
                                <p class='text-danger inputerror'>{{ $message }} </p>
                                @enderror
                                </div>
                                
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Connection Mode</label>
                                    <select name="connection_mode" id="connectionMode" class="form-control border border-2 p-2" required>
                                        <option value="bluetooth">Bluetooth</option>
                                        <option value="usb" selected>USB</option>
                                        <option value="network">Network</option>
                                        <option value="wifi">Wi-Fi</option>
                                    </select>
                                </div>
                                
                                <!-- Additional fields for printer details -->
                                <div class="mb-3 col-md-12" id="usbDetailsSection">
                                    <label class="form-label">USB Port/Device ID</label>
                                    <input type="text" name="device_id" id="deviceId" class="form-control border border-2 p-2">
                                    <small class="text-muted">This will be auto-filled when you detect the printer</small>
                                </div>
                                
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Printer Status</label>
                                    <input type="text" name="status" id="printerStatus" class="form-control border border-2 p-2" value="disconnected" readonly>
                                </div>
                            </div>
                            <button type="submit" class="btn bg-gradient-dark" id="submitBtn">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>
</x-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const detectBtn = document.getElementById('detectPrinters');
    const printerList = document.getElementById('printerList');
    const availablePrinters = document.getElementById('availablePrinters');
    const printerNameInput = document.getElementById('printerName');
    const deviceIdInput = document.getElementById('deviceId');
    const printerStatusInput = document.getElementById('printerStatus');
    const submitBtn = document.getElementById('submitBtn');
    
    // Show/hide USB details based on connection mode
    document.getElementById('connectionMode').addEventListener('change', function() {
        const usbSection = document.getElementById('usbDetailsSection');
        if (this.value === 'usb') {
            usbSection.style.display = 'block';
        } else {
            usbSection.style.display = 'none';
        }
    });
    
    detectBtn.addEventListener('click', async function() {
        try {
            // Show loading state
            detectBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Detecting...';
            detectBtn.disabled = true;
            
            // Check if WebUSB is supported
            if (!navigator.usb) {
                throw new Error('WebUSB is not supported in this browser');
            }
            
            // Request USB device access
            const devices = await navigator.usb.getDevices();
            
            // Also try to request new device access
            try {
                const device = await navigator.usb.requestDevice({
                    filters: [
                        // Common printer vendor IDs
                        { vendorId: 0x04b8 }, // Epson
                        { vendorId: 0x04a9 }, // Canon
                        { vendorId: 0x03f0 }, // HP
                        { vendorId: 0x04e8 }, // Samsung
                        { vendorId: 0x0924 }, // Zebra
                        { vendorId: 0x0483 }, // STMicroelectronics (common in thermal printers)
                        { vendorId: 0x20d1 }, // Thermal printer manufacturers
                    ]
                });
                
                if (device && !devices.find(d => d.productId === device.productId)) {
                    devices.push(device);
                }
            } catch (e) {
                // User cancelled device selection or no new device selected
                console.log('No new device selected');
            }
            
            if (devices.length === 0) {
                availablePrinters.innerHTML = '<div class="alert alert-warning">No USB printers detected. Make sure your printer is connected and powered on.</div>';
                printerList.style.display = 'block';
                return;
            }
            
            // Display found devices
            let printersHtml = '';
            devices.forEach((device, index) => {
                const deviceName = device.productName || `Unknown Device (${device.vendorId}:${device.productId})`;
                printersHtml += `
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="mb-1">${deviceName}</h6>
                                    <p class="text-sm text-muted mb-0">
                                        Vendor ID: 0x${device.vendorId.toString(16).toUpperCase()}<br>
                                        Product ID: 0x${device.productId.toString(16).toUpperCase()}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-sm btn-success select-printer" 
                                            data-name="${deviceName}" 
                                            data-device-id="${device.vendorId}:${device.productId}"
                                            data-index="${index}">
                                        Select This Printer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            
            availablePrinters.innerHTML = printersHtml;
            printerList.style.display = 'block';
            
            // Add event listeners to select buttons
            document.querySelectorAll('.select-printer').forEach(btn => {
                btn.addEventListener('click', function() {
                    const printerName = this.getAttribute('data-name');
                    const deviceId = this.getAttribute('data-device-id');
                    
                    // Fill form fields
                    printerNameInput.value = printerName;
                    deviceIdInput.value = deviceId;
                    printerStatusInput.value = 'connected';
                    
                    // Update UI
                    document.querySelectorAll('.select-printer').forEach(b => {
                        b.classList.remove('btn-success');
                        b.classList.add('btn-outline-success');
                        b.textContent = 'Select This Printer';
                    });
                    
                    this.classList.remove('btn-outline-success');
                    this.classList.add('btn-success');
                    this.textContent = 'Selected';
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Printer Selected!',
                        text: `${printerName} has been selected and is ready to be saved.`,
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            });
            
        } catch (error) {
            console.error('Error detecting printers:', error);
            availablePrinters.innerHTML = `
                <div class="alert alert-danger">
                    <strong>Error:</strong> ${error.message}<br>
                    <small>Make sure your browser supports WebUSB and the printer is properly connected.</small>
                </div>
            `;
            printerList.style.display = 'block';
        } finally {
            // Reset button state
            detectBtn.innerHTML = '<i class="fas fa-search"></i> Detect USB Printers';
            detectBtn.disabled = false;
        }
    });
    
    // Form submission validation
    document.getElementById('printerForm').addEventListener('submit', function(e) {
        const connectionMode = document.getElementById('connectionMode').value;
        const deviceId = deviceIdInput.value;
        const printerStatus = printerStatusInput.value;
        
        if (connectionMode === 'usb' && !deviceId) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'USB Printer Not Detected',
                text: 'Please detect and select a USB printer before submitting.',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        if (connectionMode === 'usb' && printerStatus === 'disconnected') {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Printer Not Connected',
                text: 'The selected printer appears to be disconnected. Please check the connection.',
                confirmButtonText: 'OK'
            });
            return;
        }
    });
});
</script>

<style>
.select-printer {
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

#printerList {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>