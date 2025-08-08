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
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Electron Point Of Sale</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page"></li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Number Of Products {{$numberOfProducts ?? 'N/A'}}</h6>
        </nav>
      </div>
    </nav>  

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">category</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Number Of Categories</p>
                <h4 class="mb-0">{{$numberOfCattegories ?? 'N/A'}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3"></div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">shopping_cart</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Number Of Sales</p>
                <h4 class="mb-0">{{$numberOfSales ?? 'N/A'}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3"></div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">local_shipping</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Number Of Suppliers</p>
                <h4 class="mb-0">{{$numberOfSuppliers ?? 'N/A'}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3"></div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">people</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Number Of Customers</p>
                <h4 class="mb-0">{{$numberOfCustomers ?? 'N/A'}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3"></div>
          </div>
        </div>
      </div>

      <br>

      <!-- Payment Type Filter for Sales Data -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header pb-0">
              <h6>Filter Sales Data by Payment Method</h6>
            </div>
            <div class="card-body">
              <form method="GET" action="{{ route('dashboard') }}">
                <div class="row align-items-end">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="payment_method" class="form-label">Select Payment Method:</label>
                      <select id="payment_method" name="payment_method" class="form-control" style="border: 2px solid #dee2e6; border-radius: 6px; padding: 8px 12px;">
                        <option value="">All Payment Methods</option>
                        @if(isset($paymentTypeStats))
                          @foreach($paymentTypeStats as $stat)
                            <option value="{{ $stat->payment_method }}" {{ request('payment_method') == $stat->payment_method ? 'selected' : '' }}>
                              {{ ucfirst(str_replace('_', ' ', $stat->payment_method)) }}
                            </option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="d-flex gap-2">
                      <button type="submit" class="btn btn-primary btn-sm">
                        <i class="material-icons">filter_list</i> Apply Filter
                      </button>
                      <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="material-icons">clear</i> Clear Filter
                      </a>
                    </div>
                  </div>
                </div>
              </form>
              
              @if(request('payment_method'))
                <div class="alert alert-info mt-3">
                  <i class="material-icons">info</i>
                  <strong>Filter Active:</strong> Sales data filtered for <strong>{{ ucfirst(str_replace('_', ' ', request('payment_method'))) }}</strong> payment method.
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">today</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Total Sales Per Day</p>
                <h4 class="mb-0">${{ number_format($totalSalesPerDay->sum('total_sales') ?? 0, 2) }}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              @if(request('payment_method'))
                <p class="text-info text-sm mb-0">
                  <i class="material-icons text-sm">filter_list</i>
                  {{ ucfirst(str_replace('_', ' ', request('payment_method'))) }} only
                </p>
              @else
                <p class="text-muted text-sm mb-0">All payment methods</p>
              @endif
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">date_range</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Total Sales Per Week</p>
                <h4 class="mb-0">${{ number_format($totalSalesPerWeek->sum('total_sales') ?? 0, 2) }}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              @if(request('payment_method'))
                <p class="text-info text-sm mb-0">
                  <i class="material-icons text-sm">filter_list</i>
                  {{ ucfirst(str_replace('_', ' ', request('payment_method'))) }} only
                </p>
              @else
                <p class="text-muted text-sm mb-0">All payment methods</p>
              @endif
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">calendar_month</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Total Sales Per Month</p>
                <h4 class="mb-0">${{ number_format($totalSalesPerMonth->sum('total_sales') ?? 0, 2) }}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              @if(request('payment_method'))
                <p class="text-info text-sm mb-0">
                  <i class="material-icons text-sm">filter_list</i>
                  {{ ucfirst(str_replace('_', ' ', request('payment_method'))) }} only
                </p>
              @else
                <p class="text-muted text-sm mb-0">All payment methods</p>
              @endif
            </div>
          </div>
        </div>

        @if(session('error'))
         <div class="alert alert-danger" role="alert">
        {{ session('error') }}
        </div>
       @endif

        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-3 pt-2">
               <div class="icon icon-lg icon-shape bg-gradient-danger shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">calendar_month</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Total Sales Per Year</p>
                <h4 class="mb-0">${{ number_format($totalSalesPerYear->sum('total_sales') ?? 0, 2) }}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              @if(request('payment_method'))
                <p class="text-info text-sm mb-0">
                  <i class="material-icons text-sm">filter_list</i>
                  {{ ucfirst(str_replace('_', ' ', request('payment_method'))) }} only
                </p>
              @else
                <p class="text-muted text-sm mb-0">All payment methods</p>
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-6">
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
          <div class="card z-index-2">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent"></div>
            <div class="card-body"></div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mt-4 mb-4">
          <div class="card z-index-2">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent"></div>
            <div class="card-body">
              <div class="d-flex justify-content-center mt-3"></div>
              <hr class="dark horizontal">
              <div class="d-flex"></div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </main>
</x-layout>
