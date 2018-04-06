@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">@lang('Manage Clients')</div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-12" id="alerts">
                                        
                                    </div>
                                    <form class="col-12" method="POST" action="{{ url('home/management/clients') }}" id="form_Management">
                                        @csrf
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="name">@lang('Name')</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="@lang('Name')">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="id_type" id="id_type" value="cpf">CPF
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="radio" name="id_type" id="id_type" value="cnpj">CNPJ
                                                        </label>
                                                    </div>
                                                </label>
                                                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="CPF/CNPJ">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="zipcode">@lang('ZipCode')</label>
                                                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="99999-999">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="state_id">@lang('State')</label>
                                                <select class="form-control" id="state_id" name="state_id">
                                                    <option value="" selected>Selecione...</option>
                                                    <option value="1">São Paulo</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="city_id">@lang('City')</label>
                                                <select class="form-control" id="city_id" name="city_id">
                                                    <option value="" selected>Selecione...</option>
                                                    <option value="1">Santo André</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-9">
                                                <label for="address">@lang('Address')</label>
                                                <input type="text" class="form-control" name="address" id="address" placeholder="@lang('Address')">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label for="number">@lang('Number')</label>
                                                <input type="text" class="form-control" name="number" id="number" placeholder="@lang('Number')">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="complement">@lang('Complement')</label>
                                                <input type="text" class="form-control" name="complement" id="complement" placeholder="@lang('Complement')">
                                            </div>
                                            <div class="form-group col-md-8">
                                                <label for="neighborhood">@lang('Neighborhood')</label>
                                                <input type="text" class="form-control" name="neighborhood" id="neighborhood" placeholder="@lang('Neighborhood')">
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
            function submitForm(actionType){
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        data: {actionType: actionType},
                        dataType: 'json',
                        success: function(response){
                            if(!Boolean(response.error)){
                                $('#alerts').append('<div class="alert alert-'+response.alerts['type']+' alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.alerts['text']+'</div>');
                            }else{
                                $('#alerts').append('<div class="alert alert-'+response.alerts['type']+' alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+response.alerts['text']+'</div>');
                            }
                            $('#form_Management')[0].reset();
                            $('#form_Management #id').val('');
                            hideLoader();
                        }
                    });
                });
            }

            function getList(page = 1){
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        url: 'clients?page='+page,
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
                getList($(this).prop('href').split('page=')[1]);
                e.preventDefault();
                e.stopPropagation();
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
                                $('#form_Management #id').val(response.client['id']);
                                $('#form_Management #name').val(response.client['name']);
                                $('#form_Management #cpf').val(response.client['cpf']);
                                $('#form_Management #zipcode').val(response.client['zipcode']);
                                $('#form_Management #state_id').val(response.client['state_id']);
                                $('#form_Management #city_id').val(response.client['city_id']);
                                $('#form_Management #address').val(response.client['address']);
                                $('#form_Management #number').val(response.client['number']);
                                $('#form_Management #complement').val(response.client['complement']);
                                $('#form_Management #neighborhood').val(response.client['neighborhood']);
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
                                $('#alerts').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Por favor, consulte e selecione um cliente</div>');
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
