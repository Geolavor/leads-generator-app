@php($menu = Menu::prepare())

<div class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-dark bg-dark navbar-vertical-aside-initialized"
    v-bind:class="{'open': !isMenuOpen}">
    <div class="navbar-vertical-container">
        <div class="navbar-vertical-footer-offset">
            <div style="display: inline-flex;">
                <a class="navbar-brand" href="{{ route('dashboard.index') }}">
                    <img class="navbar-brand-logo-mini mt-3" src="{{ asset('vendor/leadBrowser/admin/assets/images/logotyp-mini.svg') }}" alt="{{ config('app.name') }}"/>
                </a>
                <span class="desktop-hide icon" style="margin: 13px;height: 30px;width: 30px;cursor:pointer;margin-left:70px;margin-top:30px;" @click="toggleMenu"
                    v-bind:class="[isMenuOpen ? 'menu-fold-icon' : 'menu-unfold-icon']">
                </span>
            </div>
            
            <div class="navbar-vertical-content">
                <div class="nav nav-pills nav-vertical card-navbar-nav">

                    <!-- <span class="dropdown-header">Groups</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="navbar-nav nav-compact"></div>
                    <div id="navbarVerticalMenuPagesMenu">
                        <div class="menu-item active" title="test">
                            <a class="nav-link collapsed" href="#" role="button" data-bs-toggle="collapse"
                                aria-expanded="false">

                                <i class="bi bi-people nav-icon"></i>
                                <span class="nav-link-title">Moja firma</span>
                            </a>
                        </div>
                    </div> -->

                    <span class="dropdown-header">Pages</span>
                    <small class="bi-three-dots nav-subtitle-replacer"></small>
                    <div class="navbar-nav nav-compact"></div>
                    <div id="navbarVerticalMenuPagesMenu">
                        <!-- Collapse -->
                        @foreach ($menu->items as $menuItem)
                        <div class="menu-item {{ Menu::getActive($menuItem) }}" title="{{ $menuItem['name'] }}">

                            <a class="nav-link collapsed {{ $menuItem['key'] != 'settings' && $menuItem['key'] != 'search' && count($menuItem['children']) ? 'dropdown-toggle' : ''  }}"
                                href="{{ $menuItem['url'] }}" role="button" data-bs-toggle="collapse"
                                aria-expanded="false">

                                <i class="{{ $menuItem['icon-class'] }} nav-icon"></i>
                                <span class="nav-link-title">{{ $menuItem['name'] }}</span>
                            </a>

                            @if ($menuItem['key'] != 'settings' && $menuItem['key'] != 'search' &&
                            count($menuItem['children']))
                            <ul class="nav-collapse collapse {{ Menu::getActive($menuItem) }}">
                                @foreach ($menuItem['children'] as $subMenuItem)
                                <a class="nav-link {{ Menu::getActive($subMenuItem) }}"
                                    href="{{ count($subMenuItem['children']) ? current($subMenuItem['children'])['url'] : $subMenuItem['url'] }}">
                                    <span class="menu-label">{{ $subMenuItem['name'] }}</span>
                                </a>

                                @if (count($subMenuItem['children']))
                                <ul class="nav-collapse collapse {{ Menu::getActive($menuItem) }}">
                                    @foreach ($subMenuItem['children'] as $childSubMenuItem)
                                    <a class="nav-link {{ Menu::getActive($childSubMenuItem) }}"
                                        href="{{ count($childSubMenuItem['children']) ? current($childSubMenuItem['children'])['url'] : $childSubMenuItem['url'] }}">
                                        <span class="menu-label">{{ $childSubMenuItem['name'] }}</span>
                                    </a>
                                    @endforeach
                                </ul>
                                @endif
                                
                                @endforeach
                            </ul>
                            @endif

                        </div>
                        @endforeach
                        <!-- End Collapse -->

                        <div class="card help-box bg-white rounded-3 mt-5 py-5 px-4 text-center">
                            <img src="https://d33wubrfki0l68.cloudfront.net/87584482299b2cc1ec6f1e31ccfb1d42669f7a7a/4abee/assets/images/illustrations/upgrade-illustration.svg" alt="..." class="img-fluid mb-4" width="160" height="160">    
                            <h6>Upgrade to explore<br> <span class="emphasize">premium</span> features</h6>
                            <a class="btn btn-primary btn-transition w-100" href="{{ route('plans.index') }}">{{ __('admin::app.layouts.upgrade') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
