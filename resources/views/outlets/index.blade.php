@extends('layouts.main')

@section('title',  config('payment_system.app.name') .' :: '.__('outlets.title'))

@section('content')

    <h3 class="page-title">@lang('outlets.page_title')</h3>

    @include('layouts.partial.page_breadcrumb',  [
        'breadcrumb_text'  => __('breadcrumbs.outlets'),
    ])


        <p>
            <a href="{{route('payment_system:outlets.show_add_form')}}" type="button" class="btn blue-madison">@lang('outlets.button_add_new')</a>
        </p>

        <div class="portlet box">
            <div class="portlet-body flip-scroll">
                <table id="table_outlets" class="table table-bordered table-striped table-condensed flip-content table-hover">
                    <thead class="flip-content">
                        <tr>
                            <th>@lang('outlets.table.table_header.th_1')</th>
                            <th>@lang('outlets.table.table_header.th_2')</th>
                            <th>@lang('outlets.table.table_header.th_3')</th>
                            <th>@lang('outlets.table.table_header.th_4')</th>
                            <th>@lang('outlets.table.table_header.th_5')</th>
                            <th>@lang('outlets.table.table_header.th_6')</th>
                            <th>@lang('outlets.table.table_header.th_7')</th>
                            <th>@lang('outlets.table.table_header.th_8')</th>
                            <th>@lang('outlets.table.table_header.th_9')</th>
                            <th>@lang('outlets.table.table_header.th_10')</th>
                            <th>@lang('outlets.table.table_header.th_11')</th>
                            <th>@lang('outlets.table.table_header.th_12')</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach ($data['outlets'] as $k => $outlet)
                        <tr>
                            <td>{{++$k}}</td>
                            <td><a href="{{route('payment_system:outlets.show_edit_form', $outlet->id)}}">{{$outlet->name}}</a></td>

                            <td>{{$outlet->outlet_url}}</td>
                            <td>{{$outlet->gateway1->name ?? ''}}</td>
                            <td>{{$outlet->gateway2->name ?? ''}}</td>
                            <td>
                                @if($outlet->outlet_status == 'test') @lang('outlets.table.test') @endif
                                @if($outlet->outlet_status == 'active') @lang('outlets.table.active') @endif
                            </td>
                            <td>@php echo substr($outlet->success_url, strrpos($outlet->success_url, '/')) @endphp</td>
                            <td>@php echo substr($outlet->failed_url, strrpos($outlet->failed_url, '/')) @endphp</td>
                            <td>@php echo substr($outlet->callback_url, strrpos($outlet->callback_url, '/')) @endphp</td>
                            <td>
                                <button class="btn btn-xs btn-info api-key" outlet_api_key="{{$outlet->api_key}}"  data-toggle="modal" data-target="#outlet-api-key-modal">
                                    @lang('outlets.table.button_show')
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-xs btn-info secret-key" outlet_secret_key="{{$outlet->secret_key}}"  data-toggle="modal" data-target="#outlet-secret-key-modal">
                                    @lang('outlets.table.button_show')
                                </button>
                            </td>
                            <td>
                                <a href="{{route('payment_system:outlets.show_edit_form', $outlet->id)}}" class="btn blue btn-xs outlet_edit">
                                    @lang('outlets.table.button_edit')
                                </a>
                                <button class="btn btn-xs btn-danger outlet-delete" outlet="{{$outlet->id}}" outlet_name="{{$outlet->name}}" data-toggle="modal" data-target="#outlet-delete-modal">
                                    @lang('outlets.table.button_delete')
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    {{--Modal outlet delete --}}
    <div class="modal fade" id="outlet-delete-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">@lang('outlets.modal_delete.modal_title')</h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('payment_system:outlets.delete')}}" method="get" id="form_outlet_delete">
                        @csrf
                        <input type="hidden" name="outlet_id">
                        <h4>@lang('outlets.modal_delete.modal_body')<b><span id="outlet_name_span"></span></b></h4>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">@lang('outlets.modal_delete.button_delete')</button>
                            <button type="button" class="btn default" data-dismiss="modal">@lang('outlets.modal_delete.button_close')</button>
                        </div>

                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--End Modal client delete --}}

    {{--Modal outlet api key --}}
    <div class="modal fade" id="outlet-api-key-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">@lang('outlets.modal_api_key.modal_title')</h4>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="outlet_api_key">
                            <span class="bold" id="api_key_copied" style="display: none">@lang('outlets.modal_api_key.api_key_copied')</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn blue" onclick="fun_copy_api()">@lang('outlets.modal_api_key.button_copy')</button>
                        <button type="button" class="btn default" data-dismiss="modal">@lang('outlets.modal_api_key.button_close')</button>
                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--End Modal outlet api key --}}

    {{--Modal outlet secret key --}}
    <div class="modal fade" id="outlet-secret-key-modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">@lang('outlets.modal_secret_key.modal_title')</h4>

                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="outlet_secret_key">
                            <span class="bold" id="secret_key_copied" style="display: none">@lang('outlets.modal_secret_key.api_key_copied')</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn blue" onclick="fun_copy_secret()">@lang('outlets.modal_secret_key.button_copy')</button>
                        <button type="button" class="btn default" data-dismiss="modal">@lang('outlets.modal_secret_key.button_close')</button>
                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    {{--End Modal outlet secret key --}}

@endsection
