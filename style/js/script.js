// Récupérer le modal
var modalPatient = document.getElementById("patientModal");
var modalMedecin = document.getElementById("medecinModal");

// Récupérer le bouton qui ouvre le modal
var btnPatient = document.getElementById("openPatientBtn");
var btnMedecin = document.getElementById("openMedecinBtn");

// Récupérer l'élément <span> qui ferme le modal
var spanPatient = document.getElementsByClassName("close")[0];
var spanMedecin = document.getElementsByClassName("close")[0];

// Lorsque l'utilisateur clique sur le bouton, ouvrir le modal 
btnPatient.onclick = function () {
    modalPatient.style.display = "block";
}

// Lorsque l'utilisateur clique sur <span> (x), fermer le modal
spanPatient.onclick = function () {
    modalPatient.style.display = "none";
}

// Lorsque l'utilisateur clique n'importe où en dehors du modal, fermer le modal
window.onclick = function (event) {
    if (event.target == modalMedecin) {
        modalPatient.style.display = "none";
    }
}
// Lorsque l'utilisateur clique sur le bouton, ouvrir le modal 
btnMedecin.onclick = function () {
    modalMedecin.style.display = "block";
}

// Lorsque l'utilisateur clique sur <span> (x), fermer le modal
spanMedecin.onclick = function () {
    modalMedecin.style.display = "none";
}

// Lorsque l'utilisateur clique n'importe où en dehors du modal, fermer le modal
window.onclick = function (event) {
    if (event.target == modalMedecin) {
        modalMedecin.style.display = "none";
    }
}


function showForm(type) {
    const formContainer = document.getElementById("contact-info");
    formContainer.innerHTML = `
			<center><h3> ${type === 'email' ? 'email' : 'telephone'}</h3></center>
			<form method="POST" action="controller/medecinController.php">
				<label for="intitule">Nouvel email :</label>
				<input type="text" id="email" name="email" required placeholder="Exemple : medecin@gmail.com">
	
				<input type="hidden" name="action" value="${type === 'email' ? 'ajouterEmail' : 'ajouterTelephone'}"><br>

				<button type="submit" class="btn">Valider</button>
			</form>
		`;
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".toggle-docs").forEach(button => {
        button.addEventListener("click", function () {
            let idRdv = this.getAttribute("data-id");
            let row = document.getElementById("docs-" + idRdv);
            if (row.style.display === "none") {
                row.style.display = "table-row";
                this.textContent = "Masquer documents";
            } else {
                row.style.display = "none";
                this.textContent = "Voir documents";
            }
        });
    });
});
