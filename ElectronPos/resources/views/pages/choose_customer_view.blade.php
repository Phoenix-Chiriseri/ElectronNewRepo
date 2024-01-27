<!-- Add jQuery library (include it before the script) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage='Select Customer'></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid" style="margin-top:120px;">
            <div class="card card-body mx-3 mx-md-4 mt-n6" style="margin-top: 50px;">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="text-center">Welcome {{$name}}</h4>
                        <input type="text" id="search" class="form-control border border-2 p-2" placeholder="Search Customer">
                        <div id="searchResults"></div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-danger" id="createCustomer" role="tab" aria-selected="true">
                            <i class="material-icons text-lg position-relative"></i>
                            <span class="ms-1"></span><i class="fa fa-user"></i>Create Customer
                        </a>
                        <a class="btn btn-danger" id="processSale" role="tab" aria-selected="true">
                            <i class="material-icons text-lg position-relative"></i>
                            <span class="ms-1"></span><i class="fa fa-user"></i>Process Sale
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <x-footers.auth></x-footers.auth>
    </div>
    <x-plugins></x-plugins>
</x-layout>
<!-- Add SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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

        // Event listener for the 'Create Customer' button
        $("#createCustomer").on("click", function () {
            Swal.fire({
                title: 'Create Customer',
                icon: 'info',
                html:
                    '<form id="createCustomerForm">' +
                    '<input type="text" id="customerName" class="swal2-input form-control" placeholder="Customer Name" required>' +
                    '<input type="text" id="code" class="swal2-input" placeholder="Code" required>' +
                    '<input type="text" id="taxNumber" class="swal2-input" placeholder="Customer Tax Number" required>' +
                    '<input type="text" id="city" class="swal2-input" placeholder="Customer City" required>' +
                    '<input type="text" id="address" class="swal2-input" placeholder="Customer Address" required>' +
                    '<select id="status" class="swal2-select" placeholder="Customer Status" required>' +
                    '<option value="active" class="form-control">Active</option>' +
                    '<option value="inactive" class="form-control">Inactive</option></select>' +
                    '</form>',
                showCancelButton: true,
                confirmButtonText: 'Create',
                cancelButtonText: 'Cancel',
                focusConfirm: false,
                preConfirm: () => {
                    // Collect form data
                    return {
                        customerName: document.getElementById('customerName').value,
                        code: document.getElementById('code').value,
                        taxNumber: document.getElementById('taxNumber').value,
                        city: document.getElementById('city').value,
                        address: document.getElementById('address').value,
                        status: document.getElementById('status').value,
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create a form element dynamically
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/submit-customers';

                    // Append input fields to the form
                    Object.keys(result.value).forEach(key => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = result.value[key];
                        form.appendChild(input);
                    });

                    // Append the form to the body and submit
                    document.body.appendChild(form);
                    form.submit();

                    // After creating the customer, prompt the user to select the customer for the sale
                    promptSelectCustomerForSale(result.value.customerName);
                }
            });
        });

        // Event listener for the 'Process Sale' button
        $("#processSale").on("click", function () {
            const selectedCustomer = $(".list-group-item.active").text();
            if (selectedCustomer) {
                // Proceed with the sale, you can add your logic here
                Swal.fire({
                    title: 'Sale Completed',
                    icon: 'success',
                    text: `Sale completed for ${selectedCustomer}`,
                });
            } else {
                showAlert('Please select a customer', 'error');
            }
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
                    showAlert('Customer Not Found', 'error');
                }
            });
        }

        function showAlert(message, errorIconMessage) {
            Swal.fire({
                position: "top-end",
                icon: errorIconMessage,
                title: message,
                showConfirmButton: false,
                timer: 1000
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
                const listItem = $('<li class="list-group-item clickable">' + customer.customer_name + '</li>');

                // Add a click event listener
                listItem.on("click", function () {
                    // Toggle the active class on click
                    $(".list-group-item").removeClass("active");
                    listItem.addClass("active");
                });

                // Append the list item to the list
                resultList.append(listItem);
            });

            // Append the list to the container
            searchResultsContainer.append(resultList);
        }
    });
</script>