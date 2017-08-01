var app = {
    points_left_actual: [],
    points_left_desirable: [],

    start: function() {

        $.each($(".tr-item"), function() {
            app.points_left_actual[$(this).attr("data-id")] = 100;
            app.points_left_desirable[$(this).attr("data-id")] = 100;
        });

        $("#btnPesquisa").click(function(e) {
            e.preventDefault();
            $("#divStart").fadeOut();
            $("#divPesquisa").fadeIn();
        });

        $(".input-actual").change(function() {
            item_id = $(this).parent().parent().parent().attr("data-id");
            if ($(this).val() == "")
                $(this).val("0");
            app.recalc("actual", item_id);
        });

        $(".input-desirable").change(function() {
            item_id = $(this).parent().parent().parent().attr("data-id");
            if ($(this).val() == "")
                $(this).val("0");
            app.recalc("desirable", item_id);
        });

        $("#btnEnviar").click(function(e) {
            e.preventDefault();
            sum_actual = new Number(0);
            sum_desirable = new Number(0);

            total_points_actual = new Number(0);
            total_points_desirable = new Number(0);

            $.each($(".tr-item"), function() {
                n = new Number(app.points_left_actual[$(this).attr("data-id")]);
                n2 = new Number(app.points_left_desirable[$(this).attr("data-id")]);
                sum_actual += n;
                sum_desirable += n2;
                total_points_actual += 100;
                total_points_desirable += 100;
            });

            if (sum_actual == 0 && sum_desirable == 0) {
                alert('OK! enviando....');
                post_data = {};
                $.each($(".input-actual, .input-desirable"), function() {
                    post_data[$(this).attr("name")] = $(this).val();
					//console.log(post_data);
					//numbers.forEach(post_data[$(this).attr("name")]), function() {
					//	console.log("1");
					//}

                });

                post_data["uid"] = $("#uid").val();

                $.post("survey.php", post_data, function() {
                    alert('Dados enviados! Obrigado!');
                    document.location = "index.php";
                });
            } else {
                alert('Existem pontos ainda não alocados.');
            }
        });
    },

    redraw: function(what, item_id) {
        $("#points_left_" + what + "_" + item_id).html(app["points_left_" + what][item_id]);
        val = new Number(app["points_left_" + what][item_id]);
        if (val < 0) {
            $("#points_left_" + what + "_" + item_id).attr("class", "").addClass("number-negative");
            $("#btnEnviar").prop("disabled", true);
        } else {
            $("#points_left_" + what + "_" + item_id).attr("class", "");
            $("#btnEnviar").prop("disabled", false);
        }
		if (val == 0){
            $("#points_left_" + what + "_" + item_id).attr("class", "").addClass("number-zero");
		}
    },

    recalc: function(what, item_id) {
        threshold = 100;
        sum = new Number(0);
        $.each($("tr[data-id='" + item_id + "'] .input-" + what), function() {
            n = new Number($(this).val());
            sum += n;
        });
        app["points_left_" + what][item_id] = threshold - sum;
        app.redraw(what, item_id);
    }
}

$(document).ready(function() {
    app.start();
});
