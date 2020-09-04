<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{route('payment_system:profile.index')}}">@lang('breadcrumbs.home')</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <a href="{{$route}}">{{$breadcrumb_text}}</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            {{$breadcrumb_text_add_edit}}
        </li>
    </ul>
</div>
