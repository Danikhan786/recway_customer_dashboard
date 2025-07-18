<!-- Page sidebar start-->
<aside class="page-sidebar">
  <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
  <div class="main-sidebar" id="main-sidebar">
  <ul class="sidebar-menu" id="simple-bar"  style="padding: 10px 15px;">
      <li class="pin-title sidebar-main-title">
        <div>
          <h5 class="sidebar-title f-w-700">Pinned</h5>
        </div>
      </li>
      <li class="sidebar-main-title">
        <div>
          <h5 class="lan-1 f-w-700 sidebar-title">{{ __('messages.general') }}</h5>
        </div>
      </li>
        <li class="sidebar-list {{ Request::routeIs('dashboard') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('dashboard') }}">
                <i class="fa-sharp-duotone fa-solid fa-house" style="font-size: 20px"></i>
                <h6 class="f-w-600">{{ __('messages.dashboard') }}</h6>
            </a>
        </li>
        <li class="sidebar-list {{ Request::routeIs('create_order') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('create_order') }}">
                <i class="fa-sharp-duotone fa-solid fa-circle-plus" style="font-size: 20px"></i>
                <h6 class="f-w-600">{{ __('messages.create_order') }}</h6>
            </a>
        </li>
        <li class="sidebar-list {{ Request::routeIs('orders') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('orders') }}">
                <i class="fa-sharp-duotone fa-solid fa-list" style="font-size: 20px"></i>
                <h6 class="f-w-600">{{ __('messages.order') }}</h6>
            </a>
        </li>
        <li class="sidebar-list {{ Request::routeIs('history') ? 'active' : '' }}">
            <a class="sidebar-link" href="{{ route('history') }}">
                <i class="fa-sharp-duotone fa-solid fa-clock-rotate-left" style="font-size: 20px"></i>
                <h6 class="f-w-600">{{ __('messages.archieved') }}</h6>
            </a>
        </li>
    </ul>
  </div>
  <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
</aside>
<!-- Page sidebar end-->
