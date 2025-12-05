<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
<title>قالب پنل مدیریت |نت کپی</title>
    <link rel="stylesheet" href="/admin_assets/css/style.css">
    <link rel="stylesheet" href="/admin_assets/css/responsive_991.css" media="(max-width:991px)">
    <link rel="stylesheet" href="/admin_assets/css/responsive_768.css" media="(max-width:768px)">
    <link rel="stylesheet" href="/admin_assets/css/font.css">
</head>
<body>
<div class="sidebar__nav border-top border-left">
    <span class="bars d-none padding-0-18"></span>
    <a class="header__logo  d-none" href="https://netcopy.ir"></a>
    <div class="profile__info border cursor-pointer text-center">
        <div class="avatar__img"><img src="/admin_assets/img/pro.jpg" class="avatar___img">
            <input type="file" accept="image/*" class="hidden avatar-img__input">
            <div class="v-dialog__container" style="display: block;"></div>
            <div class="box__camera default__avatar"></div>
        </div>
        <span class="profile__name">کاربر :  {{ auth()->user()->name ? auth()->user()->name : auth()->user()->phone }} </span>
    </div>
    <ul>
        <li class="item-li i-dashboard "><a href="/admin">داشبورد</a></li>
        <li class="item-li i-courses  {{ request()->is('*/product*') ? 'is-active' : '' }}"><a href="{{ route("admin.products.index") }}">محصولات</a></li>
        <li class="item-li i-users {{ request()->is('*/user*') ? 'is-active' : '' }}"><a href="{{ route("admin.users.index") }}"> کاربران</a></li>
        <li class="item-li i-categories {{ request()->is('*/categor*') ? 'is-active' : '' }}"><a href="{{ route("admin.categories.index") }}">دسته بندی ها</a></li>
        <li class="item-li i-slideshow {{ request()->is('*/slider*') ? 'is-active' : '' }}"><a href="{{ route("admin.sliders.index") }}">اسلایدشو</a></li>
        <li class="item-li i-banners {{ request()->is('*/banner*') ? 'is-active' : '' }}"><a href="{{ route("admin.banners.index") }}">بنر ها</a></li>
        <!-- <li class="item-li i-articles"><a href="articles.html">مقالات</a></li> -->
        <!-- <li class="item-li i-ads"><a href="ads.html">تبلیغات</a></li> -->
        <!-- <li class="item-li i-comments {{ request()->is('*/comment*') ? 'is-active' : '' }}"><a href="{{ route("admin.comments.index") }}"> نظرات</a></li> -->
        <li class="item-li i-tickets {{ request()->is('*/ticket*') ? 'is-active' : '' }}"><a href="{{ route("admin.tickets.index") }}"> تیکت ها</a></li>
        <li class="item-li i-discounts {{ request()->is('*/discount*') ? 'is-active' : '' }}"><a href="{{ route("admin.discounts.index") }}">تخفیف ها</a></li>
        <li class="item-li i-transactions {{ request()->is('*/order*') ? 'is-active' : '' }}"><a href="{{ route("admin.orders.index") }}">تراکنش ها</a></li>
        <li class="item-li i-transactions {{ request()->is('*/setting*') ? 'is-active' : '' }}"><a href="{{ route("admin.settings.index") }}">تراکنش ها</a></li>
    </ul>

</div>
    @yield("content")
</body>
<script src="/admin_assets/js//jquery-3.4.1.min.js"></script>
<script src="/admin_assets/js//js.js"></script>
</html>
