@extends('base')



@section('styles')
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    <link rel="stylesheet" type="text/css" href="{{asset('/plugins/select2/select2.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}"/>
{{--    <link rel="stylesheet" type="text/css" href="{{asset('plugins/bootstrap-daterangepicker/daterangepicker-bs3.css')}}"/>--}}
    <!-- END PAGE LEVEL STYLES -->
    @yield('page_styles')

    <!-- BEGIN THEME STYLES -->
    <!-- DOC: To use 'material design' style just load 'components-md.css' stylesheet instead of 'components.css' in the below style tag -->
    <link href="{{ asset('css/components-md.css') }}" id="style_components" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/plugins-md.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/layout.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/themes/darkblue.css')}}" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <style>

        .sidebar-toggler {margin-bottom: 10px;}
        .page-logo {padding-top: 13px;}
        .page-logo span {color: #ffffff; font-size: 14px;}
        .gateway_edit, .outlet_edit, .outlet-delete {margin-bottom: 5px}
        .payment_gateways{margin-top: 8px}
        .help-block_password {color: #000000; font-weight: 600}
        .header_balance {color: #c6cfda;}
        .form-control.is-invalid{border-color:#dc3545;}
        .submit_transaction_period {margin-top: 22px;}

    </style>

@endsection

@section('layout')
    <!-- BEGIN HEADER -->
    @include('layouts.partial.header')
    <!-- END HEADER -->
    <div class="clearfix">
    </div>
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        @include('layouts.partial.sidebar')
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <div class="page-content">
                @yield('content')
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    @include('layouts.partial.footer')
    <!-- END FOOTER -->
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

    @yield('page_scripts')

    <script>
        jQuery(document).ready(function() {
            //Metronic.init(); // init metronic core componets
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

            $('#table_clients').DataTable();
            $('#table_gateways').DataTable();
            $('#table_outlets').DataTable();

            $('input[name="transaction_from"]').datetimepicker(
                {
                    format: 'yyyy-mm-dd',
                },
            );
            $('input[name="transaction_to"]').datetimepicker(
                {
                    format: 'yyyy-mm-dd',
                },
            );

        });

        let table_transactions = $('#table_transactions').DataTable({
                "language": {
                    "url": "http://cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json"
                },
                initComplete: function() {
                    let count = 0;

                    this.api().columns([1]).every( function () {
                        var title = this.header();
                        //replace spaces with dashes
                        title = $(title).html();
                        var column = this;
                        var select = $('#select_outlet').select2()
                            //.appendTo( $(column.header()).empty() )
                            .on( 'change', function () {
                                //Get the "text" property from each selected data
                                //regex escape the value and store in array
                                var data = $.map( $('#select_outlet').select2('data'), function( value, key ) {
                                    return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                                });
                                //if no data selected use ""
                                if (data.length === 0) {
                                    data = [""];
                                }
                                //join array into string with regex or (|)
                                var val = data.join('|');
                                //search for the option(s) selected
                                column
                                    .search( val ? val : '', true, false )
                                    .draw();
                            });
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' );
                        });
                        //use column title as selector and placeholder
                        $('#select_outlet').select2({
                            //multiple: true,
                            language: "ru",
                            closeOnSelect: true,
                            placeholder: title,
                        });
                        //initially clear select otherwise first option is selected
                        select.val(null).trigger('change');
                    });
                    this.api().columns([2]).every( function () {
                        var title = this.header();
                        //replace spaces with dashes
                        title = $(title).html();
                        var column = this;
                        var select = $('#select_gateway').select2()
                            //.appendTo( $(column.header()).empty() )
                            .on( 'change', function () {
                                //Get the "text" property from each selected data
                                //regex escape the value and store in array
                                var data = $.map( $('#select_gateway').select2('data'), function( value, key ) {
                                    return value.text ? '^' + $.fn.dataTable.util.escapeRegex(value.text) + '$' : null;
                                });
                                //if no data selected use ""
                                if (data.length === 0) {
                                    data = [""];
                                }
                                //join array into string with regex or (|)
                                var val = data.join('|');
                                //search for the option(s) selected
                                column
                                    .search( val ? val : '', true, false )
                                    .draw();
                            });
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' );
                        });
                        //use column title as selector and placeholder
                        $('#select_gateway').select2({
                            //multiple: true,
                            language: "ru",
                            closeOnSelect: true,
                            placeholder: title,
                        });
                        //initially clear select otherwise first option is selected
                        select.val(null).trigger('change');
                    });
                }
            });
        $('#table_balance_1').DataTable();
        $('#table_balance_2').DataTable();
        $('#table_hold_1').DataTable();
        $('#table_hold_2').DataTable();
        $('#table_payouts').DataTable();

    </script>
    <script>
        //удаление магазина
        $(document).on('click', '.outlet-delete', function(e){
            let id = $(e.target).attr('outlet');
            let name = $(e.target).attr('outlet_name');
            console.log(id);
            console.log(name);
            $('#form_outlet_delete input[name=outlet_id]').val(id);
            $('#form_outlet_delete #outlet_name_span').html(name);
        });
        //показать апи ключ
        $(document).on('click', '.api-key', function(e){
            let api_key = $(e.target).attr('outlet_api_key');
            $('#outlet_api_key').val(api_key);
        });
        //показать секретный ключ
        $(document).on('click', '.secret-key', function(e){
            let secret_key = $(e.target).attr('outlet_secret_key');
            $('#outlet_secret_key').val(secret_key);
        });


        // $(document).on('click', '.client-delete', function(e){
        //     let id = $(e.target).attr('client');
        //     let name = $(e.target).attr('client_name');
        //     $('#form_client_delete input[name=client_id]').val(id);
        //     $('#form_client_delete #client_name_span').html(name);
        // });

        function str_rand() {
            var result = '';
            var words = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            var max_position = words.length - 1;
            for (let i = 0; i < 10; ++i) {
                position = Math.floor(Math.random() * max_position);
                result = result + words.substring(position, position + 1);
            }
            return result;
        }


        $(":checkbox").uniform({checkboxClass: 'myCheckClass'});
        $(":radio").uniform({radioClass: 'myCheckClass'});

        // outlets -> show_add_form, show_edit_form выбор шлюза
        function fun_check() {
            var chbox1;
            chbox1 = document.getElementById("gateway_1");
            if (null != chbox1 && chbox1.checked) {
                $('.gateway_table_1').show();
            } else {
                $('.gateway_table_1').hide();
            }
            var chbox2;
            chbox2 = document.getElementById("gateway_2");
            if (null != chbox2 && chbox2.checked) {
                $('.gateway_table_2').show();
            } else {
                $('.gateway_table_2').hide();
            }
        }


        //копирование апи ключа в буфер
        function fun_copy_api() {
            /* Get the text field */
            let copyText = document.getElementById("outlet_api_key");
            let key_copied = document.getElementById("api_key_copied");
            /* Select the text field */
            copyText.select();
            /* Copy the text inside the text field */
            document.execCommand("copy");
            key_copied.style.display = 'block';
        }
        //копирование секретного ключа в буфер
        function fun_copy_secret() {
            /* Get the text field */
            let copyText = document.getElementById("outlet_secret_key");
            let key_copied = document.getElementById("secret_key_copied");
            /* Select the text field */
            copyText.select();
            /* Copy the text inside the text field */
            document.execCommand("copy");
            key_copied.style.display = 'block';
        }
        //min/max интервал сумм доступных для выплаты
        function min_max_interval(obj) {
            let value= +obj.value.replace(/\D/g,'')||0;
            let min = +obj.getAttribute('min');
            let max = +obj.getAttribute('max');
            obj.value = Math.min(max, Math.max(min, value));
        }

    </script>


    <!-- END JAVASCRIPTS -->
@endsection
