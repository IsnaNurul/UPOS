<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">UPOS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">UP</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item {{ Request::is('home*') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">PAGES</li>

            <li class="nav-item {{ Request::is('kasir*') ? 'active' : '' }}">
                <a href="{{ route('kasir.index') }}" class="nav-link"><i class="fas fa-cash-register"></i><span>Kasir</span></a>
            </li>

            <li class="nav-item {{ Request::is('member*') ? 'active' : '' }}">
                <a href="{{ route('member.index') }}" class="nav-link"><i class="fas fa-id-card"></i><span>Member</span></a>
            </li>

            <li class="nav-item {{ Request::is('manage-product*') ? 'active' : '' }}">
                <a href="{{ route('manage-product.index') }}" class="nav-link"><i class="fas fa-id-card"></i><span>Manage Products</span></a>
            </li>

            <li class="nav-item dropdown {{ Request::is('product*') || Request::is('categories*') || Request::is('discount-product*') || Request::is('restock*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-box"></i><span>Inventory Management</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item {{ Request::is('product*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('product.index') }}">Product List</a>
                    </li>
                    <li class="nav-item {{ Request::is('categories*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('categories.index') }}">Categories Product</a>
                    </li>
                    <li class="nav-item {{ Request::is('discount-product*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('discount-product.index') }}">Discount Product</a>
                    </li>
                    <li class="nav-item {{ Request::is('restock*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('restock.index') }}">Restock</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item dropdown {{ Request::is('transaction-discount*') || Request::is('voucher-discount*') || Request::is('discount-member*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-percentage"></i><span>Discounts</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item {{ Request::is('discount-member*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('discount-member.index') }}">Member Discount</a>
                    </li>
                    {{-- <li class="nav-item {{ Request::is('transaction-discount*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('transaction-discount.index') }}">Transaction Discount</a>
                    </li> --}}
                    <li class="nav-item {{ Request::is('voucher-discount*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('voucher-discount.index') }}">Voucher Discount</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ Request::is('order*') ? 'active' : '' }}">
                <a href="{{ route('order.index') }}" class="nav-link"><i class="fas fa-shopping-cart"></i><span>Orders</span></a>
            </li>

            <li class="nav-item dropdown{{ Request::is('payment-gateaway*') || Request::is('campaign*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-link"></i><span>Integrations</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item {{ Request::is('payment-gateaway*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('payment-gateaway.index') }}">Payment Gateaway</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ Request::is('setting-tax*') || Request::is('setting-receipt*') || Request::is('setting-service-charge') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i><span>Settings</span></a>
                <ul class="dropdown-menu">
                    <li class="nav-item {{ Request::is('setting-tax*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('setting-tax.index') }}"></i>Tax</a>
                    </li>
                    <li class="nav-item {{ Request::is('setting-receipt*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('setting-receipt.index') }}"></i>Receipt</a>
                    </li>
                    <li class="nav-item {{ Request::is('service-charge*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('service-charge.index') }}"></i>Service Fee</a>
                    </li>
                    <li class="nav-item {{ Request::is('branch*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('branch.index') }}"></i>Branches</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>

