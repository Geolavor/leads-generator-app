<header class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-container navbar-bordered bg-white" v-bind:class="{'open-content': !isMenuOpen}">
    <div class="navbar-nav-wrap">

        <div class="navbar-nav-wrap-content-start">
            <span class="icon" style="margin: 13px;height: 30px;width: 30px;cursor:pointer" @click="toggleMenu"
                v-bind:class="[isMenuOpen ? 'menu-fold-icon' : 'menu-unfold-icon']">
            </span>
        </div>

        <div class="navbar-nav-wrap-content-end">
            <!-- Navbar -->
            <ul class="navbar-nav">

                <!-- <li class="nav-item">
                    <a href="#">
                        <i class="bi bi-patch-check"></i>
                    </a>
                </li> -->

                <li class="nav-item">
                    <div>
                        @if (bouncer()->hasPermission('search.location.text'))
                            <div class="quick-create">
                                <button class="button btn btn-success dropdown-toggle">
                                    Start search
                                </button>

                                <div class="dropdown-list nav-quickly-menu">

                                    <div class="quick-link-container">
                                        @if (bouncer()->hasPermission('search.database.organizations'))
                                            <div class="quick-link-item">
                                                <a href="{{ route('organizations.index') }}">
                                                    <i class="icon bi-file-bar-graph" style="font-size:25px"></i>

                                                    <span>{{ __('admin::app.layouts.companies') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                        @if (bouncer()->hasPermission('search.location.text'))
                                            <div class="quick-link-item">
                                                <a href="{{ route('search.location.create') }}">
                                                    <i class="icon bi-compass" style="font-size:25px"></i>

                                                    <span>{{ __('admin::app.layouts.location') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                        @if (bouncer()->hasPermission('search.websites.text'))
                                            <div class="quick-link-item">
                                                <a href="{{ route('search.websites.create') }}">
                                                    <i class="icon bi-diagram-2" style="font-size:25px"></i>

                                                    <span>{{ __('admin::app.layouts.websites') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                        @if (bouncer()->hasPermission('search.phones.text'))
                                            <div class="quick-link-item">
                                                <a href="{{ route('search.phones.create') }}">
                                                    <i class="icon bi-phone" style="font-size:25px"></i>

                                                    <span>{{ __('admin::app.layouts.phone') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        @endif
                    </div>
                </li>

                <li class="nav-item">
                    <!-- Account -->
                    <div>

                        <a class="navbar-dropdown-account-wrapper dropdown dropdown-toggle" href="javascript:;"
                            id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false"
                            data-bs-auto-close="outside" data-bs-dropdown-animation="">
                            <div class="avatar avatar-sm avatar-circle">
                                <img class="avatar-img" src="{{ auth()->guard('user')->user()->image_url }}"
                                    alt="Image Description">
                                <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                            </div>
                        </a>

                        <div class="dropdown">
                            <div class="dropdown-list dropdown-container dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-accountx"
                                aria-labelledby="accountNavbarDropdown"
                                style="width: 16rem; opacity: 1; transform: translateY(10px) translateY(-10px); transition: transform 300ms ease 0s, opacity 300ms ease 0s;"
                                data-bs-popper="none">

                                <span
                                    class="p-2">{{ __('admin::app.layouts.app-version', ['version' => 'v' . config('app.version')]) }}</span>

                                <a class="card text-black my-2 border-0" href="{{ route('plans.index') }}">
                                    <div class="card-body">
                                        <h6 class="card-subtitle">Wallet</h6>


                                        <div class="row align-items-center gx-2 mb-1 mt-3">
                                            <div class="col-12">
                                                <div class="row align-items-center flex-grow-1 mb-2">
                                                    <div class="col">
                                                        <h6 class="card-header-title">Search</h6>
                                                    </div>
                                                    <div class="col-auto">
                                                        <small>
                                                            <span class="text-dark fw-semi-bold">{{ auth()->guard('user')->user()->usage['used'] }}</span>
                                                            used of {{ auth()->guard('user')->user()->usage['available'] }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="progress rounded-pill">
                                                    <div role="progressbar" aria-valuenow="{{ auth()->guard('user')->user()->usage['percentage'] }}" aria-valuemin="0"
                                                        aria-valuemax="100" class="progress-bar"
                                                        style="width: {{ auth()->guard('user')->user()->usage['percentage'] }}%;"></div>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-3">
                                                <div class="row align-items-center flex-grow-1 mb-2">
                                                    <div class="col">
                                                        <h6 class="card-header-title">Verifications</h6>
                                                    </div>
                                                    <div class="col-auto">
                                                        <small>
                                                            Unlimited
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="progress rounded-pill">
                                                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100" class="progress-bar"
                                                        style="width: 0%;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-2">
                                            <span>Monthly quotas reset in {{ auth()->guard('user')->user()->usage['days'] }} days.</span>
                                        </div>

                                        <a class="btn btn-primary btn-transition w-100"
                                            href="{{ route('plans.index') }}">{{ __('admin::app.layouts.upgrade') }}</a>
                                    </div>
                                </a>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item"
                                    href="{{ route('dashboard.index') }}">{{ __('admin::app.layouts.browser') }}</a>
                                <a class="dropdown-item"
                                    href="{{ route('user.account.edit') }}">{{ __('admin::app.layouts.my-account') }}</a>
                                <a class="dropdown-item"
                                    href="{{ route('session.destroy') }}">{{ __('admin::app.layouts.logout') }}</a>

                            </div>
                        </div>



                    </div>
                    <!-- End Account -->

                </li>

            </ul>
            <!-- End Navbar -->
        </div>
    </div>
</header>
