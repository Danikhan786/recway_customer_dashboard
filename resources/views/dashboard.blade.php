@include('includes.head')


<?php
date_default_timezone_set('Europe/Stockholm');

$current_time = date('h:i A');

?>
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
<style>
    .bg-gradient {
        border-radius: 50%;
        /* Make it a circle */
        padding: 15px;
        /* Space around the icon */
        display: flex;
        /* Center the icon */
        align-items: center;
        /* Center vertically */
        justify-content: center;
        /* Center horizontally */
    }


    .donut-legend {
        display: flex;
        /* Use flexbox for alignment */
        flex-wrap: wrap;
        /* Allow wrapping if necessary */
        align-items: center;
        /* Center items vertically */
    }

    .donut-legend span {
        display: flex;
        /* Use flexbox for each legend item */
        align-items: center;
        /* Center circle and text vertically */
        margin-right: 15px;
        /* Space between legend items */
        font-weight: bold;
        /* Makes the text bold */
    }

    .donut-legend i {
        width: 12px;
        /* Width of the color box */
        height: 12px;
        /* Height of the color box */
        border-radius: 50%;
        /* Makes the box circular */
        display: inline-block;
        /* Ensures the box displays inline */
        margin-right: 5px;
        /* Space between color box and text */
        margin-top: 0;
        /* Remove margin-top */
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

    .status-filter.active {
        background-color: #007bff;
        /* Change this to your preferred active color */
        color: white;
    }

    .dataTables_wrapper table.dataTable th,
    .dataTables_wrapper table.dataTable td {
        font-size: small;
    }

    .dataTables_wrapper table.dataTable th,
    .dataTables_wrapper table.dataTable td a {
        font-size: small;
    }

    table.dataTable thead>tr>th.sorting_asc,
    table.dataTable thead>tr>th.sorting_desc,
    table.dataTable thead>tr>th.sorting,
    table.dataTable thead>tr>td.sorting_asc,
    table.dataTable thead>tr>td.sorting_desc,
    table.dataTable thead>tr>td.sorting {
        padding-right: 15px !important;
    }
</style>

<body>
    <!-- page-wrapper Start-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
        <div class="loader" style="color:red;fill:red"><span></span><span></span><span></span><span></span><span></span>
        </div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('includes.header')
        <div class="page-body">
            <div class="container-fluid">
                <div class="page-title">
                </div>
            </div>
            <!-- Container-fluid starts-->

            <div class="container-fluid default-dashboard" style="display: none;">
                <div class="row">
                    <div class="col-xl-12 col-sm-12 box-col-12">
                        @if (session('success'))
                            <button class="btn btn-secondary sweet-13" type="button"
                                onclick="_gaq.push(['_trackEvent', 'example', 'try', 'sweet-13']);"
                                style="display:none">Alert</button>
                        @endif
                        <div class="card welcome-banner">
                            <div class="card-header p-0 card-no-border">
                                <div class="welcome-card" style="height:120px !important">
                                    <img class="w-100 img-fluid" src="assets/images/dashboard-1/welcome-bg.png"
                                        alt="" />
                                    <img class="position-absolute img-1 img-fluid"
                                        src="assets/images/dashboard-1/img-1.png" alt="" />
                                    <img class="position-absolute img-2 img-fluid"
                                        src="assets/images/dashboard-1/img-2.png" alt="" />
                                    <img class="position-absolute img-3 img-fluid"
                                        src="assets/images/dashboard-1/img-3.png" alt="" />
                                    <img class="position-absolute img-4 img-fluid"
                                        src="assets/images/dashboard-1/img-4.png" alt="" />
                                    <img class="position-absolute img-5 img-fluid"
                                        src="assets/images/dashboard-1/img-5.png" alt="" />
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="d-flex align-center">
                                    <h1>{{ __('messages.hello') }}, {{ Auth::user()->name }} <img
                                            src="assets/images/dashboard-1/hand.png" alt="" /></h1>
                                </div>
                                {{ getTranslatedText('hello_message') }}
                                <div class="d-flex align-center justify-content-between mt-2">
                                    <a class="btn btn-primary"
                                        href="{{ route('create_order') }}">{{ __('messages.create_order') }}</a>
                                    <span>
                                        <i class="fa-sharp-duotone fa-solid fa-clock"></i>
                                        <span id="current_time" style="padding: 0px;border-color: transparent;"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
          <div class="col-xxl-12 col-xl-12 col-lg-12 box-col-12">
            <div class="card analytics-card">
              <div class="card-header card-no-border pb-0">
                <div class="header-top">
                  <h3>Orders</h3>
                </div>
              </div>
              <div class="card-body sale-chart-box">
                <div id="chart-school-performance"></div>
              </div>
            </div>
          </div>
        </div> -->

                <div class="row">
                    @php
                        // Calculate the column class based on the number of active categories
                        $colClass = '';
                        if ($activeCategories == 1) {
                            $colClass = 'col-12';
                        } elseif ($activeCategories == 2) {
                            $colClass = 'col-6';
                        } else {
                            $colClass = 'col-4';
                        }
                    @endphp

                    <!-- @if ($interviewCount > 0)
<div class="{{ $colClass }}">
              <div class="card pie-card">
                <div class="card-header card-no-border pb-0">
                  <div class="header-top">
                    <h3>Interviews</h3>
                  </div>
                </div>
                <div class="card-body revenue-category">
                  <div class="interviews-chart" id="interviews-chart"></div>
                  <div class="donut-legend" id="interviews-legend"></div>
                </div>
              </div>
            </div>
@endif

          @if ($backgroundCheckCount > 0)
<div class="{{ $colClass }}">
              <div class="card pie-card">
                <div class="card-header card-no-border pb-0">
                  <div class="header-top">
                    <h3>Background Check</h3>
                  </div>
                </div>
                <div class="card-body revenue-category">
                  <div class="background-check-chart" id="background-check-chart"></div>
                  <div class="donut-legend" id="background-check-legend"></div>
                </div>
              </div>
            </div>
@endif

          @if ($followUpCount > 0)
<div class="{{ $colClass }}">
              <div class="card pie-card">
                <div class="card-header card-no-border pb-0">
                  <div class="header-top">
                    <h3>Follow Up Check</h3>
                  </div>
                </div>
                <div class="card-body revenue-category">
                  <div class="follow-up-check-chart" id="follow-up-check-chart"></div>
                  <div class="donut-legend" id="follow-up-check-legend"></div>
                </div>
              </div>
            </div>
@endif -->
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-absolute b-t-primary">
                            <div class="card-header bg-primary">
                                <h3>{{ __('messages.recent_orders') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <button class="btn btn-primary" style="float: right;margin-left:5px"
                                            id="clearFilter"><i class="fas fa-filter"
                                                style="margin-right:5px"></i>{{ __('messages.clear') }}</button>
                                        <button class="btn btn-primary" style="float: right;"
                                            onclick="show_filter()"><i class="fas fa-filter"
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
                                                $recentorderscount = 0;
                                                if (!empty($recentOrders)) {
                                                    $recentorderscount = count($recentOrders);
                                                }
                                            @endphp
                                            <div class="col-12 col-md-3">
                                                <div class="card m-1">
                                                    <div class="card-body p-0">
                                                        <button class="btn btn-outline-primary-2x w-100 active"
                                                            data-category="">{{ __('messages.all_orders') }}
                                                            <span
                                                                class="badge badge-primary rounded-circle btn-p-space btn-light text-dark ms-2">{{ $recentorderscount }}</span></button>
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
                                                            <button class="btn btn-outline-primary-2x w-100"
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
                                                        <th style="width: 60px;display: flex;flex-direction: column;">
                                                            {{ __('messages.order_id') }}</th>
                                                        <th>{{ __('messages.candidate') }}</th>
                                                        <th>{{ __('messages.status') }}</th>
                                                        <th style="width: auto;display: flex;flex-direction: column;">
                                                            {{ __('messages.interview_date') }}</th>
                                                        <th>{{ __('messages.delievery_date') }}</th>
                                                        <th>{{ __('messages.service_type') }}</th>
                                                        @if (isset($company_manager) && !empty($company_manager))
                                                            <th>Customer Name</th>
                                                        @endif
                                                        <th>{{ __('messages.staff') }}</th>
                                                        <th>{{ __('messages.archive_time') }}</th>
                                                        <th style="width: 13% !important;">{{ __('messages.action') }}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($recentOrders as $recentOrder)
                                                        @if ($recentOrder->days_to_archive != 'already_archived')
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td><a class="text-dark"
                                                                        href="{{ route('viewOrder', ['id' => $recentOrder->id]) }}"
                                                                        style="text-decoration:none">{{ $recentOrder->order_id ?? 'N/A' }}</a>
                                                                </td>
                                                                <td onmouseover="showCard('history_log<?= $recentOrder->id ?>')"
                                                                    onmouseout="hideCard('history_log<?= $recentOrder->id ?>')">
                                                                    <a class="text-dark"
                                                                        href="{{ route('viewOrder', ['id' => $recentOrder->id]) }}"
                                                                        class="name_td"
                                                                        style="text-decoration:none">{{ $recentOrder->name . ' ' . $recentOrder->surname }}</a>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        style="display:none">{{ $recentOrder->service_category_id . '' . $recentOrder->service_category_name }}</span>
                                                                    <span
                                                                        style="display:none">{{ $recentOrder->status . '' . $recentOrder->status_title }}</span>
                                                                    <span class="badge badge-pill"
                                                                        style="background-color: <?= $recentOrder->status_color ?>;">{{ $recentOrder->status_title }}</span>
                                                                </td>
                                                                <td>{{ $recentOrder->booked ?? 'Null' }}</td>
                                                                <td>{{ $recentOrder->delivery_date ?? 'Null' }}</td>
                                                                <td>{{ $recentOrder->interview_title ?? 'Null' }}</td>
                                                                @if (isset($company_manager) && !empty($company_manager))
                                                                    <td>{{ $recentOrder->cus_name ?? 'N/A' }}</td>
                                                                @endif
                                                                <td>{{ $recentOrder->staff->name ?? 'N/A' }}</td>
                                                                <td>{{ $recentOrder->days_to_archive ?? 'N/A' }}</td>
                                                                <td style="width: 12% !important;text-align:center">
                                                                    <a href="{{ route('viewOrder', ['id' => $recentOrder->id]) }}"
                                                                        class="btn btn-secondary m-r-10"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top" data-bs-title="View">
                                                                        <i class="icon-eye"></i>
                                                                    </a>
                                                                    @if ($recentOrder->status != 9)
                                                                        <a href="{{ route('editOrder', ['id' => $recentOrder->id]) }}"
                                                                            class="btn btn-primary m-r-10"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top"
                                                                            data-bs-title="Edit">
                                                                            <i class="icon-pencil-alt"></i>
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
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
        </div>

        <div class="container-fluid default-dashboard">
            <div class="row">

                <div class="col-xl-12 col-sm-12 box-col-12 mb-3">
                    <div class="row">
                        <div class="col-sm-6 col-6 ">
                            <div class="card small-widget mb-sm-2" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <a href="{{ route('orders') }}">
                                    <div class="card-body primary d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-end gap-1 text-dark">
                                                <h3> {{ __('messages.my_current_orders') }}</h3>
                                            </div>
                                            <?php $grand_total = $totalOrdersCount - $filteredOrdersCount; ?>
                                            <span style="font-size:15px"
                                                class="f-light text-dark">{{ $totalOrdersCount - $grand_total }}</span>
                                        </div>
                                        <div class="bg-gradient rounded-icon"
                                            style="background: linear-gradient(144.16deg, rgba(48, 142, 135, 0.1) 19.06%, rgba(48, 142, 135, 0) 79.03%) !important">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                width="24" height="24" color="#000000" fill="none">
                                                <path
                                                    d="M3 11C3 7.25027 3 5.3754 3.95491 4.06107C4.26331 3.6366 4.6366 3.26331 5.06107 2.95491C6.3754 2 8.25027 2 12 2C15.7497 2 17.6246 2 18.9389 2.95491C19.3634 3.26331 19.7367 3.6366 20.0451 4.06107C21 5.3754 21 7.25027 21 11V13C21 16.7497 21 18.6246 20.0451 19.9389C19.7367 20.3634 19.3634 20.7367 18.9389 21.0451C17.6246 22 15.7497 22 12 22C8.25027 22 6.3754 22 5.06107 21.0451C4.6366 20.7367 4.26331 20.3634 3.95491 19.9389C3 18.6246 3 16.7497 3 13V11Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M15 9.5L7 9.5M10 14.5H7" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                            </div>
                            </a>
                        </div>

                        <div class="col-sm-6 col-6">
                            <div class="card small-widget mb-sm-2" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                <a href="{{ route('history') }}">
                                    <div class="card-body primary d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="d-flex align-items-end gap-1 text-dark">
                                                <h3>{{ __('messages.archive_order') }}</h3>
                                            </div>
                                            <span style="font-size:15px"
                                                class="f-light text-dark">{{ $totalHistoryCount + $grand_total }}</span>
                                        </div>
                                        <div class="bg-gradient rounded-icon"
                                            style="background: linear-gradient(144.16deg, rgba(234, 146, 0, 0.1) 19.06%, rgba(234, 146, 0, 0) 79.03%) !important">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                width="24" height="24" color="#000000" fill="none">
                                                <path
                                                    d="M11.0065 21H9.60546C6.02021 21 4.22759 21 3.11379 19.865C2 18.7301 2 16.9034 2 13.25C2 9.59661 2 7.76992 3.11379 6.63496C4.22759 5.5 6.02021 5.5 9.60546 5.5H13.4082C16.9934 5.5 18.7861 5.5 19.8999 6.63496C20.7568 7.50819 20.9544 8.7909 21 11"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M18.85 18.85L17.5 17.95V15.7M13 17.5C13 19.9853 15.0147 22 17.5 22C19.9853 22 22 19.9853 22 17.5C22 15.0147 19.9853 13 17.5 13C15.0147 13 13 15.0147 13 17.5Z"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M16 5.5L15.9007 5.19094C15.4056 3.65089 15.1581 2.88087 14.5689 2.44043C13.9796 2 13.197 2 11.6316 2H11.3684C9.80304 2 9.02036 2 8.43111 2.44043C7.84186 2.88087 7.59436 3.65089 7.09934 5.19094L7 5.5"
                                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- @if ($interviewCount > 0)
<div class="col-sm-6">
                <div class="card small-widget mb-sm-2" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                  <div class="card-body primary d-flex justify-content-between align-items-center">
                    <div>
                      <span style="font-size:15px" class="f-light">Interviews</span>
                      <div class="d-flex align-items-end gap-1">
                        <h3>{{ $interviewCount }}</h3>
                      </div>
                    </div>
                    <div class="bg-gradient rounded-icon" style="background: linear-gradient(144.16deg, rgba(234, 146, 0, 0.1) 19.06%, rgba(234, 146, 0, 0) 79.03%) !important">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                        <path d="M22 7.28342C22 9.92499 19.7611 12.0668 17 12.0668C16.6753 12.0672 16.3516 12.0372 16.0327 11.9773C15.8031 11.9342 15.6883 11.9127 15.6082 11.9249C15.5281 11.9371 15.4145 11.9975 15.1874 12.1183C14.545 12.4599 13.7959 12.5806 13.0755 12.4466C13.3493 12.1098 13.5363 11.7057 13.6188 11.2725C13.6688 11.0075 13.545 10.7501 13.3594 10.5617C12.5166 9.70583 12 8.5526 12 7.28342C12 4.64184 14.2388 2.50006 17 2.50006C19.7611 2.50006 22 4.64184 22 7.28342Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round" />
                        <path d="M15.4922 7.5H15.5003M18.4922 7.5H18.5003" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        <path d="M7.50189 21.5001H4.71817C4.39488 21.5001 4.07021 21.4546 3.77327 21.327C2.80666 20.9117 2.31624 20.3633 2.08769 20.0202C1.95764 19.8251 1.97617 19.5764 2.11726 19.389C3.23716 17.9015 5.83846 17.0031 7.50665 17.003C9.17484 17.0031 11.7714 17.9015 12.8913 19.389C13.0324 19.5764 13.0509 19.8251 12.9209 20.0202C12.6923 20.3633 12.2019 20.9117 11.2353 21.327C10.9383 21.4546 10.6137 21.5001 10.2904 21.5001H7.50189Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10.2854 11.7889C10.2854 13.3202 9.04129 14.5616 7.50664 14.5616C5.97199 14.5616 4.72791 13.3202 4.72791 11.7889C4.72791 10.2576 5.97199 9.01624 7.50664 9.01624C9.04129 9.01624 10.2854 10.2576 10.2854 11.7889Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
@endif
              @if ($backgroundCheckCount > 0)
<div class="col-sm-6">
                <div class="card small-widget mb-sm-2" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                  <div class="card-body primary d-flex justify-content-between align-items-center">
                    <div>
                      <span style="font-size:15px" class="f-light">Background Check</span>
                      <div class="d-flex align-items-end gap-1">
                        <h3>{{ $backgroundCheckCount }}</h3>

                      </div>
                    </div>
                    <div class="bg-gradient rounded-icon" style="background: linear-gradient(144.16deg, rgba(48, 142, 135, 0.1) 19.06%, rgba(48, 142, 135, 0) 79.03%) !important">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                        <path d="M22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12Z" stroke="currentColor" stroke-width="1.5" />
                        <path d="M12.2422 17V12C12.2422 11.5286 12.2422 11.2929 12.0957 11.1464C11.9493 11 11.7136 11 11.2422 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.992 8H12.001" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
@endif
              @if ($followUpCount > 0)
<div class="col-sm-6">
                <div class="card small-widget mb-sm-2" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                  <div class="card-body primary d-flex justify-content-between align-items-center">
                    <div>
                      <span style="font-size:15px" class="f-light">Follow Up</span>
                      <div class="d-flex align-items-end gap-1">
                        <h3>{{ $followUpCount }}</h3>

                      </div>
                    </div>
                    <div class="bg-gradient rounded-icon" style="background: linear-gradient(144.16deg, rgba(48, 142, 135, 0.1) 19.06%, rgba(48, 142, 135, 0) 79.03%) !important">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                        <path d="M22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22C17.5228 22 22 17.5228 22 12Z" stroke="currentColor" stroke-width="1.5" />
                        <path d="M8 12.5L10.5 15L16 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                    </div>
                  </div>
                </div>
              </div>
@endif -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($recentOrders as $recentOrder)
        <div class="card order-logs-card" style="display: none;" id="history_log<?= $recentOrder->id ?>"
            onmouseover="cancelHide('history_log<?= $recentOrder->id ?>')"
            onmouseout="forceHide('history_log<?= $recentOrder->id ?>')">
            <div class="card-header pb-0 card-no-border">
                <h3>{{ getTranslatedText('order_logs') }}</h3>
            </div>
            <div class="card-body notification">
                <ul>
                    @if (!empty($history))
                        @foreach ($history as $h)
                            @if ($h->order_id == $recentOrder->id)
                                @if (strtotime($h->date_time) < time())
                                    <li class="d-flex">
                                        <div class="activity-dot-danger"></div>
                                        <div class="w-100 ms-3">
                                            <p class="d-flex justify-content-between mb-2"><span
                                                    class="date-content bg-light-dark">{{ \Carbon\Carbon::parse($h->date_time)->format('jS M, Y') }}
                                                </span><span>{{ \Carbon\Carbon::parse($h->date_time)->format('h:i:s') }}</span>
                                            </p>
                                            <h6 class="f-w-600">{{ $h->desc }}</h6>
                                            <p class="f-m-light">{!! !empty($h->comment) ? 'Comment: ' . $h->comment : '' !!}</p>
                                        </div>
                                    </li>
                                @endif
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

    @include('includes.footer')
    <script>
        // JSON data from the controller
        var interviewsData = @json($interviewsData);
        var backgroundCheckData = @json($backgroundCheckData);
        var followUpData = @json($followUpData);
        var months = @json($months);

        const ChartOptions = {
            series: [{
                    name: "Interviews",
                    data: interviewsData,
                },
                {
                    name: "Background Check",
                    data: backgroundCheckData,
                },
                {
                    name: "Follow Up - Interviews",
                    data: followUpData,
                },
            ],
            chart: {
                height: 270,
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false,
            },
            colors: [
                AdmiroAdminConfig.secondary,
                AdmiroAdminConfig.primary,
                "#FF6347"
            ],
            stroke: {
                curve: "smooth",
                width: 5,
            },
            grid: {
                show: true,
                borderColor: "#E5E5E5",
            },
            yaxis: {
                labels: {
                    show: true,
                    style: {
                        fontWeight: 500,
                        fontSize: '14px',
                        colors: "#AAA3A0",
                    },
                    formatter: (value) => value, // Direct value without modification
                },
                min: 0,
                max: 20,
            },
            xaxis: {
                type: "category",
                categories: months, // Dynamically populate the months from the controller
                tickAmount: 12, // Same number of ticks as categories
                labels: {
                    show: true,
                    rotate: -45, // Rotate to avoid overlap
                    style: {
                        fontWeight: 500,
                        fontSize: '12px',
                        colors: "#AAA3A0",
                    },
                },
                axisBorder: {
                    show: true,
                },
            },
            legend: {
                show: false,
            },
            responsive: [{
                breakpoint: 361,
                options: {
                    chart: {
                        height: 190,
                    },
                },
            }],
        };


        const ChartEl = new ApexCharts(
            document.querySelector("#chart-school-performance"),
            ChartOptions
        );
        ChartEl.render();


        $(document).ready(function() {
            // Color arrays for each chart
            var interviewColors = [
                "#1A73E8",
                "#ffa200",
                "#008B8B",
                "#00FF00",
                "#FF0000",
                "#7b94a8"
            ];

            var backgroundCheckColors = [
                "#1a73e8",
                "#ffa200",
                "#bbec09",
                "#747d68",
                "#c3c2ff",
                "#8f1414"
            ];

            var followUpColors = [
                "#000000",
                "#2e93ff",
                "#e0ecff",
                "#000000",
            ];

            // Sample data with Blade syntax
            var interviewData = [{
                label: "New Order",
                value: {
                    {
                        $interviewStatusCount['new_order']
                    }
                }
            }, {
                label: "Pending",
                value: {
                    {
                        $interviewStatusCount['pending']
                    }
                }
            }, {
                label: "Booked",
                value: {
                    {
                        $interviewStatusCount['booked']
                    }
                }
            }, {
                label: "Approved",
                value: {
                    {
                        $interviewStatusCount['approved']
                    }
                }
            }, {
                label: "Denied",
                value: {
                    {
                        $interviewStatusCount['denied']
                    }
                }
            }, {
                label: "Cancel By Customer",
                value: {
                    {
                        $interviewStatusCount['cancel_by_customer']
                    }
                }
            }];

            var backgroundCheckData = [{
                label: "New Order",
                value: {
                    {
                        $backgroundStatusCheckCount['new_order_background']
                    }
                }
            }, {
                label: "Pending",
                value: {
                    {
                        $backgroundStatusCheckCount['pending_background']
                    }
                }
            }, {
                label: "Consent Sent",
                value: {
                    {
                        $backgroundStatusCheckCount['consent_sent']
                    }
                }
            }, {
                label: "Approved",
                value: {
                    {
                        $backgroundStatusCheckCount['approved_bc']
                    }
                }
            }, {
                label: "Rescheduling",
                value: {
                    {
                        $backgroundStatusCheckCount['rebooking']
                    }
                }
            }, {
                label: "Not available",
                value: {
                    {
                        $backgroundStatusCheckCount['not_available']
                    }
                }
            }];

            var followUpCheckData = [{
                label: "New Order",
                value: {
                    {
                        $followUpStatusCount['New_order_followuppinterview']
                    }
                }
            }, {
                label: "Pending",
                value: {
                    {
                        $followUpStatusCount['pending_msg_follow']
                    }
                }
            }, {
                label: "Booked",
                value: {
                    {
                        $followUpStatusCount['booked_msg_follow']
                    }
                }
            }, {
                label: "Approved",
                value: {
                    {
                        $followUpStatusCount['Approved_followup']
                    }
                }
            }, {
                label: "Candidate didnt show up",
                value: {
                    {
                        $followUpStatusCount['notshow_msg_follow']
                    }
                }
            }];

            function initializeChart(chartElementId, chartData, colorArray, legendElementId) {
                var chart = Morris.Donut({
                    element: chartElementId,
                    data: chartData,
                    colors: colorArray,
                });

                // Clear the legend element before appending new items
                $(legendElementId).empty();

                chart.options.data.forEach(function(item, i) {
                    // Create a legend item
                    var legendItem = $("<span></span>")
                        .text(item.label)
                        .prepend("<i>&nbsp;</i>");
                    legendItem
                        .find("i")
                        .css("backgroundColor", colorArray[i]);
                    $(legendElementId).append(legendItem);
                });
            }

            // Initialize all charts with their respective colors
            initializeChart("interviews-chart", interviewData, interviewColors, "#interviews-legend");
            initializeChart("background-check-chart", backgroundCheckData, backgroundCheckColors,
                "#background-check-legend");
            initializeChart("follow-up-check-chart", followUpCheckData, followUpColors, "#follow-up-check-legend");
        });
    </script>
    <script>
        $(document).ready(function() {
            var savedFilter = sessionStorage.getItem('selectedFilter');
            console.log(sessionStorage);
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
        let hideTimer;

        function showCard(obj) {
            clearTimeout(hideTimer);
            $('.card.order-logs-card').hide();
            $('#' + obj).show()
        }

        function hideCard(obj) {
            hideTimer = setTimeout(() => {
                $('#' + obj).hide();
            }, 1000);
        }

        function cancelHide(obj) {
            clearTimeout(hideTimer);
            $('#' + obj).show()
        }

        function forceHide(obj) {
            $('#' + obj).hide();
        }
        $(document).ready(function() {
            $('.status-filter').on('click', function() {
                $('.status-filter').removeClass('active');
                $(this).addClass('active');
            });
        });
        (document.querySelector(".sweet-13").onclick = function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            Toast.fire({
                icon: 'success',
                title: 'Order updated successfully'
            })
        });
        $(document).ready(function() {
            @if (session('success'))
                $('.sweet-13').click();
            @endif
        })

        function updateTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0'); // Pad with leading zero
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const formattedTime = `${hours}:${minutes}:${seconds}`;

            // Update the time in the HTML
            document.getElementById('current_time').textContent = formattedTime;
        }

        updateTime();
        setInterval(updateTime, 1000);
    </script>
