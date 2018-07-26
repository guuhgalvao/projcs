@if(count($service_types) > 0)
    <div class="card border-info mt-4" id="card_ResultList">
        <div class="card-header bg-info text-white">@lang('Service Types List')</div>
        <div class="table-responsive" id="tb_ResultList">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>@lang('Code')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Value')</th>
                        <th>@lang('Time')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($service_types as $service_type)
                        <tr data-id="{{ $service_type->id }}">
                            <td>{{ $service_type->code }}</td>
                            <td>{{ $service_type->name }}</td>
                            <td>{{ $service_type->value }}</td>
                            <td>{{ $service_type->time }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12">
                <div class="row justify-content-center">
                        {{ $service_types->links() }}
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