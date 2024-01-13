<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/css/fontawesome.min.css" integrity="sha384-BY+fdrpOd3gfeRvTSMT+VUZmA728cfF9Z2G42xpaRkUGu2i3DyzpTURDo5A6CaLK" crossorigin="anonymous">

<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Sell Product'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-2">
                        <div class="col">
                            <form onSubmit="">
                                <div class="input-group">
                                    <input
                                        type="text"
                                        class="form-control border border-2 p-2"
                                        placeholder="Scan Barcode..."
                                        value=""
                                        onChange=""
                                    />
                                    <div class="input-group-append">
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col">
                            <select class="form-control border border-2 p-2">
                                <option value="">Walking Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="user-cart">
                        <div class="card">
                            <table class="table align-items-center">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sadza</td>
                                        <td>
                                            <div class="input-group">
                                                <input
                                                    type="number"
                                                    class="form-control border border-2 py-1 px-2"
                                                    value=""
                                                />
                                                <div class="input-group-append">
                                                    <button
                                                        class="btn btn-danger btn-lg py-1 px-2"
                                                        onClick=""
                                                    >
                                                        <i class="fas fa-trash fa-2x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-right"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">Total:</div>
                        <div class="col text-right"></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button
                                type="button"
                                class="btn btn-danger btn-block"
                                onClick=""
                                disabled=""
                            >
                                Cancel
                            </button>
                        </div>
                        <div class="col">
                            <button
                                type="button"
                                class="btn btn-primary btn-block"
                                disabled=""
                                onClick=""
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- Add your content for the second column here -->
                    Hello World
                </div>
            </div>
        </div>
        <x-plugins></x-plugins>
    </div>
</x-layout>
