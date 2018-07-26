@if(count($services) > 0)
    {{-- <div class="card border-info" id="card_ResultList">
        <div class="card-header bg-info text-white">@lang('Services List')</div>
        <div class="table-responsive" id="tb_ResultList"> --}}
            <table class="table table-hover">
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
        {{-- </div>
    </div> --}}
@else
    <div class="col-12">
        <div class="alert alert-info alert-dismissible fade show mt-3" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Não há resultados
        </div>
    </div>
@endif