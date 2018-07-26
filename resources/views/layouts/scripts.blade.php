<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/loader.js') }}"></script>
<script src="{{ asset('js/jquery.form.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/jquery.typeahead.min.js') }}"></script>
<script src="{{ asset('js/bootbox.min.js') }}"></script>
<!-- Additional Rules -->
<script>
    jQuery(function($){
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
        $('.maskPlate').mask('SSS-0000');
        // $('.maskPlate').mask('ZZZ-0000', {
        //     translation: {
        //         'Z': {
        //             pattern: /[A-Z]/, optional: false
        //         }
        //     }
        // });
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

        //For jQuery Validation
        $.validator.setDefaults({
            onclick: false,
            onkeyup: false,
            highlight: function(element) {
                $(element).removeClass('is-valid');
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            errorElement: 'div',
            errorClass: 'invalid-feedback',
            errorPlacement: function(error, element) {
                if(element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio' || element.prop('type') === 'file' || element.hasClass('selectpicker')) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });

        $.validator.addMethod("cpf", function(value, element) {
            value = $.trim(value);
            value = value.replace('.','');
            value = value.replace('.','');
            cpf = value.replace('-','');
            while(cpf.length < 11) cpf = "0"+ cpf;
            var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
            var a = [];
            var b =0;
            var c = 11;
            for (i=0; i<11; i++){
                a[i] = cpf.charAt(i);
                if (i < 9) b += (a[i] * --c);
            }
            if ((x = b % 11) < 2) { a[9] = 0; } else { a[9] = 11-x; }          
            b = 0;
            c = 11;
            for (y=0; y<10; y++) b += (a[y] * c--);
            if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
            var retorno = true;
            if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;
            return this.optional(element) || retorno;
        }, "Informe um CPF válido.");

        $.validator.addMethod("cnpj", function(cnpj, element) {
            cnpj = $.trim(cnpj);// retira espaços em branco
            // DEIXA APENAS OS NÚMEROS
            cnpj = cnpj.replace('/','');
            cnpj = cnpj.replace('.','');
            cnpj = cnpj.replace('.','');
            cnpj = cnpj.replace('-','');
            
            var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
            digitos_iguais = 1;
            
            if (cnpj.length < 14 && cnpj.length < 15){
                return false;
            }
            for (i = 0; i < cnpj.length - 1; i++){
                if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
                    digitos_iguais = 0;
                    break;
                }
            }
            
            if (!digitos_iguais){
                tamanho = cnpj.length - 2;
                numeros = cnpj.substring(0,tamanho);
                digitos = cnpj.substring(tamanho);
                soma = 0;
                pos = tamanho - 7;
            
                for (i = tamanho; i >= 1; i--){
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2){
                        pos = 9;
                    }
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(0)){
                    return false;
                }
                tamanho = tamanho + 1;
                numeros = cnpj.substring(0,tamanho);
                soma = 0;
                pos = tamanho - 7;
                for (i = tamanho; i >= 1; i--){
                    soma += numeros.charAt(tamanho - i) * pos--;
                    if (pos < 2){
                        pos = 9;
                    }
                }
                resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
                if (resultado != digitos.charAt(1)){
                    return false;
                }
                return true;
            }else{
                return false;
            }
        }, "Informe um CNPJ válido.");
    });
</script>
@yield('scripts')