@extends('layouts.transaction')

@section('title',  config('payment_system.app.name') .' :: '.__('platio.title'))

@section('styles')
{{--    <style>--}}
{{--        html,--}}
{{--        body {--}}
{{--            height: 100%;--}}
{{--        }--}}
{{--        .wrapper {--}}
{{--            margin: 0 auto;--}}
{{--            width: 100%;--}}
{{--            display: table;--}}
{{--            height: 100%;--}}
{{--        }--}}
{{--        #app{--}}
{{--            display: table-row;--}}
{{--            height: 100%;--}}
{{--        }--}}
{{--        footer{--}}
{{--            width: 100%;--}}
{{--            font-size: 10px;--}}
{{--            letter-spacing: .3px;--}}
{{--            padding: 15px 25px;--}}
{{--            background-color: #fafbfc;--}}
{{--            color: #637388;--}}
{{--            border-top: 1px solid rgba(72, 94, 144, 0.16);--}}
{{--            text-transform: uppercase;--}}
{{--            overflow: hidden;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            justify-content: space-between;--}}
{{--        }--}}
{{--        footer ul{--}}
{{--            padding: 0px;--}}
{{--            margin: 0px;--}}
{{--        }--}}
{{--        footer ul li{--}}
{{--            float: left;--}}
{{--            list-style: none;--}}
{{--            height: 60px;--}}
{{--            position: relative;--}}
{{--            width: 80px;--}}
{{--        }--}}
{{--        footer ul li img{--}}
{{--            position: absolute;--}}
{{--            left: 50%;--}}
{{--            top: 50%;--}}
{{--            transform: translate(-50%, -50%);--}}
{{--        }--}}

{{--        .df-example{--}}
{{--            padding: 10px 0px !important;--}}
{{--            border: 1px solid #ced4da !important;--}}
{{--        }--}}
{{--    </style>--}}
@endsection

@section('content')

    <div class="row">
        <div class="col-md-12" style="text-align: center;padding:15px">
            <a href="{{route('payment_system:main')}}">
                <img src="" class="img-fluid" alt="payment_system" width="100%" style="max-width: 160px;">
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">

            @if(isset($_SESSION['status']) && !empty($_SESSION['status']) && $_SESSION['status'] == 'success')
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    @lang('platio.success_message')
                </div>
                @php unset($_SESSION["status"]); @endphp
            @endif

            @if(isset($_SESSION['status']) && !empty($_SESSION['status']) && $_SESSION['status'] == 'fail')
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    @lang('platio.fail_message')
                </div>
                @php unset($_SESSION["status"]); @endphp
            @endif
        </div>
        <!--<div class="col-md-12">
            <h4 class="tx-spacing--1">Payment Form</h4>
        </div>-->
    </div>
    <form  class="form-horizontal" id="transaction_form" method="POST" action="{{ $action ?? ''}}">
        @csrf
        <div class="form-body">
            <div class="row">
                <input type="hidden" name="signature" value="{{ $transaction->signature ?? ''}}">
                <input type="hidden" name="pid" value="{{ $transaction->ext_payment_id ?? ''}}">
                <input type="hidden" class="form-control" name="amount" value="{{ $transaction->amount ?? ''}}">
                <input type="hidden" class="form-control" name="currency" value="{{ $transaction->currency ?? ''}}">
                <input type="hidden" class="form-control" name="transaction_token" value="{{ $transaction->token ?? ''}}">
                <input type="hidden" class="form-control" name="gateway_id" value="{{ $transaction->gateway_id ?? ''}}">
                <input type="hidden" class="form-control" name="client_id" value="{{ $transaction->client_id ?? ''}}">

                <div class="col-lg-8" >
                    <div data-label="Billing Info" class="df-example demo-table">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name" class="col-md-12 col-form-label">@lang('platio.label_first_name')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="first_name" type="text" class="form-control" name="first_name"
                                               value="{{ $transaction->user_first_name ?? ''}}" autofocus placeholder="@lang('platio.placeholder_first_name')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_name" class="col-md-12 col-form-label">@lang('platio.label_last_name')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="last_name" type="text" class="form-control" name="last_name"
                                               value="{{ $transaction->user_last_name ?? ''}}" autofocus placeholder="@lang('platio.placeholder_last_name')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address" class="col-md-12 col-form-label">@lang('platio.label_address')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="address" type="text" class="form-control" name="address"
                                               value="{{ $transaction->address ?? '' }}" autofocus placeholder="@lang('platio.placeholder_address')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country" class="col-md-12 col-form-label">@lang('platio.label_country')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <select class="form-control" id="country" name="country" autofocus>
                                            <option selected disabled>@lang('platio.option_country')</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location['iso_3166_1_alpha2'] }}"
                                                         @if (!empty($transaction->country) && $location['iso_3166_1_alpha2'] == $transaction->country) selected="selected" @endif>
                                                    {{ $location['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state" class="col-md-12 col-form-label">@lang('platio.label_state')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="state" type="text" class="form-control" name="state"
                                               value="" autofocus placeholder="@lang('platio.placeholder_state')">
                                        <span class="help-block">@lang('platio.help_state')</span>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="city" class="col-md-12 col-form-label">@lang('platio.label_city')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="city" type="text" class="form-control" name="city"
                                               value="{{ $transaction->city ?? '' }}" autofocus placeholder="@lang('platio.placeholder_city')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zip" class="col-md-12 col-form-label">@lang('platio.label_zip_code')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="zip" type="text" class="form-control" name="zip"
                                               value="{{ $transaction->zip ?? '' }}" autofocus placeholder="@lang('platio.placeholder_zip_code')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="col-md-12 col-form-label">@lang('platio.label_email')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{$transaction->email ?? ''}}" autofocus placeholder="@lang('platio.placeholder_email')">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_no" class="col-md-12 col-form-label">@lang('platio.label_phone_no')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="phone_no" type="text" class="form-control" name="phone_no"
                                               value="{{$transaction->phone ?? ''}}" autofocus placeholder="@lang('platio.placeholder_phone_no')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div data-label="Card Info" class="df-example demo-table" style="max-width:454px; margin:0 auto;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
{{--                                    <label for="card_type" class="col-md-12 col-form-label">Select Card <sup class="text-danger">@lang('platio.star')</sup></label>--}}
                                    <div class="col-md-12">
                                        <input type="hidden" id="card_type" name="card_type" value="">
{{--                                            <select class="form-control" name="card_type">--}}
{{--                                                <option selected disabled> -- Select Card -- </option>--}}
{{--                                                @foreach($cards as $key => $card)--}}
{{--                                                    <option value="{{ $key }}">{{ $card }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount" class="col-md-12 col-form-label">@lang('platio.label_amount')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="amount" type="text" class="form-control" value="{{ $transaction->amount ?? ''}}" autofocus
                                               placeholder="@lang('platio.placeholder_amount')" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="currency" class="col-md-12 col-form-label">@lang('platio.label_currency')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="currency" type="text" class="form-control" value="{{ $transaction->currency ?? ''}}" autofocus
                                               placeholder="@lang('platio.placeholder_currency')" disabled="disabled">
                                        <span class="help-block">@lang('platio.help_currency')</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="card_no" class="col-md-12 col-form-label">@lang('platio.label_card_no')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="card_no" type="text" class="form-control" name="card_no"
                                               value="" autofocus placeholder="@lang('platio.placeholder_card_no')" autocomplete="cc-number">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ccExpiryMonth" class="col-md-12 col-form-label">@lang('platio.label_month')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="ccExpiryMonth" autocomplete="cc-exp-month" placeholder="@lang('platio.placeholder_month')">
{{--                                        <select class="form-control" name="ccExpiryMonth">--}}
{{--                                            <option disabled> -- Select Month -- </option>--}}
{{--                                            @foreach($months as $month)--}}
{{--                                                <option value="{{ $month }}">{{ $month }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ccExpiryYear" class="col-md-12 col-form-label">@lang('platio.label_year')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" name="ccExpiryYear" autocomplete="cc-exp-year" placeholder="@lang('platio.placeholder_year')">
{{--                                        <select class="form-control" name="ccExpiryYear">--}}
{{--                                            <option disabled> -- Select Year -- </option>--}}
{{--                                            @foreach($years as $year)--}}
{{--                                                <option value="{{ $year }}">{{ $year }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cvvNumber" class="col-md-12 col-form-label">@lang('platio.label_cvv')<sup class="text-danger">@lang('platio.star')</sup></label>
                                    <div class="col-md-12">
                                        <input id="cvvNumber" type="password" class="form-control" name="cvvNumber" value="" autofocus placeholder="@lang('platio.placeholder_cvv')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <br>
                    <button type="submit" class="btn blue" id="submitForm" >
                        @lang('platio.button_submit')
                    </button>
                </div>
            </div>


        </div>
    </form>


    <footer class="footer">
        <div style="float: left;">
            <span>© 2020  @php echo config('payment_system.app.name'); @endphp All Right Reserved </span>
        </div>
{{--            <div style="float: right;">--}}
{{--                <nav class="nav">--}}
{{--                    <ul class="pull-center">--}}
{{--                        <li>--}}
{{--                            <img src="{{ asset('img/card-logos.jpg') }}" alt="Master Card And Visa" title="Master Card And Visa" border="0" style="width: 80px;">--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="javascript:" onclick="window.open('https://sisainfosec.com/site/certificate/36572671505100517165','SISA Certificate','width=685,height=670')">--}}
{{--                                <img src="{{ asset('img/pci_logo_footer.jpg') }}" alt="PCI-DSS - certified by SISA" title="PCI-DSS - certified by SISA" border="0">--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <a href="https://trustsealinfo.verisign.com/splash?form_file=fdf/splash.fdf&amp;lang=en" target="_blank" title="Norton Secured Powered by VeriSign">--}}
{{--                                <img src="{{ asset('img/norton_logo_footer.jpg') }}" alt="Norton Secured Powered by VeriSign" title="Norton Secured Powered by VeriSign" border="0">--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <img src="{{ asset('img/mastercard_logo_footer.jpg') }}" alt="MasterCard SecureCode" title="MasterCard SecureCode" border="0">--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <img src="{{ asset('img/visa_logo_footer.jpg') }}" alt="Verified by VISA" title="Verified by VISA" border="0">--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <img src="{{ asset('img/american_exp_footer.jpg') }}" alt="American Express SafeKey" title="American Express SafeKey" border="0">--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <img src="{{ asset('img/SafeSecureLogo.jpg') }}" alt="SafeSecure" title="SafeSecure" border="0" style="width: 70px;">--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <img src="{{ asset('img/ssl.png') }}" alt="SSL" title="SSL" border="0" style="width: 70px;">--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <img src="{{ asset('img/sitelock.png') }}" alt="sitelock" title="sitelock" border="0" style="width: 70px;">--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <img src="{{ asset('img/jcb_logo_footer.jpg') }}" alt="JCB J/Secure" title="JCB J/Secure" border="0">--}}
{{--                        </li>--}}
{{--                        <li>--}}
{{--                            <img src="{{ asset('img/comodo.png') }}" alt="Comode" title="Comode" border="0" style="width: 80px;">--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </nav>--}}
{{--            </div>--}}
    </footer>

@endsection

@section('scripts')
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <!--[if lt IE 9]>
    <script src="{{asset('plugins/respond.min.js')}}"></script>
    <script src="{{asset('plugins/excanvas.min.js')}}"></script>
    <![endif]-->
    <script src="{{asset('plugins/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/jquery-migrate.min.js')}}" type="text/javascript"></script>
    <!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
    <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/jquery.cokie.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script type="text/javascript" src="{{asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    {{--    <script type="text/javascript" src="{{asset('plugins/bootstrap-daterangepicker/moment.min.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>

    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{asset('scripts/metronic.js')}}" type="text/javascript"></script>
    <script src="{{asset('scripts/layout.js')}}" type="text/javascript"></script>
    <script src="{{asset('scripts/quick-sidebar.js')}}" type="text/javascript"></script>
    <script src="{{asset('scripts/demo.js')}}" type="text/javascript"></script>
    <script src="{{asset('scripts/index.js')}}" type="text/javascript"></script>
    <script src="{{asset('scripts/tasks.js')}}" type="text/javascript"></script>
    <script src="{{asset('scripts/components-pickers.js')}}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->

    <script type="text/javascript" src="{{asset('/plugins/select2/select2.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
    {{--    <script type="text/javascript" src="{{asset('/plugins/datatables/media/js/jquery.dataTables.min.js')}}"></script>--}}
    {{--    <script type="text/javascript" src="{{asset('/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')}}"></script>--}}
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script>
        jQuery(document).ready(function() {
            Metronic.init(); // init metronic core componets
            Layout.init(); // init layout
            //QuickSidebar.init(); // init quick sidebar
            Demo.init(); // init demo features
            //Index.init();
            //Index.initDashboardDaterange();
            //Index.initJQVMAP(); // init index page's custom scripts
            //Index.initCalendar(); // init index page's custom scripts
            // Index.initCharts(); // init index page's custom scripts
            //Index.initChat();
            //Index.initMiniCharts();
            //Tasks.initDashboardWidget();
            ComponentsPickers.init();

        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#transaction_form").validate({
                rules: {
                    first_name: {
                        required: true,
                        maxlength: 192
                    },
                    last_name: {
                        required: true,
                        maxlength: 192
                    },
                    address: {
                        required: true,
                        maxlength: 256
                    },
                    country: "required",
                    state: {
                        required: true/*,
              maxlength: 3,
              minlength: 1*/
                    },
                    city: {
                        required: true,
                        maxlength: 192
                    },
                    zip: {
                        required: true,
                        digits: true,
                        minlength: 5,
                        maxlength: 10
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    phone_no: {
                        required: true/*,
              phoneValid: true*/
                    }
                },
                messages: {
                    first_name: {
                        required: "Введите ваше имя",
                        maxlength: "Максимальноая длина 192"
                    },
                    last_name: {
                        required: "Введите вашу фамилию",
                        maxlength: "Максимальноая длина 192"
                    },
                    address: {
                        required: "Введите ваш аддрес",
                        maxlength: "Максимальноая длина 192"
                    },
                    country: "Введите вашу страну",
                    state: {
                        required: "Введите ваш штат",
                        word: "Вводить только буквы",
                        maxlength: "Максимальноая длина 3",
                        minlength: "Минимальная длина 1"
                    },
                    city: {
                        required: "Введите ваш аддрес",
                        maxlength: "Максимальноая длина 256"
                    },
                    zip: {
                        required: "Введите zip",
                        digits: "В данном поле должны быть только цифры",
                        minlength: "Минимально 5 цифр",
                        maxlength: "Максимально 9 цифр"
                    },
                    email: {
                        required: "Введите ваш email",
                        email: "Email введен некорректно"
                    },
                    phone_no: {
                        required: "Введите ваш номер телефона",
                        phoneValid: "Введен некорректно номер телефона"
                    }
                }
            });
            /*jQuery.validator.addMethod("phoneValid", function(value, element) {
              return this.optional(element) || /^\+\d{11,16}$/.test(value);
            });*/

            //TelInput
            //var input = document.querySelector("#phone_no");

            // initialise plugin

            // var iti = window.intlTelInput(document.querySelector("#phone_no"), {
            //     initialCountry: "auto",
            //     separateDialCode: true,
            //     hiddenInput: "full_phone",
            //     geoIpLookup: function(callback) {
            //         $.get('https://ipinfo.io', function() {}, "jsonp")
            //             .always(function(resp) {
            //                     //var countryCode = (resp && resp.country) ? resp.country : "";
            //                     callback((resp && resp.country) ? resp.country : "");
            //                 }
            //             );
            //     },
            // });


        });
    </script>
    <script>
        $(document).ready(function(){
            // American Express
            let amex_regex = new RegExp('^3[47][0-9]{5,}$');
            // Visa
            let visa_regex = new RegExp('^4[0-9]{6,}$'); //4
            // MasterCard
            let mastercard_regex = new RegExp('^5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,}$');
            //Discover
            let discover_regex = new RegExp('^6(?:011|5[0-9]{2})[0-9]{3,}$');


            $('#card_no').on('change', function(){
                if($('#card_no').val().match(amex_regex) ) {
                    $('#card_type').val('1');
                } else if($('#card_no').val().match(visa_regex)) {
                    $('#card_type').val('2');
                } else if($('#card_no').val().match(mastercard_regex)) {
                    $('#card_type').val('3');
                } else if($('#card_no').val().match(discover_regex)){
                    $('#card_type').val('4');
                }
            });
        })
    </script>

@endsection
