@include('includes.head')
<style>
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
@php
    $document = 0;
    $InvoiceRecipient = __('messages.invoice_recipient');
    $InvoiceReference = __('messages.invoice_reference'); 
    $InvoiceComment = __('messages.invoice_comment');
    $InvoiceRecipientPlac = __('messages.invoice_recipient_placeholder');
    $InvoiceReferencePlac = __('messages.invoice_reference_placeholder');
    $InvoiceCommentPlac = __('messages.invoice_comment_placeholder');
    if (!empty($form_builder)) {
        $form = json_decode($form_builder['form'])->form_builder;
        if (!empty($form->billing_info)) {
            foreach ($form->billing_info as $b_k => $b_v) {
                $real_dta = explode(',', $b_k);
                $label = isset($real_dta[1]) ? $real_dta[1] : '';
                $name = isset($real_dta[2]) ? $real_dta[2] : '';
                $plac = isset($real_dta[3]) ? $real_dta[3] : '';
                if ($name == 'pref') {
                    $InvoiceRecipient = $label;
                    $InvoiceRecipientPlac = $plac;
                }
                if ($name == 'ref') {
                    $InvoiceReference = $label;
                    $InvoiceReferencePlac = $plac;
                }
                if ($name == 'comment') {
                    $InvoiceComment = $label;
                    $InvoiceCommentPlac = $plac;
                }
            }
        }
    }

@endphp

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
                            <h2>{{ __('messages.account') }}</h2>
                        </div>
                        <div class="col-sm-6 col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i
                                            class="iconly-Home icli svg-color"></i></a></li>
                                <li class="breadcrumb-item">{{ __('messages.account') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xxl-12 col-12">
                        <div class="card" style="border-radius:0px">
                            <div class="card-body p-0" style="padding-top: 10px !important;">
                                <ul class="nav nav-tabs border-tab border-0 mb-0 nav-dark" id="topline-tab"
                                    role="tablist">
                                    <li class="nav-item" role="presentation"><a
                                            class="nav-link active nav-border pt-0 text-dark nav-dark"
                                            id="topline-top-user-tab" data-bs-toggle="tab" href="#topline-top-user"
                                            role="tab" aria-controls="topline-top-user" aria-selected="true"> <i
                                                class="fa-solid fa-user">
                                            </i>{{ __('messages.personal_information') }}</a></li>
                                    <li class="nav-item" role="presentation"><a
                                            class="nav-link nav-border text-dark nav-dark" id="topline-top-billing-tab"
                                            data-bs-toggle="tab" href="#topline-top-billing" role="tab"
                                            aria-controls="topline-top-billing" aria-selected="false" tabindex="-1"> <i
                                                class="fa-solid fa-money-bill">
                                            </i>{{ __('messages.billing_details') }}</a></li>
                                    <li class="nav-item" role="presentation"><a
                                            class="nav-link nav-border text-dark nav-dark"
                                            id="topline-top-description-tab" data-bs-toggle="tab"
                                            href="#topline-top-description" role="tab"
                                            aria-controls="topline-top-description" aria-selected="false"
                                            tabindex="-1"><i class="fa-solid fa-envelope">
                                            </i>{{ __('messages.email_settings') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 mb-lg-3 col-12">
                        <div class="card" style="border-radius:0px">
                            <div class="card-body">
                                <div class="tab-content" id="topline-tabContent">
                                    <div class="tab-pane fade show active" id="topline-top-user" role="tabpanel"
                                        aria-labelledby="topline-top-user-tab">
                                        <div class="card-body pt-0 px-0 pb-0">
                                            <div class="user-header pb-2">
                                                <h5 class="fw-bold">{{ __('messages.personal_information') }}:
                                                </h5>
                                            </div>
                                            <div class="user-content">
                                                <form
                                                    class="row g-3 needs-validation custom-input validation-vertical-wizard"
                                                    method="POST" action="{{ route('profile.update') }}">
                                                    @csrf
                                                    @if (session('success'))
                                                        <div class="alert alert-success">
                                                            {{ session('success') }}
                                                        </div>
                                                    @endif
                                                    <div class="col-md-4 col-sm-6">
                                                        <label class="form-label"
                                                            for="validationCustom0-a">{{ __('messages.name') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" id="validationCustom0-a"
                                                            name="name" type="text"
                                                            value="{{ old('name', $user->name) }}"
                                                            placeholder="{{ __('messages.enter_name') }}"
                                                            required="">
                                                        @if ($errors->has('name'))
                                                            <div class="text-danger">{{ $errors->first('name') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4 col-sm-6">
                                                        <label class="form-label"
                                                            for="validationemail-b">{{ __('messages.email') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" id="validationemail-b"
                                                            name="email" type="email" required=""
                                                            value="{{ old('name', $user->email) }}"
                                                            placeholder="{{ __('messages.email_placeholder') }}">
                                                        @if ($errors->has('email'))
                                                            <div class="text-danger">{{ $errors->first('email') }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4 col-sm-6">
                                                        <label class="form-label"
                                                            for="phone">{{ __('messages.phone') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" id="phone" type="text"
                                                            name="phone"
                                                            placeholder="{{ __('messages.phone_placeholder') }}"
                                                            value="{{ old('name', $user->phone) }}" required="">
                                                        @if ($errors->has('phone'))
                                                            <div class="text-danger">{{ $errors->first('phone') }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4 col-sm-6">
                                                        <label class="form-label"
                                                            for="comapny_name">{{ __('messages.company') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" id="comapny_name" type="text"
                                                            name="company"
                                                            placeholder="{{ __('messages.company_placeholder') }}"
                                                            value="{{ old('name', $user->company) }}" required="">
                                                        @if ($errors->has('company'))
                                                            <div class="text-danger">{{ $errors->first('company') }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4 col-sm-6">
                                                        <label class="form-label"
                                                            for="cost_place">{{ __('messages.organization_number') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" id="cost_place" type="text"
                                                            name="org_no" required=""
                                                            value="{{ old('name', $user->org_no) }}"
                                                            placeholder="{{ __('messages.organization_placeholder') }}">
                                                        @if ($errors->has('org_no'))
                                                            <div class="text-danger">{{ $errors->first('org_no') }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-4 col-sm-6">
                                                        <label class="form-label"
                                                            for="password">{{ __('messages.password') }}<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" id="password" name="password"
                                                            type="password"
                                                            placeholder="{{ __('messages.password_change_note') }}">
                                                        @if ($errors->has('password_confirmation'))
                                                            <div class="text-danger">
                                                                {{ $errors->first('password_confirmation') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 col-sm-12">
                                                        <label
                                                            class="form-label">{{ __('messages.last_login') }}</label>
                                                        <p><b>{{ $user->last_login }}</b></p>
                                                    </div>

                                                    <div class="col-12 text-end">
                                                        <button class="btn btn-primary"
                                                            type="submit">{{ __('messages.update') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="topline-top-billing" role="tabpanel"
                                        aria-labelledby="topline-top-billing-tab">
                                        <div class="card-body pt-0 px-0 pb-0">
                                            <div class="user-header pb-2">
                                                <h5 class="fw-bold">{{ __('messages.billing_details') }}:</h5>
                                            </div>
                                            <div class="user-content">
                                                <form
                                                    class="row g-3 needs-validation custom-input validation-vertical-wizard"
                                                    method="POST" action="{{ route('billing.update') }}">
                                                    @csrf
                                                    <div class="col-md-12 col-sm-6 mb-2">
                                                        <label class="form-label"
                                                            for="referenceInvoiceRecipient">{!! $InvoiceRecipient !!}</label>
                                                        <input class="form-control" id="referenceInvoiceRecipient"
                                                            name="referenceperson" type="text"
                                                            placeholder="{{ $InvoiceRecipientPlac }}"
                                                            value="{{ $standard->referenceperson ?? '' }}">
                                                    </div>
                                                    <div class="col-md-12 col-sm-6 mb-2">
                                                        <label class="form-label"
                                                            for="reference">{!! $InvoiceReference !!}</label>
                                                        <input class="form-control" id="reference" name="reference"
                                                            type="text" placeholder="{{ $InvoiceReferencePlac }}"
                                                            value="{{ $standard->reference ?? '' }}">
                                                    </div>
                                                    <div class="col-md-12 col-sm-6 mb-2">
                                                        <label class="form-label"
                                                            for="invoiceComment">{!! $InvoiceComment !!}</label>
                                                        <input class="form-control" id="invoiceComment"
                                                            name="comment" type="text"
                                                            placeholder="{{ $InvoiceCommentPlac }}"
                                                            value="{{ $standard->comment ?? '' }}">
                                                    </div>

                                                    <div class="col-12 text-end">
                                                        <button class="btn btn-primary"
                                                            type="submit">update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="topline-top-description" role="tabpanel"
                                        aria-labelledby="topline-top-description-tab">
                                        <div class="card-body pt-0 px-0 pb-0">
                                            <div class="user-header pb-2">
                                                <h5 class="fw-bold">{{ __('messages.email_settings') }}:&nbsp;
                                                    <small>({{ __('messages.email_settings_note') }})</small>
                                                </h5>
                                            </div>
                                            <div class="user-content">
                                                <ul class="nav mb-4 border-tab" id="top-tab" role="tablist"
                                                    style="display: flex;flex-direction: row;flex-wrap: nowrap;">
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
                                                                    <button
                                                                        class="btn btn-outline-dark-2x btn-lg w-100"
                                                                        data-id="{{ $category->id }}"
                                                                        data-category="{{ $category->id . '' . $category->name }}">{{ $category->name }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                                <d class="row" id="status_row" style="display: none;">
                                                   <h5 style="margin-left:10px;margin-bottom:10px">
                                                        <small>{{ __('messages.status_selection_note') }}</small></h5>
                                                    </h5>
                                                    <div class="col-12"
                                                        style="display: flex;flex-direction: row;flex-wrap: wrap;align-items: baseline;margin-bottom:20px">
                                                        @foreach ($categories as $category)
                                                            @foreach ($statuses as $status)
                                                                @if ($status->service_cat_id == $category->id)
                                                                    @if ($status->status != 'New Order')
                                                                        <div class="col-md-3 mb-3 statuses-filter"
                                                                            data-service-cat="{{ $category->id . '' . $category->name }}"
                                                                            style="display:none">
                                                                            <div class="form-check"
                                                                                style="padding-left: 0.7em;">
                                                                                <div class="checkbox-wrapper-51">
                                                                                    <label
                                                                                        for="cbx-status-{{ $status->id }}"
                                                                                        class="checkbox-label">{{ $status->status }}</label>
                                                                                    <input
                                                                                        {{ optional($status->allowedEmails)->allowed == 1 ? 'checked' : '' }}
                                                                                        onclick="allow_email(this,'{{ $status->id }}')"
                                                                                        type="checkbox"
                                                                                        id="cbx-status-{{ $status->id }}"
                                                                                        class="checkbox-item-{{ str_replace(' ', '-', strtolower(trim($category->name))) }}" />
                                                                                    <label
                                                                                        for="cbx-status-{{ $status->id }}"
                                                                                        class="toggle">
                                                                                        <span>
                                                                                            <svg width="10px"
                                                                                                height="10px"
                                                                                                viewBox="0 0 10 10">
                                                                                                <path
                                                                                                    d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z">
                                                                                                </path>
                                                                                            </svg>
                                                                                        </span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            @endforeach
                                                        @endforeach
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
    </div>
    @include('includes.footer')
    <script>
        $(document).on('click', '.btn-outline-dark-2x.btn-lg', function(e) {
            e.preventDefault();
            $('.btn-outline-dark-2x.btn-lg').removeClass('active')
            $(this).addClass('active')
            var statusId = $(this).data('category');

            if (statusId != '') {
                $('#status_row').show();
                $('.statuses-filter').hide();
                $(`div[data-service-cat='${statusId}']`).each(function() {
                    $(this).show();
                });
            } else {
                $('#status_row').hide();
            }
        });

        function allow_email(obj, status_id) {
            var status_id = status_id;
            var checked = 2;
            if ($(obj).is(':checked')) {
                var checked = 1;
            }
            $.ajax({
                url: '{{ route('allow_email') }}',
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
