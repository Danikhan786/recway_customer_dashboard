@include('includes.head')
<style>
</style>
@php
    $document = 0;
    $InvoiceRecipient = getTranslatedText('invoice_recipent');
    $InvoiceReference = getTranslatedText('reference');
    $InvoiceComment = getTranslatedText('invoice_comment');
    if (!empty($form_builder)) {
        $form = json_decode($form_builder['form'])->form_builder;
        if (!empty($form->personal_info)) {
            foreach ($form->personal_info as $p_k => $p_v) {
                $real_dta = explode(',', $p_k);
                $name = isset($real_dta[2]) ? $real_dta[2] : '';
                if ($name == 'documnet_file') {
                    $document = 1;
                }
            }
        }
        if (!empty($form->billing_info)) {
            foreach ($form->billing_info as $b_k => $b_v) {
                $real_dta = explode(',', $b_k);
                $label = isset($real_dta[1]) ? $real_dta[1] : '';
                $name = isset($real_dta[2]) ? $real_dta[2] : '';
                if ($name == 'pref') {
                    $InvoiceRecipient = $label;
                }
                if ($name == 'ref') {
                    $InvoiceReference = $label;
                }
                if ($name == 'comment') {
                    $InvoiceComment = $label;
                }
            }
        }
    } else {
        $document = 1;
    }
    if (!empty(Auth::user()->interview_template)) {
        $document = 1;
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
                            <h2>{{getTranslatedText('order_id')}}: {{$candidate->order_id }}</h2>
                        </div>
                        <div class="col-sm-6 col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i
                                            class="iconly-Home icli svg-color"></i></a></li>
                                            <li class="breadcrumb-item">{{getTranslatedText('recway')}}</li>
                                            <li class="breadcrumb-item active">{{getTranslatedText('View Order')}}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row project-cards">
                    <div class="col-md-9">
                        <div class="card">
                            @if (session('success'))
                                <button class="btn btn-secondary sweet-13" type="button"
                                    onclick="_gaq.push(['_trackEvent', 'example', 'try', 'sweet-13']);"
                                    style="display:none">Alert</button>
                            @endif
                            <div class="card-body">
                                <div class="row shopping-wizard">
                                    <div class="col-12">
                                        <div class="row shipping-form g-3">
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="nav nav-pills horizontal-options shipping-options"
                                                            id="cart-options-tab" role="tablist"
                                                            aria-orientation="vertical">
                                                            <a class="nav-link active" id="wizard-contact-tab"
                                                                data-bs-toggle="pill" href="#wizard-contact" role="tab"
                                                                aria-controls="wizard-contact" aria-selected="true">
                                                                <div class="cart-options">
                                                                    <div class="stroke-icon-wizard"><i
                                                                            class="fa-solid fa-user"></i></div>
                                                                    <div class="cart-options-content">
                                                                        <h6 class="f-w-700">{{getTranslatedText('candidate_info')}}</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            @if (!empty($document))
                                                                <a class="nav-link" id="wizard-cart-tab"
                                                                    data-bs-toggle="pill" href="#wizard-cart" role="tab"
                                                                    aria-controls="wizard-cart" aria-selected="false"
                                                                    tabindex="-1">
                                                                    <div class="cart-options">
                                                                        <div class="stroke-icon-wizard"><i
                                                                                class="fa-solid fa-paperclip"></i></div>
                                                                        <div class="cart-options-content">
                                                                            <h6 class="f-w-700">{{getTranslatedText('attachment')}}</h6>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            @endif
                                                            <a class="nav-link" id="wizard-banking-tab"
                                                            data-bs-toggle="pill" href="#wizard-banking" role="tab"
                                                            aria-controls="wizard-banking" aria-selected="false"
                                                            tabindex="-1">
                                                            <div class="cart-options">
                                                                    <div class="stroke-icon-wizard"><i
                                                                    class="fa-solid fa-money-bill"></i></div>
                                                                    <div class="cart-options-content">
                                                                        <h6 class="f-w-700">{{getTranslatedText('billing_details')}}</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            <a class="nav-link" id="additional-note-tab"
                                                            data-bs-toggle="pill" href="#additional-note" role="tab"
                                                            aria-controls="additional-note" aria-selected="false"
                                                            tabindex="-1">
                                                            <div class="cart-options">
                                                                <div class="stroke-icon-wizard"><i
                                                                class="fa-solid fa-square-check"></i></div>
                                                                <div class="cart-options-content">
                                                                    <h6 class="f-w-700">{{getTranslatedText('additional_note')}}</h6>
                                                                </div>
                                                            </div>
                                                        </a>
@if (
  (!empty($candidate->report) || !empty($candidate->interview_report)) &&
  (
    (isset($company_manager) && !empty($company_manager) && !empty($can_view_report)) ||
    (!empty($can_view_report))
  )
)
                                                            <a class="nav-link" id="result-cart-tab"
                                                                data-bs-toggle="pill" href="#result-cart" role="tab"
                                                                aria-controls="result-cart" aria-selected="false"
                                                                tabindex="-1">
                                                                <div class="cart-options">
                                                                    <div class="stroke-icon-wizard"><i
                                                                            class="fa-solid fa-paperclip"></i></div>
                                                                    <div class="cart-options-content">
                                                                        <h6 class="f-w-700">{{getTranslatedText('Result')}}</h6>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="vertical-main-wizard mt-5">
                                    <div class="row g-3">
                                        <div class="col-xxl-12 col-md-12 col-xl-12 col-12" style="min-height:18rem">
                                            <div class="tab-content" id="wizard-tabContent">
                                                <div class="tab-pane fade show active" id="wizard-contact"
                                                    role="tabpanel" aria-labelledby="wizard-contact-tab">
                                                    <form
                                                        class="row g-3 needs-validation custom-input validation-vertical-wizard"
                                                        novalidate="">
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('order_id')}}</b>:</h6>
                                                            <span>{{$candidate->order_id }}</span>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('status')}}</b>:</h6>
                                                            <span class="badge badge-pill" style="background-color:<?= $candidate->status_color ?>">{{ $candidate->status_title }}</span>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('Candidate Name')}}</b></h6>
                                                            <span>{{$candidate->name . " ". $candidate->surname}}</span>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('Candidate Email')}}</b></h6>
                                                            <span>{{$candidate->email }}</span>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('Security Number')}}</b></h6>
                                                            <span>{{$candidate->security }}</span>
                                                        </div>
                                                        @if (!empty($candidate->vasc_id))
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('VASC ID')}}</b></h6>
                                                            <span>{{ $candidate->vasc_id }}</span>
                                                        </div>
                                                        @endif
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('service_type')}}</b></h6>
                                                            <span>{{ $candidate->interview_title }}</span>
                                                        </div>
                                                        @if(!empty($candidate->booked))
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('interview_date')}}</b></h6>
                                                            <span>{{ $candidate->booked }}</span>
                                                        </div>
                                                        @endif
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('phone')}}</b></h6>
                                                            <span>{{ $candidate->phone ?? 'Null' }}</span>
                                                        </div>
                                                        @if (!empty($candidate->place))
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('place')}}</b></h6>
                                                            <span>{{$candidate->place_name }}</span>
                                                        </div>
                                                        @endif
                                                        @if (!empty($candidate->country))
                                                        <div class="col-md-6 col-sm-12 mb-3">
                                                            <h6><b>{{getTranslatedText('country')}}</b></h6>
                                                            <span>{{ $candidate->country }}</span>
                                                        </div>
                                                        @endif
                                                        @if(isset($candidate->meta_data) && !empty($candidate->meta_data))
                                                                                                                @php
                                                                                                                    $can_meta_data = json_decode($candidate->meta_data);
                                                                                                                @endphp
                                                                                                                @foreach($can_meta_data as $m_key => $m_value)
                                                                                                                    <div class="col-md-6 col-sm-12 mb-3">
                                                                                                                        <h6><b>{{ $m_key }}</b></h6>
                                                                                                                        <span>{{ $m_value }}</span>
                                                                                                                    </div>
                                                                                                                @endforeach
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-content" id="wizard-cartContent">
                                                <div class="tab-pane fade" id="wizard-cart" role="tabpanel"
                                                    aria-labelledby="wizard-cart-tab">
                                                    <form
                                                        class="row g-3 needs-validation custom-input validation-vertical-wizard"
                                                        novalidate="">
                                                        @if (!empty($candidate->cv) || !empty($candidate->report) || !empty($candidate->interview_template))
                                                                                                            @if (!empty($candidate->cv))
                                                                                                                                                                <div class="col-md-12 col-sm-12 mb-3 mt-3">
                                                                                                                                                                    <h6><b>{{getTranslatedText('document_cv')}}</b></h6>
                                                                                                                                                                    @php
                                                                                                                                                                        $documents = explode(',', $candidate->cv);
                                                                                                                                                                    @endphp
                                                                                                                                                                    @foreach ($documents as $document)
                                                                                                                                                                        @if (!empty($document))
                                                                                                                                                                            <span
                                                                                                                                                                                style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                                                                                                                                                                                <a target="_blank" href="{{ asset($document) }}"
                                                                                                                                                                                    style="cursor: pointer"
                                                                                                                                                                                    class="text-success open-doc">
                                                                                                                                                                                    <b>{{ $document }}</b>
                                                                                                                                                                                </a>
                                                                                                                                                                            </span><br>
                                                                                                                                                                        @endif
                                                                                                                                                                    @endforeach
                                                                                                                                                                </div>
                                                                                                            @endif

                                                                                                            @if (!empty($candidate->report))
                                                                                                                <div class="col-md-12 col-sm-12 mb-3 mt-3">
                                                                                                                    <h6><b>{{getTranslatedText('Background Check Report')}}</b></h6>
                                                                                                                    <span
                                                                                                                        style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                                                                                                                        <a target="_blank"
                                                                                                                            href="{{ asset($candidate->report) }}"
                                                                                                                            style="cursor: pointer"
                                                                                                                            class="text-success open-doc">
                                                                                                                            <b>{{ $candidate->report }}</b>
                                                                                                                        </a>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            @endif

                                                                                                            @if (!empty($candidate->interview_template))
                                                                                                                <div class="col-md-12 col-sm-12 mb-3 mt-3">
                                                                                                                    <h6><b>{{getTranslatedText('interview_template')}}</b></h6>
                                                                                                                    <span
                                                                                                                        style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                                                                                                                        <a target="_blank"
                                                                                                                            href="{{ asset($candidate->interview_template) }}"
                                                                                                                            style="cursor: pointer"
                                                                                                                            class="text-success open-doc">
                                                                                                                            <b>{{ $candidate->interview_template }}</b>
                                                                                                                        </a>
                                                                                                                    </span>
                                                                                                                </div>
                                                                                                            @endif
                                                        @else
                                                            <h5 style="text-align:center; margin-top:5rem">{{getTranslatedText('no_attachments_found')}}</h5>
                                                        @endif

                                                    </form>
                                                </div>
                                            </div>
@if (!empty($candidate->report) ||
  (!empty($candidate->interview_report)) &&
  (
    (isset($company_manager) && !empty($company_manager) && !empty($can_view_report)) ||
    (!empty($can_view_report))
  )
)
                                                <div class="tab-content" id="wizard-cartContent">
                                                    <div class="tab-pane fade" id="result-cart" role="tabpanel"
                                                        aria-labelledby="wizard-cart-tab">
                                                        <form
                                                            class="row g-3 needs-validation custom-input validation-vertical-wizard"
                                                            novalidate="">


                                                            <div class="col-md-12 col-sm-12 mb-3 mt-3">
                                                                <h6><b>{{getTranslatedText('Background Check Report')}}</b></h6>
                                                                <span
                                                                    style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis">
                                                                    <a target="_blank"
                                                                        href="{{ asset($candidate->report) }}"
                                                                        style="cursor: pointer"
                                                                        class="text-success open-doc">
                                                                        <b>{{ $candidate->report }}</b>
                                                                    </a>
                                                                </span>
                                                            </div>
@if (
  (!empty($candidate->interview_report)) &&
  (
    (isset($company_manager) && !empty($company_manager) && !empty($can_view_report)) ||
    (!empty($can_view_report))
  )
)
                                                                <div class="col-md-12 col-sm-12 mb-3 mt-3">
                                                                    <h6><b>{{getTranslatedText('interview_report')}}</b></h6>
                                                                                @php
                        $decodedReport = json_decode($candidate->interview_report, true);
                        $reports = [];
                        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedReport)) {
                            $reports = $decodedReport;
                        } else {
                            $reports = ['spi' => $candidate->interview_report];
                        }
                    @endphp
                                                                <div class="col-md-12 col-sm-12 mb-3 mt-3">
                                                                    <h6><b>{{getTranslatedText('interview_report')}}</b></h6>
                                                                                            @foreach ($reports as $key => $file)
                            <span style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis; display: block;">
                                <a target="_blank"
                                   href="http://customer.recway.se/security-report-uploads/{{ $file }}"
                                   style="cursor: pointer"
                                   class="text-success open-doc">
                                    <b>{{ $candidate->order_id }}.interview_report</b>
                                </a>
                            </span>
                        @endforeach
                                                                </div>
                                                                </div>
                                                            @endif

                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="tab-content" id="wizard-bankingContent">
                                                <div class="tab-pane fade" id="wizard-banking" role="tabpanel"
                                                    aria-labelledby="wizard-banking-tab">
                                                    <form
                                                        class="row g-3 mb-3 needs-validation custom-input vartical-validation validation-vertical-wizard"
                                                        novalidate="">
                                                        <div class="col-md-12 col-sm-12 mb-3  mt-3">
                                                            <h6><b>{{ $InvoiceRecipient }}</b></h6>
                                                            <span>{{ $candidate->referensperson ?? 'Null' }}</span>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 mb-3">
                                                            <h6><b>{{ $InvoiceReference }}</b></h6>
                                                            <span>{{ $candidate->reference ?? 'Null' }}</span>
                                                        </div>

                                                        <div class="col-md-12 col-sm-12 mb-3">
                                                            <h6><b>{{ $InvoiceComment }}</b></h6>
                                                            <span>
                                                                @if (!empty($candidate->comment))
                                                                    {{$candidate->comment}}
                                                                @else
                                                                    Null
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="tab-content" id="additional-noteContent">
                                                <div class="tab-pane fade" id="additional-note" role="tabpanel"
                                                    aria-labelledby="additional-note-tab">
                                                    <form
                                                        class="row g-3 mb-3 needs-validation custom-input vartical-validation validation-vertical-wizard"
                                                        novalidate="">
                                                        <div class="col-md-12 col-sm-12 mb-3 mt-3">
                                                            <h6><b>{{getTranslatedText('Only visiable to you and us ')}}</b></h6>
                                                            <span>
                                                                @if (!empty($candidate->note))
                                                                    {{$candidate->note}}
                                                                @else
                                                                    Null
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($candidate->status != 9 && $candidate->status != 40)
                                @if (isset($company_manager) && !empty($company_manager) && ($candidate->status == 6 || $candidate->status == 47 || $candidate->status == 39))
                                        <div class="col-12 mt-3" style="text-align:right">
                                            <div class="row">
                                                <div class="col-4">
                                                    <a href="{{ route('editOrder', ['id' => $candidate->id]) }}"
                                                        class="btn btn-secondary w-100">
                                                        <i class="icon-pencil-alt"></i>
                                                        {{getTranslatedText('Edit Order')}}
                                                    </a>
                                                </div>
                                                <div class="col-4">
                                                    <button type="button" class="btn btn-info w-100" data-bs-placement="top"
                                                        data-bs-toggle="modal" data-bs-target="#changeStatus">
                                                        <i class="fas fa-edit"></i>
                                                        {{getTranslatedText('Change Status')}}
                                                    </button>
                                                </div>
                                                <div class="col-4">
                                                    <button type="button" class="btn btn-danger w-100" data-bs-placement="top"
                                                        data-bs-toggle="modal" data-bs-target="#delete">
                                                        <i class="icon-trash"></i>
                                                        {{getTranslatedText('Cancel Order')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12 mt-3" style="text-align:right">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a href="{{ route('editOrder', ['id' => $candidate->id]) }}"
                                                        class="btn btn-secondary w-100">
                                                        <i class="icon-pencil-alt"></i>
                                                        {{getTranslatedText('Edit Order')}}
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger w-100" data-bs-placement="top"
                                                        data-bs-toggle="modal" data-bs-target="#delete">
                                                        <i class="icon-trash"></i>
                                                        {{getTranslatedText('Cancel Order')}}
                                                    </button>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body" style="padding-left: 5px;">
                                <div class="vertical-main-wizard">
                                    <div class="row g-3 ">
                                        <div class="col-xxl-12 col-xl-12 col-12 notification"
                                            style="padding-left: 20px;margin-bottom: 10px">
                                            <h3 style="padding-left: 10px;margin-bottom: 20px;">{{getTranslatedText('order_logs')}}</h3>
                                            <ul>
                                                @if (!empty($history))
                                                    @foreach ($history as $h)
                                                        @if(strtotime($h->date_time) < time())
                                                            <li class="d-flex">
                                                                <div class="activity-dot-danger"></div>
                                                                <div class="w-100 ms-3">
                                                                    <p class="d-flex justify-content-between mb-2"><span
                                                                            class="date-content bg-light-dark">{{ \Carbon\Carbon::parse($h->date_time)->format('jS M, Y') }}
                                                                        </span><span>{{ \Carbon\Carbon::parse($h->date_time)->format('h:i:s') }}</span>
                                                                    </p>
                                                                    <h6 class="f-w-600">{{ $h->desc }}</h6>
                                                                    <p class="f-m-light">
                                                                        {!! !empty($h->comment) ? 'Comment: ' . $h->comment : '' !!}
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <li>
                                                        <div class="time">{{getTranslatedText('no_record_found')}}</div>
                                                    </li>
                                                @endif
                                            </ul>
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
    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h5 class="modal-title f-16 w-600 text-black" id="deleteLabel">{{getTranslatedText('Cancel Order')}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding-bottom: 0px;">
                        <form action="{{ route('cancel_order') }}" method="post">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="">{{getTranslatedText('Comment (Add a reason to cancel this order)')}}</label>
                                    <input type="text" name="comment" class="form-control" placeholder="Enter Comment">
                                    <input type="hidden" name="id" value="{{$candidate->id}}">
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{getTranslatedText('Close')}}</button>
                            <button type="submit" class="btn btn-danger">         {{getTranslatedText('Cancel Order')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Container-fluid starts  -->
            </div>
        </div>
        <div class="modal fade" id="changeStatus" tabindex="-1" aria-labelledby="changeStatusLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title f-16 w-600 text-black" id="changeStatusLabel">{{getTranslatedText('Change Status')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-bottom: 0px;">
                    <form action="{{ route('change_status') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="">{{getTranslatedText('Select Status')}}</label>
                                <select name="status" class="form-control">
                                    <option value="">{{getTranslatedText('choose_status')}}</option>
                                    @if($candidate->status == 39)
                                    <option value="37" data-status-variable="Approved_followup">Approved</option>
                                    <option value="42" data-status-variable="Denied_followup">Denied</option>
                                    @else
                                    <option value="4" data-status-variable="approved">Approved</option>
                                    <option value="7" data-status-variable="denied">Denied</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">{{getTranslatedText('comment')}}</label>
                                <textarea name="comment" class="form-control" placeholder="{{getTranslatedText('enter_comment')}}"></textarea>
                                <input type="hidden" name="id" value="{{$candidate->id}}">
                                <input type="date" id="date" style="display: none;">
                            </div>
                        </div>
                        <div class="modal-footer pr-0 pl-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{getTranslatedText('Close')}}</button>
                            <button type="button" class="btn btn-info"
                            id="submit-btn"
                            onclick="submitPDF(event,this)">{{getTranslatedText('Change Status')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Container-fluid starts  -->
        </div>
    </div>

    @include('includes.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.5.28/dist/jspdf.plugin.autotable.js"></script>
    <script>
        let candidate = @json($candidate) || [];
        let customer = @json($customer) || [];
        let staff = @json($candidate->staff) || [];
        customer = Array.isArray(customer) && customer.length > 0 ? customer[0] : {};
        $(document).ready(function () {
            if (window.jspdf && window.jspdf.jsPDF) {
                window.jsPDF = window.jspdf.jsPDF;
            } else {
                console.error("jsPDF is NOT loaded.");
            }
        })
        function submitPDF(event, obj) {
            event.preventDefault();
            var statusVariable = $('select[name="status"]').find("option:selected").data("status-variable")
            if ((statusVariable === "approved" || statusVariable === "denied") && customer.send_security_report == 1) {
                $(".city_row").show();
                if (statusVariable === "approved") {
                    // $(".reason-col").remove()
                }
                check_field()
            }else{
                $(".city_row").hide();
                
            }
            if (typeof jsPDF === "undefined") {
                console.error("jsPDF is undefined. Make sure the library is loaded.");
                return;
            }

            // Create new jsPdf instance
            const doc = new jsPDF()
            var x = 10;
            var y = 5;
            var leftMargin = 10;
            var rightMargin = 10;
            var statusVariable = $("select[name=status]").find("option:selected").data("status-variable")

            const addHeader = function () {
                y = 5
                doc.addImage("../assets/images/vattenfall.png", 'PNG', (doc.internal.pageSize.width / 2) - 25, y, 50, 8)
            }

            // Define footer function
            const addFooter = function () {
                doc.setTextColor("#9298A0")
                doc.setFontSize(8)
                const date = new Date();
                const options = {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                };
                const formattedDate = date.toLocaleDateString('en-US', options);
                doc.text(formattedDate, leftMargin, doc.internal.pageSize.height - 5)

                doc.text("Confidentiality class: C3 - Restricted", doc.internal.pageSize.width - 56, doc.internal.pageSize.height - 10)
                doc.text("(after completion of the form)", doc.internal.pageSize.width - 56, doc.internal.pageSize.height - 5)
            }

            const addTable = function (caption, table) {
                doc.setFontSize(12);
                doc.setFont("Helvetica", "Bold");
                doc.text(caption, leftMargin, y)

                y += 3
                var data = [];
                table.forEach(function (row) {
                    data.push({
                        key: row[0],
                        value: row[1]
                    })
                })

                doc.autoTable({
                    startY: y,
                    margin: {
                        top: 25,
                        bottom: 25
                    },
                    head: [{
                        key: 'Key',
                        value: 'Value'
                    }],
                    body: data,
                    showHead: false,
                    theme: 'grid',
                    // pageBreak: 'avoid',
                    columnStyles: {
                        key: {
                            textColor: 0,
                            fontStyle: 'bold',
                            cellWidth: 90,
                            fillColor: '#DBE5F1'
                        },
                    },
                    didParseCell: function (data) {

                    }
                })
            }

            // Function to draw a checkmark symbol
            function drawCheckmark(doc, x, y) {
                var tickSize = 2; // Size of the tick lines
                doc.setLineWidth(0.5); // Set line width for tick lines
                doc.setDrawColor(0, 0, 0)
                doc.line(x, y, x + tickSize, y + tickSize); // Draw the first tick line
                doc.line(x - 0.2 + tickSize, y - 0.2 + tickSize, x + tickSize * 2, y - tickSize); // Draw the second tick line
            }

            const addTable2 = function (table) {
                y += 3;
                var data = [];
                table.forEach(function (row, index) {
                    const rowData = {
                        key: row[0],
                        col1: row[1],
                        col2: row[2],
                        col3: row[3]
                    };

                    if (index > 2) {
                        rowData.key = {
                            content: rowData.key,
                            colSpan: 2
                        };
                        delete rowData.col1;
                    }

                    data.push(rowData);
                });

                doc.autoTable({
                    startY: y,
                    margin: {
                        top: 25,
                        bottom: 25
                    },
                    head: [{
                        key: 'Key',
                        col1: 'Col1',
                        col2: 'Col2',
                        col3: 'Col3'
                    }],
                    body: data,
                    showHead: false,
                    theme: 'grid',
                    // pageBreak: 'avoid',
                    columnStyles: {
                        key: {
                            textColor: 0,
                            fontStyle: 'bold',
                            cellWidth: 90,
                            fillColor: '#DBE5F1'
                        },
                        col2: {
                            textColor: '#000000'
                        }
                    },
                    didParseCell: function (data) {
                        if (data.row.index > 2 && data.column.index === 1) {
                            data.cell.colSpan = 2;
                        }
                    },
                    didDrawCell: function (data) {
                        if (data.cell.section === "body" && data.column.index === 2 && data.row.index > 2) {
                            var cellWidth = data.cell.width;
                            var cellHeight = data.cell.height;
                            var cellX = data.cell.x;
                            var cellY = data.cell.y;

                            var tickX = cellX + (cellWidth / 2) - 2.5; // Calculate the position of the tick symbol
                            var tickY = cellY + (cellHeight / 2) - 2.5;
                            tickY += 2.5

                            drawCheckmark(doc, tickX, tickY); // Draw the checkmark symbol
                        }
                    }
                });
            }

            const addTable3 = function (table, status) {
                y += 3
                var data = [];
                table.forEach(function (row) {
                    data.push({
                        key: row[0],
                        value: row[1]
                    })
                })

                doc.autoTable({
                    startY: y,
                    margin: {
                        top: 25,
                        bottom: 25
                    },
                    head: [{
                        key: 'Key',
                        col1: 'Col1',
                        col2: "Col2"
                    }],
                    body: data,
                    showHead: false,
                    theme: 'grid',
                    // pageBreak: 'avoid',
                    columnStyles: {
                        key: {
                            textColor: 0,
                            fontStyle: 'bold',
                            cellWidth: 120,
                            fillColor: '#DBE5F1'
                        },
                    },
                    didDrawCell: function (data) {
                        if (data.cell.section === "body" && data.column.index === 2 && status === "denied") {
                            var cellWidth = data.cell.width;
                            var cellHeight = data.cell.height;
                            var cellX = data.cell.x;
                            var cellY = data.cell.y;

                            var tickX = cellX + (cellWidth / 2) - 2.5; // Calculate the position of the tick symbol
                            var tickY = cellY + (cellHeight / 2) - 2.5;
                            tickY += 2.5

                            drawCheckmark(doc, tickX, tickY); // Draw the checkmark symbol
                        }

                        if (data.cell.section === "body" && data.column.index === 1 && status === "approved") {
                            var cellWidth = data.cell.width;
                            var cellHeight = data.cell.height;
                            var cellX = data.cell.x;
                            var cellY = data.cell.y;

                            var tickX = cellX + (cellWidth / 2) - 2.5; // Calculate the position of the tick symbol
                            var tickY = cellY + (cellHeight / 2) - 2.5;
                            tickY += 2.5

                            drawCheckmark(doc, tickX, tickY); // Draw the checkmark symbol
                        }
                    }
                })
            }

            function getTextWidth(text, fontSize) {
                // Text width in mm
                return (doc.getStringUnitWidth(text) * fontSize) / (72 / 25.6)
            }

            function pxToMm(px) {
                return px * 25.4 / 72;
            }

            // Add first page with header
            addHeader()
            addFooter()

            // Report Data
            y += 20;
            doc.setFontSize(14)
            doc.setTextColor("#000000")
            doc.setFont("Helvetica", 'Bold')
            doc.text("Result of the basic investigation", leftMargin, y)

            y += 10;
            doc.setFontSize(12)
            doc.setFont("Helvetica", '')
            var para = `Denna blankett ska användas vid återrapportering efter genomförd grundutredning.
        Med grundutredning enligt 3 kap. 3 § säkerhetsskyddslagen (2018:585) avses en utredning om personliga förhållanden av betydelse för säkerhetsprövningen. Utredningen ska omfatta betyg, intyg, referenser och uppgifter som den som prövningen gäller har lämnat samt andra uppgifter i den utsträckning det är relevant för prövningen. De detaljerade kraven återfinns i Vattenfalls kravspecifikation för Säkerhetsprövning.`;
            doc.text(para, leftMargin, y, {
                maxWidth: doc.internal.pageSize.width - (leftMargin * 2),
                align: 'left'
            })

            y += 33;
            para = `This form must be used when reporting back after a basic investigation has been completed.
        With basic investigation according to ch. 3 Section 3 of the Swedish Protective Security Act (2018:585) refers to an investigation into personal circumstances of importance for the security vetting. The investigation shall include grades, certificates, references and information provided by the person to whom the examination applies, as well as other information to the extent that it is relevant to the examination. The detailed requirements can be found in Vattenfall's requirements specification for Security Vetting.`;
            doc.text(para, leftMargin, y, {
                maxWidth: doc.internal.pageSize.width - (leftMargin * 2),
                align: 'left'
            })
            // Generate Table
            y += 35
            const table = [];
            var caption = "Beställare av säkerhetsprövningen (på Vattenfall)";
            table.push(["Namn & användarnamn / Name & User-ID", customer.name])
            table.push(["E-post / E-mail", customer.email])
            table.push(["Företag / Company", customer.company])
            addTable(caption, table)
            y += 28
            table.length = 0
            caption = "Bakgrundskontroll genomförd av / Basic investigation conducted by"
            table.push(["Namn / Name", "Staff at Recway AB"])
            table.push(["Telefonnummer / Telephone number", "08-551 063 97"])
            table.push(["E-post / E-mail", "info@recway.se"])
            table.push(["Företag / Company", "Recway AB"])
            addTable(caption, table)

            y += 37
            table.length = 0
            caption = "Intervjuarens uppgifter / Information about the interviewer"
            table.push(["Namn / Name", staff.name])
            table.push(["Telefonnummer / Telephone number", staff.phone])
            table.push(["E-post / E-mail", staff.email])
            table.push(["Företag / Company", "Recway AB"])
            addTable(caption, table)

            y += 37
            table.length = 0
            caption = "Kandidatens uppgifter / Information about the vetted candidate"
            table.push(["Namn / Name", candidate.name + " " + candidate.surname])
            table.push(["Personnummer (ååmmdd-xxxx) Birth date (yymmdd-xxxx)", candidate.security])
            table.push(["VASC-ID", candidate.vasc_id])
            addTable(caption, table)

            y += 35
            doc.setDrawColor(0, 0, 0)
            // doc.setFillColor(0,0,0)
            doc.rect(leftMargin, y, doc.internal.pageSize.width - (leftMargin * 2), 25)
            para = `Svaren i personbedömningen vidimeras genom undertecknande på sida två.
Formuläret skickas via mail till: securityvetting@vattenfall.com
The answers in the vetting is authenticated by signing the form on page two.
The form sends by e-mail to: securityvetting@vattenfall.com`;
            doc.setFontSize(12)
            doc.setFont("Helvetica", "")
            doc.text(para, leftMargin + 5, y + 7, {
                maxWidth: doc.internal.pageSize.width - (leftMargin * 2),
                align: 'left'
            })

            doc.addPage()
            addHeader()
            addFooter()

            y += 20;
            doc.setFontSize(14)
            doc.setTextColor("#000000")
            doc.setFont("Helvetica", 'Bold')
            doc.text("Result of the basic investigation", leftMargin, y)

            y += 7;
            doc.setFontSize(12)
            doc.setFont("Helvetica", '')
            var para = `Markera vilka bakgrundskontroller som genomförts. Detaljer om respektive kontroll finns i Vattenfalls kravspecifikation för säkerhetsprövning. Resultatet ska överlämnas till Vattenfall separat.
Select which of the background screening activities that have been performed. Details about the respective controls can be found in the Specification of requirements for Security Vetting. The results of the screening shall be handed over to Vattenfall separately.
`;
            doc.text(para, leftMargin, y, {
                maxWidth: doc.internal.pageSize.width - (leftMargin * 2),
                align: 'left'
            })

            y += 26
            doc.setFontSize(8)
            doc.text("Not Applicable*", doc.internal.pageSize.width / 2, y)
            doc.setFontSize(8)
            doc.text("Ja/Yes", (doc.internal.pageSize.width / 2) + 31, y)
            doc.setFontSize(8)
            doc.text("Nej/No", (doc.internal.pageSize.width / 2) + 61, y)

            table.length = 0
            table.push([`Kontroll av CV (Curriculum Vitae)*
Verification of Resumé/CV`, "", "", ""])
            table.push([`Kontroll av referenser*
Verification of references/employer check`, "", "", ""])
            table.push([`Kontroll av betyg, intyg och diplom*
Verification of education, grades and diplomas`, "", "", ""])
            table.push([`Kreditupplysning (säkerhetsklass 2)
Credit check (security class 2-positions)`, "", "", ""])
            table.push([`Kontroll mot Kronofogden
Verification against the Enforcement authority / The Bailiff check`, "", "", ""])
            table.push([`Kontroll av folkbokföring
Verification of civil registration`, "", "", ""])
            table.push([`Kontroll av exponering på sociala medier
Verification of exposure on social medias`, "", "", ""])
            table.push([`Kontroll av öppna källor
Verification of open sources`, "", "", ""])
            table.push([`Kontroll av bolagsaktiviteter samt föreningsaktiviteter
Verification of corporate and associated activities`, "", "", ""])
            table.push([`Kontroll av rättsliga processer och historiska/pågående domar
Verification of legal processes and historical/ongoing judgements`, "", "", ""])
            addTable2(table)

            y = doc.lastAutoTable.finalY + 5;
            doc.setFontSize(10)
            doc.setFont("Helvetica", "Bold")
            doc.text("Resultat av säkerhetsprövningsintervjun ", leftMargin + 5, y)
            doc.setFontSize(8)
            doc.setFont("Helvetica", "")
            doc.text("(markera med ett X)", leftMargin + 75, y)

            y += 5
            doc.setFontSize(10)
            doc.setFont("Helvetica", "Bold")
            doc.text("Result of the security vetting ", leftMargin + 5, y)
            doc.setFontSize(8)
            doc.setFont("Helvetica", "")
            doc.text("(mark with an X) ", leftMargin + 55, y)

            y += 2
            doc.setFontSize(8)
            doc.text("Ja/Yes", (doc.internal.pageSize.width / 2) + 30, y)
            doc.setFontSize(8)
            doc.text("Nej/No", (doc.internal.pageSize.width / 2) + 60, y)

            table.length = 0
            table.push([`Det finns en god personlig kännedom om den prövade
There is a god knowledge about the vetted person`, "", ""])
            table.push([`Individen kan antas vara lojal mot de intressen som ska skyddas av säkerhetsskyddslagen
The individual can be assumed to be loyal to the interests to be protected by the Swedish Protective Security Act`, "", ""])
            table.push([`Individen kan i övrigt anses pålitlig från säkerhetssynpunkt.
The individual can otherwise be considered reliable from a security point of view.`, "", ""])
            addTable3(table, statusVariable)

            y = doc.lastAutoTable.finalY + 2;
            doc.rect(leftMargin, y, doc.internal.pageSize.width - (leftMargin * 2), 15)
            para = $("#reason").val()
            doc.text("Om ”nej” ovan, ange anledning / If ”no” above, state reason: ", leftMargin + 2, y + 4)
            doc.line(leftMargin + 2, y + 5, leftMargin + 76, y + 5)
            doc.text(para ? para : "", leftMargin + 2, y + 8, {
                maxWidth: doc.internal.pageSize.width - (leftMargin * 2)
            })

            y += 19
            doc.text(`Datum för bakgrundskontroll /
Date for the background check`, leftMargin, y)
            var bcd = candidate.background_check_date
            var date = new Date(bcd);
            var options = {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            var formattedDate = date.toLocaleDateString('en-US', options);
            doc.setFont("Helvetica", "Bold")
            doc.text(bcd ? formattedDate : "N/A", leftMargin, y + 6)

            y += 10
            doc.setFont("Helvetica", "")
            var interview_date = candidate.booked
            date = new Date(interview_date)
            options = {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            formattedDate = date.toLocaleDateString('en-US', options);
            doc.text(`Datum för intervjun / Date for the interview`, leftMargin, y)
            doc.setFont("Helvetica", "Bold")
            doc.text(interview_date ? formattedDate : "N/A", leftMargin, y + 3)

            y -= 10
            doc.text(`Vidimering av genomförd grundutredning`, doc.internal.pageSize.width - 65, y)
            doc.setFont("Helvetica", "")
            doc.text(`Ort / City : `, doc.internal.pageSize.width - 65, y + 3)
            doc.setFont("Helvetica", "Bold")
            var city = $("#city_report").val()
            doc.text(city ? city : "", doc.internal.pageSize.width - 51, y + 3)

            y += 3
            doc.setFont("Helvetica", "")
            var dateVal = $("#date").val()
            date = new Date(dateVal)
            options = {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            formattedDate = date.toLocaleDateString('en-US', options);
            doc.text(`Datum / Date : `, doc.internal.pageSize.width - 65, y + 3)
            doc.setFont("Helvetica", "Bold")
            doc.text(formattedDate, doc.internal.pageSize.width - 45, y + 3)

            y += 3
            doc.setFont("Helvetica", "")
            doc.text(`Signatur/ansvarig för genomförd
grundutredning : `, doc.internal.pageSize.width - 65, y + 3)
            doc.setFont("Helvetica", "Bold")
            doc.text(staff.name ? staff.name : "", doc.internal.pageSize.width - 43, y + 6.5)

            y += 12
            doc.setFontSize(8)
            doc.setFont("Helvetica", "")
            doc.text(`* Dessa kontroller utförs av Vattenfall i fall av nyrekryteringar. Vid konsult/entreprenörsuppdrag utförs de av leverantören själv.
   These controls are carried out by Vattenfall, in cases of recruitments. For consultants, they are carried out by the supplier itself.`, leftMargin, y)

            var blobPDF = new Blob([doc.output('blob')], {
                type: "application/pdf"
            })
            var blobURL = URL.createObjectURL(blobPDF)
            // window.open(blobURL);
            var formData = new FormData();
            formData.append('file', blobPDF, 'filename.pdf');
            formData.append('id', candidate.id);
            formData.append('filename', candidate.order_id);

            // Send the form data to the PHP script using AJAX
            $.ajax({
                url: "{{ route('upload_report') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $(obj).closest('form').submit()
                },
                error: function (xhr, status, error) {
                }
            });
        }
        document.addEventListener("DOMContentLoaded", function () {
            let today = new Date().toISOString().split('T')[0];
            document.getElementById("date").value = today;
        });
        function check_field() {
            var city = $('#city_report').val()
            if (city != '') {
                $('#submit-btn').attr('disabled', false)
                $('#city_text_msg').hide()
            } else {
                $('#submit-btn').attr('disabled', true)
                $('#city_text_msg').show()
            }
        }
        // }
    </script>
    <script>
        // function append_id(id) {
        //     $('input[name="id"]').val(id)
        // }
        (document.querySelector(".sweet-13").onclick = function () {
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
        $(document).ready(function () {
            @if(session('success'))
                $('.sweet-13').click();
            @endif
        })
    </script>