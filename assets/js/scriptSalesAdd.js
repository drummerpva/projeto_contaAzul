function selectClient(obj) {
    var id = $(obj).attr('data-id');
    var name = $(obj).html();
    $(".searchResults").slideUp('fast');
    $("#clientName").val(name);
    $("input[name=clientId]").val(id);
}

function updateSubTotal(obj) {
    var quant = $(obj).val();
    if (quant <= 0) {
        $(obj).val(1);
        quant = 1;
    }
    var price = $(obj).attr('data-price');
    var subtotal = price * quant;
    $(obj).closest('tr').find('.subTotal').html("R$ " + subtotal);
    updateTotal();

}

function updateTotal() {
    var total = 0;
    for (var q = 0; q < $(".pQuant").length; q++) {
        var objQuant = $(".pQuant").eq(q);
        var price = objQuant.attr('data-price');
        var subtotal = price * parseInt(objQuant.val());
        total += subtotal;
    }
    $("input[name=totalPrice]").val(total);

}

function excluirProd(obj) {
    $(obj).closest("tr").remove();
    updateTotal();
}

function addProd(obj) {
    var id = $(obj).attr('data-id');
    var name = $(obj).attr('data-name');
    var price = $(obj).attr("data-price");
    $(".searchResults").slideUp('fast');
    $("#addProd").val("");
    $("#addProd").focus();
    if ($("input[name='quant[" + id + "]'").length == 0) {
        var tr = "<tr>" +
            "<td>" + name + "</td>" +
            "<td>" +
            "<input onchange='updateSubTotal(this);' name='quant[" + id + "]' type='number'  min='1' class='pQuant' value='1' data-price='" + price + "'/>" +
            "</td>" +
            "<td>R$ " + price + "</td>" +
            "<td class='subTotal'>R$ " + price + "</td>" +
            "<td><a href='javascript:;' onclick='excluirProd(this);'>Excluir</a></td>" +
            "</tr>";
        $("#tableProducts").append(tr);
    }
    updateTotal();
}
$(function () {

    $("#clientName").on("blur", function () {

        setTimeout(function () {
            $(".searchResults").slideUp('fast');
        }, 200);

    });
    $('#totalPrice').mask('000.000.000.000.000,00', {
        reverse: true,
        placeholder: "0,00"
    });
    $(".clientAddButton").on('click', function (e) {
        e.preventDefault();
        var name = $("#clientName").val();
        if (name != '' && name.length >= 3) {
            if (confirm('Você deseja adicionar um cliente com nome: ' + name + '?')) {
                $.ajax({
                    url: BASE_URL + "ajax/addClient",
                    type: "POST",
                    dataType: "json",
                    data: {
                        name: name
                    },
                    success: function (json) {
                        $(".searchResults").slideUp('fast');
                        $("input[name=clientId]").val(json.id);
                    }
                });
            }
        }
    });

    $("#clientName").on("keyup", function () {
        if ($(this).val() != "") {
            var url = BASE_URL + "ajax/" + $(this).attr("data-type");
            var q = $(this).val();
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                data: {
                    q: q
                },
                success: function (json) {
                    if ($(".searchResults").length == 0) {
                        $('#clientName').after("<div class='searchResults'></div>").slideDown('fast');
                    }
                    $(".searchResults").css('left', $("#clientName").offset().left + 'px');
                    $(".searchResults").css('top', ($("#clientName").offset().top + $("#clientName").height() + 4) + 'px');

                    var html = "";
                    $(".clientAddButton").removeAttr("disabled");
                    for (var i in json) {
                        $(".clientAddButton").attr("disabled", "disabled");
                        html += "<div class='si' ><a href ='javascript:;'  onclick='selectClient(this);' data-id='" + json[i].id + "' >" + json[i].name + "</a></div>";
                    }


                    $(".searchResults").html(html);
                    $(".searchResults").slideDown('fast');

                }
            });
        }
    });
    $("#addProd").on("keyup", function () {
        if ($(this).val() != "") {
            var url = BASE_URL + "ajax/" + $(this).attr("data-type");
            var q = $(this).val();
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                data: {
                    q: q
                },
                success: function (json) {
                    if ($(".searchResults").length == 0) {
                        $('#addProd').after("<div class='searchResults'></div>").slideDown('fast');
                    }
                    $(".searchResults").css('left', $("#addProd").offset().left + 'px');
                    $(".searchResults").css('top', ($("#addProd").offset().top + $("#addProd").height() + 4) + 'px');

                    var html = "";
                    $(".clientAddButton").removeAttr("disabled");
                    for (var i in json) {
                        $(".clientAddButton").attr("disabled", "disabled");
                        html += "<div class='si' ><a href ='javascript:;'  onclick='addProd(this);' data-id='" + json[i].Id + "' data-price='" + json[i].price + "' data-name='" + json[i].name + "'>" + json[i].name + " - R$ " + json[i].price + "</a></div>";
                    }


                    $(".searchResults").html(html);
                    $(".searchResults").slideDown('fast');

                }
            });
        }
    });


});