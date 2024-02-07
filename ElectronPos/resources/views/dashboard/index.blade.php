<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <style>
        @keyframes blink {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}

.blink {
  animation: blink 1s linear infinite;
}
      </style>
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
        <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
        </ol>
        <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group input-group-outline">
        </div>
        </div>
        <ul class="navbar-nav  justify-content-end">
        <li class="nav-item d-flex align-items-center">
        </li>
        <li class="mt-2">
        </li>
        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
        <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
        <div class="sidenav-toggler-inner">
        <i class="sidenav-toggler-line"></i>
        <i class="sidenav-toggler-line"></i>
        <i class="sidenav-toggler-line"></i>
        </div>
        </a>
        </li>
        <li class="nav-item px-3 d-flex align-items-center">
        <a href="javascript:;" class="nav-link text-body p-0">
        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
        </a>
        </li>
        <li class="nav-item dropdown pe-2 d-flex align-items-center">
        <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        </a>
        <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
        <li class="mb-2">
        <a class="dropdown-item border-radius-md" href="javascript:;">
        <div class="d-flex py-1">
        <div class="my-auto">
        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
        </div>
        <div class="d-flex flex-column justify-content-center">
        <h6 class="text-sm font-weight-normal mb-1">
        <span class="font-weight-bold">New message</span> from Laur
        </h6>
        <p class="text-xs text-secondary mb-0">
        <i class="fa fa-clock me-1"></i>
        13 minutes ago
        </p>
        </div>
        </div>
        </a>
        </li>
        <li class="mb-2">
        <a class="dropdown-item border-radius-md" href="javascript:;">
        <div class="d-flex py-1">
        <div class="my-auto">
        <img src="../assets/img/small-logos/logo-spotify.svg" class="avatar avatar-sm bg-gradient-dark  me-3 ">
        </div>
        <div class="d-flex flex-column justify-content-center">
        <h6 class="text-sm font-weight-normal mb-1">
        <span class="font-weight-bold">New album</span> by Travis Scott
        </h6>
        <p class="text-xs text-secondary mb-0">
        <i class="fa fa-clock me-1"></i>
        1 day
        </p>
        </div>
        </div>
        </a>
        </li>
        <li>
        <a class="dropdown-item border-radius-md" href="javascript:;">
        <div class="d-flex py-1">
        <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <title>credit-card</title>
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
        <g transform="translate(1716.000000, 291.000000)">
        <g transform="translate(453.000000, 454.000000)">
        <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
        <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
        </g>
        </g>
        </g>
        </g>
        </svg>
        </div>
        <div class="d-flex flex-column justify-content-center">
        <h6 class="text-sm font-weight-normal mb-1">
        Payment successfully completed
        </h6>
        <p class="text-xs text-secondary mb-0">
        <i class="fa fa-clock me-1"></i>
        2 days
        </p>
        </div>
        </div>
        </a>
        </li>
        </ul>
        </li>
        <li class="nav-item d-flex align-items-center">
        </a>
        </li>
        </ul>
        </div>
        </div>
        </nav>       
        <div class="container-fluid py-4">
        <div class="row">
        <div class="col-lg-8">
        <div class="row">
        <div class="col-xl-6 mb-xl-0 mb-4">
        <div class="card bg-transparent shadow-xl">
        <div class="overflow-hidden position-relative border-radius-xl">
        <img src="" class="position-absolute opacity-2 start-0 top-0 w-100 z-index-1 h-100" alt="pattern-tree">
        <span class="mask bg-gradient-dark opacity-10"></span>
        <div class="card-body position-relative z-index-1 p-3">
        <i class="material-icons text-white p-2">user</i>
        <h5 class="text-white mt-4 mb-5 pb-2">Welcome {{$user->name}}</h5>
        <div class="d-flex">
        <div class="d-flex">
        <div class="me-4">
        </div>
        <div>
        </div>
        </div>
        
        <div class="ms-auto w-20 d-flex align-items-end justify-content-end">
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="col-xl-6">
        <div class="row">
        <div class="col-md-6 col-6">
        <div class="card">
        <div class="card-header mx-4 p-3 text-center">
        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
        <i class="material-icons opacity-10">account_balance</i>
        </div>
        </div>
        <div class="card-body pt-0 p-3 text-center">
        <h6 class="text-center mb-0">Total Amount Of  Sales</h6>
        <hr class="horizontal dark my-3">
        <h5 class="mb-0">{{$totalSales}}</h5>
        </div>
        </div>
        </div>
        <div class="col-md-6 col-6">
        <div class="card">
        <div class="card-header mx-4 p-3 text-center">
        <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
        <i class="material-icons opacity-10">account_balance_wallet</i>
        </div>
        </div>
        <p class = "text-center" style="color:black;">Number Of Sales {{$numberOfSales}}</p>
        </div>
        </div>
        </div>
        </div>
        <div>
          <h6>Top Selling Products</h6>
          <ul class = "list-group">
              @foreach ($topSellingProducts as $product)
                  <li class = "list-group-item" style="color:black;">
                      {{ $product->product_name }} - {{ $product->total_quantity_sold }} units sold
                  </li>
              @endforeach
          </ul>
          <div class="d-flex justify-content-center mt-3">
            {{ $topSellingProducts->links('vendor.pagination.bootstrap-4') }}
        </div>
      </div>
      <div>
        <h6>Top Customers</h6>
        <ul class="list-group">
            @foreach ($topCustomers as $customer)
                <li class="list-group-item">
                    {{ $customer->customer_name }} - $ {{ $customer->total_purchase }} 
                </li>
            @endforeach
        </ul>
        <div class="d-flex justify-content-center mt-3">
            {{ $topCustomers->links('vendor.pagination.bootstrap-4') }}
        </div>
      </div>
      <div>
      <div class="alert alert-warning blink" role="alert">
          <h6>Alert. These 5 Products That Almost Out Of Stock</h6>
      </div>
        <ul class="list-group">
            @foreach ($lowestStockProducts as $product)
                <li class="list-group-item">
                    {{$product->product_name}} -  {{ $product->total_quantity }} 
                </li>
            @endforeach
        </ul>
        <div class="d-flex justify-content-center mt-3">
            {{ $topCustomers->links('vendor.pagination.bootstrap-4') }}
        </div>
      </div>
        <div class="col-md-12 mb-lg-0 mb-4">
        <div class="card mt-4">
        <div class="card-header pb-0 p-3">
        <div class="row">
        <div class="col-6 d-flex align-items-center">
        
        </div>
        </div>
        </div>
        <div class="card-body p-3">
        <div class="row">
        <div class="col-md-6 mb-md-0 mb-4">
        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
        <img class="w-10 me-3 mb-0">
        <h6 class="mb-0"></h6>
        </div>
        </div>
        <div class="col-md-6">
        <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
        <img class="w-10 me-3 mb-0">
        <h6 class="mb-0"></h6>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <div class="col-lg-4">
        <div class="card h-100">
        <div class="card-header pb-0 p-3">
        <div class="row">
        <div class="col-6 d-flex align-items-center">
        </div>
        <div class="col-6 text-end">
        </div>
        </div>
        </div>
        <div class="card-body p-3 pb-0">
        <ul class="list-group">
        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
        <h6 class="mb-1 text-dark font-weight-bold text-sm">Number Of</h6>
        <span class="text-xs">Products</span>
        </div>
        <div class="d-flex align-items-center text-sm">
            {{$numberOfProducts}}
        <a class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" href="{{ route('view-products') }}"><i class="material-icons text-lg position-relative me-1">picture_as_pdf</i>Read More</a>
        </div>
        </li>
        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
        <h6 class="text-dark mb-1 font-weight-bold text-sm">Number Of</h6>
        <span class="text-xs">Customers</span>
        </div>
        <div class="d-flex align-items-center text-sm">
          {{$numberOfCustomers }}
          <a class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" href="{{ route('view-customers') }}"><i class="material-icons text-lg position-relative me-1">picture_as_pdf</i>Read More</a>
        </div>
        </li>
        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
        <h6 class="text-dark mb-1 font-weight-bold text-sm">Number Of</h6>
        <span class="text-xs">Cattegories</span>
        </div>
        <div class="d-flex align-items-center text-sm">
        {{ $numberOfCattegories}}
        <a class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" href="{{ route('view-cattegories') }}"><i class="material-icons text-lg position-relative me-1">picture_as_pdf</i>Read More</a>
        </div>
        </li>
        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
        <div class="d-flex flex-column">
        <h6 class="text-dark mb-1 font-weight-bold text-sm">Number Of </h6>
        <span class="text-xs">Suppliers</span>
        </div>
        <div class="d-flex align-items-center text-sm">
          {{$numberOfSuppliers}}
          <a class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" href="{{ route('view-suppliers') }}"><i class="material-icons text-lg position-relative me-1">picture_as_pdf</i>Read More</a>
        </div>
        </li>
        </ul>
        </div>
        </div>
        </div>
        </div>
        <footer class="footer py-4  ">
        <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
        <div class="col-lg-6 mb-lg-0 mb-4">
        </div
        </div>
        </div>
        </footer>
        </div>
        </main>
        <div class="fixed-plugin">
        <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
        <i class="material-icons py-2">settings</i>
        </a>
        <div class="card shadow-lg">
        <div class="card-header pb-0 pt-3">
        <div class="float-start">
        <h5 class="mt-3 mb-0">Material UI Configurator</h5>
        <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
        <i class="material-icons">clear</i>
        </button>
        </div>
        </div>
        <hr class="horizontal dark my-1">
        <div class="card-body pt-sm-3 pt-0">
        
        <div>
        <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
        <div class="badge-colors my-2 text-start">
        <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
        <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
        <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
        <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
        <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
        <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
        </div>
        </a>
        
        <div class="mt-3">
        <h6 class="mb-0">Sidenav Type</h6>
        <p class="text-sm">Choose between 2 different sidenav types.</p>
        </div>
        <div class="d-flex">
        <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
        <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
        <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        
        <div class="mt-3 d-flex">
        <h6 class="mb-0">Navbar Fixed</h6>
        <div class="form-check form-switch ps-0 ms-auto my-auto">
        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
        </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
        <h6 class="mb-0">Light / Dark</h6>
        <div class="form-check form-switch ps-0 ms-auto my-auto">
        <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
        </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">
        <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
        <h6 class="mt-3">Thank you for sharing!</h6>
        <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
        <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
        </a>
        <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
        <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
        </a>
        </div>
        </div>
        </div>
        </div>
        
        <script src="../assets/js/core/popper.min.js"></script>
        <script src="../assets/js/core/bootstrap.min.js"></script>
        <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
        <script>
            var win = navigator.platform.indexOf('Win') > -1;
            if (win && document.querySelector('#sidenav-scrollbar')) {
              var options = {
                damping: '0.5'
              }
              Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
            }
          </script>
        
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        
        <script src="../assets/js/material-dashboard.min.js?v=3.1.0"></script>
        <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317" integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA==" data-cf-beacon='{"rayId":"848aa9be7e3ef0cb","version":"2024.1.0","token":"1b7cbb72744b40c580f8633c6b62637e"}' crossorigin="anonymous"></script>
        </body>
        </html>
    
</x-layout>