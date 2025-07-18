@include('includes.head')

<link rel="stylesheet" type="text/css" href="assets/css/vendors/dropzone.css">
<link rel="stylesheet" type="text/css" href="assets/css/vendors/filepond.css">
<link rel="stylesheet" type="text/css" href="assets/css/vendors/filepond-plugin-image-preview.css">
@php
$doc_html = null;
$personal = null;
$billing = null;
if (!empty($form_builder)) {
if (!empty($form_builder->form)) {
$form_builder = json_decode($form_builder->form);
if (isset($form_builder->form_builder) && !empty($form_builder->form_builder)) {
$form_data = $form_builder->form_builder;
if (isset($form_data->personal_info) && !empty($form_data->personal_info)) {
$personal = $form_data->personal_info;
}
if (isset($form_data->billing_info) && !empty($form_data->billing_info)) {
$billing = $form_data->billing_info;
}
}
}
}
@endphp

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
                            <h2>{{getTranslatedText('Edit Order')}}</h2>
                        </div>
                        <div class="col-sm-6 col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="iconly-Home icli svg-color"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item"> {{getTranslatedText('recway')}}</li>
                                <li class="breadcrumb-item active">{{getTranslatedText('Edit Order')}}</li>
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
                                @if (session('success'))
                                <button class="btn btn-secondary sweet-13" type="button" onclick="_gaq.push(['_trackEvent', 'example', 'try', 'sweet-13']);" style="display:none">Alert</button>
                                @endif
                            </div>
                            <div class="card-body">
                            <div class="row shopping-wizard">
                                    <div class="col-12">
                                        <div class="row shipping-form g-3">
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="nav nav-pills horizontal-options shipping-options" id="cart-options-tab" role="tablist" aria-orientation="vertical">
                                                            <a class="nav-link active" href="#wizard-contact" onclick="check_validity(event, 'wizard-contact',this)">
                                                                <div class="cart-options">
                                                                    <div class="stroke-icon-wizard"><i class="fa-solid fa-user"></i></div>
                                                                    <div class="cart-options-content">
                                                                        <h6 class="f-w-700">{{getTranslatedText('candidate_info')}}</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a class="nav-link" href="#wizard-cart" id="attachment_tab" onclick="check_validity(event, 'wizard-cart',this)">
                                                                <div class="cart-options">
                                                                    <div class="stroke-icon-wizard"><i class="fa-solid fa-paperclip"></i></div>
                                                                    <div class="cart-options-content">
                                                                        <h6 class="f-w-700">{{getTranslatedText('attachment')}}</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a class="nav-link" href="#wizard-banking" onclick="check_validity(event, 'wizard-banking',this)">
                                                                <div class="cart-options">
                                                                    <div class="stroke-icon-wizard"><i class="fa-solid fa-money-bill"></i></div>
                                                                    <div class="cart-options-content">
                                                                        <h6 class="f-w-700">{{getTranslatedText('billing_details')}}</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vertical-main-wizard mt-4" >
                                    <div class="row g-3">
                                        <div class="col-xxl-12 col-xl-12 col-12">
                                            
                                            <div class="tab-content" id="wizard-tabContent">
                                                <form id="step1Form" action="{{ route('updateOrder') }}" class="row g-3 tab-content needs-validation custom-input validation-vertical-wizard" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                                    <span class="mb-2 mendatory_statment"><strong>{{getTranslatedText('mandatory_fields')}}</strong></span>
                                                        <input type="hidden" id="service_type" value="{{ $candidate->interview_id }}">
                                                        <input type="hidden" name="id" value="{{ $candidate->id }}">
                                                        <div class="row" id="personal_info_row">
                                                            @if (!empty($personal))
                                                            @foreach ($personal as $p_k => $p_v)
                                                            @php
                                                            $real_dta = explode(',', $p_k);
                                                            $type = isset($real_dta[0]) ? $real_dta[0] : '';
                                                            $label = isset($real_dta[1]) ? $real_dta[1] : '';
                                                            $name = isset($real_dta[2]) ? $real_dta[2] : '';
                                                            $placehol = isset($real_dta[3]) ? $real_dta[3] : '';
                                                            $req = isset($real_dta[4]) ? $real_dta[4] : '';
                                                            $is_tra = isset($real_dta[5]) ? $real_dta[5] : '';
                                                            $new_field = isset($real_dta[6]) ? $real_dta[6] : '';
                                                            $default_val = isset($real_dta[7]) ? $real_dta[7] : '';
                                                            @endphp
                                                            <?php if ($type == 'select') { ?>
                                                                <div class="col-md-6 col-sm-12 mb-2">
  <label><?= htmlspecialchars($label) ?></label>
  <select class="form-control select-ui" 
          name="<?= $is_tra ? 'form_builder[' . $label . ']' : $name ?>">

    <?php if (!empty($placehol)) : ?>
      <option value="" selected hidden><?= htmlspecialchars($placehol) ?></option>
    <?php endif; ?>

    <?php
      $options = [];
      if (is_string($default_val) && trim($default_val) !== '') {
          $options = array_filter(array_map('trim', explode('|', $default_val)));
      }
      foreach ($options as $opt) :
          $selected = ($p_v == $opt) ? 'selected' : '';
    ?>
      <option value="<?= htmlspecialchars($opt) ?>" <?= $selected ?>><?= htmlspecialchars($opt) ?></option>
    <?php endforeach; ?>

  </select>
</div>
                                                            <?php }else if ($name != 'document_file') { ?>
                                                                <div class="col-md-6 col-sm-12 mb-2">
                                                                    <label class="form-label" for="name">{{$label}} <?php if (!empty($req)) { ?><span class="text-danger">*</span><?php } ?></label>
                                                                    <input class="form-control" type="<?= $type ?>"
                                                                        <?php if ($new_field != '') { ?>
                                                                        name="form_builder[<?= $label ?>]"
                                                                        <?php $meta_data =  json_decode($candidate->meta_data) ?>
                                                                        value="<?php echo isset($meta_data->$label) ? $meta_data->$label : '' ?>"
                                                                        <?php } else { ?>
                                                                        name="<?= $name ?>" value="<?= $candidate->$name ?>"
                                                                        <?php } ?>
                                                                        placeholder="<?= $placehol ?>"
                                                                        <?= $req ?>>
                                                                </div>
                                                            <?php } else { ?>
                                                                @php
                                                                $doc_html = '<div class="col-md-12 col-sm-12 mb-2">
                                                                    <label class="form-label">'. getTranslatedText('document') .'</label>
                                                                    <div class="dropzone dropzone-secondary p-3" id="dropzoneArea" onclick="triggerFileInput()" style="text-align:center">
                                                                        <div class="dz-message needsclick">
                                                                            <i class="fa-solid fa-cloud-arrow-up"></i>
                                                                            <h6>'. getTranslatedText('upload_document_cv') .'</h6>
                                                                            <span class="note needsclick">('. getTranslatedText("click_to_upload") .')</span>
                                                                        </div>
                                                                    </div>
                                                                </div>'
                                                                @endphp
                                                            <?php } ?>
                                                            @endforeach
                                                            @else
                                                            <div class="col-md-6 col-sm-12 mb-2">
                                                                <label class="form-label" for="name">{{ getTranslatedText('name') }} <span class="text-danger">*</span></label>
                                                                <input class="form-control" name="name" type="text" placeholder="Enter name" required="" value="{{$candidate->name}}">
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 mb-2">
                                                                <label class="form-label" for="surname">{{ getTranslatedText('surname') }} <span class="text-danger">*</span></label>
                                                                <input class="form-control" name="surname" type="text" placeholder="Enter surname" required="" value="{{$candidate->surname}}">
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 mb-2">
                                                                <label class="form-label" for="email">{{ getTranslatedText('email') }} <span class="text-danger">*</span></label>
                                                                <input class="form-control" name="email" type="email" required="" placeholder="admiro@example.com" value="{{$candidate->email}}">
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 mb-2">
                                                                <label class="form-label" for="phone">{{ getTranslatedText('phone') }} <span class="text-danger">*</span></label>
                                                                <input class="form-control" name="phone" type="tel" required="" placeholder="Enter number" value="{{$candidate->phone}}">
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 mb-2">
                                                                <label class="form-label" for="ssn">{{getTranslatedText('Social Security Number')}} <span class="text-danger">*</span></label>
                                                                <input class="form-control" name="security" type="text" required="" placeholder="Enter Social Security Number" value="{{$candidate->security}}">
                                                            </div>
                                                            <div class="col-md-6 col-sm-12 mb-2">
                                                                <label class="form-label" for="vasc_id">{{getTranslatedText('VASC ID')}}</label>
                                                                <input class="form-control" name="vasc_id" type="text" placeholder="VASC ID" value="{{$candidate->vasc_id}}">
                                                            </div>
                                                            @endif

                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="submit" class="btn btn-primary" onclick="submit_form(this)">{{getTranslatedText('Update')}}</button>
                                                        </div>
                                                    </div>
                                                    <!-- Step 2 -->
                                                    <div class="tab-pane fade" id="wizard-cart" role="tabpanel" aria-labelledby="wizard-cart-tab">
                                                        <input type="file" name="cv" id="hiddenFileInput" style="display: none;" accept="application/pdf" onchange="handleFileChange()">
                                                        <div class="row mb-3" id="document_row">
                                                            @if (!empty($doc_html))
                                                            {!! $doc_html !!}
                                                            @else
                                                            <div class="col-md-12 col-sm-12 mb-2">
                                                                <label class="form-label">{{ getTranslatedText('document') }}</label>
                                                                <div class="dropzone dropzone-secondary p-3" id="dropzoneArea" onclick="triggerFileInput()" style="text-align:center">
                                                                    <div class="dz-message needsclick">
                                                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                                                        <h6>{{ getTranslatedText('upload_document_cv') }}</h6>
                                                                        <span class="note needsclick">({{ getTranslatedText('click_to_upload') }})</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if (isset(auth()->user()->interview_template) && !empty(auth()->user()->interview_template))
                                                        <div class="col-md-12 col-sm-12 mb-2">
                                                            <label class="form-label">{{getTranslatedText('Interview Template')}}</label>
                                                            <input type="file" name="interview_template" id="hiddenFileInput2" style="display: none;" accept="application/pdf" onchange="handleFileChange2()">
                                                            <div class="dropzone dropzone-primary p-3" id="dropzoneArea2" onclick="triggerFileInput2()" style="text-align:center">
                                                                <div class="dz-message needsclick">
                                                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                                                    <h6>{{ getTranslatedText('upload_interview_template') }}</h6>
                                                                    <span class="note needsclick">({{ getTranslatedText('click_to_upload') }})</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <div class="col-12 text-end">
                                                            <button type="submit" class="btn btn-primary" onclick="submit_form(this)">{{getTranslatedText('Update')}}</button>
                                                        </div>
                                                    </div>
                                                    <!-- Step 3 -->
                                                    <div class="tab-pane fade" id="wizard-banking" role="tabpanel" aria-labelledby="wizard-banking-tab">
                                                        <div class="row" id="billing_info_row">
                                                        <span class="mb-2 mendatory_statment"><strong>{{getTranslatedText('mandatory_fields')}}</strong></span>
                                                            @if (!empty($billing))
                                                            @foreach ($billing as $b_k => $b_v)
                                                            @php
                                                            $real_dta = explode(',', $b_k);
                                                            $type = isset($real_dta[0]) ? $real_dta[0] : '';
                                                            $label = isset($real_dta[1]) ? $real_dta[1] : '';
                                                            $name = isset($real_dta[2]) ? $real_dta[2] : '';
                                                            $placehol = isset($real_dta[3]) ? $real_dta[3] : '';
                                                            $req = isset($real_dta[4]) ? $real_dta[4] : '';
                                                            $is_tra = isset($real_dta[5]) ? $real_dta[5] : '';
                                                            $new_field = isset($real_dta[6]) ? $real_dta[6] : '';
                                                            @endphp
                                                            <?php if ($name != 'note') { ?>
                                                                <div class="col-md-12 col-sm-6 mb-2">
                                                                    <label class="form-label"><?= $label ?><?php if (!empty($req)) { ?><span class="star text-danger">*</span><?php } ?></label>
                                                                    <input class="form-control" type="<?= $type ?>" <?php if ($new_field != '') { ?> name="form_builder[<?= $label ?>]" <?php $meta_data =  json_decode($candidate->meta_data) ?> value="<?php echo isset($meta_data->$label) ? $meta_data->$label : '' ?>" <?php } else { ?>name="<?= $name ?>" <?php } ?> placeholder="<?= $placehol ?>" <?= $req ?> <?php if ($name == 'ref') { ?>value="<?= $candidate->reference ?>" <?php } ?> <?php if ($name == 'pref') { ?>value="<?= $candidate->referensperson ?>" <?php } ?> <?php if ($name == 'comment') { ?>value="<?= $candidate->comment ?>" <?php } ?>>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="col-md-12 col-sm-6 mb-2">
                                                                    <label class="form-label">{{getTranslatedText('note')}}</label>
                                                                    <textarea class="form-control" name="note" placeholder="{{getTranslatedText('order_note')}}" required="">{{$candidate->note}}</textarea>
                                                                </div>
                                                            <?php } ?>
                                                            @endforeach
                                                            @else
                                                            <div class="col-md-12 col-sm-6 mb-2">
                                                                <label class="form-label">{{ getTranslatedText('invoice_recipent') }} <span class="text-danger">*</span></label>
                                                                <input class="form-control" name="pref" type="text" placeholder="{{ getTranslatedText('enter_reference_invoice') }}" required="" value="{{$candidate->referensperson}}">
                                                            </div>
                                                            <div class="col-md-12 col-sm-6 mb-2">
                                                                <label class="form-label" for="reference">{{ getTranslatedText('reference') }} <span class="text-danger">*</span></label>
                                                                <input class="form-control" id="reference" name="ref" type="text" placeholder="{{ getTranslatedText('enter_reference') }}" required="" value="{{$candidate->reference}}">
                                                            </div>
                                                            <div class="col-md-12 col-sm-6 mb-2">
                                                                <label class="form-label" for="invoiceComment">{{ getTranslatedText('invoice_comment') }}</label>
                                                                <input class="form-control" id="invoiceComment" name="comment" type="text" placeholder="{{ getTranslatedText('invoice_comment') }}" value="{{$candidate->comment}}">
                                                            </div>
                                                            <div class="col-md-12 col-sm-6 mb-2">
                                                                <label class="form-label" for="note">{{getTranslatedText('note')}}</label>
                                                                <input class="form-control" id="note" name="note" type="text" placeholder="{{getTranslatedText('order_note')}}" value="{{$candidate->note}}">
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="submit" class="btn btn-primary" onclick="submit_form(this)">{{getTranslatedText('update')}}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
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
        <script>
            function hide_both_button(obj) {
                var hrml = `<p>Please wait for a few seconds while your order has been processed.</p>`;
                $(obj).closest('div[class="col-12 text-end"]').hide();
                $('#terms-and-conditions').append(html);
            }
            document.addEventListener("DOMContentLoaded", function() {
                // Select all tabs and forms
                const wizardTabs = document.querySelectorAll('.nav-link');
                const formSections = document.querySelectorAll('.tab-pane');
                let currentTab = 0; // start at the first tab

                // Function to show the current tab
                function showTab(index) {
                    formSections.forEach((section, i) => {
                        if (i === index) {
                            section.classList.add('show', 'active');
                        } else {
                            section.classList.remove('show', 'active');
                        }
                    });

                    wizardTabs.forEach((tab, i) => {
                        if (i === index) {
                            tab.classList.add('active');
                        } else {
                            tab.classList.remove('active');
                        }
                    });
                }

                showTab(currentTab);
                document.querySelectorAll('.btn-primary').forEach((btn) => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        let buttonText = btn.innerText.toLowerCase();

                        if (buttonText === 'next') {
                            let isValid = validateForm();
                            if (isValid) {
                                currentTab++;
                                if (currentTab >= formSections.length) {
                                    currentTab = formSections.length - 1;
                                }
                                document.querySelector('#step1Form').classList.remove('was-validated');
                                showTab(currentTab);
                            }
                        } else if (buttonText === 'previous') {
                            currentTab--;
                            if (currentTab < 0) {
                                currentTab = 0;
                            }
                            showTab(currentTab);
                        } else if (buttonText === 'create order') {
                            let isValid = validateForm();
                            if (isValid) {
                                submitStep4();
                            }
                        }
                    });
                });

                // Validate the current form step
                function validateForm() {
                    let formFields = formSections[currentTab].querySelectorAll("input[required], select[required]");
                    let isValid = true;
                    document.querySelector('#step1Form').classList.add('was-validated');
                    formFields.forEach((field) => {
                        // Email validation logic for email fields
                        if (field.type === "email") {
                            if (!validateEmail(field.value)) {
                                field.classList.add('is-invalid');
                                isValid = false;
                            } else {
                                field.classList.remove('is-invalid');
                                field.classList.add('is-valid');
                            }
                        } else if (!field.value.trim()) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            field.classList.remove('is-invalid');
                            field.classList.add('is-valid');
                        }
                    });

                    return isValid;
                }

                // Function to validate email format
                function validateEmail(email) {
                    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    return emailPattern.test(email);
                }

                function submitStep4() {
                    const form = document.querySelector('#step1Form');

                    if (form.checkValidity()) {
                        const formData = new FormData(form);

                    } else {
                        form.classList.add('was-validated');
                    }
                }

            });

            function triggerFileInput() {
                $('#hiddenFileInput').click(); // Trigger the hidden file input click using jQuery
            }

            function triggerFileInput2() {
                $('#hiddenFileInput2').click(); // Trigger the hidden file input click using jQuery
            }

            function handleFileChange() {
                const file = $('#hiddenFileInput')[0].files[0]; // Get the selected file from input
                const dropzone = $('#dropzoneArea'); // Dropzone element
                const removeButton = $('#removeFileButton'); // Remove file button

                // Clear any existing previews
                dropzone.find('.dz-message.needsclick').remove();

                if (file) {
                    const fileReader = new FileReader();

                    fileReader.onload = function(e) {
                        const filePreview = `
          <div class="dz-preview dz-file-preview">
            <div class="dz-details" style="background-color:transparent">
              <div class="dz-filename" style="height:60px"><span style="width: 60px;">${file.name}</span></div>
              <div class="dz-size">${(file.size / 1024).toFixed(2)} KB</div>
            </div>
          </div>
          </br>
          <button type="button" id="removeFileButton" class="btn btn-outline-danger" onclick="removeFile(event)" ><span class="fa-solid fa-trash"></span></button>`;
                        dropzone.html(filePreview);
                        removeButton.show(); // Show the remove file button when a file is selected
                    };

                    if (file.type.startsWith('image/')) {
                        fileReader.readAsDataURL(file);
                    } else {
                        const filePreview = `
          <div class="dz-preview dz-file-preview">
            <div class="dz-details" style="background-color:transparent">
              <div class="dz-filename" style="height:60px"><span style="width: 60px;">${file.name}</span></div>
              <div class="dz-size">${(file.size / 1024).toFixed(2)} KB</div>
            </div>
          </div>
          </br>
          <button type="button" id="removeFileButton" class="btn btn-outline-danger" onclick="removeFile(event)" ><span class="fa-solid fa-trash"></span></button>`;
                        dropzone.html(filePreview);
                        removeButton.show();
                    }
                }
            }

            function removeFile(event) {
                event.stopPropagation();
                const dropzone = $('#dropzoneArea');
                const fileInput = $('#hiddenFileInput');
                const removeButton = $('#removeFileButton');

                fileInput.val('');

                dropzone.html(`
      <div class="dz-message needsclick">
        <i class="fa-solid fa-cloud-arrow-up"></i>
        <h6>Here you can upload document or CV.</h6>
        <span class="note needsclick">(Click to upload your file.)</span>
      </div>
    `);

                // Hide the remove file button
                removeButton.hide();
            }

            function handleFileChange2() {
                const file = $('#hiddenFileInput2')[0].files[0];
                const dropzone = $('#dropzoneArea2');
                const removeButton = $('#removeFileButton2');

                dropzone.find('.dz-message.needsclick').remove();

                if (file) {
                    const fileReader = new FileReader();

                    fileReader.onload = function(e) {
                        const filePreview = `
          <div class="dz-preview dz-file-preview">
            <div class="dz-details" style="background-color:transparent">
              <div class="dz-filename" style="height:60px"><span style="width: 60px;">${file.name}</span></div>
              <div class="dz-size">${(file.size / 1024).toFixed(2)} KB</div>
            </div>
          </div>
          </br>
          <button type="button" id="removeFileButton2" class="btn btn-outline-danger" onclick="removeFile2(event)" ><span class="fa-solid fa-trash"></span></button>`;
                        dropzone.html(filePreview);
                        removeButton.show();
                    };

                    if (file.type.startsWith('image/')) {
                        fileReader.readAsDataURL(file);
                    } else {
                        const filePreview = `
          <div class="dz-preview dz-file-preview">
            <div class="dz-details" style="background-color:transparent">
              <div class="dz-filename" style="height:60px"><span style="width: 60px;">${file.name}</span></div>
              <div class="dz-size">${(file.size / 1024).toFixed(2)} KB</div>
            </div>
          </div>
          </br>
          <button type="button" id="removeFileButton2" class="btn btn-outline-danger" onclick="removeFile2(event)" ><span class="fa-solid fa-trash"></span></button>`;
                        dropzone.html(filePreview);
                        removeButton.show();
                    }
                }
            }

            function removeFile2(event) {
                event.stopPropagation();
                const dropzone = $('#dropzoneArea2');
                const fileInput = $('#hiddenFileInput2');
                const removeButton = $('#removeFileButton2');

                fileInput.val('');

                dropzone.html(`
        <div class="dz-message needsclick">
          <i class="fa-solid fa-cloud-arrow-up"></i>
          <h6>Here you can upload Interview Template.</h6>
          <span class="note needsclick">(Click to upload your file.)</span>
        </div>
        `);
                removeButton.hide();
            }
        </script>
        <script>
            function submit_form(obj) {
                let currentTab = document.querySelector('.tab-pane.active.show');
                if (validateFormpane(currentTab)) {
                    $('form').submit();
                }
            }

            function check_validity(event, targetTabId, clickedElement) {
                event.preventDefault();
                var service_id = $('#service_type').val();
                if (service_id) {
                    let currentTab = document.querySelector('.tab-pane.active.show');
                    if (validateFormpane(currentTab)) {
                        if (targetTabId == 'wizard-cart') {
                                $('.mendatory_statment').hide();
                            } else {
                                $('.mendatory_statment').show();
                            }
                        activateTab(targetTabId, clickedElement);
                    } else {
                        console.log("Form validation failed");
                    }
                }
            }

            function validateFormpane(activePane) {
                let formFields = activePane.querySelectorAll("input[required], select[required]");
                let isValid = true;
                document.querySelector('#step1Form').classList.add('was-validated');

                formFields.forEach((field) => {
                    if (field.type === "email") {
                        if (!validateEmail(field.value)) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            field.classList.remove('is-invalid');
                            field.classList.add('is-valid');
                        }
                    } else if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });

                return isValid;
            }

            function activateTab(targetTabId, clickedElement) {
                document.querySelector('#step1Form').classList.remove('was-validated');
                document.querySelector('.nav-link.active').classList.remove('active');
                document.querySelector('.tab-pane.active.show').classList.remove('active', 'show');

                document.querySelector(`#${targetTabId}`).classList.add('active', 'show');
                document.querySelector(`.nav-link[href="#${targetTabId}"]`).classList.add('active');
            }

            function validateEmail(email) {
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return emailPattern.test(email);
            }
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
                @if(session('success'))
                $('.sweet-13').click();
                @endif
            })
        </script>