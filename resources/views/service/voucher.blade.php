<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body{
            background-color: #fff;
            font-family: 'Arial, sans-serif' !important;
            font-size: .7rem;
        }
        p{
            margin-bottom: 0px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div id="app">
        <main class="px-0 py-0">
            <div class="container-fluid mx-0 px-0">
                <div class="row">
                    {{-- <div class="com-md-12 border-bottom pb-2 mb-2 text-center">
                        <h3>Comrpovante</h3>
                    </div> --}}
                    <div class="col-md-12 px-0">
                        {{-- <div class="text-center">
                            <h4>Comprovante</h4>
                            <hr>
                        </div> --}}
                        <div>
                            <p><b>@lang('Order'):</b> {{ $service->order }}</p>
                            <p><b>@lang('Service'):</b> {{ $service->service_type->name }}</p>
                            <p><b>@lang('Input'):</b> {{ $service->started_in }}</p>
                            <p><b>@lang('Output'):</b> {{ $service->finished_in }}</p>
                            <p><b>@lang('Value'):</b> {{ 'R$ '.$service->value }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->get_font(\'Arial, Helvetica, sans-serif\', \'normal\');
                $pageText = $PAGE_NUM.\' de \'.$PAGE_COUNT;
                $y = 770;
                $x = 294;
                $size = 8;
                $pdf->text($x, $y, $pageText, $font, $size, array(0.25, 0.25, 0.25));
            ');
        }
    </script>
</body>
</html>