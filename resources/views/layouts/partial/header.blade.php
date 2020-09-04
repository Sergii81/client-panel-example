<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="{{route('payment_system:profile.index')}}">
{{--                <img src="{{asset('/img/logo.png')}}" alt="logo" class="logo-default">--}}
                <span>@lang('header.logo')</span>
            </a>
        </div>
        <!-- END LOGO -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
        </a>
        <!-- BEGIN TOP NAVIGATION MENU -->
    @include('layouts.partial.top_navigation_menu')
    <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
