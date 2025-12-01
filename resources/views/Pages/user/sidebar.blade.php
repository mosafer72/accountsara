<div class="col-lg-3 border-end" style="background:#ccc">
    <div class="p-4">
        <div class="nav flex-column nav-pills">
            <a class="nav-link  {{ request()->is('profile') ? 'active' : '' }}" href="{{ route("dashboard") }}"><i class="fas fa-user me-2"></i>پروفایل
                من</a>
            <a class="nav-link  {{ request()->is('*/order*') ? 'active' : '' }}" href="{{ route("profile.orders") }}"><i class="fas fa-lock me-2"></i>خرید‌های من</a>
            <a class="nav-link  {{ request()->is('*/ticket*') ? 'active' : '' }}" href="{{ route("profile.tickets") }}"><i class="fas fa-credit-card me-2"></i>تیکت ها</a>
            <a class="nav-link " href="{{ route("logout") }}"><i class="fas fa-credit-card me-2"></i>خروج از محیط کاربری</a>
        </div>
    </div>
</div>
<style>
    .card-body{
        overflow:hidden;
    }
</style>
