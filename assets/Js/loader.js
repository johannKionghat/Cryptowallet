// Sélectionnez l'élément du loader par son ID
var loader = document.getElementById('loader');

// Affichez le loader
function showLoader() {
    loader.style.display = 'block';
}

// Masquez le loader
function hideLoader() {
    loader.style.display = 'none';
}
// Afficher le loader avant d'envoyer la requête AJAX
showLoader();

// Envoyer la requête AJAX
$.ajax({
    url: 'votre/url',
    type: 'GET',
    success: function(response) {
        // Traitement de la réponse
    },
    complete: function() {
        // Masquer le loader une fois la requête terminée
        hideLoader();
    }
});// Afficher le loader avant d'envoyer la requête AJAX
showLoader();

