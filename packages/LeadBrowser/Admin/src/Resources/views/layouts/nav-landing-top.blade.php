  <!-- ========== HEADER ========== -->
  <header id="header" class="navbar navbar-expand-lg navbar-end navbar-absolute-top navbar-light navbar-show-hide">

    <div class="container">
      <nav class="js-mega-menu navbar-nav-wrap hs-menu-initialized hs-menu-horizontal mt-3">
        <!-- Default Logo -->
        <a class="navbar-brand" href="{{ route('landing.home') }}">
            <img class="navbar-brand-logo-mini logo-mini-border" src="{{ asset('vendor/leadBrowser/admin/assets/images/logotyp-mini.svg') }}" alt="{{ config('app.name') }}"/>
        </a>
        <!-- <a class="navbar-brand" href="{{ route('landing.home') }}">
          <img class="navbar-brand-logo" src="{{ asset('vendor/leadBrowser/admin/assets/images/mini-black.png') }}" alt="{{ config('app.name') }}"/>
        </a> -->
        <!-- End Default Logo -->

        <!-- Toggler -->
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-default">
            <i class="bi-list"></i>
          </span>
          <span class="navbar-toggler-toggled">
            <i class="bi-x"></i>
          </span>
        </button>
        <!-- End Toggler -->

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul id="navbarNavDropdownNav" class="navbar-nav">
          
            <li class="nav-item">
              <a class="nav-link" href="{{ route('compare.home') }}">Compare us</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('pricing.home') }}">Pricing</a>
            </li>

            @if (!auth()->guard('user')->user())
            <li class="nav-item">
              <a class="nav-link" href="{{ route('auth.login.create') }}">{{ __('admin::app.layouts.login') }}</a>
            </li>
            @endif

            @if (auth()->guard('user')->user())
                <div class="dropdown">
                    <a class="dropdown-toggle navbar-dropdown-account-wrapper show" href="#" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="true" data-bs-auto-close="outside" data-bs-dropdown-animation="">
                        <div class="avatar avatar-sm avatar-circle">
                        <img class="avatar-img" src="{{ auth()->guard('user')->user()->image_url }}" alt="Image Description">
                        <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                        </div>
                    </a>

                    <div class="dropdown-list dropdown-container dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-accountx" aria-labelledby="accountNavbarDropdown" style="width: 16rem; opacity: 1; transform: translateY(10px) translateY(-10px); transition: transform 300ms ease 0s, opacity 300ms ease 0s;" data-bs-popper="none">
                        
                        <a class="dropdown-item" href="#">{{ __('admin::app.layouts.app-version', ['version' => 'v' . config('app.version')]) }}</a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('dashboard.index') }}">{{ __('admin::app.layouts.dashboard') }}</a>
                        <a class="dropdown-item" href="{{ route('user.account.edit') }}">{{ __('admin::app.layouts.my-account') }}</a>
                        <a class="dropdown-item"href="{{ route('session.destroy') }}">{{ __('admin::app.layouts.logout') }}</a>
                        
                    </div>
                </div>
            @else
                <!-- Button -->
                <li class="nav-item">
                    <a class="btn btn-primary btn-transition" href="{{ route('auth.register.create') }}">{{ __('admin::app.layouts.register') }}</a>
                </li>
                <!-- End Button -->
            @endif

          </ul>
        </div>
        <!-- End Collapse -->
      </nav>
    </div>
  </header>
  <!-- ========== END HEADER ========== -->