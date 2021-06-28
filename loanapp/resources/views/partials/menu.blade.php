<div class="sidebar">
    <nav class="sidebar-nav ps ps--active-y">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fas fa-users nav-icon">

                    </i>
                    {{ trans('global.userManagement.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <i class="fas fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('global.permission.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fas fa-briefcase nav-icon">

                            </i>
                            {{ trans('global.role.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fas fa-user nav-icon">

                            </i>
                            {{ trans('global.user.title') }}
                        </a>
                    </li>
                </ul>
            </li>
            <!-- <li class="nav-item">
                <a href="{{ route("admin.products.index") }}" class="nav-link {{ request()->is('admin/products') || request()->is('admin/products/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.product.title') }}
                </a>
            </li> -->
            <li class="nav-item">
                <a href="{{ route("admin.income_sources.index") }}" class="nav-link {{ request()->is('admin/income_sources') || request()->is('admin/income_sources/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.income_sources.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route("admin.interest_rates.index") }}" class="nav-link {{ request()->is('admin/interest_rates') || request()->is('admin/interest_rates/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.interest_rates.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route("admin.loan_amount.index") }}" class="nav-link {{ request()->is('admin/loan_amount') || request()->is('admin/loan_amount/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.loan_amount.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route("admin.loan_duration.index") }}" class="nav-link {{ request()->is('admin/loan_duration') || request()->is('admin/loan_duration/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.loan_duration.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route("admin.loan_reason.index") }}" class="nav-link {{ request()->is('admin/loan_reason') || request()->is('admin/loan_reason/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.loan_reason.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route("admin.loan_requests.index") }}" class="nav-link {{ request()->is('admin/loan_requests') || request()->is('admin/loan_requests/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.loan_requests.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route("admin.emi_history.index") }}" class="nav-link {{ request()->is('admin/emi_history') || request()->is('admin/emi_history/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.emi_history.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route("admin.loan_offers.index") }}" class="nav-link {{ request()->is('admin/loan_offers') || request()->is('admin/loan_offers/*') ? 'active' : '' }}">
                    <i class="fas fa-cogs nav-icon">

                    </i>
                    {{ trans('global.loan_offers.title') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 869px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 415px;"></div>
        </div>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>