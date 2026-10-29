<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand -->
    {{-- <a href="#" class="brand-link">
        <img src="{{ asset('assets/admin/dist/img/AdminLTELogo.png') }}" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">ERP System</span>
    </a> --}}

    <div class="sidebar">

        <!-- User -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <i class="fas fa-user-circle fa-2x text-white"></i>
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
                    $accountsOpen = request()->routeIs('acaauont_types.*', 'acaauonts.*', 'TreasuriesTransaction.*', 'customers.*', 'Suppliers_Category.*', 'Suppliers.*', 'Exchange.*','Delegates.*');
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
                                <p>الشجره المحاسبيه (الحسابات) </p>
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
                            <a href="{{ route('Delegates.index') }}"
                                class="nav-link {{ request()->routeIs('Delegates.*') ? 'active' : '' }}">
                                <p> حسابات  المندوبين</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('TreasuriesTransaction.index') }}"
                                class="nav-link {{ request()->routeIs('TreasuriesTransaction.*') ? 'active' : '' }}">
                                <p> شاشه تحصيل النقديه </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('Exchange.index') }}"
                                class="nav-link {{ request()->routeIs('Exchange.*') ? 'active' : '' }}">
                                <p> شاشه صرف النقديه </p>
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

                {{-- ================= حركة مخزونية ================= --}}
                @php
                    $movementOpen = request()->routeIs('SupplierWithOrder.*','suppliers_with_ordersGenralReturn.*','itemcardbalances.*');
                @endphp

                <li class="nav-item has-treeview {{ $movementOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $movementOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            حركة مخزونية
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('SupplierWithOrder.index') }}"
                                class="nav-link {{ request()->routeIs('SupplierWithOrder.*') ? 'active' : '' }}">
                                {{-- <i class="nav-icon fas fa-file-invoice"></i> --}}
                                <p>فواتير المشتريات</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('suppliers_with_ordersGenralReturn.index') }}"
                                class="nav-link {{ request()->routeIs('suppliers_with_ordersGenralReturn.*') ? 'active' : '' }}">
                                {{-- <i class="nav-icon fas fa-file-invoice"></i> --}}
                                <p>فواتير مرتجع المشتريات العام </p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('itemcardbalances.index') }}"
                                class="nav-link {{ request()->routeIs('itemcardbalances.*') ? 'active' : '' }}">
                                {{-- <i class="nav-icon fas fa-file-invoice"></i> --}}
                                <p>ارصده الاااصناف </p>
                            </a>
                        </li>
                    </ul>
                </li>
{{-- ----------------------------المبيعات --}}
                @php
                    $movementOpen = request()->routeIs('Sales_Invoice.*','sales_invoice_return.*');
                @endphp

                <li class="nav-item has-treeview {{ $movementOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $movementOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                           المبيعات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('Sales_Invoice.index') }}"
                                class="nav-link {{ request()->routeIs('Sales_Invoice.*') ? 'active' : '' }}">
                                {{-- <i class="nav-icon fas fa-file-invoice"></i> --}}
                                <p>  المبيعات</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sales_invoice_return.index') }}"
                                class="nav-link {{ request()->routeIs('sales_invoice_return.*') ? 'active' : '' }}">
                                {{-- <i class="nav-icon fas fa-file-invoice"></i> --}}
                                <p>مرتجع المبيعات العام </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>خدمات داخليه وخارجيه</p>
                    </a>
                </li>

                {{-- --------------الصلاحيات --}}
                @php
                    $movementOpen = request()->routeIs('admin_accauonts.*');
                @endphp

                <li class="nav-item has-treeview {{ $movementOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $movementOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>

                            الصلاحيات
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin_accauonts.index') }}"
                                class="nav-link {{ request()->routeIs('admin_accauonts.*') ? 'active' : '' }}">
                                {{-- <i class="nav-icon fas fa-file-invoice"></i> --}}
                                <p> المستخدمين</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- ---حركه شفت الخزينه --}}
                @php
                    $movementOpen = request()->routeIs('admins_shift.*');
                @endphp

                <li class="nav-item has-treeview {{ $movementOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $movementOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>

                            حركه شفت الخزينه
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admins_shift.index') }}"
                                class="nav-link {{ request()->routeIs('admins_shift.*') ? 'active' : '' }}">
                                {{-- <i class="nav-icon fas fa-file-invoice"></i> --}}
                                <p> شفتات الخزن</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{-- --------------------نهايه شفت الخزينه---------- --}}
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
