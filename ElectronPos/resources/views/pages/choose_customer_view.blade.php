<!-- Add jQuery library (include it before the script) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script>
        $(document).ready(function () {
            const searchInput = $("#search");
            const searchResultsContainer = $("#searchResults");

            // Event listener for keyup on the search input
            searchInput.on("keyup", function () {
                // Delay the search by a small interval to prevent too frequent requests
                setTimeout(function () {
                    performSearch(searchInput.val());
                }, 300);
            });

            // Event listener for the search button
            $("#searchBtn").on("click", function () {
                performSearch(searchInput.val());
            });

            function performSearch(searchQuery) {
                // Make an AJAX request to the search endpoint
                $.ajax({
                    url: "{{ route('search-customers') }}",
                    method: "GET",
                    data: { search: searchQuery },
                    dataType: 'json', // Expect JSON response
                    success: function (data) {
                        // Update the search results container with the received JSON data
                        displaySearchResults(data.customers);
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
            }

            function displaySearchResults(customers) {
                // Clear previous results
                searchResultsContainer.empty();

                // Create an unordered list
                const resultList = $('<ul class="list-group"></ul>');
                resultList.append("<br>");

                // Append list items for each customer
                customers.forEach(function (customer) {
                    // Create a clickable list item
                    const listItem = $('<li class="list-group-item clickable list-group-item active">' + customer.customer_name + '</li>');

                    // Add a click event listener
                    listItem.on("click", function () {
                        // Perform an action when the list item is clicked
                        alert("Selected customer: " + customer.customer_name);
                        // You can replace the alert with your desired action, like redirecting to a page.
                    });

                    // Append the list item to the list
                    resultList.append(listItem);
                });

                // Append the list to the container
                searchResultsContainer.append(resultList);
            }
        });
    </script>
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Select Customer'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid" style="margin-top:120px;">
            
            <div class="card card-body mx-3 mx-md-4 mt-n6" style="margin-top: 50px;"> <!-- Adjust the margin-top value as needed -->
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('assets') }}/img/bruce-mars.jpg" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1" role="tablist">
                                <li class="nav-item">
                                    <a class="btn btn-info" href="{{ route('shop-list') }}" role="tab" aria-selected="true">
                                        <i class="material-icons text-lg position-relative"></i>
                                        <span class="ms-1"></span>Finish Transaction
                                    </a>
                                </li>
                            </ul>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" id="search" class="form-control border border-2 p-2" placeholder="Search customers...">
                                    </div>
                                    <!-- Display search results -->
                                    <div id="searchResults"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>
</x-layout>