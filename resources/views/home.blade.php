@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-3">
            <a href="{{ url()->route('start_service') }}" class="btn btn-info"><i class="fas fa-plus"></i> Novo Serviço</a>
        </div>

        <form class="col-12" method="POST" action="{{ url('home') }}" id="form_Management">
            @csrf
        </form>
        @if(count($services) > 0)
        <div class="col-md-12" id="div_ResultList">
            <div class="card border-info" id="card_ResultList">
                <div class="card-header bg-info text-white">@lang('Services List')</div>
                <div class="table-responsive" id="tb_ResultList">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>@lang('Started in')</th>
                                <th>@lang('Order')</th>
                                <th>@lang('User')</th>
                                <th>@lang('Vehicle')</th>
                                <th>@lang('Client')</th>
                                <th>@lang('Service Type')</th>
                                <th>@lang('Annotations')</th>
                                <th>@lang('Status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($services as $service)
                                <tr data-id="{{ $service->id }}" data-status="{{ $service->status }}">
                                    <td>{{ $service->started_in or '-' }}</td>
                                    <td>{{ $service->order or '-' }}</td>
                                    <td>{{ $service->user->name or '-' }}</td>
                                    <td>{{ $service->vehicle->plate.' - '.$service->vehicle->brand.'/'.$service->vehicle->model.' - '.$service->vehicle->color }}</td>
                                    <td>{{ $service->client->name or '-' }}</td>
                                    <td>{{ $service->service_type->name or '-' }}</td>
                                    <td>{{ $service->annotations or '-' }}</td>
                                    <td>{{ config('constants.status.'.$service->status) }}</td>
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
        {{-- <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info text-white">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    Conectado!
                </div>
            </div>
        </div> --}}
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

            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                e.stopPropagation();
                getList($(this).prop('href').split('page=')[1]);
            });

            $(document).on('click', '#tb_ResultList tbody tr', function(e){
                //$('#form_Management #id').val($(this).data('id'));
                switch($(this).data('status')){
                    case 1:
                        window.location = '{{ route("services") }}/finish/'+$(this).data('id');
                        break;

                    case 3:
                        window.location = '{{ route("services") }}/schedule/'+$(this).data('id');
                        break;
                }
            });
        });
    </script>
@endsection
