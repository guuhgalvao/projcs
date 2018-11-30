@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">@lang('Start Service')</div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-12" id="alerts"></div>
                                    <form class="col-12" method="POST" action="{{ url('home/services') }}" id="form_Management">
                                        @csrf
                                        <input type="hidden" name="id" id="id" value="{{ $service->id }}">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label><b>@lang('Start in')</b></label>
                                                <input type="text" class="form-control-plaintext" readonly value="{{ $service->started_in }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label><b>@lang('Order')</b></label>
                                                <input type="text" class="form-control-plaintext" readonly value="{{ $service->order }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label><b>@lang('Service Type')</b></label>
                                                <input type="text" class="form-control-plaintext" readonly value="{{ $service->service_type->name }}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label><b>@lang('Vehicle')</b></label>
                                                <input type="text" class="form-control-plaintext" readonly value="{{ $service->vehicle->plate }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label><b>@lang('Client')</b></label>
                                                <input type="text" class="form-control-plaintext" readonly value="{{ $service->client->name or '-' }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label><b>@lang('Annotations')</b></label>
                                                <input type="text" class="form-control-plaintext" readonly value="{{ $service->annotations or '-' }}">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="schedule_start">@lang('Start')</button>
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
            $('button[name=btn_Action]').on('click', function(){
                $('#alerts div.alert').remove();
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        data: {actionType: 'schedule_start'},
                        dataType: 'json',
                        success: function(response){
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
            });
        });
    </script>
@endsection