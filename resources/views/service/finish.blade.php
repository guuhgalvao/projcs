@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">@lang('Finalize Service')</div>
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
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="finished_in">@lang('Finalize in')</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control maskDateTime" name="finished_in" id="finished_in" placeholder="" value="{{ date('d/m/Y H:i:s') }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="value">@lang('Value')</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">R$</span>
                                                    </div>
                                                    <input type="text" class="form-control maskMoney2" name="value" id="value" value="{{ $service->value }}">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="payment_method_id">@lang('Payment Methods')</label>
                                                <select class="form-control" id="payment_method_id" name="payment_method_id">
                                                    <option value="" selected>Selecione...</option>
                                                    @foreach($payment_methods as $payment_method)
                                                        <option value="{{ $payment_method->id }}">{{ $payment_method->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="value">@lang('Value')</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">R$</span>
                                                    </div>
                                                    <input type="text" class="form-control maskMoney2" name="value" id="value" placeholder="@lang('Value')">
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="discount">@lang('Discount')</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control maskPercent" name="discount" id="discount" placeholder="@lang('Discount')">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="addition">@lang('Addition')</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control maskPercent" name="addition" id="addition" placeholder="@lang('Addition')">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                        {{-- <button type="button" class="btn btn-info" name="btn_Action" value="finalize">@lang('Finalize')</button>
                                        <button type="button" class="btn btn-info" name="btn_Action" value="consult">@lang('Consult')</button>
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
            $('#form_Management #payment_method_id').on('change', function(){
                if($(this).val() != ""){
                    showLoader(function(){
                        $('#form_Management').ajaxSubmit({
                            data: {actionType: 'finalize'},
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
            });
        });
    </script>
@endsection