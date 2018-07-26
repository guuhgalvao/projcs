@if(count($users) > 0)
    <div class="card border-info mt-4" id="card_ResultList">
        <div class="card-header bg-info text-white">@lang('Vehicles List')</div>
        <div class="table-responsive" id="tb_ResultList">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('E-mail')</th>
                        <th>@lang('Nickname')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr data-id="{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->nickname }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12">
                <div class="row justify-content-center">
                        {{ $users->links() }}
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