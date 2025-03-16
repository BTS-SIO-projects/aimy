<?php
include('controller/rdv/listeRdvController.php');
?>
<div class="profile-header">
    <?php if (isset($_SESSION['idmedecin'])) {  ?>
        <img src="data:image/jpg;base64,<?php echo base64_encode($_SESSION['photo']); ?>" alt="Photo de Profil" width="100" height="100">
    <?php  } ?>

    <div>
        <h2> <?php
                echo "{$_SESSION['nom']} {$_SESSION['prenom']} "  ?> </h2>
        <p><?php if (!isset($_SESSION['numeroSecu'])) {
                echo "Médecin Généraliste";
            } else {
                echo "Patient";
            } ?></p>
    </div>
</div>
<div class="contact-info">
    <h3>Informations de Contact</h3>
    <p><strong>Email :</strong> <?php echo "{$_SESSION['email']} "  ?></p>
    <!--   <button class="btn" onclick="showForm('email')">Modifier</button>   -->
    <p><strong>Téléphone :</strong> <?php echo "{$_SESSION['telephone']} "  ?>
        <!--       <button class="btn" onclick="showForm('telephone')">Modifier</button>   -->
    <p><strong>Spécialité :</strong> <?php echo "{$_SESSION['specialite']} "  ?>

    <p><strong>Adresse :</strong> <?php echo "{$_SESSION['lieu']} "  ?></p>

    <!--    <button class="btn" onclick="showForm('lieu')">Modifier</button>    -->
</div>
<script>
    function showForm(type) {
        const formContainer = document.getElementById("contact-info");
        formContainer.innerHTML = `
        <center>
            <h3> ${type === 'email' ? 'email' : 'telephone'}</h3>
        </center>
        <form method="POST" action="controller/medecinController.php">
            <label for="intitule">Nouvel email :</label>
            <input type="text" id="email" name="email" required placeholder="Exemple : medecin@gmail.com">

            <input type="hidden" name="action" value="${type === 'email' ? 'ajouterEmail' : 'ajouterTelephone'}"><br>

            <button type="submit" class="btn">Valider</button>
        </form>
        `;
    }
</script>