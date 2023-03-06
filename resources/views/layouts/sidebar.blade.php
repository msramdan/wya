<div id="scrollbar">
    <div class="container-fluid">
        <div id="two-column-menu">
        </div>
        <ul class="navbar-nav" id="navbar-nav">
            <li class="nav-item">
                <a class="nav-link menu-link {{ request()->is('/') || request()->is('dashboard') ? ' active' : '' }}"
                    href="/">
                    <i class="mdi mdi-speedometer"></i> <span data-key="t-widgets">Dashboard</span>
                </a>
            </li>
            <?php $i = 0; ?>
            @foreach (config('generator.sidebars') as $sidebar)
                @if (isset($sidebar['permissions']))
                    @canany($sidebar['permissions'])
                        @foreach ($sidebar['menus'] as $menu)
                            @php
                                $i++;
                                $permissions = empty($menu['permission']) ? $menu['permissions'] : [$menu['permission']];
                            @endphp
                            @canany($permissions)
                                @if (empty($menu['submenus']))
                                    @can($menu['permission'])
                                        <li class="nav-item">
                                            <a class="nav-link menu-link{{ is_active_menu($menu['route']) }}"
                                                href="{{ route(str($menu['route'])->remove('/')->plural() . '.index') }}">
                                                {!! $menu['icon'] !!}
                                                <span data-key="t-widgets">{{ __($menu['title']) }}</span>
                                            </a>
                                        </li>
                                    @endcan
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link menu-link collapsed" href="#sidebarApps{{ $i }}"
                                            data-bs-toggle="collapse" role="button" aria-expanded="false"
                                            aria-controls="sidebarApps{{ $i }}">
                                            {!! $menu['icon'] !!}
                                            <span data-key="t-apps">{{ __($menu['title']) }}</span>
                                        </a>
                                        <div class="collapse menu-dropdown {{ is_show_menu($menu['permissions']) }}"
                                            id="sidebarApps{{ $i }}">
                                            <ul class="nav nav-sm flex-column">
                                                @canany($menu['permissions'])
                                                    @foreach ($menu['submenus'] as $submenu)
                                                        @can($submenu['permission'])
                                                            <li class="nav-item">
                                                                <a href="{{ route(str($submenu['route'])->remove('/')->plural() . '.index') }}"
                                                                    class="nav-link {{ is_active_menu($submenu['route']) }}"
                                                                    data-key="t-calendar">
                                                                    {{ __($submenu['title']) }} </a>
                                                            </li>
                                                        @endcan
                                                    @endforeach
                                                @endcanany
                                            </ul>
                                        </div>
                                    </li>
                                @endif
                            @endcanany
                        @endforeach
                    @endcanany
                @endif
            @endforeach





            @if (env('APP_ENV') === 'local')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->is('generators/create') ? ' active' : '' }}"
                        href="{{ route('generators.create') }}">
                        <i class="mdi mdi-cogs"></i> <span data-key="t-widgets">{{ __('CRUD Generator') }}</span>
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>
<div class="sidebar-background"></div>
