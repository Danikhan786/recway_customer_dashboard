@include('includes.head')
<style>
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
                            <!-- <h2> Archieved </h2> -->
                        </div>
                        <div class="col-sm-6 col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                                <li class="breadcrumb-item">{{__('messages.recway')}}</li>
                                <li class="breadcrumb-item active">{{__('messages.history')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row project-cards">
                    <div class="col-md-12">
                        <div class="card card-absolute">
                            <div class="card-header bg-primary"><h3>{{__('messages.archive_order')}}</h3></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="display" id="data-source-1" style="width:100%">
                                        <thead>
                                        <tr>
                                                <th>#</th>
                                                <th>{{__('messages.order_id')}}</th>
                                                @if (isset($company_manager) && !empty($company_manager))
                            <th>{{getTranslatedText('customer')}}</th>
                            @endif
                                                <th>{{__('messages.status')}}</th>
                                                <th>{{__('messages.service_type')}}</th>
                                                <th>{{__('messages.delievery_date')}} / {{__('messages.interview_date')}}</th>
                                                <th>{{__('messages.order_created')}}</th>
                                            </tr>
                                        </thead> 
                                        <tbody>
                                            @foreach($expiredOrders as $order)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $order->order_id }}</td>
                                                @if (isset($company_manager) && !empty($company_manager))
                            <td>{{ $order->cus_name ?? 'N/A' }}</td>
                            @endif
                                                <td>{{ $order->company_name }}</td>
                                                <td>
                                                    <span class="badge" style="background-color: <?= $order->status_color ?>;">{{$order->status_title}}</span>
                                                </td>
                                                <td>
                                                    {{$order->interview_title}}
                                                </td>
                                                <td>
                                                    <?php if(!empty($order->booked)){ ?>
                                                        {{$order->booked}}
                                                    <?php }else if (!empty($order->delivery_date)){ ?>
                                                        {{$order->delivery_date}}
                                                    <?php } ?>
                                                </td>
                                                <td>{{ $order->created ?? 'N/A' }}</td>
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

            <!-- Container-fluid starts  -->
        </div>
        @include('includes.footer')
