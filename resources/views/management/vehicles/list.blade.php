@if(count($vehicles) > 0)
    <div class="card border-info mt-4" id="card_ResultList">
        <div class="card-header bg-info text-white">@lang('Vehicles List')</div>
        <div class="table-responsive" id="tb_ResultList">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>@lang('Plate')</th>
                        <th>@lang('Brand')</th>
                        <th>@lang('Model')</th>
                        <th>@lang('Color')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                        <tr data-id="{{ $vehicle->id }}">
                            <td>{{ $vehicle->plate }}</td>
                            <td>{{ $vehicle->brand }}</td>
                            <td>{{ $vehicle->model }}</td>
                            <td>{{ $vehicle->color }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12">
                <div class="row justify-content-center">
                        {{ $vehicles->links() }}
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