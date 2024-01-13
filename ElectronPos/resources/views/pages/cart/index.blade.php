<script src="{{ asset('../../assets/css/jquery-3.3.1.min.js') }}"></script>
<link rel = "stylesheet" href = "{{ asset('../../assets/css/font-awesome.min.css') }}">
<script src="{{ asset('../../assets/js/axios.min.js') }}"></script>
<script>
    
    //make an api call to the server and get the products to the front end as json data
    $(document).ready(function(){
        //make calls with axios to the backend to pupulate the
        
        //trigger event for the textfield that is going to search a product
        $("#searchProduct").on("change",function(){
            const value = $(this).val();
            console.log(value);
        });

        axios.get('/products-json')
        .then(function (response) {
        // handle success
        console.log("These Are The Products", response);
        })
        .catch(function (error) {
        // handle error
        console.log(error);
        })
        .finally(function (response) {
        // always executed
        console.log("These Are The Products", response);
        });
    });
</script>
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
                    <hr>
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
                                class="btn btn-dark btn-block"
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
                    <div className="mb-2">
                     <input
                         type="text"
                         class="form-control border border-2 p-2"
                         placeholder="Search Product"
                         onChange=""
                         onKeyDown=""
                         id = "searchProduct"
                     />
                 </div>
                 <div className="order-product">
                         <div
                             onClick=""
                           >
                             <img src="" alt="" />
                             <h5>
                             </h5>
                         </div>
                 </div>
                </div>
            </div>
        </div>
        <x-plugins></x-plugins>
    </div>
</x-layout>
