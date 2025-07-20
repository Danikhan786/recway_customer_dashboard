<header class="page-header row">
    <div class="logo-wrapper d-flex align-items-center col-auto" style="background-color: transparent;">
        <a href="index.html">
            <img class="light-logo img-fluid" src="{{ asset('assets/images/logo/recway.png') }}" height="50" width="170" alt="logo">
            <img class="dark-logo img-fluid" src="{{ asset('assets/images/logo/logo-dark.png') }}" height="50" width="170" alt="logo" />
        </a>
        <a class="close-btn toggle-sidebar" href="javascript:void(0)">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                <circle cx="17.75" cy="6.25" r="4.25" stroke="currentColor" stroke-width="1.5" />
                <circle cx="6.25" cy="6.25" r="4.25" stroke="currentColor" stroke-width="1.5" />
                <circle cx="17.75" cy="17.75" r="4.25" stroke="currentColor" stroke-width="1.5" />
                <circle cx="6.25" cy="17.75" r="4.25" stroke="currentColor" stroke-width="1.5" />
            </svg>
        </a>
    </div>
    <div class="page-main-header col" style="display: flex; justify-content: space-between; align-items: center;">
        <!-- Left section -->
        <div class="header-left">
            <div style="display: flex; flex-direction: row; gap: 30px; align-items: center;">
                <!-- Email section -->
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-sharp-duotone fa-solid fa-envelope" style="font-size:25px"></i>
                    <a href="mailto:info@recway.se" style="text-decoration: none; color: inherit; margin-left: 5px;">
                        <h6 style="display: inline;font-size:15px">info@recway.se</h6>
                    </a>
                </div>

                <!-- Phone section -->
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="fa-sharp-duotone fa-solid fa-phone" style="font-size:25px"></i>
                    <h6 style="margin: 0; font-size:15px">
                        <a href="tel:+46855106397" style="text-decoration: none; color: inherit;">
                            +46 8 551 063 97
                        </a>
                    </h6>
                </div>
            </div>
            <!-- Centered text -->
            <div style="text-align: center; padding: 15px; ">
                <p style="font-size: 14px; margin: 0;">
                {{__('messages.if_any_issue')}}
                </p>
            </div>
        </div>




        <!-- Right section -->
        <div class="nav-right">
            <ul class="header-right">
                <li class="custom-dropdown">
                    <div class="translate_wrapper">
                        <div class="current_lang">
                            <a class="lang" href="javascript:void(0)">
                                <h6 class="lang-txt f-w-700">{{ session('locale') == 'swg' ? 'Swedish' : 'English' }}</h6>
                            </a>
                        </div>
                        <ul class="custom-menu profile-menu language-menu py-0 more_lang">
                            <li class="d-block">
                                <a class="lang" id="lang-en" title="English" href="{{ url('lang-set?lang=swg') }}" >
                                    <div class="lang-txt">{{ __('messages.swedish') }}</div>
                                </a>
                            </li>
                            <li class="d-block">
                                <a class="lang" id="lang-sv" title="Swedish" href="{{ url('lang-set?lang=en') }}">
                                    <div class="lang-txt">{{ __('messages.english') }}</div>
                                </a>
                            </li>
                        </ul>
                        <div id="google_translate_element2" style="display: none;"></div>
                    </div>
                </li>
                <li>
                    <a class="dark-mode" href="javascript:void(0)">
                        <i class="fa-sharp-duotone fa-solid fa-moon" style="font-size:20px"></i>
                    </a>
                </li>
                <li>
                    <a class="full-screen" href="javascript:void(0)">
                        <i class="fa-sharp-duotone fa-solid fa-expand" style="font-size:20px"></i>
                    </a>
                </li>
                <li class="profile-nav custom-dropdown">
                    <div class="user-wrap">
                        <div class="user-img">
                            <img src="{{ asset('assets/dummy_profile.jpg') }}" alt="user" style="width: 38px !important;height: 38px !important;border: 1px solid var(--shape-border) !important;border-radius: 50% !important;padding:0px"/>
                        </div>
                        <div class="user-content">
                            <h6>{{ Auth::user()->name }}</h6>
                            <p class="mb-0">{{__('messages.customer')}}<i class="fa-solid fa-chevron-down"></i></p>
                        </div>
                    </div>
                    <div class="custom-menu overflow-hidden">
                        <ul class="profile-body">
                            <li class="d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                                    <path d="M6.57757 15.4816C5.1628 16.324 1.45336 18.0441 3.71266 20.1966C4.81631 21.248 6.04549 22 7.59087 22H16.4091C17.9545 22 19.1837 21.248 20.2873 20.1966C22.5466 18.0441 18.8372 16.324 17.4224 15.4816C14.1048 13.5061 9.89519 13.5061 6.57757 15.4816Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M16.5 6.5C16.5 8.98528 14.4853 11 12 11C9.51472 11 7.5 8.98528 7.5 6.5C7.5 4.01472 9.51472 2 12 2C14.4853 2 16.5 4.01472 16.5 6.5Z" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                                <a class="ms-2" href="{{ route('account') }}">{{__('messages.account')}}</a>
                            </li>
                            <li class="d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#000000" fill="none">
                                    <path d="M14 3.09502C13.543 3.03241 13.0755 3 12.6 3C7.29807 3 3 7.02944 3 12C3 16.9706 7.29807 21 12.6 21C13.0755 21 13.543 20.9676 14 20.905" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M21 12L11 12M21 12C21 11.2998 19.0057 9.99153 18.5 9.5M21 12C21 12.7002 19.0057 14.0085 18.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <form id="logout-form" method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="#" class="ms-2" onclick="document.getElementById('logout-form').submit();">{{ __('messages.logout') }}</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</header>
<!-- Page Body Start-->
<div class="page-body-wrapper">
    @include('includes.sidebar')
