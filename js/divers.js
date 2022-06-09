function CocheTout(ref, name) {
	var form = ref;

	while (form.parentNode && form.nodeName.toLowerCase() != 'form'){
		form = form.parentNode;
	}

	var elements = form.getElementsByTagName('input');

	for (var i = 0; i < elements.length; i++) {
		if (elements[i].type == 'checkbox' && elements[i].name == name) {
			elements[i].checked = ref.checked;
		}
	}
}

//******************************************************
$(document).ready(function () {

	// CLIENT
	$("a.MembreFamilleClieSupp1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheMembreFamille").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.MembreFamilleClieSupp2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheMembreFamille").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.MembreFamilleSupp1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheMembreFamille").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.MembreFamilleSupp2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheMembreFamille").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheListeClient").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheListeClient").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheClieAjou").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheClieAjou").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ClieSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ClieSupp").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheCompletForfait").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheCompletForfait").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheForfClie").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheForfClie").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ForfSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheForfList").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ForfModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ForfModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ForfClieSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheForfClientsAssocies").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ForfRetirerHeure").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ForfRetirerHeure").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ForfSuppConf").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ForfSuppConf").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ForfClieHeureAjou").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ForfClieHeureAjou").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheProfil1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheProfil1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ForfSortNumSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheForfList").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});


	$("a.AfficheFicheProfil2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheProfil2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});

	$("a.AfficheProfilAvoirSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheProprietaire").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ProfilIdentifiants1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ProfilIdentifiants1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ProfilIdentifiants2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ProfilIdentifiants2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.profilAjouChevAvoir").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#profilAjouChevAvoir").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});

	// FACTURE
	$("a.AfficheFactAuto2PrestAjou").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactAuto2PrestAjou").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactAutoPrestSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#FactAuto2List").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFactAuto1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactAuto1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFactAuto2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheFacture2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFactRechercher").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactRechercher").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheFacture1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheFacture1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheFacture2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheFacture2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheEnvoiMail").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheEnvoiMail").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheCaleEnvoiMail").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCalendrier").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});

	$("a.AfficheFactDupliquer").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactDupliquer").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFactCreeAvoir").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactCreeAvoir").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheCaissePrestations").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCaissePrestations").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheCaisseAjouPrestations").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCaisseAjouPrestations").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaissePrestationSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCaisseAjouPrestations").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AffichePrestModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AffichePrestModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheEncaissement1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheEncaissement1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheEncaissement2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheEncaissement2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheEncaissementCate").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheListeEncaissement").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheEncaissementSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheEncaissementPageComplet").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});

	$("a.AfficheFicheDepense1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheDepense1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheDepense2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheDepense2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.PasserEnFacture2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheFacture2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.SupprimerFacture").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactureComplet").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactPrestModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactPrestModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactClieModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactClieModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactDateModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactDateModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactPrestSupp2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheFacture2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactPrestAjou").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactPrestAjou").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.Afficheconfentr1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#Afficheconfentr1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.Afficheconfentr2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#Afficheconfentr2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactConditionModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#FactConditionModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactConditionModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#FactConditionModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactAjouter").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#FactAjouter").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactAutoAjouter").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#FactAutoAjouter").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactEncAjouter").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#FactEncAjouter").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheListFactureBis").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheListFactureBis").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaissePayerTotal").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#CaissePayerTotal").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.Afficheconffacturation").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#Afficheconffacturation").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaisseListePrestations").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#CaisseListePrestations").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.Afficheconfcaisse").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#Afficheconfcaisse").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFactClie").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactClie").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.FactPrestSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactPrestations").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFactClieGroupe").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFactClieGroupe").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CateCaleNumModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#CateCaleNumModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});

	// CALENDRIER
	$("a.AfficheCaleReservation").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCaleReservation").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheCaleClieFichComplet").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheProfil1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaleCondSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCalePrestations").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheMode").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCalendrier").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaleMontoirCavaSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFichMontoir").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ModeleFicheComplet1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ModeleFicheComplet1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ModeleFicheComplet2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ModeleFicheComplet2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ModeleClientsSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ModeleClientsSupp").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ModeleRepliquer").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ModeleRepliquer").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ModeleRepliquerAjou").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ModeleRepliquerAjou").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ModeleSupp1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ModeleSupp1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ModeleSupp2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheModele").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ModeleModifConfirme").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ModeleModifConfirme").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.ModeleDateExclu").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#ModeleDateExclusion").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaleReservationAffiche").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#CaleReservationAffiche").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaleSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCalendrier").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheModeleList").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheModele").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaleAjouCavalierDePassage1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#CaleAjouCavalierDePassage1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});

	// DIVERS
	$("a.CommGeneAffiche").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCommentairesGenerals").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CommGeneSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCommentairesGenerals").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.GroupAjouAffiche").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#GroupAjouAffiche").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.GroupeTelecharger2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#GroupeTelecharger2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});

	// PROFIL
	$("a.AfficheCaleClie").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCaleClie").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});

	// CONFIGURATION
	$("a.VacanceScolaire").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AffichePeriodeVacanceScolaire").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CateCaleTypePrestNumSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
  $("#noteAfficheCaleCateTypePrest").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
  $("a.CateCaleNumSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
  $("#noteAfficheCaleCate").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
  $("a.CateNiveauNumSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
  $("#noteAfficheCaleNiveau").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CateDisciplineNumSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
  $("#noteAfficheCaleDiscipline").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheDocumod1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
  $("#AfficheFicheDocumod1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheDocumod2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheDocuments").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});


	// PRESTATION
	$("a.AffichePrestationFicheComplet").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFichePrestation").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AffichePrestationFicheComplet1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AffichePrestationFicheComplet1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AffichePrestationCatAjou").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AffichePrestationCatAjou").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AffichePrestationAjou").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AffichePrestationAjou").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheTypePrestationCatNum").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheListeTypePrestation").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AffichePrestationPrixSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AffichePrestationPrix").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AffichePrestationPrixModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AffichePrestationPrixModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AffichePrestationComplet").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AffichePrestationComplet").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheListeTypePrestationCat").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheListeTypePrestationCat").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaleAjouter").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#CaleAjouter").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheCaleFichComplet").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCalendrier").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CalePointage").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCalendrier").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CalePointage1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#CalePointage").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaleDebit").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCalendrier").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaleDebit1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFichMontoir").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CaleModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheCalendrier").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.CalePartCava").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#CalePartCava").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheMontoirCava").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheMontoirCava").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheClieModif").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheClieModif").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheGroupe1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheGroupe1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheGroupe2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheFicheGroupe2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.GroupeAssociationSupp").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheGroupeAssociation").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.GroupeSupp1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#GroupeSupp1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.GroupeSupp2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheGroupeComplet").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.GroupeSupp3").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#AfficheGroupe").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.PrestationAjouPrix").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#PrestationAjouPrix").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});

	$("a.Inscription1").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#Inscription1").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.Inscription2").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#Inscription2").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.Inscription3").off('click').click(function(e) {e.stopPropagation();$('.preloader').addClass('active');
	$("#Inscription3").load(this.href, function(response, status){if(status === 'success'){$('.preloader').removeClass('active');}else{alert('Une erreur est survenue, veuillez contacter Equimondo.');$('.preloader').removeClass('active');}});return false;});
	$("a.AfficheFicheDocument1").off('click').click(function(e)
	{e.stopPropagation();
	$('.preloader').addClass('active');

	new Quill('#quillEditor', {
		theme: 'snow'
	  });


		$("#AfficheFicheDocument1").load(this.href, function(response, status){
		if(status === 'success'){
			$('.preloader').removeClass('active');}
		else{alert('Une erreur est survenue, veuillez contacter Equimondo.');
		$('.preloader').removeClass('active');}});return false;});


		var modal = $('#modalDialog');

		// Get the button that opens the modal
		var btn = $("#mbtn");

		// Get the <span> element that closes the modal
var span = $(".close");

$(document).ready(function(){
			// When the user clicks the button, open the modal
			btn.on('click', function() {
				modal.show();
			});

			// When the user clicks on <span> (x), close the modal
			span.on('click', function() {
			modal.hide();
		});
		});

// When the user clicks anywhere outside of the modal, close it
$('body').bind('click', function(e){
			if($(e.target).hasClass("modal")){
			modal.hide();
		}
		});


	// $("a.LoadPage")
	// .each(function(i){
	// 	$(this)
	// 	.href(this.href.replace("mapage", "mapage_fragment"))
	// });

});

var quill = new Quill('#quillEditor', {
    theme: 'snow'
  });

//**********************************************************************************************
