<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Tables"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Employees</h6>
                                    <h6 class="text-white text-capitalize ps-3">Number Of Employees {{$employeesCount}} </h6>
                                </div>
                                <hr>
                                <a class="btn btn-danger" href="{{ route('create-employee') }}"
                                            role="tab" aria-selected="true">
                                            <i class="material-icons text-lg position-relative"></i>
                                            <span class="ms-1">Create New Employee</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center" id="customersTable">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 150px;">
                                               Employee Name
                                            </th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                                Role
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 100px;">
                                                Access Level
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                               Created At
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                                Delete
                                             </th>
                                             <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder" style="width: 120px;">
                                                Edit
                                             </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($employees as $employee)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                   
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$employee->name}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{$employee->role}}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$employee->access_level}}</h6>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <h6 class="mb-0 text-sm">{{$employee->created_at}}</h6>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('delete-employee',$employee->id) }}">Delete Employee</a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('edit-employee',$employee->id) }}">Edit Employee</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$employees->links()}}                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
