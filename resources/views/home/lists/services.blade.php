@if(count($services) > 0)
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
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr data-id="{{ $service->id }}">
                            <td>{{ $service->started_in }}</td>
                            <td>{{ $service->order }}</td>
                            <td>{{ $service->user->name }}</td>
                            <td>{{ $service->vehicle->plate.' - '.$service->vehicle->brand.'/'.$service->vehicle->model.' - '.$service->vehicle->color }}</td>
                            <td>{{ $service->client->name or '-' }}</td>
                            <td>{{ $service->service_type->name }}</td>
                            <td>{{ $service->annotations }}</td>
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
@else
    <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        Não há resultados
    </div>
@endif