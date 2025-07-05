@php
    if(session()->has('branch_id')){
        $branch_rays = App\Models\Branch::find(session('branch_id'));
        if($branch_rays != null){
            $branch_rays = $branch_rays->ray_status;
        }
    }else{
        $branch_rays = 0;
    }
@endphp
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('admin.index') }}" class="nav-link" id="dashboard">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    {{ __('Dashboard') }}
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.profile.edit') }}" class="nav-link" id="profile">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>
                    {{ __('Profile') }}
                </p>
            </a>
        </li>
        @can('view_vault')
            <li class="nav-item">
                <a href="{{ route('admin.vault.index') }}" class="nav-link" id="profile">
                    <i class="nav-icon fas fa-wallet"></i>
                    <p>
                        {{ __('Vault') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_group')
            <li class="nav-item has-treeview" id="groups">
                <a href="#" class="nav-link" id="groups">
                    <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    <p>
                        {{ __('Invoices') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ route('admin.groups.index') }}" class="nav-link" id="groups">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('All Invoices') }}</p>
                        </a>
                    </li>
                    @can('create_group')
                        <li class="nav-item">
                            <a href="{{ route('admin.groups.create') }}" class="nav-link" id="group_create">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Create Invoice') }}</p>
                            </a>
                        </li>

                    @if($branch_rays)
                            <li class="nav-item">
                                <a href="{{ route('admin.ray_groups.create') }}" class="nav-link" id="create_ray_group">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ __('Create Ray Invoice') }}</p>
                                </a>
                            </li>
                        @endif
                    @endcan

                    @can('view_retrieve_group')
                        <li class="nav-item">
                            <a href="{{ url('admin/retrieved') }}" class="nav-link" id="group_retrieved">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Retrieved') }}</p>
                            </a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a href="{{ url('admin/calce') }}" class="nav-link" id="group_create">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('Calculator') }}</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('view_medical_report')
            <li class="nav-item has-treeview" id="medical_reports">
                <a href="#" class="nav-link" id="medical_reports">
                    <i class="nav-icon fas fa-flag"></i>
                    <p>
                        {{ __('Medical reports') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ route('admin.medical_reports.index') }}" class="nav-link" id="groups">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('All Medical reports') }}</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.medical_reports.index', ['type' => 'done']) }}" class="nav-link"
                            id="group_create">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('Done reports') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.medical_reports.index', ['type' => 'pending']) }}" class="nav-link"
                            id="group_create">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('Pending reports') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.medical_reports.index', ['type' => 'unsigned']) }}" class="nav-link"
                            id="group_create">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('Unsigned reports') }}</p>
                        </a>
                    </li>

                </ul>
            </li>
        @endcan

        @can('view_category')
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link" id="categories">
                    <i class="nav-icon fas fa-tasks"></i>
                    <p>
                        {{ __('Categories') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_test')
            <li class="nav-item">
                <a href="{{ route('admin.tests.index') }}" class="nav-link" id="tests">
                    <i class="nav-icon fas fa-flask"></i>
                    <p>
                        {{ __('Tests') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_culture')
            <li class="nav-item">
                <a href="{{ route('admin.cultures.index') }}" class="nav-link" id="cultures">
                    <i class="nav-icon fas fa-vial"></i>
                    <p>
                        {{ __('Cultures') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_culture_option')
            <li class="nav-item">
                <a href="{{ route('admin.culture_options.index') }}" class="nav-link" id="culture_options">
                    <i class="nav-icon fas fa-vial"></i>
                    <p>
                        {{ __('Culture options') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_antibiotic')
            <li class="nav-item">
                <a href="{{ route('admin.antibiotics.index') }}" class="nav-link" id="antibiotics">
                    <i class="nav-icon fas fa-capsules"></i>
                    <p>
                        {{ __('Antibiotics') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_package')
            <li class="nav-item">
                <a href="{{ route('admin.packages.index') }}" class="nav-link" id="packages">
                    <i class="nav-icon fas fa-box"></i>
                    <p>
                        {{ __('Packages') }}
                    </p>
                </a>
            </li>
        @endcan

        @canany(['view_test_prices', 'view_culture_prices', 'view_package_prices'])
            <li class="nav-item has-treeview" id="prices">
                <a href="#" class="nav-link" id="prices_link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                        {{ __('Price List') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    @can('view_test_prices')
                        <li class="nav-item">
                            <a href="{{ route('admin.prices.tests') }}" class="nav-link" id="tests_prices">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Tests') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_culture_prices')
                        <li class="nav-item">
                            <a href="{{ route('admin.prices.cultures') }}" class="nav-link" id="cultures_prices">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Cultures') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_package_prices')
                        <li class="nav-item">
                            <a href="{{ route('admin.prices.packages') }}" class="nav-link" id="packages_prices">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Packages') }}</p>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan

        @can('view_contract')
            <li class="nav-item has-treeview" id="contracts">
                <a href="#" class="nav-link" id="contracts">
                    <i class="nav-icon fas fa-file-contract"></i>
                    <p>
                        {{ __('Contracts') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item has-treeview" id="contracts">

                    <li class="nav-item">
                        <a href="{{ route('admin.contracts.index') }}" class="nav-link" id="contracts">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('Contracts') }}</p>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a href="{{ route('admin.governments.index') }}" class="nav-link" id="governments">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('Gov. & Regions') }}</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.contract_prices') }}" class="nav-link" id="contract_prises">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('Contract Prices') }}</p>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a href="{{ route('admin.labs.index') }}" class="nav-link" id="labs">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('Add Contract To Lab') }}</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.send_to_lab.index') }}" class="nav-link" id="send_to_lab">
                            <i class="far fa-circle nav-icon"></i>
                            <p>{{ __('Send Tests To Lab') }}</p>
                        </a>
                    </li>


                </ul>
            </li>
        @endcan

        @if($branch_rays)
            @can('view_test')
                <li class="nav-item has-treeview" id="rays">
                    <a href="#" class="nav-link" id="rays">
                        <i class="nav-icon fas fa-flask"></i>
                        <p>
                            {{ __('Rays') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- <li class="nav-item has-treeview" id="rays_test"> --}}

                        <li class="nav-item">
                            <a href="{{ route('admin.rays.index') }}" class="nav-link" id="rays_test">

                                <i class="nav-icon fas fa-flask"></i>
                                <p>{{ __('Rays') }}</p>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a href="{{ route('admin.rays_categories.index') }}" class="nav-link" id="rays_categories">
                                <i class="nav-icon fas fa-tasks"></i>
                                <p>{{ __('Rays Categroies') }}</p>
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan
        @endif

        @can('view_test')
            <li class="nav-item">
                <a href="{{ route('admin.labs_out.index') }}" class="nav-link" id="labs_out">
                    <i class="nav-icon fas fa-user-injured"></i>
                    <p>
                        {{ __('Out Labs') }}
                    </p>
                </a>
            </li>
        @endcan
        @can('view_patient')

            <li class="nav-item">
                <a href="{{ route('admin.patients.index') }}" class="nav-link" id="patients">
                    <i class="nav-icon fas fa-user-injured"></i>
                    <p>
                        {{ __('Patients') }}
                    </p>
                </a>
            </li>
        @endcan



        @canAny(['view_supplier', 'view_products', 'view_purchases', 'view_adjustments', 'view_transfers'])
            <li class="nav-item has-treeview" id="inventory">
                <a href="#" class="nav-link" id="inventory_link">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>
                        {{ __('Inventory') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    @can('view_supplier')
                        <li class="nav-item">
                            <a href="{{ route('admin.inventory.suppliers.index') }}" class="nav-link" id="suppliers">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Suppliers') }}
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('view_product')
                        <li class="nav-item">
                            <a href="{{ route('admin.inventory.products.index') }}" class="nav-link" id="products">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Products') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                    @can('view_product')
                        <li class="nav-item">
                            <a href="{{ route('admin.fixed_assets.index') }}" class="nav-link" id="products">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Fixed Assets') }}
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('view_purchase')
                        <li class="nav-item">
                            <a href="{{ route('admin.inventory.purchases.index') }}" class="nav-link" id="purchases">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Purchases') }}
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('view_adjustment')
                        <li class="nav-item">
                            <a href="{{ route('admin.inventory.adjustments.index') }}" class="nav-link" id="adjustments">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Adjustments') }}
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('view_transfer')
                        <li class="nav-item">
                            <a href="{{ route('admin.inventory.transfers.index') }}" class="nav-link" id="transfers">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Transfers') }}
                                </p>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan


        @can('view_doctor')
            <li class="nav-item">
                <a href="{{ route('admin.doctors.index') }}" class="nav-link" id="doctors">
                    <i class="nav-icon fa fa-user-md"></i>
                    <p>
                        {{ __('Doctors') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_visit')
            <li class="nav-item">
                <a href="{{ route('admin.visits.index') }}" class="nav-link" id="visits">
                    <i class="nav-icon fas fa-home"></i>
                    <p>
                        {{ __('Home Visits') }}
                    </p>
                </a>
            </li>
        @endcan

        <li class="nav-item">
            <a href="{{ route('admin.bookings.index') }}" class="nav-link" id="patients">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    {{ __('Bookings') }}
                </p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.prescriptions.index') }}" class="nav-link" id="patients">
                <i class="nav-icon fas fa-home"></i>
                <p>
                    {{ __('Prescriptions') }}
                </p>
            </a>
        </li>



        @canAny(['view_supplier', 'view_products', 'view_purchases', 'view_adjustments', 'view_transfers'])
            <li class="nav-item has-treeview" id="inventory">
                <a href="#" class="nav-link" id="inventory_link">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>
                        {{ __('Mobile Application') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ route('admin.tips.index') }}" class="nav-link" id="tips">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>
                                {{ __('Tips And Offer') }}
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.static_pages.index') }}" class="nav-link" id="static_pages">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>
                                {{ __('Static Page') }}
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.sliders.index') }}" class="nav-link" id="sliders">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>
                                {{ __('Sliders') }}
                            </p>
                        </a>
                    </li>

                </ul>
            </li>
        @endcan





        @canany(['view_payment_method', 'view_expense', 'view_expense_category'])
            <li class="nav-item has-treeview" id="accounting">
                <a href="#" class="nav-link" id="accounting_link">
                    <i class="nav-icon fas fa-calculator"></i>
                    <p>
                        {{ __('Accounting') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    @can('view_payment_method')
                        <li class="nav-item">
                            <a href="{{ route('admin.payment_methods.index') }}" class="nav-link" id="payment_methods">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Payment methods') }}
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('view_expense_category')
                        <li class="nav-item">
                            <a href="{{ route('admin.expense_categories.index') }}" class="nav-link"
                                id="expense_categories">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Expense Categories') }}
                                </p>
                            </a>
                        </li>
                    @endcan

                    @can('view_expense')
                        <li class="nav-item">
                            <a href="{{ route('admin.expenses.index') }}" class="nav-link" id="expenses">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    {{ __('Expenses') }}
                                </p>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan

        @canany(['view_accounting_report', 'view_doctor_report', 'view_supplier_report', 'view_inventory_report'])
            <li class="nav-item has-treeview" id="reports">
                <a href="#" class="nav-link" id="reports_link">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>
                        {{ __('Reports') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    @can('view_accounting_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.rep') }}" class="nav-link" id="reports.rep">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Representative reports') }}</p>
                            </a>
                        </li>
                    @endcan
                    @can('view_accounting_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.lab') }}" class="nav-link" id="reports.lab">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Lab-to-Lab reports') }}</p>
                            </a>
                        </li>
                    @endcan
                    @can('view_accounting_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.contract') }}" class="nav-link" id="reports.contract">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Contracts reports') }}</p>
                            </a>
                        </li>
                    @endcan
                    @can('view_accounting_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.delayed_money') }}" class="nav-link" id="reports.delayed_money">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Delayed Money') }}</p>
                            </a>
                        </li>
                    @endcan
                    @can('view_accounting_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.accounting') }}" class="nav-link" id="accounting_report">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Accounting report') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_doctor_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.doctor') }}" class="nav-link" id="doctor_report">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Doctor report') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_doctor_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.normal_doctor') }}" class="nav-link" id="normal_doctor_report">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Normal Doctor report') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_supplier_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.supplier') }}" class="nav-link" id="supplier_report">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Supplier report') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_purchase_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.purchase') }}" class="nav-link" id="purchase_report">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Purchases report') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_inventory_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.inventory') }}" class="nav-link" id="inventory_report">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Inventory report') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_product_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.product') }}" class="nav-link" id="product_report">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Products report') }}</p>
                            </a>
                        </li>
                    @endcan
                    @can('view_employee_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.employee') }}" class="nav-link" id="product_report">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Employees report') }}</p>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan
        @canany(['view_accounting_report', 'view_doctor_report', 'view_supplier_report', 'view_inventory_report'])
            <li class="nav-item has-treeview" id="reports_details">
                <a href="#" class="nav-link" id="reports_details_link">
                    <i class="nav-icon fas fa-chart-bar"></i>
                    <p>
                        {{ __('Details Reports') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    @can('view_accounting_report')
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.work_load_month') }}" class="nav-link" id="reports_work_load_month">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Workload Monthly') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.work_load_day') }}" class="nav-link" id="reports_work_load_day">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Workload Daily') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.expenses') }}" class="nav-link" id="reports_expenses">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Expenses') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.testes_branch') }}" class="nav-link" id="reports_testes_branch">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Testes Branch Report') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.reports.contract_details') }}" class="nav-link" id="reports_contract_details">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Contract Report') }}</p>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @canany(['view_user', 'view_role'])
            <li class="nav-item has-treeview" id="users_roles">
                <a href="#" class="nav-link" id="users_roles_link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        {{ __('Roles And Users') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    @can('view_role')
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" class="nav-link" id="roles">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Roles') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_user')
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link" id="users">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Users') }}</p>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan




        @can('view_hr')
            <li class="nav-item has-treeview" id="hr">
                <a href="#" class="nav-link" id="hr">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        {{ __('HR & Employees') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item has-treeview" id="tests_prices">
                        @can('view_hr')
                        <li class="nav-item">
                            <a href="{{ route('admin.employees.index') }}" class="nav-link" id="tests_prices">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Employees') }}</p>
                            </a>
                        </li>
                    @endcan

                    @can('view_violations')
                        <li class="nav-item">
                            <a href="{{ route('admin.violations.index') }}" class="nav-link" id="governments">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Violations') }}</p>
                            </a>
                        </li>
                    @endcan
                    @can('view_hr')
                        <li class="nav-item">
                            <a href="{{ route('admin.vocations.index') }}" class="nav-link" id="labs">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Vocations Request') }}</p>
                            </a>
                        </li>
                    @endcan
                    @can('view_hr')
                        <li class="nav-item">
                            <a href="{{ route('admin.attendance.index') }}" class="nav-link" id="labs">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{ __('Attendance') }}</p>
                            </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan

        @can('view_chat')
            <li class="nav-item">
                <a href="{{ route('admin.chat.index') }}" class="nav-link" id="chat">
                    <i class="nav-icon far fa-comment-dots"></i>
                    <p>
                        {{ __('Chat') }}
                    </p>
                </a>
            </li>
        @endcan

        @can('view_branch')
            <li class="nav-item">
                <a href="{{ route('admin.branches.index') }}" class="nav-link" id="branches">
                    <i class="fas fa-map-marked-alt nav-icon"></i>
                    <p>{{ __('Branches') }}</p>
                </a>
            </li>
        @endcan

        @can('view_branch')
            <li class="nav-item">
                <a href="{{ route('admin.branches_custody.index') }}" class="nav-link" id="branches_custody">
                    <i class="fas fa-map-marked-alt nav-icon"></i>
                    <p>{{ __('Branches Custody') }}</p>
                </a>
            </li>
        @endcan

        @can('view_setting')
            <li class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link" id="settings">
                    <i class="fa fa-cogs nav-icon"></i>
                    <p>{{ __('Settings') }}</p>
                </a>
            </li>
        @endcan

        @can('view_translation')
            <li class="nav-item">
                <a href="{{ route('admin.translations.index') }}" class="nav-link" id="translations">
                    <i class="fa fa-book nav-icon"></i>
                    <p>{{ __('Translations') }}</p>
                </a>
            </li>
        @endcan

        @can('view_activity_log')
            <li class="nav-item">
                <a href="{{ route('admin.activity_logs.index') }}" class="nav-link" id="activity_logs">
                    <i class="fa fa-server nav-icon"></i>
                    <p>{{ __('Activity Logs') }}</p>
                </a>
            </li>
        @endcan

        @can('view_backup')
            <li class="nav-item">
                <a href="{{ route('admin.backups.index') }}" class="nav-link" id="backups">
                    <i class="fa fa-database nav-icon"></i>
                    <p>{{ __('Database Backups') }}</p>
                </a>
            </li>
        @endcan


    </ul>
</nav>
