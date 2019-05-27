$(document).ready(function(){

	/*************************************************/
	/****************** EVENEMENTS *******************/
	/*************************************************/


	jQuery("#code_radio").keyup(function() {
		var code_radio = jQuery(this).val();
		envoyerAJAX(code_radio, 'code_radio');
	});
	jQuery("#user_code").keyup(function() {
		var user_code = jQuery(this).val();
		envoyerAJAX(user_code, 'user_code');
	});





	/*************************************************/
	/****************** ENVOI AJAX *******************/
	/*************************************************/



	function envoyerAJAX(code, type) {
		//tableau
		var objetJSON = {'type': type, 'code': code};

		// Serialise objet JSON
		var donneesClient = JSON.stringify(objetJSON);

		// Envoyer donnees JSON
		jQuery.ajax({type: "POST", url: "verify_exist.php", dataType: "JSON", data: 'donneesClient=' + donneesClient,
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
				if (val.code_radio == "1") {
					jQuery('#code_radio').removeClass('non').addClass('oui');
				} else {
					jQuery('#code_radio').removeClass('oui').addClass('non');
				}
				if (val.user_code == "1") {
					jQuery('#user_code').removeClass('non').addClass('oui');
					console.log(val.user_code);
				} else {
					jQuery('#user_code').removeClass('oui').addClass('non');
				}
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
