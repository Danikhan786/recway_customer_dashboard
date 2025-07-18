@include('includes.head')
<body>
  <!-- page-wrapper Start-->
  <!-- tap on top starts-->
  <div class="tap-top">
    <i class="iconly-Arrow-Up icli"></i>
  </div>
  <!-- tap on tap ends-->
  <!-- loader-->
  <div class="loader-wrapper">
    <div class="loader">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="page-wrapper compact-wrapper" id="pageWrapper"> <?php include('includes/header.php'); ?>
    <!-- Page sidebar end-->
    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-sm-6 col-12">
               <h2>{{ __('messages.add_reviewer') }}</h2>
            </div>
            <div class="col-sm-6 col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.html">
                    <i class="iconly-Home icli svg-color"></i>
                  </a>
                </li>
                <li class="breadcrumb-item">{{ __('messages.recway') }}</li>
                <li class="breadcrumb-item active">{{ __('messages.add_reviewer') }}</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- Container-fluid starts-->
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-no-border pb-0">
              </div>
              <div class="card-body">
                <div class="vertical-main-wizard">
                    <div class="row">
                        <div class="col-md-12">
                            <h5 for="">{{ __('messages.email') }} <span class="text-danger">*</span> </h5>
                            <input type="text" class="form-control form-control-lg mt-1">
                        </div>
                        <div class="col-md-12 mt-4">
                            <h5 for="">{{ __('messages.password') }} <span class="text-danger">*</span> </h5>
                            <input type="text" class="form-control form-control-lg mt-1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4 mt-4 text-end">
                            <button class="btn btn-primary">{{ __('messages.add_reviewer') }}</button>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> 
    @include('includes.footer')