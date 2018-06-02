@if(count($values) > 0)
    <div class="card border-info mt-4" id="card_ResultList">
        <div class="card-header bg-info text-white">@lang('Values List')</div>
        <div class="table-responsive" id="tb_ResultList">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>@lang('Started in')</th>
                        <th>@lang('Service Type')</th>
                        <th>@lang('Value')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($values as $value)
                        <tr data-id="{{ $value->id }}">
                            <td>{{ $value->created_at }}</td>
                            <td>{{ $value->service_type->name }}</td>
                            <td>{{ $value->value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12">
                <div class="row justify-content-center">
                        {{ $values->links() }}
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