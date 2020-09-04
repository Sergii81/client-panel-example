<div class="top-menu">
    <ul class="nav navbar-nav pull-right">
        <!-- BEGIN USER LOGIN DROPDOWN -->
        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
        <li class="dropdown dropdown-extended  dropdown-notification">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                @php $balances = App\Models\Balance::getBalance(); @endphp
                <span class="header_balance">@lang('header.available_for_payout')</span>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu">
{{--                <li class="external">--}}
{{--                    <h3><span class="bold">@lang('header.available_for_payout')</h3>                    --}}
{{--                </li>--}}
                <li>
                    <ul class="dropdown-menu-list scroller"  data-handle-color="#637283">
                        @foreach($balances as $k => $balance)
                            <li>
                                <a href="{{route('payment_system:finance.payouts_create_form_gateway_name', ++$k)}}">
                                    <span class="time">{{$balance->amount}} {{$balance->currency}}</span>
                                    <span class="details">{{$balance->gateway->name }} </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>
        <li class="dropdown dropdown-user dropdown-dark">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                <span class="username ">{{auth()->user()->name}}</span>
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-default">
                <li>
                    <a href="{{route('payment_system:profile.index')}}">
                        <i class="icon-user"></i>@lang('header.my_profile')</a>
                </li>
                <li>
                    <a href="{{ route('logout') }}">
                        <i class="icon-key"></i>@lang('header.logout')</a>
                </li>
            </ul>
        </li>
        <!-- END USER LOGIN DROPDOWN -->

    </ul>
</div>
