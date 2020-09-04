<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu page-sidebar-menu-light" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <li @if(in_array($data['route'], [
                'payment_system:profile.index',
                ])) class="active"@endif>
                @php
                    $href = ('payment_system:profile.index' === $data['route'])
                    ? route('payment_system:profile.index') . $data['query']
                    : route('payment_system:profile.index') ;
                @endphp
                <a href="{{ $href }}">
                    <i class="icon-user"></i>
                    <span class="title">@lang('sidebar.profile')</span>
                </a>
            </li>
            <li @if(in_array($data['route'], [
                'payment_system:outlets.index',
                ])) class="active"@endif>
                @php
                    $href = ('payment_system:outlets.index' === $data['route'])
                    ? route('payment_system:outlets.index') . $data['query']
                    : route('payment_system:outlets.index') ;
                @endphp
                <a href="{{ $href }}">
                    <i class="icon-book-open"></i>
                    <span class="title">@lang('sidebar.outlets')</span>
                </a>
            </li>
            <li @if(in_array($data['route'], [
                    'payment_system:transactions.index',
                    'payment_system:transactions.show_details',
                    ])) class="active"@endif>
                @php
                    $href = ('payment_system:transactions.index' === $data['route'])
                    ? route('payment_system:transactions.index') . $data['query']
                    : route('payment_system:transactions.index') ;
                @endphp
                <a href="{{ $href }}">
                    <i class="icon-basket"></i>
                    <span class="title">@lang('sidebar.transactions')</span>
                </a>

            </li>
            <li @if(in_array($data['route'], [
                'payment_system:finance.payouts',
                'payment_system:finance.payouts_create_form',
                'payment_system:finance.payouts_create_form_gateway_name',
                'payment_system:finance.show_balance',
                ])) class="active open"@endif>
                <a href="javascript:;">
                    <i class="icon-wallet"></i>
                    <span class="title">@lang('sidebar.finance')</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li @if(in_array($data['route'], [
                        'payment_system:finance.show_balance',
                        ])) class="active"@endif>
                        @php
                            $href = ('payment_system:finance.show_balance' === $data['route'])
                            ? route('payment_system:finance.show_balance') . $data['query']
                            : route('payment_system:finance.show_balance') ;
                        @endphp
                        <a href="{{ $href }}">@lang('sidebar.balance')</a>
                    </li>
                    <li @if(in_array($data['route'], [
                        'payment_system:finance.payouts',
                        ])) class="active"@endif>
                        @php
                            $href = ('payment_system:finance.payouts' === $data['route'])
                            ? route('payment_system:finance.payouts') . $data['query']
                            : route('payment_system:finance.payouts') ;
                        @endphp
                        <a href="{{ $href }}">@lang('sidebar.payouts')</a>
                    </li>
                    <li @if(in_array($data['route'], [
                        'payment_system:finance.payouts_create_form',
                        'payment_system:finance.payouts_create_form_gateway_name',
                        ])) class="active"@endif>
                        @php
                            $href = ('payment_system:finance.payouts_create_form' === $data['route'])
                            ? route('payment_system:finance.payouts_create_form') . $data['query']
                            : route('payment_system:finance.payouts_create_form') ;
                        @endphp
                        <a href="{{ $href }}">@lang('sidebar.payouts_create_form')</a>
                    </li>

                </ul>
            </li>
            <!-- BEGIN ANGULARJS LINK -->

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
