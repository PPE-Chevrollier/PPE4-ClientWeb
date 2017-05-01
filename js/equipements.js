$( document ).ready(function() {
	$("#libelle_equipements").autocomplete({
		source: function (request, response) {
            $.ajax({
                url: "/ajax/recup-equipements/"+request.term,
                dataType: 'json',
                success: function (data) {
                    response(data);
                },
                error: function () {
                    response([]);
                }
            });
        }
    });
});