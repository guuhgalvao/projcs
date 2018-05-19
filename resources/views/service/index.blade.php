@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">@lang('New Service')</div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-12" id="alerts"></div>
                                    <form class="col-12" method="POST" action="{{ url('home/services') }}" id="form_Management">
                                        @csrf
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="started_in">@lang('Start in')</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control maskDateTime" name="started_in" id="started_in" placeholder="" value="{{ date('d/m/Y H:i:s') }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="service_type">@lang('Service Type')</label>
                                                <div class="typeahead__container">
                                                    <div class="typeahead__field">
                                                        <span class="typeahead__query">
                                                            <input class="js-typeahead" name="service_types" id="service_types" type="search" autocomplete="off" placeholder="@lang('Code or Service')">
                                                        </span>
                                                        {{-- <span class="typeahead__button">
                                                            <button type="submit">
                                                                <span class="typeahead__search-icon"></span>
                                                            </button>
                                                        </span> --}}
                                                    </div>
                                                </div>
                                                {{-- <input type="text" class="form-control" name="service_type" id="service_type" placeholder="@lang('Service Type')"> --}}
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="vehicles">@lang('Vehicle')</label>
                                                <div class="typeahead__container">
                                                    <div class="typeahead__field">
                                                        <span class="typeahead__query">
                                                            <input class="js-typeahead maskPlate" name="vehicles" id="vehicles" type="search" autocomplete="off" placeholder="@lang('Plate')">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="clients">@lang('Client')</label>
                                                <div class="typeahead__container">
                                                    <div class="typeahead__field">
                                                        <span class="typeahead__query">
                                                            <input class="js-typeahead" name="clients" id="clients" type="search" autocomplete="off" placeholder="@lang('Name')">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="value">@lang('Value')</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">R$</span>
                                                    </div>
                                                    <input type="text" class="form-control maskMoney2" name="value" id="value" placeholder="@lang('Value')">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="annotations">@lang('Annotations')</label>
                                                <textarea class="form-control" name="annotations" id="annotations" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="add">@lang('Add')</button>
                                        {{-- <button type="button" class="btn btn-info" name="btn_Action" value="consult">@lang('Consult')</button>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="update">@lang('Update')</button>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="remove">@lang('Remove')</button> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function($){
            function submitForm(actionType){
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        data: {actionType: actionType},
                        dataType: 'json',
                        success: function(response){
                            if(!Boolean(response.error)){
                                $('#form_Management')[0].reset();
                                $('#form_Management #id').val('');
                                //$('#alerts').append('<div class="alert alert-'+response.alerts['type']+' alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.alerts['text']+'</div>');
                                bootbox.alert(response.alerts['text'], function() {
                                    window.location = response.redirect;
                                });
                            }else{
                                $('#alerts').append('<div class="alert alert-'+response.alerts['type']+' alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.alerts['text']+'</div>');
                            }
                            hideLoader();
                        }
                    });
                });
            }

            $.typeahead({
                input: "#service_types",
                order: "asc",
                minLength: 1,
                accent: {
                    from: 'àáâãèéêìíîòóôõùúûÀÁÂÃÈÉÊÌÍÎÒÓÔÕÙÚÛ',
                    to: 'aaaaeeeiiioooouuuAAAAEEEIIIOOOOUUU'
                },
                source: {
                    //data: ['Lavagem']
                    serivce_types: {
                        // Ajax Request
                        ajax: {
                            type: "POST",
                            url: "{{ route('services') }}",
                            data: {_token: $('input[name=_token]').val(), actionType: 'get_service_types'}
                        }
                    }
                },
                callback: {
                    //onClickBefore: function () { }
                    onClickAfter: function(){
                        $('#form_Management').ajaxSubmit({
                            url: '{{ route('services') }}',
                            data: {actionType: 'get_value'},
                            success: function(response){
                                $('#form_Management #value').val(response);
                            }
                        });
                    }
                }
            }); 

            $.typeahead({
                input: "#vehicles",
                order: "asc",
                minLength: 1,
                accent: {
                    from: 'àáâãèéêìíîòóôõùúûÀÁÂÃÈÉÊÌÍÎÒÓÔÕÙÚÛ',
                    to: 'aaaaeeeiiioooouuuAAAAEEEIIIOOOOUUU'
                },
                source: {
                    serivce_types: {
                        // Ajax Request
                        ajax: {
                            type: "POST",
                            url: "{{ route('services') }}",
                            data: {_token: $('input[name=_token]').val(), actionType: 'get_vehicles'}
                        }
                    }
                },
                // callback: {
                //     onClickBefore: function () { console.log('foi'); }
                // }
            });

            $.typeahead({
                input: "#clients",
                order: "asc",
                minLength: 1,
                accent: {
                    from: 'àáâãèéêìíîòóôõùúûÀÁÂÃÈÉÊÌÍÎÒÓÔÕÙÚÛ',
                    to: 'aaaaeeeiiioooouuuAAAAEEEIIIOOOOUUU'
                },
                source: {
                    serivce_types: {
                        // Ajax Request
                        ajax: {
                            type: "POST",
                            url: "{{ route('services') }}",
                            data: {_token: $('input[name=_token]').val(), actionType: 'get_clients'}
                        }
                    }
                },
                // callback: {
                //     onClickBefore: function () { console.log('foi'); }
                // }
            });

            function getList(page = 1){
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        url: 'services?page='+page,
                        data: {actionType: 'consult'},
                        dataType: 'html',
                        success: function(response){
                            $('#div_ResultList').html(response);
                            hideLoader();
                        }
                    });
                });
            }

            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                e.stopPropagation();
                getList($(this).prop('href').split('page=')[1]);
            });

            $(document).on('click', '#tb_ResultList tbody tr', function(e){
                $('#form_Management #id').val($(this).data('id'));
                $('#div_ResultList').html('');
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        data: {actionType: 'show'},
                        dataType: 'json',
                        success: function(response){
                            if(!Boolean(response.error)){
                                $('#form_Management #id').val(response.vehicle['id']);
                                $('#form_Management #plate').val(response.vehicle['plate']);
                                $('#form_Management #brand').val(response.vehicle['brand']);
                                $('#form_Management #model').val(response.vehicle['model']);
                                $('#form_Management #color').val(response.vehicle['color']);
                            }
                            hideLoader(function(){
                                //$('#alerts').append('<div class="alert alert-'+response.alerts['type']+' alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.alerts['text']+'</div>');
                            });
                        }
                    });
                });
            });

            $('button[name=btn_Action]').on('click', function(){
                $('#alerts div.alert').remove();
                switch($(this).val()){
                    default:
                        if($(this).val() == 'update' || $(this).val() == 'remove'){
                            if($('#form_Management #id').val() === ""){
                                $('#alerts').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Por favor, consulte e selecione um vehiclee</div>');
                                return false;
                            }
                        }
                        submitForm($(this).val());
                        break;

                    case 'consult':
                        getList();
                        break;
                }
            });
        });
    </script>
@endsection