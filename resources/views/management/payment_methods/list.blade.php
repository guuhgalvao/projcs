@if(count($payment_methods) > 0)
    <div class="card border-info mt-4" id="card_ResultList">
        <div class="card-header bg-info text-white">@lang('Payment Methods List')</div>
        <div class="table-responsive" id="tb_ResultList">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Is Card?')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payment_methods as $payment_method)
                        <tr data-id="{{ $payment_method->id }}">
                            <td>{{ $payment_method->name }}</td>
                            <td>{{ $payment_method->card ? 'Sim' : 'Não' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12">
                <div class="row justify-content-center">
                        {{ $payment_methods->links() }}
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