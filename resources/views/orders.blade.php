@include('includes.head')
<style>
    /* Default hidden state for each dropdown */
    .dropdown-content-home,
    .dropdown-content-profile,
    .dropdown-content-contact {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 100px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        max-height: 270px;
        /* Limit the height */
        overflow-y: auto;
        /* Add vertical scrollbar when content exceeds the height */
        border-radius: 10px;
    }


    /* Dropdown item styles */
    .dropdown-content-home a,
    .dropdown-content-profile a,
    .dropdown-content-contact a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        transition: background-color 0.3s ease, color 0.3s ease;
        /* Smooth transition for hover effect */
    }

    /* Hover state for dropdown items */
    .dropdown-content-home a:hover,
    .dropdown-content-profile a:hover,
    .dropdown-content-contact a:hover {
        background-color: #000000;
        /* Change background color on hover */
        color: white;
        /* Change text color on hover */
    }


    /* Hover on the tab OR dropdown keeps the dropdown visible */
    .nav-item:hover .dropdown-content-home,
    .nav-item:hover .dropdown-content-profile,
    .nav-item:hover .dropdown-content-contact,
    .dropdown-content-home:hover,
    .dropdown-content-profile:hover,
    .dropdown-content-contact:hover {
        display: block;
    }

    /* When hovered, show the respective dropdown */
    .dropbtn:hover+.dropdown-content-home {
        display: block;
    }

    .dropbtn:hover+.dropdown-content-profile {
        display: block;
    }

    .dropbtn:hover+.dropdown-content-contact {
        display: block;
    }

    /* Custom scrollbar (optional for better design) */
    .dropdown-content-home::-webkit-scrollbar {
        width: 8px;
    }

    .dropdown-content-home::-webkit-scrollbar-thumb {
        background-color: #888;
        /* Customize scrollbar color */
        border-radius: 10px;
    }

    .dropdown-content-home::-webkit-scrollbar-thumb:hover {
        background-color: #555;
        /* Color when hovered */
    }

    .action {
        list-style: none;
        /* Remove default list styling */
        padding: 0;
        /* Remove default padding */
        margin: 0;
        /* Remove default margin */
    }

    .action li {
        display: inline-block;
        /* Align items horizontally */
        margin-right: 10px;
        /* Add space between items */
    }

    .action li:last-child {
        margin-right: 0;
        /* Remove margin from the last item */
    }

    /* Flex container for status items */
    .status-item {
        display: flex;
        justify-content: space-between;
        /* Space between items */
        align-items: center;
        /* Center items vertically */
        padding: 12px 16px;
        /* Add padding for better spacing */
    }

    /* Make sure the status count has a fixed width */
    .status-count {
        margin-left: auto;
        /* Pushes the count to the right */
        text-align: right;
        /* Align text to the right */
        min-width: 50px;
        /* Set a minimum width to ensure alignment */
    }

    /* Optional: Adjust the dropdown item padding */
    .dropdown-content-home a {
        display: flex;
        /* Ensure dropdown items are flex containers */
        padding: 12px 16px;
        /* Consistent padding */
    }
</style>

<body>
    <!-- page-wrapper Start-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
        <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('includes.header')
        <!-- Page sidebar end-->
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-title">
                    <div class="row">
                        <div class="col-sm-6 col-12">
                            <!-- <h2> Orders </h2> -->
                        </div>
                        <div class="col-sm-6 col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i
                                            class="iconly-Home icli svg-color"></i></a></li>
                                <li class="breadcrumb-item">{{ __('messages.recway') }}</li>
                                <li class="breadcrumb-item active">{{ __('messages.orders') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-absolute b-t-primary">
                            <div class="card-header bg-primary">
                                <h3>{{ __('messages.all_current_orders') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <button class="btn btn-primary" style="float: right;margin-left:5px"
                                            id="clearFilter"><i class="fas fa-filter" style="margin-right:5px"></i>
                                            {{ __('messages.clear') }}</button>
                                        <button class="btn btn-primary" style="float: right;" onclick="show_filter()"><i
                                                class="fas fa-filter"
                                                style="margin-right:5px"></i>{{ __('messages.filter') }}</button>
                                    </div>
                                    <div class="col-12" id="filter-buttons">
                                        <h5 style="margin-left: 5px;margin-top: 10px;margin-bottom: 10px;">
                                            <b>{{ __('messages.service_categories') }}</b><small>
                                                ({{ __('messages.click_category_any') }})</small>
                                        </h5>
                                        <ul class="nav mb-2 border-tab" id="top-tab" role="tablist"
                                            style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;">
                                            @php
                                                $orderscount = 0;
                                                if (!empty($orders)) {
                                                    $orderscount = count($orders);
                                                }
                                            @endphp
                                            <div class="col-12 col-md-3">
                                                <div class="card m-1">
                                                    <div class="card-body p-0">
                                                        <button class="btn btn-outline-primary-2x  w-100 active"
                                                            data-category="">{{ __('messages.all_orders') }} <span
                                                                class="badge badge-primary rounded-circle btn-p-space btn-light text-dark ms-2">{{ $orderscount }}</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ($categories as $category)
                                                @php
                                                    $ordersCount = 0;
                                                @endphp
                                                @foreach ($statuses as $status)
                                                    @if ($status->service_cat_id == $category->id)
                                                        @php
                                                            $ordersCount += $status->count;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                <div class="col-12 col-md-3">
                                                    <div class="card m-1">
                                                        <div class="card-body p-0">
                                                            <button class="btn btn-outline-primary-2x  w-100"
                                                                data-id="{{ $category->id }}"
                                                                data-category="{{ $category->id . '' . $category->name }}">{{ $category->name }}<span
                                                                    class="badge badge-primary rounded-circle btn-p-space btn-light text-dark ms-2">{{ $ordersCount }}</span></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </ul>
                                        <div class="row" id="status_row" style="display: none;">
                                            <h5 style="margin-left:10px">
                                                <small>({{ __('messages.click_any_recent_order') }})</small>
                                            </h5>
                                            <div class="col-12"
                                                style="display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;align-items: baseline;margin-bottom:20px">
                                                @foreach ($categories as $category)
                                                    @foreach ($statuses as $status)
                                                        @if ($status->service_cat_id == $category->id)
                                                            <div class="card m-1 statuses-filter"
                                                                data-service-cat="{{ $category->id . '' . $category->name }}">
                                                                <div class="card-body p-0">
                                                                    <button
                                                                        class="btn btn-outline-primary-2x status-filter"
                                                                        data-status-title="{{ $status->id . '' . $status->status }}"
                                                                        data-status-id="{{ $status->id }}"
                                                                        data-category-id="{{ $status->service_cat_id }}">{{ $status->status }}
                                                                        <span
                                                                            class="badge badge-primary rounded-circle btn-p-space btn-light text-dark ms-2">{{ $status->count }}</span></button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div class="table-responsive">
                                            <table class="display" id="data-source-1" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>{{ __('messages.order_id') }}</th>
                                                        <th>{{ __('messages.candidate') }}</th>
                                                        <th>{{ __('messages.status') }}</th>
                                                        <th>{{ __('messages.interview_date') }}</th>
                                                        <th>{{ __('messages.delievery_date') }}</th>
                                                        <th>{{ __('messages.service_type') }}</th>
                                                        @if (isset($company_manager) && !empty($company_manager))
                                                            <th>{{ __('messages.customer') }}</th>
                                                        @endif
                                                        <th>{{ __('messages.staff') }}</th>
                                                        <th>{{ __('messages.archive_time') }} </th>
                                                        <th style="width: 13% !important;">
                                                            {{ __('messages.action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($orders as $order)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td><a class="text-dark"
                                                                    href="{{ route('viewOrder', ['id' => $order->id]) }}"
                                                                    style="text-decoration:none">{{ $order->order_id ?? 'N/A' }}</a>
                                                            </td>
                                                            <td onmouseover="showCard('history_log<?= $order->id ?>')"
                                                                onmouseout="hideCard('history_log<?= $order->id ?>')"><a
                                                                    class="text-dark"
                                                                    href="{{ route('viewOrder', ['id' => $order->id]) }}"
                                                                    class="name_td"
                                                                    style="text-decoration:none">{{ $order->name . ' ' . $order->surname }}</a>
                                                            </td>
                                                            <td>
                                                                <span
                                                                    style="display:none">{{ $order->service_category_id . '' . $order->service_category_name }}</span>
                                                                <span
                                                                    style="display:none">{{ $order->status . '' . $order->status_title }}</span>
                                                                <span class="badge badge-pill"
                                                                    style="background-color: <?= $order->status_color ?>;">{{ $order->status_title }}</span>
                                                            </td>
                                                            <td>{{ $order->booked ?? 'Null' }}</td>
                                                            <td>{{ $order->delivery_date ?? 'Null' }}</td>
                                                            <td>{{ $order->interview_title ?? 'Null' }}</td>
                                                            <td>{{ $order->staff->name ?? 'N/A' }}</td>
                                                            <td>{{ $order->days_to_archive ?? 'N/A' }}</td>
                                                            <td style="width: 12% !important;text-align:center">
                                                                @if ($order->status != 9 && $order->status != 40)
                                                                    <a href="{{ route('editOrder', ['id' => $order->id]) }}"
                                                                        class="btn btn-primary m-r-10"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        data-bs-title="Edit">
                                                                        <i class="icon-pencil-alt"></i>
                                                                    </a>
                                                                @endif
                                                                <a href="{{ route('viewOrder', ['id' => $order->id]) }}"
                                                                    class="btn btn-secondary m-r-10"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="View">
                                                                    <i class="icon-eye"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($orders as $order)
                <div class="card order-logs-card" style="display: none;" id="history_log<?= $order->id ?>"
                    onmouseover="cancelHide('history_log<?= $order->id ?>')"
                    onmouseout="forceHide('history_log<?= $order->id ?>')">
                    <div class="card-header pb-0 card-no-border">
                        <h3>{{ getTranslatedText('order_logs') }}</h3>
                    </div>
                    <div class="card-body notification">
                        <ul>
                            @if (!empty($history))
                                @foreach ($history as $h)
                                    @if ($h->order_id == $order->id)
                                        <li class="d-flex">
                                            <div class="activity-dot-danger"></div>
                                            <div class="w-100 ms-3">
                                                <p class="d-flex justify-content-between mb-2"><span
                                                        class="date-content bg-light-dark">{{ \Carbon\Carbon::parse($h->date_time)->format('jS M, Y') }}
                                                    </span><span>{{ \Carbon\Carbon::parse($h->date_time)->format('H:i:s') }}</span>
                                                </p>
                                                <h6 class="f-w-600">{{ $h->desc }}</h6>
                                                <p class="f-m-light">{!! !empty($h->comment) ? 'Comment: ' . $h->comment : '' !!}</p>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <li>
                                    <div class="time">{{ getTranslatedText('no_record_found') }}</div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            @endforeach
            <!-- Container-fluid starts  -->
        </div>

        @include('includes.footer')
        <script>
            //     // Select all the nav items with dropdown
            // document.querySelectorAll('.nav-item.dropdown').forEach(function(item) {

            // // Add event listeners for mouse enter and mouse leave
            // item.addEventListener('mouseenter', function() {
            //     this.classList.add('show'); // Bootstrap dropdown show class
            //     this.querySelector('.dropdown-menu').classList.add('show'); // Show the dropdown
            // });

            // item.addEventListener('mouseleave', function() {
            //     this.classList.remove('show'); // Remove show class
            //     this.querySelector('.dropdown-menu').classList.remove('show'); // Hide the dropdown
            // });
            // });

            // On status selection from the dropdown

            // $(document).ready(function() {
            //     $('.status-filter').on('click', function(e) {
            //         e.preventDefault();

            //         var statusId = $(this).data('status-id'); // Get the selected status ID
            //         var categoryId = $(this).data('category-id'); // Get the selected category ID

            //         // Call the function to modify table columns based on the selected category
            //         modifyTableColumns(categoryId);

            //         // Make an AJAX request to send the status and category IDs to the server
            //         $.ajax({
            //             url: '{{ route('update.status') }}', // Laravel route to handle status update
            //             method: 'POST',
            //             data: {
            //                 _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for security
            //                 status_id: statusId,
            //                 category_id: categoryId
            //             },
            //             success: function(response) {
            //                 // Clear the existing table rows
            //                 $('#data-source-1 tbody').empty();

            //                 // Check if the returned data is empty
            //                 if (response.data.length === 0) {
            //                     // If no data, append a message to indicate the table is empty
            //                     var noDataHtml = `
    //             <tr>
    //                 <td colspan="9" class="text-center">No data available for this status.</td>
    //             </tr>
    //         `;
            //                     $('#data-source-1 tbody').append(noDataHtml);
            //                 } else {
            //                     // Loop through the returned data and append rows to the table based on category
            //                     $.each(response.data, function(index, order) {
            //                         var rowHtml = '';

            //                         if (categoryId == '1') { // Default columns
            //                             rowHtml = `
    //                     <tr>
    //                         <td>${index + 1}</td>
    //                         <td>${order.order_id || 'N/A'}</td>
    //                         <td>${order.name || 'N/A'}</td>
    //                         <td><span class="badge badge-pill" style="background-color: ${order.status_color};">${order.status_title}</span></td>
    //                         <td>${order.booked || 'Null'}</td>
    //                         <td>${order.interview_title || 'Null'}</td>
    //                         <td>${order.delivery_date || 'Null'}</td>
    //                         <td>${order.staff_name || 'N/A'}</td>
    //                         <td>
    //                             <ul class="action">
    //                                 <li>
    //                                     <a href="{{ route('viewOrder', ['id' => '']) }}/${order.id}" class="btn btn-warning">
    //                                         <i class="icon-eye"></i>
    //                                     </a>
    //                                 </li>
    //                             </ul>
    //                         </td>
    //                     </tr>
    //                 `;
            //                         } else if (categoryId == '3') { // Category 3 columns
            //                             rowHtml = `
    //                     <tr>
    //                         <td>${index + 1}</td>
    //                         <td>${order.order_id || 'N/A'}</td>
    //                         <td>${order.name || 'N/A'}</td>
    //                         <td><span class="badge badge-pill" style="background-color: ${order.status_color};">${order.status_title}</span></td>
    //                         <td>${order.interview_title || 'Null'}</td>
    //                         <td>${order.staff_name || 'N/A'}</td>
    //                         <td>
    //                             <ul class="action">
    //                                 <li>
    //                                     <a href="{{ route('viewOrder', ['id' => '']) }}/${order.id}" class="btn btn-warning">
    //                                         <i class="icon-eye"></i>
    //                                     </a>
    //                                 </li>
    //                             </ul>
    //                         </td>
    //                     </tr>
    //                 `;
            //                         } else if (categoryId == '9') { // Category 9 columns
            //                             rowHtml = `
    //                     <tr>
    //                         <td>${index + 1}</td>
    //                         <td>${order.order_id || 'N/A'}</td>
    //                         <td><span class="badge badge-pill" style="background-color: ${order.status_color};">${order.status_title}</span></td>
    //                         <td>${order.interview_title || 'Null'}</td>
    //                         <td>${order.service_type || 'Null'}</td>
    //                         <td>${order.delivery_date || 'Null'}</td>
    //                         <td>${order.staff_name || 'N/A'}</td>
    //                         <td>
    //                             <ul class="action">
    //                                 <li>
    //                                     <a href="{{ route('viewOrder', ['id' => '']) }}/${order.id}" class="btn btn-warning">
    //                                         <i class="icon-eye"></i>
    //                                     </a>
    //                                 </li>
    //                             </ul>
    //                         </td>
    //                     </tr>
    //                 `;
            //                         }

            //                         // Append the row to the table body
            //                         $('#data-source-1 tbody').append(rowHtml);
            //                     });
            //                 }
            //             },
            //             error: function(xhr, status, error) {
            //                 console.log('Error:', error);
            //             }
            //         });
            //     });
            // });


            function modifyTableColumns(categoryId) {
                var table = $('#data-source-1 thead tr');
                var tableBody = $('#data-source-1 tbody');

                // Reset the table columns (show all initially)
                table.find('th').show();
                tableBody.find('tr td').show();

                if (categoryId == '3') {
                    // Hide interview date & service type for category 3
                    table.find('th:nth-child(6), th:nth-child(7)').hide();
                    tableBody.find('tr td:nth-child(6), td:nth-child(7)').hide();
                } else if (categoryId == '9') {
                    // Hide candidate & staff for category 9
                    table.find('th:nth-child(3)').hide();
                    tableBody.find('tr td:nth-child(3)').hide();
                }
            }
        </script>
        <script>
            $(document).ready(function() {
                var savedFilter = sessionStorage.getItem('selectedFilter');
                if (savedFilter) {
                    filterTableByStatus(savedFilter);
                }
            });
            $(document).on('click', '#clearFilter', function() {
                sessionStorage.removeItem('selectedFilter');
                sessionStorage.removeItem("activeCategory");
                sessionStorage.removeItem("activeStatus");
                filterTableByStatus('');
                $('.btn-outline-primary-2x.w-100').removeClass('active');
                $('.btn-outline-primary-2x.w-100[data-category=""]').addClass('active');
                $('#status_row').hide();
                $('.statuses-filter').hide();
            });

            $(document).ready(function() {
                var selectedCategory = sessionStorage.getItem("activeCategory");
                var selectedStatus = sessionStorage.getItem("activeStatus");
                if (selectedCategory) {
                    $(`.btn-outline-primary-2x.w-100[data-category='${selectedCategory}']`).trigger("click");
                }
                if (selectedStatus) {
                    $(`.status-filter[data-status-id='${selectedStatus}']`).trigger("click");
                    $(`.status-filter[data-status-id='${selectedStatus}']`).addClass('active')
                }
            });
            $(document).on('click', '.btn-outline-primary-2x.w-100', function(e) {
                e.preventDefault();
                var statusId = $(this).data('category');
                sessionStorage.setItem("activeCategory", statusId);
            });
            $(document).on('click', '.status-filter', function() {
                var statusId = $(this).data('status-id');
                sessionStorage.setItem("activeStatus", statusId);
            });

            function show_filter() {
                if ($('#filter-buttons').is(':hidden')) {
                    $('#filter-buttons').slideDown();
                } else {
                    $('#filter-buttons').slideUp();
                }
            }

            function append_id(id) {
                $('input[name="id"]').val(id)
            }
            $(document).on('click', '.status-filter', function(e) {
                e.preventDefault();

                var statusId = $(this).data('status-title');

                filterTableByStatus(statusId);
            });
            $(document).on('click', '.btn-outline-primary-2x.w-100', function(e) {
                e.preventDefault();
                var table = $('#data-source-1').DataTable();
                $('.btn-outline-primary-2x.w-100').removeClass('active')
                $(this).addClass('active')
                var statusId = $(this).data('category');

                var id = $(this).data('id');
                if (id == 3) {
                    table.column(5).visible(true);
                    table.column(4).visible(false);
                } else {
                    table.column(4).visible(true);
                    table.column(5).visible(false);
                }

                if (statusId != '') {
                    $('#status_row').show();
                    $('.statuses-filter').hide();
                    $(`div[data-service-cat='${statusId}']`).each(function() {
                        $(this).show();
                    });
                } else {
                    $('#status_row').hide();
                }
                filterTableByStatus(statusId);
            });

            function filterTableByStatus(statusId) {
                var table = $('#data-source-1').DataTable();
                var searchValue = statusId;
                if (searchValue) {
                    table.column(3).search(searchValue, true, false).draw();
                } else {
                    table.column(3).search('').draw();
                }
            }
        </script>
