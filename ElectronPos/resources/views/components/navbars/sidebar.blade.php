@props(['activePage'])
<link rel="stylesheet" href="{{asset('assets/css/waves.min.css')}} " type="text/css" media="all">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
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
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3  bg-gradient-dark"
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
                        <i style="font-size: 1.2rem;" class="fa fa-dashboard ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                href="{{ route('create-customers') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-users ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Customers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                href="{{ route('create-suppliers') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-users ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Suppliers</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('create-cattegory') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fa fa-folder ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Create Cattegory</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('create-product') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fa fa-box ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Products</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link btn btn-dark btn-sm dropdown-toggle text-right" href="#" id="inventoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i style="font-size: 1.2rem;" class="fas fa-warehouse me-2 ps-2 pe-2 text-center"></i>
                    Inventory
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="inventoryDropdown">
                    <a class="dropdown-item" href="{{ route('viewall-stock') }}">Available Stock</a>
                    <a class="dropdown-item" href="{{ route('create-grn') }}">Goods Received Note</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('cart-index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class = "fas fa-shopping-cart ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Open Pos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="/sales">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class = "fa fa-money ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sales</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('view-employees') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-users ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Employees</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('view-reports') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-book ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('view-shop') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fa fa-shop ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Shop</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            <a href="javascript:;" class="btn bg-gradient-primary w-100">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign
                    Out</span>
            </a>
        </div>  
    </div>
</aside>