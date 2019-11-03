$(function () {
    $("input[name=addressZipCode]").on("blur", function () {
        var cep = $(this).val();
        $.ajax({
            url: "http://api.postmon.com.br/v1/cep/" + cep,
            type: "GET",
            dataType: "json",
            success: function (json) {
                if(typeof json.cidade != 'undefined'){
                    $("input[name=address]").val(json.logradouro);
                    $("input[name=addressNeighb]").val(json.bairro);
                    $("input[name=addressCity]").val(json.cidade);
                    $("input[name=addressState]").val(json.estado);
                    $("input[name=addressCountry]").val("Brasil");
                }
                if($("input[name=address]").val() == ""){
                    $("input[name=address]").focus();
                }else{
                    $("input[name=addressNumber]").focus();
                }
            }
        });

    });
});