<div class="home">
    <h3><span><i class="fas fa-stethoscope"></i> AIMY :</span> service de santé</h3>
    <?php
    if (isset($_SESSION['idpatient']) || isset($_SESSION['idmedecin'])) {
        $role = isset($_SESSION['idpatient']) ? "Patient" : (isset($_SESSION['idmedecin']) ? "Médecin" : "Utilisateur");
        echo "<div class='user-info'>Bonjour, {$_SESSION['prenom']} {$_SESSION['nom']} ($role)</div>";
    }
    ?>
    <div class="contenu">
        <div class="item">
            <img src="images/agenda.jpg" height="100" width="100">
            <p> Accédez simplement et rapidement à une large communauté de praticiens.</p>
        </div>

        <div class="item">
            <img src="images/coeur.jpg" height="100" width="100">
            <p> Gérez votre santé et celle de vos proches de façon sécurisée : compte, documents, rendez-vous</p>
        </div>

        <div class="item">
            <img src="images/megaphone.jpg" height="100" width="100">
            <p> Prévenez l’apparition de maladies grâce à des messages de sensibilisation.</p>
        </div>
    </div>


    <pre>Aimy c'est...              80 millions de patients             900 000 utilisateurs professionnels         97% d'avis positifs</pre>
    <br>

    <h5><i class="fas fa-question-circle"></i> Une question ? Besoin d'aide ?</h5>
    <p><i class="fas fa-life-ring"></i> notre aide en ligne</p>
    <a href="index.php?page=faq"><button type="button">Consulter le centre aide</button></a>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("success") && urlParams.get("success") === "document_added") {
            alert("Le document a été créé avec succès !");
        }
    });
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("success") && urlParams.get("success") === "medecin_added") {
            alert("Votre demande de création de compte sera traité sous 48 heures.");
        }
    });
</script>