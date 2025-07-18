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
                                    <h2> Reviewers </h2>
                                </div>
                                <div class="col-sm-6 col-12">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                                        <li class="breadcrumb-item">Recway</li>
                                        <li class="breadcrumb-item active">Reviewers</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Container-fluid starts-->
                    <div class="container-fluid">
                        <div class="row project-cards">
                            <div class="col-md-12 project-list">
                                <div class="card">
                                    <div class="row">
                                        <div class="col-md-8">
                                            
                                        </div>
                                        <div class="col-md-4 d-md-block d-none">
                                            <div class="form-group mb-0 me-0"> </div>
                                            <a href="{{ route('reviewer.create') }}" class="btn btn-primary d-flex align-items-center" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                                </svg>Create New Reviewer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <div class="table-responsive">
                                        <table class="display" id="data-source-1" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($reviewers as $reviewer)
                                                    <tr>
                                                        <td>{{ $reviewer->email }}</td>
                                                        <td>
                                                            <ul class="action">
                                                                <li><a class="btn btn-success" href="{{ route('reviewers.edit', ['id' => $reviewer->id]) }}"><i class="icon-pencil-alt"></i></a></li>
                                                                
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Email</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
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