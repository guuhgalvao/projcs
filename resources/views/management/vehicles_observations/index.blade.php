@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">@lang('Manage Vehicles Observations')</div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-12" id="alerts"></div>
                                    <form class="col-12" method="POST" action="{{ url('home/management/vehicles_observations') }}" id="form_Management">
                                        @csrf
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="vehicle_id">@lang('Vehicle')</label>
                                                <select class="form-control" name="vehicle_id" id="vehicle_id">
                                                    <option value="" selected>Selecione</option>
                                                    @foreach($vehicles as $vehicle)
                                                        <option value="{{ $vehicle->id }}">{{ $vehicle->plate }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="observation">@lang('Observation')</label>
                                                <textarea class="form-control" name="observation" id="observation" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="add">@lang('Add')</button>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="consult">@lang('Consult')</button>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="update">@lang('Update')</button>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="remove">@lang('Remove')</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="div_ResultList"></div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function($){
            function showAlert(messages, type = 'info'){
                $('#alerts').append('<div class="alert alert-'+type+' alert-dismissible fade show" role="alert" id="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                if($.isArray(messages)){
                    $.each(messages, function(key, msg){
                        $('#alert').append('<li>'+msg+'</li>');
                    });
                }else{
                    $('#alert').append(messages);
                }
            }

            function submitForm(actionType){
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        data: {actionType: actionType},
                        dataType: 'json',
                        success: function(response){
                            if(!Boolean(response.error)){
                                $('#form_Management')[0].reset();
                                $('#form_Management #id').val('');
                            }
                            showAlert(response.alerts['text'], response.alerts['type']);
                            hideLoader();
                        }
                    });
                });
            }

            function getList(page = 1){
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        url: 'vehicles_observations?page='+page,
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
                                $('#form_Management #id').val(response.vehicle_observation['id']);
                                $('#form_Management #vehicle_id').val(response.vehicle_observation['vehicle_id']);
                                $('#form_Management #observation').val(response.vehicle_observation['observation']);
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
                                $('#alerts').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Por favor, consulte e selecione um veículo</div>');
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