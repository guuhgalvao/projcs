@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(count($services) > 0)
        <div class="col-md-12">
            <div class="card border-info" id="card_ResultList">
                <div class="card-header bg-info text-white">
                    @lang('Services List')
                    <button class="btn btn-secondary btn-sm float-right" type="button" value="export"  name="btn_Action" id="export"><i class="fas fa-file-excel"></i></button>
                    <button class="btn btn-secondary btn-sm float-right mr-2" data-toggle="collapse" href="#filter" type="button"><i class="fas fa-filter prefix"></i></button>
                </div>
                <div class="collapse" id="filter">
                    <div class="card-body">
                        <form method="POST" action="{{ route('reports_services') }}" class="form-horizontal" id="form_Filter">
                            @csrf
                            <div class="form-row">                                            
                                <div class="form-group col-lg-5">
                                    <label for="start" class="col-form-label control-label text-md-right">{{ __('Period') }}</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                        <input id="start" type="text" class="form-control maskDate datetimepicker-input" data-target="#start" data-toggle="datetimepicker" name="start" placeholder="{{ __('start') }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">-</span>
                                        </div>                                                        
                                        <input id="end" type="text" class="form-control maskDate datetimepicker-input" data-target="#end" data-toggle="datetimepicker" name="end" placeholder="{{ __('end') }}">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                        </div>
                                    </div>                                                                                                
                                </div>                                            
                                <div class="form-group col-lg-3">
                                    <label for="user" class="col-form-label text-md-right">{{ __('User') }}</label>
                                    <select name="user" id="user" class="custom-select">
                                        <option value="" selected>{{ __('Select') }}</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-lg-2 row align-items-end">
                                    <div class="col-lg-5 offset-1">
                                        <button type="button" name="btn_Action" value="filter" class="btn btn-secondary mt-new"><b>{{ __('Filter') }}</b></button>
                                    </div>                                                
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive" id="div_ResultList">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>@lang('Order')</th>
                                <th>@lang('Started in')</th>
                                <th>@lang('Finished in')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Plate')</th>
                                <th>@lang('Client')</th>
                                <th>@lang('Service Type')</th>
                                <th>@lang('Annotations')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr data-id="{{ $service->id }}">
                                    <td>{{ $service->order or '-' }}</td>
                                    <td>{{ $service->started_in or '-' }}</td>
                                    <td>{{ $service->finished_in or '-' }}</td>
                                    <td>{{ $service->user->name or '-' }}</td>
                                    <td>{{ $service->vehicle->plate or '-' }}</td>
                                    <td>{{ $service->client->name or '-' }}</td>
                                    <td>{{ $service->service_type->name or '-' }}</td>
                                    <td>{{ $service->annotations or '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-12">
                        <div class="row justify-content-center">
                                {{ $services->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function($){

            function getList(page = 1){
                showLoader(function(){
                    $('#form_Management').ajaxSubmit({
                        url: 'home?page='+page,
                        data: {actionType: 'consult'},
                        dataType: 'html',
                        success: function(response){
                            $('#div_ResultList').html(response);
                            hideLoader();
                        }
                    });
                });
            }

            function getFilter(xls = false, page = 1){
                showLoader(function(){
                    $('#form_Filter').ajaxSubmit({
                        url: '{{ route("reports_services") }}?page='+page,
                        data:{actionType: 'filter', export: xls},
                        success: function(response){
                            if(xls){
                                window.location = response['path'];
                            }else{
                                $('#div_ResultList').empty();
                                $('#div_ResultList').html(response);
                            }                            
                            hideLoader();
                        }
                    });
                });
            }

            $('button[name=btn_Action]').on('click', function(){
                switch($(this).val()){                
                    case 'filter':
                        getFilter();
                        break;

                    case 'export':
                        getFilter(true);
                        break;
                }
            });
                            
            $('#start, #end').datetimepicker({
                locale: 'pt-br',
                useCurrent: false,
                format: 'DD/MM/YYYY',
                maxDate: 'now'
            });

            // $(document).on('click', '#tb_ResultList tbody tr', function(e){
            //     //$('#form_Management #id').val($(this).data('id'));
            //     window.location = 'home/services/finish/'+$(this).data('id');
            // });            

            $(document).on('click','.pagination a', function(e){
                e.preventDefault();                    
                getFilter(false, $(this).attr('href').split('page=')[1]);                    
            });            
        });
    </script>
@endsection
