<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="configure-printers"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Configure Printers"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            @if(session('success'))
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        timer: 2000,
                        showConfirmButton: false
                    });
                </script>
            @endif
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Configure Printers</h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('save-printer') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="form-label" for="printer_name">Select Default Printer</label>
                                    <select name="printer_name" id="printer_name" class="form-control border border-2 p-2" required>
                                        <option value="">-- Select Printer --</option>
                                        @foreach($systemPrinters as $sp)
                                            <option value="{{ $sp }}" {{ ($savedPrinter && $savedPrinter->name == $sp) ? 'selected' : '' }}>
                                                {{ $sp }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Printer</button>
                            </form>

                            <hr>
                            <h5 class="mt-4">Currently Saved Printer</h5>
                            @if($savedPrinter)
                                <div class="alert alert-success text-white">
                                    <strong>Active Printer:</strong> {{ $savedPrinter->name }}
                                </div>
                            @else
                                <div class="alert alert-warning text-white">
                                    No printer configured yet. Transaction receipt printing will look for a default or fallback printer!
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
