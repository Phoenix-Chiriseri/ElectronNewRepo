<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card my-4">
                        <div class="card-header p-0 poition-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Confirm Payment</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <!-- Display dynamic content from the database -->
                                        <!-- Replace the static content with data from your database -->
                                            <!-- Assuming the controller passes $data to the view -->
                                            @foreach ($saleItems as $item)
                                            <p>Product ID: {{ $item['product_id'] }}</p>
                                            <p>Quantity: {{ $item['quantity'] }}</p>
                                        @endforeach
                                        
                                        <p>Customer ID: {{ $customerId }}</p>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Right column with change textfield and buttons -->
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Actions</h6>
                            </div>
                        </div>
                        <div class="card-body px-3 pb-2">
                            <!-- Text field for change -->
                            <div class="mb-3">
                                <label for="change" class="form-label">Change:</label>
                                <input type="text" class="form-control" id="change">
                            </div>
                            <!-- Buttons for printing -->
                            <button class="btn btn-success mb-2">Print Receipt</button>
                            <button class="btn btn-info mb-2">Print Invoice</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </main>
    <x-plugins></x-plugins>
</x-layout>