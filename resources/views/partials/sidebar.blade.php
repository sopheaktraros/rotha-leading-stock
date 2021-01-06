<aside id="sidebar-wrapper">
    <div class="sidebar-brand text-left pl-3">
        <a href="{{ url('/')  }}" class="d-flex align-items-center">
            <span class="img-logo">
                <img src="{{ url(setting('logo')) }}" class="img-fluid p-2"
                     alt="logo">
            </span>
            <span class="text-dark ml-2 text-uppercase">{{ env('APP_NAME') }}</span>
        </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm overflow-hidden">
        <a href="{{ url('/') }}">
{{--            <img src="{{ url('images/logo/logo.png') }}" class="w-75 img-fluid"--}}
{{--                                            alt="logo">--}}
            <span class="img-logo">
                <img src="{{ url(setting('logo')) }}" class="img-fluid p-2"
                     alt="logo">
            </span>
        </a>
    </div>

    <ul class="sidebar-menu">
        @php
            $navigations = [
                [
                    'name' => 'Sales',
                    'icon' => 'fas fa-shopping-cart',
                    'permission' => 'sales',
                    'children' => [
                        [
                            'name' => 'Sale',
                            'permission' => 'sale',
                            'url' => route('sales.index'),
                            'isActive' => (Request::segment(1) == 'sales')
                        ],
                        [
                            'name' => 'Customer',
                            'permission' => 'customer',
                            'url' => route('customers.index'),
                            'isActive' => (Request::segment(1) == 'customers')
                        ]
                    ]
                ],
                [
                    'name' => 'Medicines',
                    'icon' => 'fas fa-medkit',
                    'permission' => 'medicines',
                    'children' => [
                        [
                            'name' => 'Medicine',
                            'permission' => 'medicine',
                            'url' => route('users.index'),
                            'isActive' => (Request::segment(1) == 'medicines')
                        ],
                        [
                            'name' => 'Import Stock',
                            'permission' => 'import',
                            'url' => route('import-stocks.index'),
                            'isActive' => (Request::segment(1) == 'import-stocks')
                        ],
                        [
                            'name' => 'Category',
                            'permission' => 'category',
                            'url' => route('categories.index'),
                            'isActive' => (Request::segment(1) == 'categories')
                        ],
                        [
                            'name' => 'Brand',
                            'permission' => 'brand',
                            'url' => route('brands.index'),
                            'isActive' => (Request::segment(1) == 'brands')
                        ],
                        [
                            'name' => 'Supplier',
                            'permission' => 'supplier',
                            'url' => route('suppliers.index'),
                            'isActive' => (Request::segment(1) == 'suppliers')
                        ],
                    ]
                ],
                [
                    'name' => 'User',
                    'icon' => 'fas fa-user-alt',
                    'permission' => 'security',
                    'children' => [
                        [
                            'name' => 'Users',
                            'permission' => 'user',
                            'url' => route('users.index'),
                            'icon' => 'fa-users-cog',
                            'isActive' => (Request::segment(1) == 'users')
                        ],
                        [
                            'name' => 'Roles',
                            'permission' => 'role',
                            'url' => route('roles.index'),
                            'icon' => 'fa-medal',
                            'isActive' => (Request::segment(1) == 'roles')
                        ]
                    ]
                ],
                [
                    'name' => 'Settings',
                    'icon' => 'fas fa-cog',
                    'permission' => 'setting',
                    'children' => [
                        [
                            'name' => 'General',
                            'permission' => 'general',
                            'url' => route('settings.index'),
                            'icon' => 'fa-cog',
                            'isActive' => (Request::segment(1) == 'settings')
                        ],
                        [
                            'name' => 'Branch',
                            'permission' => 'branch',
                            'url' => route('branches.index'),
                            'icon' => 'fa-cog',
                            'isActive' => (Request::segment(1) == 'branches')
                        ]
                    ]
                ],
            ];
        @endphp

        @foreach($navigations as $i => $nav)
            @php
                if(count($nav['children']) > 0) {
                    $isActive = count(array_filter($nav['children'], function($child) {
                        return $child['isActive']  == true;
                    }));
                } else {
                    $isActive = isset($nav['isActive']) ? $nav['isActive'] : false;
                }
            @endphp

            @authorize($nav['permission'], 'read')
            @if(count($nav['children']) > 0)
                <li class="dropdown {{ $isActive ? 'active' : '' }}">
                    <a href="#" class="nav-link has-dropdown"><i
                            class="{{ $nav['icon'] }}"></i><span>{{ $nav['name'] }}</span></a>
                    <ul class="dropdown-menu">
                        @foreach($nav['children'] as $subNav)
                            @authorize($subNav['permission'], 'read')
                            <li class="{{ $subNav['isActive'] ? 'active' : '' }}"><a class="nav-link"
                                                                                     href="{{ $subNav['url'] }}">{{ $subNav['name'] }}</a>
                            </li>
                            @endauthorize
                        @endforeach
                    </ul>
                </li>
            @else
                <li class="{{ $isActive ? 'active' : '' }}">
                    <a href="{{ $nav['url'] }}" class="nav-link"><i
                            class="{{ $nav['icon'] }}"></i><span>{{ $nav['name'] }}</span></a>
                </li>
            @endif
            @endauthorize
        @endforeach
    </ul>
</aside>
