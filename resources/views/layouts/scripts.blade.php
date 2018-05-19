<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/loader.js') }}"></script>
<script src="{{ asset('js/jquery.form.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/jquery.typeahead.min.js') }}"></script>
<script src="{{ asset('js/bootbox.min.js') }}"></script>
<!-- Masks -->
<script>
    jQuery(document).ready(function($){
        $(document).ready(function(){
            $('.maskDate').mask('00/00/0000');
            $('.maskTime').mask('00:00:00');
            $('.maskHour').mask('00:00');
            $('.maskDateTime').mask('00/00/0000 00:00:00');
            $('.maskZipCode').mask('00000-000');
            $('.maskAddressNumber').mask('09999');
            $('.maskTwoNumber').mask('09');
            // $('.maskPhone').mask('0000-0000');
            $('.maskPhoneWithDDD').mask('(00) 0000-0000');
            // $('.maskPhoneUS').mask('(000) 000-0000');
            // $('.mixed').mask('AAA 000-S0S');
            $('.maskCPF').mask('000.000.000-00', {reverse: true});
            $('.maskCNPJ').mask('00.000.000/0000-00', {reverse: true});
            $('.maskMoney').mask('000.000.000.000.000,00', {reverse: true});
            $('.maskMoney2').mask("#.##0,00", {reverse: true});
            $('.maskPlate').mask('ZZZ-0000', {
                translation: {
                    'Z': {
                        pattern: /[A-Z]/, optional: false
                    }
                }
            });
            // $('.maskIPAddress').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
            //     translation: {
            //     'Z': {
            //         pattern: /[0-9]/, optional: true
            //     }
            //     }
            // });
            // $('.maskIPAddress').mask('099.099.099.099');
             //$('.maskPercent').mask('##0,00', {reverse: true});
             $('.maskPercent').mask('990', {reverse: true});
            // $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
            // $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
            // $('.fallback').mask("00r00r0000", {
            //     translation: {
            //         'r': {
            //         pattern: /[\/]/,
            //         fallback: '/'
            //         },
            //         placeholder: "__/__/____"
            //     }
            // });
            // $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
        });
    });
</script>
@yield('scripts')