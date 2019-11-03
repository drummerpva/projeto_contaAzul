$(function() {
    $('.tabItem').on('click', function() {
        $('.activeTab').removeClass('activeTab');
        $(this).addClass('activeTab');

        var item = $('.activeTab').index();
        $('.tabBody').hide();
        $('.tabBody').eq(item).show();

    });
    $("#busca").on("focus", function() {
        $(this).animate({
            width: "250px"
        });
    });
    $("#busca").on("blur", function() {
        if ($(this).val() == "") {
            $(this).animate({
                width: "100px"
            });
        }
        setTimeout(function() {
            $(".searchResults").slideUp('fast');
        }, 200);

    });
    $("#busca").on("keyup", function() {
        if ($(this).val() != "") {
            var url = BASE_URL + "ajax/" + $(this).attr("data-type");
            var q = $(this).val();
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                data: { q: q },
                success: function(json) {
                    if ($(".searchResults").length == 0) {
                        $('#busca').after("<div class='searchResults'></div>").slideDown('fast');
                    }
                    $(".searchResults").css('left', $("#busca").offset().left + 'px');
                    $(".searchResults").css('top', ($("#busca").offset().top + $("#busca").height() + 4) + 'px');

                    var html = "";
                    for (var i in json) {
                        html += "<div class='si' ><a href ='" + json[i].link + "'>" + json[i].name + "</a></div>";
                    }


                    $(".searchResults").html(html);
                    $(".searchResults").slideDown('fast');

                }
            });
        }
    });


});