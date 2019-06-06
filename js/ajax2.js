$(document).ready(function(){

	/*************************************************/
	/****************** EVENEMENTS *******************/
	/*************************************************/
	nom_societe = jQuery("#nom_societe").val();
	departement = jQuery('#departement').val();


	jQuery("#departement").click(function() {
		nom_societe = jQuery("#nom_societe").val();
		departement = jQuery('#departement').val();

		envoyerAJAX(nom_societe, departement);
	});

	jQuery("#nom_societe").click(function() {
		nom_societe = jQuery("#nom_societe").val();
		departement = jQuery('#departement').val();

		envoyerAJAX(nom_societe, departement);
	});





	/*************************************************/
	/****************** ENVOI AJAX *******************/
	/*************************************************/



	function envoyerAJAX(nom_societe, departement) {
		//tableau
		var objetJSON = {'nom_societe': nom_societe, 'departement': departement};

		// Serialise objet JSON
		var donneesClient = JSON.stringify(objetJSON);

		// Envoyer donnees JSON
		jQuery.ajax({type: "POST", url: "get_mag_info.php", dataType: "JSON", data: 'donneesClient=' + donneesClient,
			success: function(donneesServeur) {
				// Traiter reponse serveur
				recevoirAJAX1(donneesServeur);
			}
		});
	}





	/*************************************************/
	/**************** RECEPTION AJAX *****************/
	/*************************************************/

	// AJAX 1
	function recevoirAJAX1(donneesServeur) {
		// Tableau de données
		if (defined(donneesServeur)) {
			for (val of donneesServeur) {
				jQuery("#mail_admin").val(val.mail_admin);
				jQuery('#ip_reseau').val(val.ip_reseau);
			}
		}
	}




	/*************************************************/
	/******************** UTILES *********************/
	/*************************************************/



	// Teste si une variable est définie
	function defined(myVar) {
		if (typeof myVar != 'undefined') return true;
		return false;
	}


});
