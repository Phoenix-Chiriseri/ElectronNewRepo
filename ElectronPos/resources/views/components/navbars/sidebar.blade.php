@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
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
                        <i style="font-size: 1.2rem;" class="fa fa-box ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Create Cattegory</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('create-product') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-shopping-bag ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('view-stock') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-plus ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Stock</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('cart-index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fa fa-desktop ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Open Pos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white"
                    href="{{ route('create-employee') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-users ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users And Security</span>
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
