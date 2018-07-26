@if(count($providers) > 0)
    <div class="card border-info mt-4" id="card_ResultList">
        <div class="card-header bg-info text-white">@lang('Providers List')</div>
        <div class="table-responsive" id="tb_ResultList">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($providers as $provider)
                        <tr data-id="{{ $provider->id }}">
                            <td>{{ $provider->name }}</td>
                            <td>{{ $provider->cpf or $provider->zipcode }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12">
                <div class="row justify-content-center">
                        {{ $providers->links() }}
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