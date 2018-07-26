@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">@lang('Edit Vehicle')</div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-12" id="alerts"></div>
                                    <form class="col-12" method="POST" action="{{ url()->route('services') }}" id="form_Management">
                                        @csrf
                                        <input type="hidden" name="service_id" id="service_id" value="{{ $service->id }}">
                                        <input type="hidden" name="id" id="id" value="{{ $service->vehicle->id }}">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="plate">@lang('Plate')</label>
                                                <input type="text" class="form-control maskPlate text-uppercase" name="plate" id="plate" placeholder="ZZZ-9999" value="{{ $service->vehicle->plate }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="brand">@lang('Brand')</label>
                                                <input type="text" class="form-control" name="brand" id="brand" placeholder="@lang('Brand')">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="model">@lang('Model')</label>
                                                <input type="text" class="form-control" name="model" id="model" placeholder="@lang('Model')">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="color">@lang('Color')</label>
                                                <input type="text" class="form-control" name="color" id="color" placeholder="@lang('Color')">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="save_vehicle">@lang('Save')</button>
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
            function submitForm(actionType){
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        data: {actionType: actionType},
                        dataType: 'json',
                        success: function(response){
                            $('#form_Management')[0].reset();
                            $('#form_Management #id').val('');
                            if(!Boolean(response.error)){
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

            $('button[name=btn_Action]').on('click', function(){
                $('#alerts div.alert').remove();
                submitForm($(this).val());
            });
        });
    </script>
@endsection