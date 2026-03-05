<div class="sticky">
    <ul class="admin-leftbar">
        <li><a href="{{ route('account.dashboard') }}" class="{{ request()->routeIs('account.dashboard') ? 'active' : '' }}" >Overview</a></li>
        <hr />
        <li class="li-title">Orders</li>
        <li><a href="{{ route('account.orders') }}" class="{{ request()->routeIs(['account.orders', 'account.orderDetail', 'account.order.view', 'account.orders.cancelled']) ? 'active' : '' }}">Orders & Returns</a></li>
        <hr />
        <li class="li-title">Account</li>
        <li><a href="{{ route('account.profile') }}" class="{{ request()->routeIs(['account.profile', 'account.profile.edit', 'account.changePassword']) ? 'active' : '' }}">Profile</a></li>
        <li><a href="{{ route('account.wishlist') }}" class="{{ request()->routeIs(['account.wishlist']) ? 'active' : '' }}">Wishlist</a></li>
        <li><a href="{{ route('account.cards') }}" class="{{ request()->routeIs('account.cards') ? 'active' : '' }}">Saved Cards</a></li>
        <li><a href="{{ route('account.address') }}" class="{{ request()->routeIs('account.address') ? 'active' : '' }}">Addresses</a></li>
        <li><a href="{{ route('account.profile') }}" >Delete Account</a></li>
        <hr />
        <li class="li-title">Legal</li>
        <li><a href="{{ route('account.profile') }}" >Terms of Use</a></li>
        <li><a href="{{ route('account.profile') }}" >Privacy Center</a></li>
    </ul>
</div>