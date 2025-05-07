<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom" dir="rtl">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
        </a>

        <!-- Hamburger Button -->
        <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="تبديل القائمة">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Content -->

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            الرئيسية
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
                            الفواتير
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('quotations.*') ? 'active' : '' }}" href="{{ route('quotations.index') }}">
                            عروض الأسعار
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
                            العملاء
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            المنتجات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                            التقارير
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('currencies.*') ? 'active' : '' }}" href="{{ route('currencies.index') }}">
                            إدارة العملات
                        </a>
                    </li>
                @can('view users')
                <li class="nav-item dropdown dropdown-dark">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'active' : '' }}" href="#" id="userManagementDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        إدارة المستخدمين
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userManagementDropdown">
                        <li>
                            <a class="dropdown-item text-end {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                المستخدمين
                            </a>
                        </li>
                        @can('manage roles')
                        <li>
                            <a class="dropdown-item text-end {{ request()->routeIs('roles.*') ? 'active' : '' }}" href="{{ route('roles.index') }}">
                                الأدوار
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-end {{ request()->routeIs('permissions.*') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
                                الصلاحيات
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
            </ul>

            <!-- Left Side Navigation (in RTL this appears on right) -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown dropdown-dark dropdown-menu-end">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name ?? 'القائمة' }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                        <li class="disabled">
                            <a class="dropdown-item text-end disabled" href="{{ route('profile.edit') }}">
                                الملف الشخصي
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-end">
                                    تسجيل الخروج
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
