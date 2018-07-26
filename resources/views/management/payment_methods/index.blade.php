@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">@lang('Manage Payment Methods')</div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-md-12" id="alerts"></div>
                                    <form class="col-12" method="POST" action="{{ url('home/management/payment_methods') }}" id="form_Management">
                                        @csrf
                                        <input type="hidden" name="id" id="id">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="code">@lang('Code')</label>
                                                <input type="text" class="form-control" name="code" id="code" placeholder="@lang('Code')">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="name">@lang('Name')</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="@lang('Name')">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label for="card">@lang('Is Card?')</label>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="card" id="card" value="1">
                                                    <label class="custom-control-label" for="card">Sim</label>
                                                </div>
                                                {{-- <label for="card">@lang('Is Card?')</label>
                                                <input type="checkbox" class="form-control" name="card" id="card" value="1"> --}}
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
                        url: 'payment_methods?page='+page,
                        data: {actionType: 'consult'},
                        dataType: 'html',
                        success: function(response){
                            $('#div_ResultList').html(response);
                            hideLoader();
                        }
                    });
                });
            }

            $("#form_Management").validate({
                rules : {
                    code: 'required', 
                    name: 'required', 
                    // cpf: {
                    //     required: true,
                    //     cpf: true
                    // },
                    // password:{
                    //     required: { 
                    //         depends: function(element) {
                    //             if($('#form_User #action').val() === "Add"){
                    //                 return true;
                    //             }else{
                    //                 return false;
                    //             }
                    //         }
                    //     },
                    //     minlength:6,   
                    // },
                },
                messages:{
                    code: 'Campo obrigatório',
                    name: 'Campo obrigatório',
                }
            });

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
                                $('#form_Management')[0].reset();
                                $('#form_Management #id').val(response.payment_method['id']);
                                $('#form_Management #code').val(response.payment_method['code']);
                                $('#form_Management #name').val(response.payment_method['name']);
                                if(response.payment_method['card'] !== 0) $('#form_Management #card').prop('checked', true);
                            }
                            hideLoader(function(){});
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
                                $('#alerts').append('<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Por favor, consulte e selecione uma forma de pagamento</div>');
                                return false;
                            }
                        }
                        if($("#form_Management").valid()){
                            submitForm($(this).val());
                        }
                        break;

                    case 'consult':
                        getList();
                        break;
                }
            });
        });
    </script>
@endsection