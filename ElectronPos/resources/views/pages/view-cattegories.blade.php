<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="tables"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Cattegories</h6>
                                <h6 class="text-white text-capitalize ps-3">Number Of Cattegories {{$numberOfCattegories}}</h6>
                                <hr>
                                <a class="btn btn-white" href="{{ route('create-cattegory') }}"
                                            role="tab" aria-selected="true">
                                            <i class="material-icons text-lg position-relative"></i>
                                            <span class="ms-1">Add New Cattegory</span>
                                </a>
                            </div>
                        </div>
                        <hr>   
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                                Cattegory</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                                Created At</th>
                                            <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Edit Cattegory</th>
                                            <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder ">
                                            Delete Cattegory</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cattegories as $cattegory)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{$cattegory->cattegory_name}}</h6>
                                                    </div>
                                                </div>
                                            </td> 
                                            <td><div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{$cattegory->created_at}}</h6>
                                            </div></td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('edit-group',$cattegory->id) }}">Edit Group</a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a class="btn btn-primary" href="{{ route('delete-group',$cattegory->id) }}">Delete Group</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$cattegories->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
