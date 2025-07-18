@include('includes.head')
<style>
  /* Yaha par agar aapko custom CSS likhna hai, to likh sakte hain */
</style>
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
  <div class="page-wrapper compact-wrapper" id="pageWrapper"> 
  @include('includes.header')
    <!-- Page sidebar end-->
    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-sm-6 col-12">
              <h2>Edit Reviewer</h2>
            </div>
            <div class="col-sm-6 col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.html">
                    <i class="iconly-Home icli svg-color"></i>
                  </a>
                </li>
                <li class="breadcrumb-item">Recway</li>
                <li class="breadcrumb-item active">Edit Reviewer</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- Container-fluid starts-->
      <form action="{{ route('reviewers.update', $reviewer->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-no-border pb-0">
                    </div>
                    <div class="card-body">

                        <!-- Display success or error messages -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="vertical-main-wizard">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 for="">Email <span class="text-danger">*</span></h5>
                                    <input type="email" name="email" class="form-control form-control-lg mt-1" value="{{ old('email', $reviewer->email) }}" required>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <h5 for="">Password (leave blank to keep current password)</h5>
                                    <input type="password" name="password" class="form-control form-control-lg mt-1" placeholder="Enter new password (if any)">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4 mt-4 text-end">
                                    <button class="btn btn-primary">Update Reviewer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

    </div> 
    @include('includes.footer')
</body>
