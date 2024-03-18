<x-layout bodyClass="g-sidenav-show  bg-gray-200">
  <x-navbars.sidebar activePage='dashboard'></x-navbars.sidebar>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <style>
      @keyframes blink {
0% { opacity: 1; }
100% { opacity: 0; }
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
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
        <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">weekend</i>
        </div>
        <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize">Total Sales</p>
        <h4 class="mb-0">{{$totalSales}}</h4>
        </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
        </div>
        </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
        <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">person</i>
        </div>
        <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize">Number Of Sales</p>
        <h4 class="mb-0"> {{$numberOfSales}}</h4>
        </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
        </div>
        </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
        <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">person</i>
        </div>
        <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize">Number Of Suppliers</p>
        <h4 class="mb-0">{{$numberOfSuppliers}}</h4>
        </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
      
        </div>
        </div>
        </div>
        <div class="col-xl-3 col-sm-6">
        <div class="card">
        <div class="card-header p-3 pt-2">
        <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">weekend</i>
        </div>
        <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize">Number Of Customers</p>
        <h4 class="mb-0">{{$numberOfCustomers}}</h4>
        </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-3">
       
        </div>
        </div>
        </div>
        </div>
        <div class="row mt-6">
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
        <div class="card z-index-2 ">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-info shadow-primary border-radius-lg py-3 pe-1 alert alert-warning blink" style="color:white;">
          Alert. These Products Are Almost / Out Of Stock 
          <hr>
          Low Stock Currently Set To {{$stockLevel}} and below
        <div class="chart">
        </div>
        </div>
        <a class="btn btn-info btn-sm" href=" {{ route('set-stocklevels') }} ">
          <span class="ms-2 font-weight-bold text-white">Set Stock Levels</span>
        </a>
        </div>
        <div class="card-body">
        <ul class="list-group">
          @foreach ($lowestStockProducts as $product)
              <li class="list-group-item">
                  {{$product->product_name}} -  {{ $product->total_quantity }} 
              </li>
          @endforeach
      </ul>  
        </div>
        </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
        <div class="card z-index-2  ">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1 text-center" style="color:white;">
          Top Selling Customers
        </div>
        </div>
        <div class="card-body">
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
        <hr class="dark horizontal">
        <div class="d-flex ">
      
       
        </div>
        
        </div>
        </div>
        </div>
        
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
          <div class="card z-index-2  ">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
          <div class="bg-gradient-info shadow-success border-radius-lg py-3 pe-1 text-center" style="color:white;">
            Top Selling Products This Month
          </div>
          </div>
          <div class="card-body">
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
          <hr class="dark horizontal">
          <div class="d-flex ">
         
          </div>
          
          </div>
          </div>
          </div>
           <canvas id="monthlyTopSellingProductsChart" width="800" height="400"></canvas>

    <script>
        // Extract product names and total quantities from the paginated results
        var productNames = {!! json_encode($topSellingProducts->pluck('product_name')) !!};
        var totalQuantities = {!! json_encode($topSellingProducts->pluck('total_quantity_sold')) !!};

        // Create a new bar chart
        var ctx = document.getElementById('monthlyTopSellingProductsChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Monthly Top Selling Products',
                    data: totalQuantities,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Blue color
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
        </div>
      </html>
  
</x-layout>