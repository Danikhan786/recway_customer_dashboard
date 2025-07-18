<!DOCTYPE html>
<html lang="en" style="--theme-default: #8b2b2d;--theme-secondary: #646464;">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Admiro admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities." />
  <meta name="keywords" content="admin template, Admiro admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app" />
  <meta name="author" content="pixelstrap" />
  <title>Recway | Customer Portal</title>
  <!-- Favicon icon-->
  <link rel="icon" href="{{ asset('assets/images/favicon/favicon.png') }}" type="image/x-icon">
  <!-- Google font-->

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet" />
  <!-- Flag icon css -->
  <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}" />
  <!-- iconly-icon-->
  <link rel="stylesheet" href="{{ asset('assets/css/iconly-icon.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/bulk-style.css') }}" />
  <!-- iconly-icon-->
  <link rel="stylesheet" href="{{ asset('assets//css/themify.css') }}" />
  <!--fontawesome-->
  <link rel="stylesheet" href="{{ asset('assets//css/fontawesome-min.css') }}" />
  <!-- Whether Icon css-->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/weather-icons/weather-icons.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/slick-theme.css') }}" />

  <!-- apex-->
  <!-- <script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script> -->
  <script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
  <!-- App css -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen" />
  <!-- Include Select2 CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<style>
  .light .custom-input .form-control {
    color: #212529 !important;
  }

  .select2-container .select2-selection--single {
    height: 30px;
    /* Match the height of your form controls */
    border: 1px solid #ced4da;
    /* Add consistent border styling */
    padding: 6px 12px;
    /* Adjust padding for better alignment */
    font-size: 14px;
    /* Ensure the font size matches other inputs */
  }

  /* Hide the Google Translate toolbar */
  body>.skiptranslate {
    display: none !important;
  }

  body {
    top: 0px !important;
    /* Ensure body positioning remains normal */
  }

  .goog-te-banner-frame {
    display: none !important;
    /* Hide the Google Translate banner */
  }

  body {
    top: 0px !important;
    /* Adjust body top position */
  }

  .order-logs-card {
    /* width: 65vh;
    min-height: 60vh;
    max-height: 90vh;
    position: absolute;
    right: 0px; */

    position: fixed;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 45vh;
    border: 1px solid #ddd;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 10;
    overflow-x: hidden;
    overflow-y: scroll;
    min-height: auto;
    max-height: 80vh;
    font-size: 1.9vh
  }
</style>