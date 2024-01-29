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
                        <div class="form-group">
                            <label for="selectedCustomer">Select Customer for Sale</label>
                            <select id="selectedCustomer" class="form-control">
                                <!-- Options will be dynamically populated when searching for customers -->
                            </select>
                        </div>
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
        const selectedCustomerDropdown = $("#selectedCustomer");
        let selectedItem;  // Declare the variable here

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
                    '<input type="text" id="customer_name" class="swal2-input form-control" placeholder="Customer Name" required name="customer_name">' +
                    '<input type="text" id="code" class="swal2-input" placeholder="Code" name="code" required>' +
                    '<input type="text" id="customer_taxnumber" class="swal2-input" placeholder="Customer Tax Number" name="customer_taxnumber" required>' +
                    '<input type="text" id="city" class="swal2-input" placeholder="Customer City" required name="customer_city">' +
                    '<input type="text" id="customer_address" class="swal2-input" placeholder="Customer Address" name="customer_address" required>' +
                    '<input type="text" id="customer_phonenumber" class="swal2-input" placeholder="Customer Phone Number" name="customer_phonenumber" required>' +
                    '<input type="text" id="customer_city" class="swal2-input" placeholder="Customer City" name="customer_city" required>' +
                    '<select id="customer_status" class="swal2-select" placeholder="Customer Status" required name="customer_status">' +
                    '<option value="active" class="form-control">Active</option>' +
                    '<option value="inactive" class="form-control">Inactive</option></select>' +
                    '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                    '</form>',
                showCancelButton: true,
                confirmButtonText: 'Create',
                cancelButtonText: 'Cancel',
                focusConfirm: false,
                preConfirm: () => {
                    // Collect form data
                    return {
                        customer_name: document.getElementById('customer_name').value,
                        code: document.getElementById('code').value,
                        customer_taxnumber: document.getElementById('customer_taxnumber').value,
                        city: document.getElementById('city').value,
                        customer_address: document.getElementById('customer_address').value,
                        customer_phonenumber: document.getElementById('customer_phonenumber').value,
                        customer_status: document.getElementById('customer_status').value,
                        customer_city: document.getElementById('customer_city').value,
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
                    const csrfTokenInput = document.createElement('input'); 
                    csrfTokenInput.type = 'hidden';
                    csrfTokenInput.name = '_token';
                    csrfTokenInput.value = '{{ csrf_token() }}'; // Use Blade syntax to get the CSRF token
                    form.appendChild(csrfTokenInput);
                    form.submit();

                    // After creating the customer, update the customer dropdown
                    updateCustomerDropdown();
                }
            });
        });

        // Event listener for the 'Process Sale' button
        $("#processSale").on("click", function () {
            //const selectedCustomer = selectedCustomerDropdown.val();// Declare the variable here
            if (selectedItem) {
                // Proceed with the sale, you can add your logic here
                const saleItems = getSaleItems(); // Implement a function to get sale items
                // ...
                Swal.fire({
                    title: 'Sale Completed',
                    icon: 'success',
                    text: `Sale completed for ${selectedItem}`,
                });
            } else {
                
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

            // Set the selected customer in the dropdown
            selectedItem = customer.id;
            selectedCustomerDropdown.val(selectedItem).trigger('change');
        });

        // Append the list item to the list
        resultList.append(listItem);
    });

    // Append the list to the container
    searchResultsContainer.append(resultList);
}


function updateCustomerDropdown() {
            // Clear previous options
            selectedCustomerDropdown.empty();

            // Refresh the customer dropdown options by performing a search
            performSearch("");

            // Optionally, you can add a default option or trigger a search here
        }

        function getSaleItems() {
            // Implement a function to get sale items from your UI or data source
            // For example, you can retrieve them from a form or any other input elements
            // and return them as an array or object
            // ...

            // For demonstration purposes, return an empty array
            return [];
        }
    });
</script>
