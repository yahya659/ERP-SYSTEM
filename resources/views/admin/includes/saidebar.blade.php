<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand -->
    <a href="#" class="brand-link">
        <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">ERP System</span>
    </a>

    <div class="sidebar">

        <!-- User -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2">
            </div>
            <div class="info">
                <a class="d-block" style="color: #ffffff; font-weight: 600;">
                    {{ auth()->user()->name }}
                </a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

                {{-- ================= الضبط العام ================= --}}
                @php
                    $settingsOpen = request()->routeIs('admin.admin__panel__setting.*', 'admin.treasuries.*');
                @endphp

                <li class="nav-item has-treeview {{ $settingsOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $settingsOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>الضبط العام <i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.admin__panel__setting.index') }}"
                                class="nav-link {{ request()->routeIs('admin.admin__panel__setting.*') ? 'active' : '' }}">
                                <p>الضبط العام</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.treasuries.index') }}"
                                class="nav-link {{ request()->routeIs('admin.treasuries.*') ? 'active' : '' }}">
                                <p>بيانات الخزن</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= الحسابات ================= --}}
                @php
                    $accountsOpen = request()->routeIs('acaauont_types.*', 'acaauonts.*','customers.*','Suppliers_Category.*','Suppliers.*');
                @endphp

                <li class="nav-item has-treeview {{ $accountsOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $accountsOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>الحسابات <i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('acaauont_types.index') }}"
                                class="nav-link {{ request()->routeIs('acaauont_types.*') ? 'active' : '' }}">
                                <p>أنواع الحسابات الماليه</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('acaauonts.index') }}"
                                class="nav-link {{ request()->routeIs('acaauonts.*') ? 'active' : '' }}">
                                <p>كل الحسابات الماليه</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customers.index') }}"
                                class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                                <p>حسابات العملاء</p>
                            </a>
                        </li>
                           <li class="nav-item">
                            <a href="{{ route('Suppliers.index') }}"
                                class="nav-link {{ request()->routeIs('Suppliers.*') ? 'active' : '' }}">
                                <p> حسابات الموردين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Suppliers_Category.index') }}"
                                class="nav-link {{ request()->routeIs('Suppliers_Category.*') ? 'active' : '' }}">
                                <p> فئه الموردين</p>
                            </a>
                        </li>



                    </ul>
                </li>

                {{-- ================= المخازن ================= --}}
                @php
                    $storesOpen = request()->routeIs(
                        'admin.sales_material_types.*',
                        'admin.stores.*',
                        'admin.Inv_uom.*',
                        'inv_itemscard_categories.*',
                        'item_card.*'
                    );
                @endphp

                <li class="nav-item has-treeview {{ $storesOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $storesOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>ضبط المخازن <i class="right fas fa-angle-left"></i></p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('admin.sales_material_types.index') }}"
                                class="nav-link {{ request()->routeIs('admin.sales_material_types.*') ? 'active' : '' }}">
                                <p>فئات الفواتير</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.stores.index') }}"
                                class="nav-link {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                                <p>المخازن</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.Inv_uom.index') }}"
                                class="nav-link {{ request()->routeIs('admin.Inv_uom.*') ? 'active' : '' }}">
                                <p>الوحدات</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('inv_itemscard_categories.index') }}"
                                class="nav-link {{ request()->routeIs('inv_itemscard_categories.*') ? 'active' : '' }}">
                                <p>فئات الأصناف</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('item_card.index') }}"
                                class="nav-link {{ request()->routeIs('item_card.*') ? 'active' : '' }}">
                                <p>الأصناف</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- ================= باقي الأقسام (جاهزة للتوسعة) ================= --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>حركه مخزونيه</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>المبيعات</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>خدمات داخليه وخارجيه</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>حركه شفت الخزينه</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>الصلاحيات</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>التقارير</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>المراقبه والدعم الفني</p>
                    </a>
                </li>

            </ul>
        </nav>

    </div>
</aside>
