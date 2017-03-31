$( document ).ready(function() {
    var tabProprio = [];

    $("#ville_logements").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "http://192.168.152.1/ajax/recupVilles/"+request.term,
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

    $("#nom_proprietaire").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "http://192.168.152.1/ajax/recupProprietaires/"+request.term,
                dataType: 'json',
                success: function (data) {
                    tabProprio = data;
                    var affichage = [], sexe = "";
                    $.each(data, function(i, obj) {
                        
                        switch (obj.sexe_proprietaires){
                            case "M":
                                sexe = "M.";
                                break;
                            case "F":
                                sexe = "Mme.";
                                break;
                        }
                        affichage.push({ label: (sexe + " " + obj.prenom_proprietaires + " " + obj.nom_proprietaires), indice: i});
                    });
                    response(affichage);
                },
                error: function () {
                    response([]);
                }
            });
        },
        select: function (event, ui) {
            $("#nom_proprietaire").val(tabProprio[ui.item.indice].nom_proprietaires);
            $("#prenom_proprietaire").val(tabProprio[ui.item.indice].prenom_proprietaires);
            $("#sexe_proprietaire").val(tabProprio[ui.item.indice].sexe_proprietaires);
            $("#rue_logements").focus();
            event.preventDefault();
        }
    });
    
    $("#prenom_proprietaire").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "http://192.168.152.1/ajax/recupProprietaires/"+request.term,
                dataType: 'json',
                success: function (data) {
                    tabProprio = data;
                    var affichage = [], sexe = "";
                    $.each(data, function(i, obj) {
                        
                        switch (obj.sexe_proprietaires){
                            case "M":
                                sexe = "Mr.";
                                break;
                            case "F":
                                sexe = "Mme.";
                                break;
                        }
                        affichage.push({ label: (sexe + " " + obj.prenom_proprietaires + " " + obj.nom_proprietaires), indice: i});
                    });
                    response(affichage);
                },
                error: function () {
                    response([]);
                }
            });
        },
        select: function (event, ui) {
            $("#nom_proprietaire").val(tabProprio[ui.item.indice].nom_proprietaires);
            $("#prenom_proprietaire").val(tabProprio[ui.item.indice].prenom_proprietaires);
            $("#sexe_proprietaire").val(tabProprio[ui.item.indice].sexe_proprietaires);
            $("#rue_logements").focus();
            event.preventDefault();
        }
    });
    
    $("#libelle_motifs").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "http://192.168.152.1/ajax/recupMotifs/"+request.term,
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
	
	cacherDivs($("input[name='type_logements']:checked"));
	$("input[name='type_logements']").change(function() {
		cacherDivs(this);
	});

	function cacherDivs(obj) {
		$("#appartement").hide();
		$("#chambre").hide();
		$("#studio").hide();
		var val = $(obj).attr('id');
		if (val == 'type_logements_1')
			$("#appartement").show();
		else if (val == 'type_logements_2')
			$("#chambre").show();
		else if (val == 'type_logements_3')
			$("#studio").show();
	}
});
