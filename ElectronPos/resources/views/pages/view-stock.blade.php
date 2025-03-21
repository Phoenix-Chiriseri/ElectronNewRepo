<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Add Product To Stock"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class = "container bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <div class = "row">
                                    <div class="col-md-6">
                                        <h6 class="text-white text-capitalize ps-3">Stock</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <a class="btn btn-white" href="{{ route('viewall-stock') }}"
                                        >
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1">View All Stock Items</span>
                                    </a>
                                    </div>
                                </div>
                            </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Product Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Add Stock</th>
                                           
                                            <!-- Add more headers if needed -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$product->name}}</p>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" href="{{ route('stock.add',$product->id) }}">Add To Stock</a>
                                            </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
