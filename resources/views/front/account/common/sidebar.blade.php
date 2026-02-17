<ul class="admin-leftbar">
    <li><a href="{{ route('account.profile') }}" class="{{ request()->routeIs('account.profile') ? 'active' : '' }}" >Overview</a></li>
    <hr />
    <li class="li-title">Orders</li>
    <li><a href="{{ route('account.orders') }}" class="{{ request()->routeIs('account.orders') ? 'active' : '' }}">Orders & Returns</a></li>
    <hr />
    <li class="li-title">Account</li>
    <li><a href="{{ route('account.profile') }}" >Profile</a></li>
    <li><a href="{{ route('account.profile') }}" >Saved Cards</a></li>
    <li><a href="{{ route('account.profile') }}" >Addresses</a></li>
    <li><a href="{{ route('account.profile') }}" >Delete Account</a></li>
    <hr />
    <li class="li-title">Legal</li>
    <li><a href="{{ route('account.profile') }}" >Terms of Use</a></li>
    <li><a href="{{ route('account.profile') }}" >Privacy Center</a></li>
</ul>
