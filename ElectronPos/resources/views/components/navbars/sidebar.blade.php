@props(['activePage'])
<link rel="stylesheet" href="{{asset('assets/css/waves.min.css')}} " type="text/css" media="all">
<script src="{{asset('assets/js/jquery-3.5.1.slim.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>!-->
<!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>!-->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<style>
    /* Sidebar styles */
    .sidebar {
        width: 250px;
        background-color: #333;
        color: white;
        padding-top: 20px;
    }

    /* Main navigation item styles */
    .nav-item {
        list-style: none;
    }

    .nav-link {
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 10px;
        color: white;
    }

    .nav-link:hover {
        background-color: #555;
    }

    /* Submenu styles */
    .submenu {
        list-style: none;
        padding-left: 20px;
        display: none; /* Hide the submenu by default */
    }

    .submenu li {
        margin-bottom: 5px;
    }

    .submenu a {
        color: #bbb;
        text-decoration: none;
    }

    .submenu a:hover {
        color: #fff;
    }

    .nav-item .btn-group {
    display: flex;
    align-items: center;
}
</style>
<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-6 fixed-start ms-3  bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <span class="ms-2 font-weight-bold text-white">Electron Point Of Sale</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Select Option</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-users ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link btn btn-dark btn-sm dropdown-toggle text-right" href="#" id="inventoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i style="font-size: 1.2rem;" class="fas fa-warehouse me-2 ps-2 pe-2 text-center"></i>
                    <span class="text-capitalize">products</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="inventoryDropdown">
                    <a class="dropdown-item" href="{{ route('view-products') }}">Product List</a>
                    
                    <a class="dropdown-item" href="{{ route('view-cattegories') }}">Cattegories</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link btn btn-dark btn-sm dropdown-toggle text-right" href="#" id="inventoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i style="font-size: 1.2rem;" class="fas fa-warehouse me-2 ps-2 pe-2 text-center"></i>
                    <span class="text-capitalize">inventory</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="inventoryDropdown">
                    <a class="dropdown-item" href="{{ route('viewall-stock') }}">Available Inventory</a>
                    <a class="dropdown-item" href="{{ route('create-grn') }}">Good Received Vouchers</a>
                    <a class="dropdown-item" href="{{ route('grv-enquiry') }}">GRV Enquiry</a>
                    <a class="dropdown-item" href="{{ route('create-purchaseorder') }}">Purchase Orders</a>
                    <a class="dropdown-item" href="{{ route('stock-enquiry') }}">Stock Enquiry</a>
                    <a class="dropdown-item" href="{{ route('view-inventoryvaluation') }}">Inventory Valuation Report</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link btn btn-dark btn-sm dropdown-toggle text-right" href="#" id="inventoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i style="font-size: 1.2rem;" class="fas fa-warehouse me-2 ps-2 pe-2 text-center"></i>
                    <span class="text-capitalize">customers</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="inventoryDropdown">
                    <a class="dropdown-item" href="{{ route('create-customers') }}">Create Customers</a>
                    <a class="dropdown-item" href="{{ route('quote-customers') }}">Quote Customers</a>
                </div>
            </li>
           
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="/view-invoices">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class = "fa fa-book ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Invoices</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link btn btn-dark btn-sm dropdown-toggle text-right" href="#" id="inventoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i style="font-size: 1.2rem;" class="fas fa-users me-2 ps-2 pe-2 text-center"></i>
                    <span class="text-capitalize">Employees</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="inventoryDropdown">
                    <a class="dropdown-item" href="{{ route('view-employees') }}">View Employees</a>
                   
                </div>
            </li>
           
            <li class="nav-item">
                <a class="nav-link text-white"
                href="{{ route('view-payment-types') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fa fa-money ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Payment Types</span>
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link text-white"
                href="{{ route('view-companydata') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-building ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">My Company</span>
                </a>
            </li>
         </div>
         <br>
        <div class="mx-3">
            <div class="mx-3">
                 
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <input type="submit" value="Logout." class = "btn btn-danger btn-block">
                    </form>
            </div>  
        </div>
    </aside>