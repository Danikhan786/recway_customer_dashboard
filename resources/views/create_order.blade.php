@include('includes.head')

<link rel="stylesheet" type="text/css" href="assets/css/vendors/dropzone.css">
<link rel="stylesheet" type="text/css" href="assets/css/vendors/filepond.css">
<link rel="stylesheet" type="text/css" href="assets/css/vendors/filepond-plugin-image-preview.css">
<style>
    .col-md-3.text-center .card:hover {
        background: #6d0002a8;
        color: #fff;
    }

    .col-md-3.text-center .card.active {
        background: #6d0002a8;
        color: #fff;
    }

    .col-md-3.text-center .card .card-body {
        padding: 1rem !important;
    }

    .dark-only .col-md-3.text-center .card:hover {
        background: #6d0002a8;
        color: #fff;
    }

    #informative_text {
        display: none;
    }

    .nav-link {
        zoom: 1 !important
    }

    .nav-link.active {
        zoom: 1.2 !important
    }

    .zoom-in {
        transition: transform 0.9s ease;
        transform: scale(1);
    }

    .zoom-out {
        transition: transform 0.9s ease;
        transform: scale(1);
    }

    .zoom-in.animate {
        transform: scale(1.1);
    }

    .zoom-out.animate {
        transform: scale(0.8);
    }

    .flip {
        transition: transform 0.9s ease;
        transform: rotateY(0deg);
    }

    .flip.animate {
        transform: rotateY(90deg);
    }
</style>
@php
    $pref = '';
    $ref = '';
    $comment = '';
    if (!empty($standard->referenceperson)) {
        $pref = $standard->referenceperson;
    }
    if (!empty($standard->reference)) {
        $ref = $standard->reference;
    }
    if (!empty($standard->comment)) {
        $comment = $standard->comment;
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
                            <h2 id="choose_serv_cat">{{ __('messages.choose_service_category') }}</h2>
                        </div>
                        <div class="col-sm-6 col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="iconly-Home icli svg-color"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">{{ __('messages.recway') }}</li>
                                <li class="breadcrumb-item active">{{ __('messages.create_order') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>



            <div class="container-fluid">
                <div class="row">
                    @foreach ($services as $service)
                        <div class="col-md-3 text-center">
                            <a href="#" class="card" data-id="{{ $service->id }}"
                                onclick="fetch_services(this)">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        {{ $service->name }}
                                    </h3>
                                    @if ($service->id == 3)
                                        <img src="{{ asset('assets/images/services/history.png') }}" height="100"
                                            alt="Interview" class="ser_img">
                                    @elseif ($service->id == 10)
                                        <img src="{{ asset('assets/images/services/interview-pana.png') }}"
                                            height="100" alt="Interview" class="ser_img">
                                    @else
                                        <img src="{{ asset('assets/images/services/interview.png') }}" height="100"
                                            alt="Interview" class="ser_img">
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid" id="main-form-div" style="display:none">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-no-border pb-0">
                            </div>
                            <div class="card-body pt-0">
                                <div class="vertical-main-wizard">
                                    <div class="row g-3">
                                        <div class="col-xxl-12 col-xl-12 col-12">
                                            <div class="tab-content" id="wizard-tabContent">
                                                <form id="step1Form"
                                                    class="row g-3 tab-content needs-validation custom-input validation-vertical-wizard"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <label for="interviewSelect" id="service_label">
                                                            <h4>{{ __('messages.choose_service') }}
                                                                <span class="text-danger">*</span>
                                                                <small id="informative_text">
                                                                    <i class="fas fa-info-circle"></i>&nbsp;
                                                                    {{ __('messages.select_service') }}
                                                                </small>
                                                            </h4>
                                                        </label>
                                                        <select name="interview" id="interviewSelect"
                                                            class="form-control" required
                                                            onchange="fetch_form(this);check_p_c(this)">
                                                            <option value="" selected disabled>
                                                                {{ __('messages.choose_service') }}</option>
                                                        </select>
                                                        <div style="display:none" id="req">

                                                        </div>
                                                        <p><strong
                                                                id="delivery_days">{{ __('messages.delivery_days') }}&nbsp;&nbsp;&nbsp;&nbsp;</strong><button
                                                                class="btn btn-primary" type="button"
                                                                id="requirement_btn" onclick="show_req_modal()"
                                                                style="display:none">{{ __('messages.click_view_requirement') }}</button>
                                                        </p>
                                                        <div class="row shopping-wizard mt-1" style="display:none">
                                                            <div class="col-12">
                                                                <div class="row shipping-form g-3">
                                                                    <div class="col-xl-12">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="nav nav-pills horizontal-options shipping-options zoom-in"
                                                                                    id="cart-options-tab" role="tablist"
                                                                                    aria-orientation="vertical">
                                                                                    <a class="nav-link active zoom-in"
                                                                                        href="#wizard-contact"
                                                                                        onclick="check_validity(event, 'wizard-contact',this)">
                                                                                        <div class="cart-options">
                                                                                            <div
                                                                                                class="stroke-icon-wizard">
                                                                                                <i
                                                                                                    class="fa-solid fa-user"></i>
                                                                                            </div>
                                                                                            <div
                                                                                                class="cart-options-content">
                                                                                                <h6 class="f-w-700">
                                                                                                    {{ __('messages.candidate_info') }}
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                    <a class="nav-link zoom-in"
                                                                                        href="#wizard-cart"
                                                                                        id="attachment_tab"
                                                                                        onclick="check_validity(event, 'wizard-cart',this)">
                                                                                        <div class="cart-options">
                                                                                            <div
                                                                                                class="stroke-icon-wizard">
                                                                                                <i
                                                                                                    class="fa-solid fa-paperclip"></i>
                                                                                            </div>
                                                                                            <div
                                                                                                class="cart-options-content">
                                                                                                <h6 class="f-w-700">
                                                                                                    {{ __('messages.attachment') }}
                                                                                                </h6>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                    <a class="nav-link zoom-in"
                                                                                        href="#wizard-banking"
                                                                                        onclick="check_validity(event, 'wizard-banking',this)">
                                                                                        <div class="cart-options">
                                                                                            <div
                                                                                                class="stroke-icon-wizard">
                                                                                                <i
                                                                                                    class="fa-solid fa-money-bill"></i>
                                                                                            </div>
                                                                                            <div
                                                                                                class="cart-options-content">
                                                                                                <h6 class="f-w-700">
                                                                                                    {{ __('messages.billing_details') }}
                                                                                                </h6>
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
                                                    </div>
                                                    <div class="tab-pane fade show active flip" id="wizard-contact"
                                                        role="tabpanel" aria-labelledby="wizard-contact-tab">
                                                        <div class="col-md-12 col-sm-12">
                                                             <span class="mb-2 mendatory_statment mt-2"
                                                                style="display:none;">Fields marked with an asterisk
                                                                <span class="text-danger"> (*) </span> are
                                                                mandatory</span>
                                                            <select style="display:none" id="hidden_interview">

                                                            </select>
                                                        </div>
                                                        <div class="row" id="personal_info_row">

                                                        </div>
                                                        <div class="col-md-12 col-sm-12" id="place">
                                                            <label> {{ __('messages.place') }}<span
                                                                    class="text-danger">*</span></label>
                                                            <select name="place" class="form-control" required
                                                                id="placeSelect">
                                                                @foreach ($places as $place)
                                                                    <option value="{{ $place->id }}">
                                                                        {{ $place->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 col-sm-12" id="country">
                                                            <label>{{ __('messages.country') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="country" class="form-control" required
                                                                id="countrySelect">
                                                                <option value="Afghanistan">Afghanistan</option>
                                                                <option value="Aland Islands">Aland Islands</option>
                                                                <option value="Albania">Albania</option>
                                                                <option value="Algeria">Algeria</option>
                                                                <option value="American Samoa">American Samoa</option>
                                                                <option value="Andorra">Andorra</option>
                                                                <option value="Angola">Angola</option>
                                                                <option value="Anguilla">Anguilla</option>
                                                                <option value="Antarctica">Antarctica</option>
                                                                <option value="Antigua and Barbuda">Antigua and Barbuda
                                                                </option>
                                                                <option value="Argentina">Argentina</option>
                                                                <option value="Armenia">Armenia</option>
                                                                <option value="Aruba">Aruba</option>
                                                                <option value="Australia">Australia</option>
                                                                <option value="Austria">Austria</option>
                                                                <option value="Azerbaijan">Azerbaijan</option>
                                                                <option value="Bahamas">Bahamas</option>
                                                                <option value="Bahrain">Bahrain</option>
                                                                <option value="Bangladesh">Bangladesh</option>
                                                                <option value="Barbados">Barbados</option>
                                                                <option value="Belarus">Belarus</option>
                                                                <option value="Belgium">Belgium</option>
                                                                <option value="Belize">Belize</option>
                                                                <option value="Benin">Benin</option>
                                                                <option value="Bermuda">Bermuda</option>
                                                                <option value="Bhutan">Bhutan</option>
                                                                <option value="Bolivia">Bolivia</option>
                                                                <option value="Bonaire, Sint Eustatius and Saba">
                                                                    Bonaire, Sint Eustatius and Saba
                                                                </option>
                                                                <option value="Bosnia and Herzegovina">Bosnia and
                                                                    Herzegovina</option>
                                                                <option value="Botswana">Botswana</option>
                                                                <option value="Bouvet Island">Bouvet Island</option>
                                                                <option value="Brazil">Brazil</option>
                                                                <option value="British Indian Ocean Territory">British
                                                                    Indian Ocean Territory</option>
                                                                <option value="Brunei Darussalam">Brunei Darussalam
                                                                </option>
                                                                <option value="Bulgaria">Bulgaria</option>
                                                                <option value="Burkina Faso">Burkina Faso</option>
                                                                <option value="Burundi">Burundi</option>
                                                                <option value="Cambodia">Cambodia</option>
                                                                <option value="Cameroon">Cameroon</option>
                                                                <option value="Canada">Canada</option>
                                                                <option value="Cape Verde">Cape Verde</option>
                                                                <option value="Cayman Islands">Cayman Islands</option>
                                                                <option value="Central African Republic">Central
                                                                    African Republic</option>
                                                                <option value="Chad">Chad</option>
                                                                <option value="Chile">Chile</option>
                                                                <option value="China">China</option>
                                                                <option value="Christmas Island">Christmas Island
                                                                </option>
                                                                <option value="Cocos (Keeling) Islands">Cocos (Keeling)
                                                                    Islands</option>
                                                                <option value="Colombia">Colombia</option>
                                                                <option value="Comoros">Comoros</option>
                                                                <option value="Congo">Congo</option>
                                                                <option
                                                                    value="Congo, Democratic Republic of the Congo">
                                                                    Congo, Democratic Republic of
                                                                    the Congo</option>
                                                                <option value="Cook Islands">Cook Islands</option>
                                                                <option value="Costa Rica">Costa Rica</option>
                                                                <option value="Cote D'Ivoire">Cote D'Ivoire</option>
                                                                <option value="Croatia">Croatia</option>
                                                                <option value="Cuba">Cuba</option>
                                                                <option value="Curacao">Curacao</option>
                                                                <option value="Cyprus">Cyprus</option>
                                                                <option value="Czech Republic">Czech Republic</option>
                                                                <option value="Denmark">Denmark</option>
                                                                <option value="Djibouti">Djibouti</option>
                                                                <option value="Dominica">Dominica</option>
                                                                <option value="Dominican Republic">Dominican Republic
                                                                </option>
                                                                <option value="Ecuador">Ecuador</option>
                                                                <option value="Egypt">Egypt</option>
                                                                <option value="El Salvador">El Salvador</option>
                                                                <option value="Equatorial Guinea">Equatorial Guinea
                                                                </option>
                                                                <option value="Eritrea">Eritrea</option>
                                                                <option value="Estonia">Estonia</option>
                                                                <option value="Ethiopia">Ethiopia</option>
                                                                <option value="Falkland Islands (Malvinas)">Falkland
                                                                    Islands (Malvinas)</option>
                                                                <option value="Faroe Islands">Faroe Islands</option>
                                                                <option value="Fiji">Fiji</option>
                                                                <option value="Finland">Finland</option>
                                                                <option value="France">France</option>
                                                                <option value="French Guiana">French Guiana</option>
                                                                <option value="French Polynesia">French Polynesia
                                                                </option>
                                                                <option value="French Southern Territories">French
                                                                    Southern Territories</option>
                                                                <option value="Gabon">Gabon</option>
                                                                <option value="Gambia">Gambia</option>
                                                                <option value="Georgia">Georgia</option>
                                                                <option value="Germany">Germany</option>
                                                                <option value="Ghana">Ghana</option>
                                                                <option value="Gibraltar">Gibraltar</option>
                                                                <option value="Greece">Greece</option>
                                                                <option value="Greenland">Greenland</option>
                                                                <option value="Grenada">Grenada</option>
                                                                <option value="Guadeloupe">Guadeloupe</option>
                                                                <option value="Guam">Guam</option>
                                                                <option value="Guatemala">Guatemala</option>
                                                                <option value="Guernsey">Guernsey</option>
                                                                <option value="Guinea">Guinea</option>
                                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                                <option value="Guyana">Guyana</option>
                                                                <option value="Haiti">Haiti</option>
                                                                <option value="Heard Island and Mcdonald Islands">Heard
                                                                    Island and Mcdonald Islands
                                                                </option>
                                                                <option value="Holy See (Vatican City State)">Holy See
                                                                    (Vatican City State)</option>
                                                                <option value="Honduras">Honduras</option>
                                                                <option value="Hong Kong">Hong Kong</option>
                                                                <option value="Hungary">Hungary</option>
                                                                <option value="Iceland">Iceland</option>
                                                                <option value="India">India</option>
                                                                <option value="Indonesia">Indonesia</option>
                                                                <option value="Iran, Islamic Republic of">Iran, Islamic
                                                                    Republic of</option>
                                                                <option value="Iraq">Iraq</option>
                                                                <option value="Ireland">Ireland</option>
                                                                <option value="Isle of Man">Isle of Man</option>
                                                                <option value="Israel">Israel</option>
                                                                <option value="Italy">Italy</option>
                                                                <option value="Jamaica">Jamaica</option>
                                                                <option value="Japan">Japan</option>
                                                                <option value="Jersey">Jersey</option>
                                                                <option value="Jordan">Jordan</option>
                                                                <option value="Kazakhstan">Kazakhstan</option>
                                                                <option value="Kenya">Kenya</option>
                                                                <option value="Kiribati">Kiribati</option>
                                                                <option value="Korea, Democratic People's Republic of">
                                                                    Korea, Democratic People's
                                                                    Republic of</option>
                                                                <option value="Korea, Republic of">Korea, Republic of
                                                                </option>
                                                                <option value="Kosovo">Kosovo</option>
                                                                <option value="Kuwait">Kuwait</option>
                                                                <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                                <option value="Lao People's Democratic Republic">Lao
                                                                    People's Democratic Republic
                                                                </option>
                                                                <option value="Latvia">Latvia</option>
                                                                <option value="Lebanon">Lebanon</option>
                                                                <option value="Lesotho">Lesotho</option>
                                                                <option value="Liberia">Liberia</option>
                                                                <option value="Libyan Arab Jamahiriya">Libyan Arab
                                                                    Jamahiriya</option>
                                                                <option value="Liechtenstein">Liechtenstein</option>
                                                                <option value="Lithuania">Lithuania</option>
                                                                <option value="Luxembourg">Luxembourg</option>
                                                                <option value="Macao">Macao</option>
                                                                <option
                                                                    value="Macedonia, the Former Yugoslav Republic of">
                                                                    Macedonia, the Former
                                                                    Yugoslav Republic of</option>
                                                                <option value="Madagascar">Madagascar</option>
                                                                <option value="Malawi">Malawi</option>
                                                                <option value="Malaysia">Malaysia</option>
                                                                <option value="Maldives">Maldives</option>
                                                                <option value="Mali">Mali</option>
                                                                <option value="Malta">Malta</option>
                                                                <option value="Marshall Islands">Marshall Islands
                                                                </option>
                                                                <option value="Martinique">Martinique</option>
                                                                <option value="Mauritania">Mauritania</option>
                                                                <option value="Mauritius">Mauritius</option>
                                                                <option value="Mayotte">Mayotte</option>
                                                                <option value="Mexico">Mexico</option>
                                                                <option value="Micronesia, Federated States of">
                                                                    Micronesia, Federated States of</option>
                                                                <option value="Moldova, Republic of">Moldova, Republic
                                                                    of</option>
                                                                <option value="Monaco">Monaco</option>
                                                                <option value="Mongolia">Mongolia</option>
                                                                <option value="Montenegro">Montenegro</option>
                                                                <option value="Montserrat">Montserrat</option>
                                                                <option value="Morocco">Morocco</option>
                                                                <option value="Mozambique">Mozambique</option>
                                                                <option value="Myanmar">Myanmar</option>
                                                                <option value="Namibia">Namibia</option>
                                                                <option value="Nauru">Nauru</option>
                                                                <option value="Nepal">Nepal</option>
                                                                <option value="Netherlands">Netherlands</option>
                                                                <option value="Netherlands Antilles">Netherlands
                                                                    Antilles</option>
                                                                <option value="New Caledonia">New Caledonia</option>
                                                                <option value="New Zealand">New Zealand</option>
                                                                <option value="Nicaragua">Nicaragua</option>
                                                                <option value="Niger">Niger</option>
                                                                <option value="Nigeria">Nigeria</option>
                                                                <option value="Niue">Niue</option>
                                                                <option value="Norfolk Island">Norfolk Island</option>
                                                                <option value="Northern Mariana Islands">Northern
                                                                    Mariana Islands</option>
                                                                <option value="Norway">Norway</option>
                                                                <option value="Oman">Oman</option>
                                                                <option value="Pakistan">Pakistan</option>
                                                                <option value="Palau">Palau</option>
                                                                <option value="Palestinian Territory, Occupied">
                                                                    Palestinian Territory, Occupied</option>
                                                                <option value="Panama">Panama</option>
                                                                <option value="Papua New Guinea">Papua New Guinea
                                                                </option>
                                                                <option value="Paraguay">Paraguay</option>
                                                                <option value="Peru">Peru</option>
                                                                <option value="Philippines">Philippines</option>
                                                                <option value="Pitcairn">Pitcairn</option>
                                                                <option value="Poland">Poland</option>
                                                                <option value="Portugal">Portugal</option>
                                                                <option value="Puerto Rico">Puerto Rico</option>
                                                                <option value="Qatar">Qatar</option>
                                                                <option value="Reunion">Reunion</option>
                                                                <option value="Romania">Romania</option>
                                                                <option value="Russian Federation">Russian Federation
                                                                </option>
                                                                <option value="Rwanda">Rwanda</option>
                                                                <option value="Saint Barthelemy">Saint Barthelemy
                                                                </option>
                                                                <option value="Saint Helena">Saint Helena</option>
                                                                <option value="Saint Kitts and Nevis">Saint Kitts and
                                                                    Nevis</option>
                                                                <option value="Saint Lucia">Saint Lucia</option>
                                                                <option value="Saint Martin">Saint Martin</option>
                                                                <option value="Saint Pierre and Miquelon">Saint Pierre
                                                                    and Miquelon</option>
                                                                <option value="Saint Vincent and the Grenadines">Saint
                                                                    Vincent and the Grenadines
                                                                </option>
                                                                <option value="Samoa">Samoa</option>
                                                                <option value="San Marino">San Marino</option>
                                                                <option value="Sao Tome and Principe">Sao Tome and
                                                                    Principe</option>
                                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                                <option value="Senegal">Senegal</option>
                                                                <option value="Serbia">Serbia</option>
                                                                <option value="Serbia and Montenegro">Serbia and
                                                                    Montenegro</option>
                                                                <option value="Seychelles">Seychelles</option>
                                                                <option value="Sierra Leone">Sierra Leone</option>
                                                                <option value="Singapore">Singapore</option>
                                                                <option value="Sint Maarten">Sint Maarten</option>
                                                                <option value="Slovakia">Slovakia</option>
                                                                <option value="Slovenia">Slovenia</option>
                                                                <option value="Solomon Islands">Solomon Islands
                                                                </option>
                                                                <option value="Somalia">Somalia</option>
                                                                <option value="South Africa">South Africa</option>
                                                                <option
                                                                    value="South Georgia and the South Sandwich Islands">
                                                                    South Georgia and the South
                                                                    Sandwich Islands</option>
                                                                <option value="South Sudan">South Sudan</option>
                                                                <option value="Spain">Spain</option>
                                                                <option value="Sri Lanka">Sri Lanka</option>
                                                                <option value="Sudan">Sudan</option>
                                                                <option value="Suriname">Suriname</option>
                                                                <option value="Svalbard and Jan Mayen">Svalbard and Jan
                                                                    Mayen</option>
                                                                <option value="Swaziland">Swaziland</option>
                                                                <option selected value="Sweden">Sweden</option>
                                                                <option value="Switzerland">Switzerland</option>
                                                                <option value="Syrian Arab Republic">Syrian Arab
                                                                    Republic</option>
                                                                <option value="Taiwan, Province of China">Taiwan,
                                                                    Province of China</option>
                                                                <option value="Tajikistan">Tajikistan</option>
                                                                <option value="Tanzania, United Republic of">Tanzania,
                                                                    United Republic of</option>
                                                                <option value="Thailand">Thailand</option>
                                                                <option value="Timor-Leste">Timor-Leste</option>
                                                                <option value="Togo">Togo</option>
                                                                <option value="Tokelau">Tokelau</option>
                                                                <option value="Tonga">Tonga</option>
                                                                <option value="Trinidad and Tobago">Trinidad and Tobago
                                                                </option>
                                                                <option value="Tunisia">Tunisia</option>
                                                                <option value="Turkey">Turkey</option>
                                                                <option value="Turkmenistan">Turkmenistan</option>
                                                                <option value="Turks and Caicos Islands">Turks and
                                                                    Caicos Islands</option>
                                                                <option value="Tuvalu">Tuvalu</option>
                                                                <option value="Uganda">Uganda</option>
                                                                <option value="Ukraine">Ukraine</option>
                                                                <option value="United Arab Emirates">United Arab
                                                                    Emirates</option>
                                                                <option value="United Kingdom">United Kingdom</option>
                                                                <option value="United States">United States</option>
                                                                <option value="United States Minor Outlying Islands">
                                                                    United States Minor Outlying
                                                                    Islands</option>
                                                                <option value="Uruguay">Uruguay</option>
                                                                <option value="Uzbekistan">Uzbekistan</option>
                                                                <option value="Vanuatu">Vanuatu</option>
                                                                <option value="Venezuela">Venezuela</option>
                                                                <option value="Viet Nam">Viet Nam</option>
                                                                <option value="Virgin Islands, British">Virgin Islands,
                                                                    British</option>
                                                                <option value="Virgin Islands, U.s.">Virgin Islands,
                                                                    U.s.</option>
                                                                <option value="Wallis and Futuna">Wallis and Futuna
                                                                </option>
                                                                <option value="Western Sahara">Western Sahara</option>
                                                                <option value="Yemen">Yemen</option>
                                                                <option value="Zambia">Zambia</option>
                                                                <option value="Zimbabwe">Zimbabwe</option>

                                                            </select>
                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="button" style="display:none"
                                                                class="btn btn-primary"
                                                                id="nextButtonStep1">{{ __('messages.next') }}</button>
                                                        </div>

                                                    </div>
                                                    <!-- Step 2 -->
                                                    <div class="tab-pane fade flip" id="wizard-cart" role="tabpanel"
                                                        aria-labelledby="wizard-cart-tab">
                                                        <input type="file" name="cv" id="hiddenFileInput"
                                                            style="display: none;" accept="application/pdf"
                                                            onchange="handleFileChange()">
                                                        <div class="row mb-3" id="document_row">

                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="button" class="btn btn-primary"
                                                                id="prevButtonStep2">{{ __('messages.previous') }}</button>
                                                            <button type="button" class="btn btn-primary"
                                                                id="nextButtonStep2">{{ __('messages.next') }}</button>
                                                        </div>
                                                    </div>

                                                    <!-- Step 3 -->
                                                    <div class="tab-pane fade flip" id="wizard-banking"
                                                        role="tabpanel" aria-labelledby="wizard-banking-tab">
                                                        <span class="mb-2 mendatory_statment">Fields marked with an
                                                            asterisk <span class="text-danger"> (*) </span> are
                                                            mandatory</span>
                                                        <div class="row" id="billing_info_row">
                                                        </div>
                                                        <div class="row"
                                                            @if (empty($customerdata->send_email_question)) style="display: none;" @endif>
                                                            <h5>{{ __('messages.email_yes_no') }}</h5>
                                                            <div class="col-md-1">
                                                                <label class="d-block"
                                                                    for="sendMailYes">Yes</label>
                                                                <input class="radio radio-primary radio-border-primary"
                                                                    id="sendMailYes" type="radio" name="sendMail"
                                                                    value="yes" checked>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <label class="d-block"
                                                                    for="sendMailNo">No</label>
                                                                <input class="radio radio-primary radio-border-primary"
                                                                    id="sendMailNo" type="radio" name="sendMail"
                                                                    value="no">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input primary"
                                                                    id="approvedFollowUp" type="checkbox"
                                                                    value="" onclick="disable_order(this)">
                                                                <label class="form-check-label"
                                                                    for="approvedFollowUp">I agree to the <a
                                                                        href="" data-bs-toggle="modal"
                                                                        data-bs-target="#exampleModal"><strong>Integrity
                                                                            Policy</strong></a></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 text-end">
                                                            <button type="button" class="btn btn-primary"
                                                                id="prevButtonStep3">{{ __('messages.previous') }}</button>
                                                            <button type="submit" class="btn btn-primary"
                                                                id="finishButton"
                                                                disabled>{{ __('messages.submit_order') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- Finish -->
                                                <div class="tab-pane fade flip" id="finish" role="tabpanel"
                                                    aria-labelledby="finish-tab">
                                                    <div class="order-confirm text-center">
                                                        <img src="assets/images/gif/success/successful.gif"
                                                            alt="success" height="100">
                                                        <h4 class="f-w-600">{{ __('messages.thank_you') }}</h4>
                                                        <p class="mb-0">{{ __('messages.an_email_sent') }}</p>
                                                        <p class="text-center f-w-500 mt-2">
                                                            {{ __('messages.order_id') }}: <a
                                                                class="text-decoration-underline text-primary"
                                                                id="order_id" href="javascript:void(0)"></a></p>
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
            </div>

            <div class="container-fluid default-dashboard">
                <div class="row">

                    <div class="col-xl-12 col-sm-12 box-col-12 mb-3">
                        <div class="row">
                            <div class="col-sm-6 col-6 ">
                                <div class="card small-widget mb-sm-2"
                                    style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                    <a href="{{ route('orders') }}">
                                        <div
                                            class="card-body primary d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="d-flex align-items-end gap-1 text-dark">
                                                    <h3>{{ __('messages.my_current_orders') }}</h3>
                                                </div>
                                                <span style="font-size:15px"
                                                    class="f-light text-dark">{{ $totalOrdersCount }}</span>
                                            </div>
                                            <div class="bg-gradient rounded-icon"
                                                style="background: linear-gradient(144.16deg, rgba(48, 142, 135, 0.1) 19.06%, rgba(48, 142, 135, 0) 79.03%) !important">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    width="24" height="24" color="#000000" fill="none">
                                                    <path
                                                        d="M3 11C3 7.25027 3 5.3754 3.95491 4.06107C4.26331 3.6366 4.6366 3.26331 5.06107 2.95491C6.3754 2 8.25027 2 12 2C15.7497 2 17.6246 2 18.9389 2.95491C19.3634 3.26331 19.7367 3.6366 20.0451 4.06107C21 5.3754 21 7.25027 21 11V13C21 16.7497 21 18.6246 20.0451 19.9389C19.7367 20.3634 19.3634 20.7367 18.9389 21.0451C17.6246 22 15.7497 22 12 22C8.25027 22 6.3754 22 5.06107 21.0451C4.6366 20.7367 4.26331 20.3634 3.95491 19.9389C3 18.6246 3 16.7497 3 13V11Z"
                                                        stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
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
                                <div class="card small-widget mb-sm-2"
                                    style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                    <a href="{{ route('history') }}">
                                        <div
                                            class="card-body primary d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="d-flex align-items-end gap-1 text-dark">
                                                    <h3>{{ __('messages.archive_order') }}</h3>
                                                </div>
                                                <span style="font-size:15px"
                                                    class="f-light text-dark">{{ $totalHistoryCount }}</span>
                                            </div>
                                            <div class="bg-gradient rounded-icon"
                                                style="background: linear-gradient(144.16deg, rgba(234, 146, 0, 0.1) 19.06%, rgba(234, 146, 0, 0) 79.03%) !important">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    width="24" height="24" color="#000000" fill="none">
                                                    <path
                                                        d="M11.0065 21H9.60546C6.02021 21 4.22759 21 3.11379 19.865C2 18.7301 2 16.9034 2 13.25C2 9.59661 2 7.76992 3.11379 6.63496C4.22759 5.5 6.02021 5.5 9.60546 5.5H13.4082C16.9934 5.5 18.7861 5.5 19.8999 6.63496C20.7568 7.50819 20.9544 8.7909 21 11"
                                                        stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M18.85 18.85L17.5 17.95V15.7M13 17.5C13 19.9853 15.0147 22 17.5 22C19.9853 22 22 19.9853 22 17.5C22 15.0147 19.9853 13 17.5 13C15.0147 13 13 15.0147 13 17.5Z"
                                                        stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M16 5.5L15.9007 5.19094C15.4056 3.65089 15.1581 2.88087 14.5689 2.44043C13.9796 2 13.197 2 11.6316 2H11.3684C9.80304 2 9.02036 2 8.43111 2.44043C7.84186 2.88087 7.59436 3.65089 7.09934 5.19094L7 5.5"
                                                        stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
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

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title f-16 w-600 text-black" id="exampleModalLabel">
                            {{ __('messages.integrity_policy') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <iframe src="{{ asset('uploads/1732180920-INTEGRITETSPOLICY') }}"
                            style="width: 100%; height: 100%;" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="form-btn"
                            data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="requirements" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title f-16 w-600 text-black" id="exampleModalLabel">
                            {{ __('messages.included_things') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="form-btn"
                            data-bs-dismiss="modal">{{ __('messages.close') }}</button>
                    </div>
                </div>
            </div>
        </div>

        @include('includes.footer')
        <script>
            let service_title = '';
            var interview_template = 0
            // (isset(auth()->user()->interview_template) && !empty(auth()->user()->interview_template))
            @if (isset(auth()->user()->interview_template) && !empty(auth()->user()->interview_template))
                interview_template = 1
            @endif
            let wizardTabs = document.querySelectorAll('.nav-link');
            let formSections = document.querySelectorAll('.tab-pane');
            let currentTab = 0; // start at the first tab
            function showTab(index) {
                wizardTabs = document.querySelectorAll('.nav-link');
                formSections = document.querySelectorAll('.tab-pane');
                formSections.forEach((section, i) => {
                    if (i == index) {
                        section.classList.add('animate');
                        setTimeout(() => {
                            section.classList.remove('animate');
                        }, 300);
                        section.classList.add('show', 'active');
                    } else {
                        section.classList.remove('show', 'active');
                    }
                });

                wizardTabs.forEach((tab, i) => {
                    if (i == index) {
                        tab.classList.add('animate');
                        setTimeout(() => {
                            tab.classList.remove('animate');
                        }, 300);
                        tab.classList.add('active');
                    } else {
                        tab.classList.remove('active');
                    }
                });
            }

            showTab(currentTab);

            function validateForm() {
                wizardTabs = document.querySelectorAll('.nav-link');
                formSections = document.querySelectorAll('.tab-pane');
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



            function submitStep4() {
                const form = document.querySelector('#step1Form');

                if (form.checkValidity()) {
                    const formData = new FormData(form);

                    $.ajax({
                        url: '{{ route('submit.order') }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                showTab(4);
                                $('#finish').addClass('show')
                                $('#finish').addClass('active')
                                $('.mendatory_statment').hide()
                                $('#order_id').html(response.orderId)
                                $('#order_id').attr('href', 'http://customer.recway.se/view-order?id=' + response
                                    .keyId)
                                // $('#order_id').attr('href', 'https://orderspi.se/new_customer/public/view-order?id=' + response.keyId)

                                setTimeout(function() {
                                    location.reload();
                                }, 6000);
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('AJAX error: ' + xhr.responseJSON.message);
                        }
                    });
                } else {
                    form.classList.add('was-validated');
                }
            }

            window.translations = {
                name: "{{ __('messages.name') }}",
                surname: "{{ __('messages.surname') }}",
                email: "{{ __('messages.email') }}",
                phone: "{{ __('messages.phone') }}",
                social_security: "{{ __('messages.social_security') }}",
                vasc_id: "{{ __('messages.vasc_id') }}",
                land: "{{ __('messages.land') }}",
                reference_rec: "{{ __('messages.reference_rec') }}",
                reference: "{{ __('messages.reference') }}",
                invoice_comment: "{{ __('messages.invoice_comment') }}",
                note: "{{ __('messages.note') }}",
            };

            function fetch_form(obj) {
                var ser_id = $(obj).val();
                if (ser_id) {
                    $('.shopping-wizard').fadeIn(500);
                    $('.mendatory_statment').fadeIn(500);
                    $('#nextButtonStep1').fadeIn();
                    $('#nextButtonStep1').show();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('service.get_form') }}",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'ser_id': ser_id,
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.form) {
                                var html = '';
                                // Parse form data
                                response = JSON.parse(response.form)
                                if (response.form_builder) {
                                    response = response.form_builder;
                                    var per_info_html = '';
                                    var bil_info_html = '';
                                    var doc_file_html = '';

                                    // Process personal_info
                                    if (response.personal_info) {
                                        personal_info = response.personal_info;
                                        $.each(personal_info, function(p, v) {
                                            var real_data = p.split(',');
                                            if (real_data != '') {
                                                var type = real_data[0] || 'text';
                                                var label = real_data[1] || '';
                                                var name = real_data[2] || '';
                                                var placehol = real_data[3] || '';
                                                var req = real_data[4] || '';
                                                var is_new = real_data[6] || '';
                                                var default_val = real_data[7] || '';

                                                if (type === 'select') {
                                                    let options = [];

                                                    if (typeof default_val === 'string' && default_val
                                                        .trim() !== '') {
                                                        options = default_val.split('|')
                                                            .map(opt => opt.trim())
                                                            .filter(opt => opt !== '');
                                                    }

                                                    per_info_html +=
                                                        `<div class="col-md-6 col-sm-12 mb-2"><label>${name}</label><select class="form-control select-ui" ` +
                                                        (is_new ? `name="form_builder[` + label + `]"` :
                                                            `name="` + name + `"`) + `>`;

                                                    if (placehol) {
                                                        per_info_html +=
                                                            `<option value="" selected hidden>${placehol}</option>`;
                                                    }

                                                    options.forEach(function(opt) {
                                                        const selected = (v === opt) ? 'selected' :
                                                            '';
                                                        per_info_html +=
                                                            `<option value="${opt}" ${selected}>${opt}</option>`;
                                                    });

                                                    per_info_html += `</select></div>`;

                                                } else if (name != 'document_file') {
                                                    per_info_html += `
                          <div class="col-md-6 col-sm-12 mb-2">
                              <label class="form-label" for="">` + label + ``
                                                    if (req) {
                                                        per_info_html +=
                                                            ` <span class="text-danger">*</span>`
                                                    }
                                                    per_info_html +=
                                                        `</label><input class="form-control" id=""  ` +
                                                        (is_new ? `name="form_builder[` + label + `]"` :
                                                            `name="` + name + `"`) +
                                                        ` ` + req + `  type="` + type + `" placeholder="` +
                                                        placehol + `">
                            </div>`;
                                                } else {
                                                    doc_file_html += `<div class="col-md-12 col-sm-12 mb-2">
                                        <label class="form-label">` + label + `</label>
                                  <div class="dropzone dropzone-secondary p-3" id="dropzoneArea" onclick="triggerFileInput()" style="text-align:center">
                                    <div class="dz-message needsclick">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h6>${window.translations.upload_document_cv}</h6>
                                    <span class="note needsclick">(${window.translations.click_to_upload})</span>
                                </div>
                                </div>
                              </div>
                            @if (isset(auth()->user()->interview_template) && !empty(auth()->user()->interview_template))
                <div class="col-md-12 col-sm-12 mb-2">
                  <label class="form-label">Interview Template</label>
                  <input type="file" name="interview_template" id="hiddenFileInput2" style="display: none;" accept="application/pdf" onchange="handleFileChange2()">
                  <div class="dropzone dropzone-primary p-3" id="dropzoneArea2" onclick="triggerFileInput2()" style="text-align:center">
                  <div class="dz-message needsclick">
                  <i class="fa-solid fa-cloud-arrow-up"></i>
                  <h6>${window.translations.upload_interview_template}</h6>
                  <span class="note needsclick">(${window.translations.click_to_upload})</span>
                  </div>
                  </div>
                </div>
                @endif
                              `;
                                                }
                                            }
                                        });
                                    }

                                    // Process billing_info
                                    if (response.billing_info) {
                                        billing_info = response.billing_info;
                                        $.each(billing_info, function(p, v) {
                                            var real_data = p.split(',');
                                            if (real_data != '') {
                                                var type = real_data[0] || 'text';
                                                var label = real_data[1] || '';
                                                var name = real_data[2] || '';
                                                var placehol = real_data[3] || '';
                                                var req = real_data[4] || '';
                                                var is_new = real_data[6] || '';
                                                if (name == 'note') {
                                                    bil_info_html += `<hr style="margin-top: 15px;"><div class="col-md-12 col-sm-6 mb-2">
                                <label class="form-label" for="note">Note</label>
                                <textarea class="form-control" id="note" name="note" placeholder="${window.translations.note_plac}"></textarea>
                              </div>`
                                                } else {
                                                    bil_info_html += ` <div class="col-md-12 col-sm-6">
                                  <label class="form-label" >` + label
                                                    if (req) {
                                                        bil_info_html +=
                                                            ` <span class="text-danger">*</span>`
                                                    }
                                                    bil_info_html += `</label>
                                  <input class="form-control"  ` +
                                                        (is_new ? `name="form_builder[` + label + `]"` :
                                                            `name="` + name + `"`) +
                                                        ` ` + req + `  type="` + type + `" placeholder="` +
                                                        v + `"`
                                                    if (name == "pref") {
                                                        bil_info_html += ` value="{{ $pref }}"`
                                                    } else if (name == "ref") {
                                                        bil_info_html += ` value="{{ $ref }}"`
                                                    } else if (name == "comment") {
                                                        bil_info_html += ` value="{{ $comment }}"`
                                                    }
                                                    bil_info_html += `>
                            </div>`;
                                                }
                                            }
                                        });
                                    }
                                    // Append HTML to the page
                                    $('#personal_info_row').html(per_info_html);
                                    $('#billing_info_row').html(bil_info_html);
                                    if (doc_file_html) {
                                        var doc_html = `<div class="tab-pane fade flip" id="wizard-cart" role="tabpanel" aria-labelledby="wizard-cart-tab">
                            <input type="file" name="cv" id="hiddenFileInput" style="display: none;" accept="application/pdf" onchange="handleFileChange()">
                            <div class="row mb-3" id="document_row">

                            </div>
                            <div class="col-12 text-end">
                              <button type="button" class="btn btn-primary" onclick="btn_primary_click(event,this)" id="prevButtonStep2">${window.translations.previous}</button>
                              <button type="button" class="btn btn-primary" onclick="btn_primary_click(event,this)" id="nextButtonStep2">${window.translations.next}</button>
                            </div>
                          </div>`
                                        var tab_html = `<a class="nav-link zoom-in" href="#wizard-cart" id="attachment_tab" onclick="check_validity(event, 'wizard-cart',this)">
                                            <div class="cart-options">
                                              <div class="stroke-icon-wizard"><i class="fa-solid fa-paperclip"></i></div>
                                              <div class="cart-options-content">
                                                <h6 class="f-w-700">${window.translations.attachment}</h6>
                                              </div>
                                            </div>
                                          </a>`
                                        if ($('#attachment_tab').length == 0) {
                                            $('.nav-link:eq(0)').after(tab_html);
                                            $('.tab-pane.fade:eq(0)').after(doc_html);
                                        }
                                        $('#document_row').html(doc_file_html);
                                    } else {
                                        if (interview_template) {
                                            var inter_html = `@if (isset(auth()->user()->interview_template) && !empty(auth()->user()->interview_template))
            <div class="col-md-12 col-sm-12 mb-2">
              <label class="form-label">Interview Template</label>
              <input type="file" name="interview_template" id="hiddenFileInput2" style="display: none;" accept="application/pdf" onchange="handleFileChange2()">
              <div class="dropzone dropzone-primary p-3" id="dropzoneArea2" onclick="triggerFileInput2()" style="text-align:center">
              <div class="dz-message needsclick">
              <i class="fa-solid fa-cloud-arrow-up"></i>
              <h6>${window.translations.upload_interview_template}</h6>
              <span class="note needsclick">(${window.translations.click_to_upload})</span>
              </div>
              </div>
            </div>
          @endif
                          `
                                            $('#wizard-cart').html(inter_html)
                                        } else {
                                            $('#attachment_tab').remove();
                                            $('#wizard-cart').remove();
                                        }
                                    }
                                }
                            } else {
                                var per_info_html = `<div class="col-md-6 col-sm-12 mb-2">
                              <label class="form-label" for="name">${window.translations.name} <span class="text-danger">*</span></label>
                              <input class="form-control" id="name" name="name" type="text" placeholder="Enter name" required="">
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                              <label class="form-label" for="surname">${window.translations.surname} <span class="text-danger">*</span></label>
                              <input class="form-control" id="surname" name="surname" type="text" placeholder="Enter surname" required="">
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                              <label class="form-label" for="email">${window.translations.email} <span class="text-danger">*</span></label>
                              <input class="form-control" id="email" name="email" type="email" required="" placeholder="admiro@example.com">
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                              <label class="form-label" for="phone">${window.translations.phone} <span class="text-danger">*</span></label>
                              <input class="form-control" id="phone" name="phone" type="tel" required="" placeholder="Enter number">
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                              <label class="form-label" for="ssn">${window.translations.social_security} <span class="text-danger">*</span></label>
                              <input class="form-control" id="ssn" name="security" type="text" required="" placeholder="Enter Social Security Number">
                            </div>
                            <div class="col-md-6 col-sm-12 mb-2">
                              <label class="form-label" for="vasc_id">${window.translations.vasc_id}</label>
                              <input class="form-control" id="vasc_id" name="vasc_id" type="text" placeholder="VASC ID">
                            </div>`
                                var bil_info_html = `<div class="col-md-12 col-sm-6 mb-2">
                                <label class="form-label" for="referenceInvoiceRecipient">${window.translations.reference_rec} <span class="text-danger">*</span></label>
                                <input class="form-control" id="referenceInvoiceRecipient" name="pref" type="text" placeholder="Enter Reference (Invoice Recipient)" required=""  value="{{ $pref }}">
                              </div>
                              <div class="col-md-12 col-sm-6 mb-2">
                                <label class="form-label" for="reference">${window.translations.reference} <span class="text-danger">*</span></label>
                                <input class="form-control" id="reference" name="ref" type="text" placeholder="Enter Reference" required="" value="{{ $ref }}">
                              </div>
                              <div class="col-md-12 col-sm-6 mb-2">
                                <label class="form-label" for="invoiceComment">${window.translations.invoice_comment}</label>
                                <input class="form-control" id="invoiceComment" name="comment" type="text" placeholder="Invoice Comment" value="{{ $comment }}">
                              </div>   
                              <hr style="margin-top: 15px;">                          
                              <div class="col-md-12 col-sm-6 mb-2">
                              <label class="form-label" for="note">${window.translations.note}</label>
                              <textarea class="form-control" id="note" name="note" placeholder="${window.translations.note_plac}"></textarea>
                              </div>`
                                var doc_file_html = `<div class="col-md-12 col-sm-12 mb-2">
                                        <label class="form-label">${window.translations.document}</label>
                                  <div class="dropzone dropzone-secondary p-3" id="dropzoneArea" onclick="triggerFileInput()" style="text-align:center">
                                    <div class="dz-message needsclick">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <h6>${window.translations.upload_document_cv}</h6>
                                    <span class="note needsclick">(${window.translations.click_to_upload})</span>
                                </div>
                                </div>
                              </div>
                            @if (isset(auth()->user()->interview_template) && !empty(auth()->user()->interview_template))
                <div class="col-md-12 col-sm-12 mb-2">
                  <label class="form-label">Interview Template</label>
                  <input type="file" name="interview_template" id="hiddenFileInput2" style="display: none;" accept="application/pdf" onchange="handleFileChange2()">
                  <div class="dropzone dropzone-primary p-3" id="dropzoneArea2" onclick="triggerFileInput2()" style="text-align:center">
                  <div class="dz-message needsclick">
                  <i class="fa-solid fa-cloud-arrow-up"></i>
                  <h6>${window.translations.upload_interview_template}</h6>
                  <span class="note needsclick">(${window.translations.click_to_upload})</span>
                  </div>
                  </div>
                </div>
                @endif
                            `
                                $('#personal_info_row').html(per_info_html);
                                $('#billing_info_row').html(bil_info_html);
                                var doc_html = `<div class="tab-pane fade flip" id="wizard-cart" role="tabpanel" aria-labelledby="wizard-cart-tab">
                            <input type="file" name="cv" id="hiddenFileInput" style="display: none;" accept="application/pdf" onchange="handleFileChange()">
                            <div class="row mb-3" id="document_row">

                            </div>
                            <div class="col-12 text-end">
                              <button type="button" class="btn btn-primary" onclick="btn_primary_click(event,this)" id="prevButtonStep2">${window.translations.previous}</button>
                              <button type="button" class="btn btn-primary" onclick="btn_primary_click(event,this)" id="nextButtonStep2">${window.translations.next}</button>
                            </div>
                          </div>`
                                var tab_html = `<a class="nav-link zoom-in" href="#wizard-cart" id="attachment_tab" onclick="check_validity(event, 'wizard-cart',this)">
                                            <div class="cart-options">
                                              <div class="stroke-icon-wizard"><i class="fa-solid fa-paperclip"></i></div>
                                              <div class="cart-options-content">
                                                <h6 class="f-w-700">${window.translations.attachment}</h6>
                                              </div>
                                            </div>
                                          </a>`
                                if ($('#attachment_tab').length == 0) {
                                    $('.nav-link:eq(0)').after(tab_html);
                                    $('.tab-pane.fade:eq(0)').after(doc_html);
                                }
                                if ($('#document_row').length == 0) {
                                    $('#wizard-cart').remove();
                                    $('.tab-pane.fade:eq(0)').after(doc_html);
                                }
                                $('#document_row').html(doc_file_html);

                            }
                            $('.nav-link').removeClass('active');
                            $('a[href="#wizard-contact"]').addClass('active');
                            $('.tab-pane.fade').removeClass('active');
                            $('.tab-pane.fade').removeClass('show');
                            $('#wizard-contact').addClass('active');
                            $('#wizard-contact').addClass('show');
                        },
                        error: function(e) {
                            alert("AJAX request failed!");
                        }
                    });
                }
            }

            function check_p_c(obj = null) {
                if (obj == null) {
                    var obj_val = $('#interviewSelect').val();
                    var place = $('#hidden_interview').find('option:selected').data('place');
                    var country = $('#hidden_interview').find('option:selected').data('country');
                    var ddays = $('#hidden_interview').find('option:selected').data('ddays');
                    var desc = $('#hidden_interview').find('option:selected').data('desc');
                } else {
                    var obj_val = $(obj).val();
                    var place = $('#hidden_interview').find('option[value=' + obj_val + ']').data('place');
                    var country = $('#hidden_interview').find('option[value=' + obj_val + ']').data('country');
                    var ddays = $('#hidden_interview').find('option[value=' + obj_val + ']').data('ddays');
                    var desc = $('#hidden_interview').find('option[value=' + obj_val + ']').data('desc');
                }
                if (place == 1) {
                    $('div[id="place"]').removeClass('d-none')
                    $('select[name="place"]').prop("disabled", false)
                } else {
                    $('div[id="place"]').addClass('d-none')
                    $('select[name="place"]').prop("disabled", true)
                }
                if (country == 1) {
                    $('#country').removeClass('d-none')
                    $('select[name="country"]').prop("disabled", false)
                } else {
                    $('#country').addClass('d-none')
                    $('select[name="country"]').prop("disabled", true)
                }
                if (desc == 1) {
                    $('#requirement_btn').show()
                } else {
                    $('#requirement_btn').hide()
                }
                if (ddays > 0) {
                    $('#delivery_days').html('Delivery : ' + ddays + ' Days &nbsp;&nbsp;&nbsp;&nbsp;')
                } else {
                    $('#delivery_days').html('')
                }
            }
            $(document).ready(function() {
                check_p_c();
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
                        const filePreview =
                            `
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
                        const filePreview =
                            `
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
        <h6>${window.translations.upload_document_cv}</h6>
        <span class="note needsclick">(${window.translations.click_to_upload})</span>
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
                        const filePreview =
                            `
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
                        const filePreview =
                            `
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
          <h6>${window.translations.upload_interview_template}</h6>
          <span class="note needsclick">(${window.translations.click_to_upload})</span>
        </div>
        `);
                removeButton.hide();
            }

            function check_validity(event, targetTabId, clickedElement) {
                event.preventDefault();
                clickedElement.classList.add('animate');
                setTimeout(() => {
                    clickedElement.classList.remove('animate');
                }, 300);
                var service_id = $('#interviewSelect').find('option:selected').val();
                if (service_id) {
                    let currentTab = document.querySelector('.tab-pane.active.show');
                    if (validateFormpane(currentTab)) {
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
                document.querySelector(`#${targetTabId}`).classList.add('animate');
                setTimeout(() => {
                    document.querySelector(`#${targetTabId}`).classList.remove('animate');
                }, 300);
                document.querySelector('#step1Form').classList.remove('was-validated');
                document.querySelector('.nav-link.active').classList.remove('active');
                document.querySelector('.tab-pane.active.show').classList.remove('active', 'show');

                document.querySelector(`#${targetTabId}`).classList.add('active', 'show');
                document.querySelector(`.nav-link[href="#${targetTabId}"]`).classList.add('active');
            }
            // Function to validate email format
            function validateEmail(email) {
                const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return emailPattern.test(email);
            }

            function disable_order(obj) {
                if ($(obj).is(':checked')) {
                    $('#finishButton').prop('disabled', false);
                } else {
                    $('#finishButton').prop('disabled', true);
                }
            }
            $('#service_label').on('mouseenter', function() {
                $('#informative_text').fadeIn(500);
            })


            function fetch_services(obj) {
                var service_id = $(obj).data('id');
                $('#personal_info_row').html('');
                $('#billing_info_row').html('');
                $('#document_row').html('');
                $('a.card').removeClass('active')
                $(obj).addClass('active')
                $('#choose_serv_cat').text('Create Order')
                $('.ser_img').slideUp();
                $('#delivery_days').html('')
                $.ajax({
                    type: "POST",
                    url: "{{ route('service.get') }}",
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'ser_id': service_id,
                    },
                    dataType: "json",
                    success: function(response) {
                        var req = '';
                        var html = `<option value="" selected disabled>Choose Service</option>`;
                        var opt_html = `<option value="" selected disabled>Choose Service</option>`;
                        var desc = 0;
                        if (response) {
                            $.each(response, function(i, v) {
                                desc = 0;
                                if (v.desc != '') {
                                    desc = 1
                                } else {
                                    desc = 0
                                }
                                req += `<div id="req_` + v.id + `">` + v.desc + `</div>`
                                html += `<option value="` + v.id + `">` + v.title + `</option>`;
                                opt_html += `<option value="` + v.id + `" data-place="` + v.place +
                                    `" data-country="` + v.country + `" data-ddays="` + v.delivery_days +
                                    `"  data-desc="` + desc + `">` + v.title + `</option>`;
                            });
                            $('#interviewSelect').html(html)
                            $('#place').addClass('d-none')
                            $('#country').addClass('d-none')
                            $('#hidden_interview').html(opt_html)
                            $('#interviewSelect').select2({
                                allowClear: true,
                                height: 'resolve'
                            });
                            $('#personal_info_row').html('');
                            $('#billing_info_row').html('');
                            $('#document_row').html('');
                            $('#main-form-div').slideDown(500);
                            $('.shopping-wizard').hide();
                            $('.nav-link').removeClass('active');
                            $('a[href="#wizard-contact"]').addClass('active');
                            $('.tab-pane.fade').removeClass('active');
                            $('.tab-pane.fade').removeClass('show');
                            $('#req').html(req)
                        }

                    },
                    error: function(e) {
                        alert("AJAX request failed!");
                    }
                });

            }

            function btn_primary_click(event, obj) {
                event.preventDefault();
                let btn = $(obj);
                let buttonText = btn.text().toLowerCase();
                wizardTabs = document.querySelectorAll('.step');
                formSections = document.querySelectorAll('.tab-pane');
                currentTab = Array.from(formSections).findIndex(tab => tab.classList.contains('active'));
                if (buttonText == 'next' || buttonText == 'nästa') {
                    let isValid = validateForm();
                    if (isValid) {
                        currentTab++;
                        if (currentTab >= formSections.length) {
                            currentTab = formSections.length - 1;
                        }
                        document.querySelector('#step1Form').classList.remove('was-validated');
                        showTab(currentTab);
                    }
                } else if (buttonText === 'previous' || buttonText == 'föregående') {
                    currentTab--;
                    if (currentTab < 0) {
                        currentTab = 0;
                    }
                    showTab(currentTab);
                } else if (buttonText === 'submit order' || buttonText == 'skicka beställning') {
                    var html = `<p id="waiting-text">Please wait for a few seconds while your order has been processed.</p>`;

                    let isValid = validateForm();
                    if (isValid) {
                        btn.closest('.col-12.text-end').hide();
                        $('#billing_info_row').append(html);
                        submitStep4();
                    }
                }
            }

            function show_req_modal() {
                var obj_val = $('#interviewSelect').val();
                if (obj_val) {
                    var req = $("#req_" + obj_val).html();
                    $('#requirements').find('.modal-body').html(req);
                    $('#requirements').modal('show')
                }
            }
        </script>
