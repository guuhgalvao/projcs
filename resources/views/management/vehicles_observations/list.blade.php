@if(count($vehicles_observations) > 0)
    <div class="card border-info mt-4" id="card_ResultList">
        <div class="card-header bg-info text-white">@lang('Vehicles List')</div>
        <div class="table-responsive" id="tb_ResultList">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>@lang('Vehicle')</th>
                        <th>@lang('Observation')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles_observations as $v_observation)
                        <tr data-id="{{ $v_observation->id }}">
                            <td>{{ $v_observation->vehicle->plate }}</td>
                            <td>{{ $v_observation->observation }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12">
                <div class="row justify-content-center">
                        {{ $vehicles_observations->links() }}
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