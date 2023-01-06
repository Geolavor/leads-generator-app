<div>
    <div id="navbarVerticalNavMenuEg2">
        <ul id="navbarSettingsEg2" class="js-sticky-block js-scrollspy nav nav-tabs nav-link-gray nav-vertical">
            <li class="nav-item">
                <a class="{{ Request::routeIs('user.account.edit') ? 'nav-link active': 'nav-link' }}" href="{{ route('user.account.edit') }}">Account</a>
            </li>
            <li class="nav-item">
                <a class="{{ Request::routeIs('user.account.billing.index') ? 'nav-link active': 'nav-link' }}" href="{{ route('user.account.billing.index') }}">Billing</a>
            </li>
            <li class="nav-item">
                <a class="{{ Request::routeIs('user.account.current-plan.index') ? 'nav-link active': 'nav-link' }}" href="{{ route('user.account.current-plan.index') }}">Current plan</a>
            </li>
            <li class="nav-item">
                <a class="{{ Request::routeIs('user.account.integrations.index') ? 'nav-link active': 'nav-link' }}" href="{{ route('user.account.integrations.index') }}">Integrations</a>
            </li>
            <li class="nav-item">
                <a class="{{ Request::routeIs('user.account.api.index') ? 'nav-link active': 'nav-link' }}" href="{{ route('user.account.api.index') }}">API</a>
            </li>
        </ul>
    </div>
</div>