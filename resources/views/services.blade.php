@include('includes.head')
<style>
    .card:hover {
        background: #8a8a8a;
        color: #fff;
    }

    .dark-only .card:hover {
        background: #AC0206;
        color: #fff;
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
                            <h2> Services </h2>
                        </div>
                        <div class="col-sm-6 col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                                <li class="breadcrumb-item">Recway</li>
                                <li class="breadcrumb-item active">Services</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <!-- Interview Card -->
                    @if (!empty($services))
                    @foreach ($services as $ser)
                    @if (!empty($ser->id))
                    <div class="col-md-3 text-center">
                        <a href="{{ route('create_order', ['id' => $ser->id]) }}" class="card">
                            <div class="card-body">
                                <h3 class="card-title">
                                    {{$ser->name}}
                                </h3>
                                <!-- @if ($ser->id == 3) -->
                                <img src="{{ asset('assets/images/services/history.png') }}" height="200" alt="Interview">
                                <!-- @else -->
                                <img src="{{ asset('assets/images/services/interview.png') }}" height="200" alt="Interview">
                                <!-- @endif -->
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach
                    @endif

                    <!-- <div class="col-md-4">
                        <a href="{{ route('create_order', ['id' => 3]) }}" class="card">
                            <div class="card-body">
                                <h3 class="card-title">Background Check</h3>
                                <img src="{{ asset('assets/images/services/history.png') }}" height="300" alt="Background Check">
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="{{ route('create_order', ['id' => 9]) }}" class="card">
                            <div class="card-body">
                                <h3 class="card-title">Follow-Up Interview</h3>
                                <img src="{{ asset('assets/images/services/interview.png') }}" height="300" alt="Follow-Up Interview">
                            </div>
                        </a>
                    </div> -->
                </div>
            </div>
            <!-- Container-fluid starts  -->
        </div>
        @include('includes.footer')