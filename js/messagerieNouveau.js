$(document).ready(function()
{
	var tabEtu = [];
	
	$("#destinataire_messages").autocomplete({
		source: function (request, response) {
			$.ajax({
				url: "http://192.168.152.1/ajax/recup-etudiants/" + request.term,
				dataType: 'json',
				success: function(data) {
					tabEtu = data;
					var affichage = [], sexe = "";
					$.each(data, function(i, obj) {
						switch (obj.sexe_etudiants){
							case "M":
								sexe = "M.";
								break;
							case "F":
								sexe = "Mme.";
								break;
						}
						affichage.push({ label: (sexe + " " + obj.prenom + " " + obj.nom), indice: i});
					});
					response(affichage);
				},
				error: function () {
					response([]);
				}
			});
		},
		select: function (event, ui) {
			$("#destinataire_messages").val(tabEtu[ui.item.indice].nomUtilisateur);
			$("#sujet_messages").focus();
			event.preventDefault();
		}
	});
});