@include('includes.head') <style>
  .checkbox-wrapper-51 input[type="checkbox"] {
    visibility: hidden;
    display: none;
  }

  .checkbox-wrapper-51 .toggle {
    position: relative;
    display: block;
    width: 42px;
    height: 24px;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
    transform: translate3d(0, 0, 0);
  }

  .checkbox-wrapper-51 .checkbox-label {
    margin-right: 10px;
    font-size: 16px;
    display: inline-block;
    vertical-align: middle;
  }

  .checkbox-wrapper-51 .toggle:before {
    content: "";
    position: relative;
    top: 1px;
    left: 1px;
    width: 40px;
    height: 22px;
    display: block;
    background: #c8ccd4;
    border-radius: 12px;
    transition: background 0.2s ease;
  }

  .checkbox-wrapper-51 .toggle span {
    position: absolute;
    top: 0;
    left: 0;
    width: 24px;
    height: 24px;
    display: block;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 2px 6px rgba(154, 153, 153, 0.75);
    transition: all 0.2s ease;
  }

  .checkbox-wrapper-51 .toggle span svg {
    margin: 7px;
    fill: none;
  }

  .checkbox-wrapper-51 .toggle span svg path {
    stroke: #c8ccd4;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    stroke-dasharray: 24;
    stroke-dashoffset: 0;
    transition: all 0.5s linear;
  }

  .checkbox-wrapper-51 input[type="checkbox"]:checked+.toggle:before {
    background: #AC0206;
  }

  .checkbox-wrapper-51 input[type="checkbox"]:checked+.toggle span {
    transform: translateX(18px);
  }

  .checkbox-wrapper-51 input[type="checkbox"]:checked+.toggle span path {
    stroke: #AC0206;
    stroke-dasharray: 25;
    stroke-dashoffset: 25;
  }
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
  <div class="page-wrapper compact-wrapper" id="pageWrapper"> @include('includes.header')
    <!-- Page sidebar end-->
    <div class="page-body">
      <div class="container-fluid">
        <div class="page-title">
          <div class="row">
            <div class="col-sm-6 col-12">
              <h2>{{__('messages.email_setting')}}</h2>
            </div>
            <div class="col-sm-6 col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.html">
                    <i class="iconly-Home icli svg-color"></i>
                  </a>
                </li>
                <li class="breadcrumb-item">{{__('messages.recway')}}</li>
                <li class="breadcrumb-item active">{{__('messages.email')}}</li>
              </ol>
            </div>

          </div>

        </div>
      </div>
      <!-- Container-fluid starts-->
      <div class="container-fluid">
        <div class="col-md-12 project-list">
          <div class="card">
            <div class="row">
              <div class="col-md-8">

                <ul class="nav nav-tabs border-tab" id="top-tab" role="tablist">
                  @foreach ($interviews as $index => $category)
                  <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $index === 0 ? 'active' : '' }}" id="tab-{{ $category->id }}" data-bs-toggle="tab" href="#content-{{ $category->id }}" role="tab" aria-controls="content-{{ $category->id }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="12" r="6"></circle>
                        <circle cx="12" cy="12" r="2"></circle>
                      </svg>{{ $category->name }}
                    </a>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row project-cards">

          <div class="tab-content">



            <div class="tab-content" id="top-tabContent">

              @foreach ($categories as $index => $category)
              <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="content-{{ $category->id }}" role="tabpanel" aria-labelledby="tab-{{ $category->id }}">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body">
                      <h3><strong>{{ $category->name }}</strong></h3>
                      <div class="statuses mt-3">
                        <div class="row">
                          <div class="col-md-12 mb-4">
                            <p><b>Note:</b> Select the statuses for which you want to receive an email</p>
                            <div class="form-check">
                              <div class="checkbox-wrapper-51">
                                <!-- Master checkbox to control all others -->
                                <label for="cbx-select-{{ str_replace(' ', '-', strtolower(trim($category->name))) }}" class="checkbox-label">Select All</label>
                                <input type="checkbox" id="cbx-select-{{ str_replace(' ', '-', strtolower(trim($category->name))) }}" />
                                <label for="cbx-select-{{ str_replace(' ', '-', strtolower(trim($category->name))) }}" class="toggle">
                                  <span>
                                    <svg width="10px" height="10px" viewBox="0 0 10 10">
                                      <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>
                                    </svg>
                                  </span>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          @foreach ($category->statuses as $status)
                          <div class="col-md-3 mb-3">
                            <div class="form-check">
                              <div class="checkbox-wrapper-51">
                                <label for="cbx-status-{{ $status->id }}" class="checkbox-label">{{ $status->status }}</label>
                                <input {{ optional($status->allowedEmails)->allowed == 1 ? 'checked' : '' }} type="checkbox" id="cbx-status-{{ $status->id }}" onclick="allow_email(this,'{{$status->id}}')" class="checkbox-item-{{ str_replace(' ', '-', strtolower(trim($category->name))) }}" />
                                <label for="cbx-status-{{ $status->id }}" class="toggle">
                                  <span>
                                    <svg width="10px" height="10px" viewBox="0 0 10 10">
                                      <path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path>
                                    </svg>
                                  </span>
                                </label>
                              </div>
                            </div>
                          </div>

                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </div>

          </div>
        </div>
      </div>
      <!-- Container-fluid starts  -->
    </div> @include('includes.footer')

    <script>
      // Function to set up master checkbox and individual checkboxes
      function setupCheckboxes(masterCheckboxId, checkboxClass) {
        const masterCheckbox = document.getElementById(masterCheckboxId);
        const checkboxes = document.querySelectorAll(`.${checkboxClass}`);

        // Add an event listener to the master checkbox
        masterCheckbox.addEventListener('change', function() {
          checkboxes.forEach(checkbox => {
            checkbox.checked = masterCheckbox.checked; // Set all checkboxes based on master checkbox
          });
        });

        // Optionally, listen for individual checkbox changes to uncheck the master checkbox
        checkboxes.forEach(checkbox => {
          checkbox.addEventListener('change', function() {
            if (!checkbox.checked) {
              masterCheckbox.checked = false; // Uncheck master checkbox if any checkbox is unchecked
            }
          });
        });
      }

      // Set up checkboxes for each tab
      setupCheckboxes('cbx-select-interviews', 'checkbox-item-interviews');
      setupCheckboxes('cbx-select-background-check', 'checkbox-item-background-check');
      setupCheckboxes('cbx-select-follow-up---interview', 'checkbox-item-follow-up---interview');
    </script>
    <script>
      function allow_email(obj,status_id) {
        var status_id = status_id;
        var checked = 2;
        if($(obj).is(':checked')) {
          var checked = 1;
        }
        $.ajax({
          url: '{{route("allow_email")}}',
          type: 'POST',
          data: {
            _token: "{{ csrf_token() }}",
            checked: checked,
            status_id: status_id
          },
          success: function(response) {
            console.log(response);
          }
        });
      }
    </script>
