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
                        <h4 class = "text-center">Welcome {{$name}}</h4>
                        <input type="text" id="search" class="form-control border border-2 p-2" placeholder="Search Customer">
                        <div id="searchResults"></div>
                    </div>
                    <div class="col-md-4">
                        <a class="btn btn-danger" id = "createCustomer" role="tab" aria-selected="true">
                            <i class="material-icons text-lg position-relative"></i>
                            <span class="ms-1"></span><i class = "fa fa-user"></i>Create Customer
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
                $(this).val("");
                performSearch(searchInput.val());
            }, 300);
            //button that will be clicked and save a customer to the database....
            $("#createCustomer").on("click",function(){
            Swal.fire({
            title: 'Create Customer',
            icon: 'info',
            html:
                '<input id="customerName" class="swal2-input form-control" placeholder="Customer Name">' +
                '<input id="code" class="swal2-input" placeholder="Code">' +
                '<input id="taxNumber" class="swal2-input" placeholder="Customer Tax Number">' +
                '<input id="city" class="swal2-input" placeholder="Customer City">' +
                '<input id="address" class="swal2-input" placeholder="Customer Address">' +
                '<select id="status" class="swal2-select" placeholder="Customer Status">' +
                '<option value="active" class = "form-control">Active</option>' +
                '<option value="inactive" class = "form-control">Inactive</option></select>',
            showCancelButton: true,
            confirmButtonText: 'Create',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
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
                // Handle the data submitted by the user (result.value)
                console.log(result.value);
                // You can perform further actions here, like sending the data to the server
            }
        });
    });
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
                    showAlert('Customer Not Found','error');
                }
            });
        }

        function showAlert(message,errorIconMessage){
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
                const listItem = $('<li class="list-group-item clickable list-group-item active">' + customer.customer_name + '</li>');

                // Add a click event listener
                listItem.on("click", function () {
                    // Show a SweetAlert with payment methods
                    showPaymentMethodsAlert(customer.payment_methods);
                });

                // Append the list item to the list
                resultList.append(listItem);
            });

            // Append the list to the container
            searchResultsContainer.append(resultList);
        }

        function showPaymentMethodsAlert(paymentMethods) {
            // Use SweetAlert to show a customized alert
            Swal.fire({
                title: 'How Would You Like The Customer To Receive Their Receipt',
                icon: 'info',
                html: '<button class="btn btn-success" onclick="printReceipt()">Print Receipt</button>' +
                      '<button class="btn btn-primary" onclick="saveReceipt()">Save Receipt</button>',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                showCloseButton: true,
            });
        }

        // Function to simulate printing receipt
        function printReceipt() {
            Swal.fire('Receipt printed!', '', 'success');
        }

        // Function to simulate saving receipt
        function saveReceipt() {
            Swal.fire('Receipt saved!', '', 'success');
        }
    });
</script>

