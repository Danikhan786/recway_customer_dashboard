<footer class="footer">
  <div class="container-fluid">
    <div class="row text-center">
      <div class="col-md-12 footer-copyright">
      <p class="mb-0">Copyright © <?php echo date('Y'); ?> | {{ __('messages.copyright') }}<strong>Recway AB</strong></p>
      </div>
    </div>
  </div>
</footer>
</div>
</div>

<script src="{{ asset('assets/js/vendors/jquery/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<!-- bootstrap js-->
<script src="{{ asset('assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}" defer=""></script>
<script src="{{ asset('assets/js/vendors/bootstrap/dist/js/popper.min.js') }}" defer=""></script>
<!--fontawesome-->
<script src="{{ asset('assets/js/vendors/font-awesome/fontawesome-min.js') }}"></script>
<!-- feather-->
<script src="{{ asset('assets/js/vendors/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/feather-icon/custom-script.js') }}"></script>
<!-- sidebar -->
<script src="{{ asset('assets/js/sidebar.js') }}"></script>
<!-- popover -->
<!-- <script src="{{ asset('assets/js/popover.js') }}"></script>jquery -->
<!-- height_equal-->
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<!-- config-->
<script src="{{ asset('assets/js/config.js') }}"></script>
<!-- apex-->
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
<!-- scrollbar-->
<!-- morrischart-->
<script src="{{ asset('assets/js/chart/morris-chart/raphael.js') }}"></script>
<script src="{{ asset('assets/js/chart/morris-chart/morris.js') }}"> </script>
<script src="{{ asset('assets/js/chart/morris-chart/prettify.min.js') }}"></script>
<!-- page_morrischart-->
<script src="{{ asset('assets/js/chart/morris-chart/morris-script.js') }}"></script>
<!-- Scrollbar -->
<script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
<!-- slick-->
<script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick/slick.js') }}"></script>
<!-- data_table-->
<script src="{{ asset('assets/js/js-datatables/datatables/jquery.dataTables.min.js') }}"></script>
<!-- page_datatable-->
<script src="{{ asset('assets/js/js-datatables/datatables/datatable.custom.js') }}"></script>
<!-- page_datatable1-->
<script src="{{ asset('assets/js/js-datatables/datatables/datatable.custom1.js') }}"></script>
<!-- page_datatable-->
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<!-- tilt-->
<script src="{{ asset('assets/js/animation/tilt/tilt.jquery.js') }}"></script>
<!-- page_tilt-->
<script src="{{ asset('assets/js/animation/tilt/tilt-custom.js') }}"></script>
<!-- custom script -->
<script src="{{ asset('assets/js/script.js') }}"></script>
<!-- Include Select2 JS -->
<script src="assets/js/dropzone/dropzone.js"></script>
<script src="assets/js/dropzone/dropzone-script.js"></script>
<!-- filepond -->
<script src="assets/js/filepond/filepond-plugin-image-preview.js"></script>
<script src="assets/js/filepond/filepond-plugin-file-rename.js"></script>
<script src="assets/js/filepond/filepond-plugin-image-transform.js"></script>
<script src="assets/js/filepond/filepond.js"></script>
<script src="assets/js/filepond/custom-filepond.js"></script>
<!-- dashboard-->
<script src="assets/js/dashboard/dashboard_2.js"></script>
<script src="assets/js/dashboard/dashboard_3.js"></script>
<script src="{{ asset('assets/js/sweetalert/sweetalert2.min.js') }}"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>


</body>

<script>
  @if(!empty(session('lang_pair')))
  var language = "{{ session('lang_pair') }}";
  @endif
  $(document).ready(function() {
    $('#interviewSelect').select2({
      allowClear: true,
      height: 'resolve' // This will inherit the width of the original select element
    });
    $('#placeSelect').select2({
      allowClear: true,
      height: 'resolve' // This will inherit the width of the original select element
    });
    $('#countrySelect').select2({
      allowClear: true,
      height: 'resolve' // This will inherit the width of the original select element
    });
    if (language) {
      doGTranslate(language)
    }
  });
  // Function to read cookies (optional, if needed)
  function readCookie(name) {
    var c = document.cookie.split('; '),
      cookies = {},
      i, C;

    for (i = c.length - 1; i >= 0; i--) {
      C = c[i].split('=');
      cookies[C[0]] = C[1];
    }
    return cookies[name];
  }

  // Initialize Google Translate
  function googleTranslateElementInit2() {
    new google.translate.TranslateElement({
      pageLanguage: 'en',
      autoDisplay: false
    }, 'google_translate_element2');
    $('#loader').hide();
  }

  function setLanguageInSession(lang_pair) {
    $.ajax({
      url: '/set-language',
      type: 'POST',
      data: {
        lang_pair: lang_pair,
        _token: '{{ csrf_token() }}' // Include CSRF token for Laravel
      },
      success: function(response) {},
      error: function(xhr) {
        console.log('Error saving language to session');
      }
    });
  }

  // Handle language change
  function doGTranslate(lang_pair) {
    if (lang_pair == 'en|sv') {
      $('.current_lang').find('h6').html('Swedish')
    } else {
      $('.current_lang').find('h6').html('English')
    }
    if (lang_pair.value) lang_pair = lang_pair.value;
    if (lang_pair == '') return;

    var lang = lang_pair.split('|')[1];
    var teCombo;
    var select = document.getElementsByClassName('goog-te-combo');

    for (var i = 0; i < select.length; i++) {
      if (select[i].className === 'goog-te-combo') {
        teCombo = select[i];
      }
    }

    if (document.getElementById('google_translate_element2') == null ||
      document.getElementById('google_translate_element2').innerHTML.length === 0 ||
      teCombo.length === 0 || teCombo.innerHTML.length === 0) {
      // setTimeout(function() {
      //   doGTranslate(lang_pair);
      // }, 1000);
    } else {
      teCombo.value = lang;
      teCombo.dispatchEvent(new Event('change'));
    }
    setLanguageInSession(lang_pair);
  }

  document.addEventListener('DOMContentLoaded', function() {
    var lang_en = document.querySelector('#lang-1-en');
    var lang_sv = document.querySelector('#lang-1-sv');

    lang_en.addEventListener('click', function() {
      doGTranslate('en|sv'); // Switch to Swedish
    });

    lang_sv.addEventListener('click', function() {
      doGTranslate('sv|en'); // Switch to English
    });
  });
  // document.addEventListener('DOMContentLoaded', function() {
  //   const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  //   const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
  // });
  document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-placement="top"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });
</script>

<script>
  document.addEventListener("contextmenu", function (e) {
    e.preventDefault();
  });

  document.addEventListener("keydown", function (e) {
    if (e.key === "F12") {
      e.preventDefault();
    }
    if (e.ctrlKey && e.shiftKey && ["I", "J", "C"].includes(e.key.toUpperCase())) {
      e.preventDefault();
    }

    if (e.ctrlKey && e.key.toUpperCase() === "U") {
      e.preventDefault();
    }
  });
</script>

</html>
