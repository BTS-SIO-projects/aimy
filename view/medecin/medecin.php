<?php

include('controller/specialite/specialiteController.php');
include('controller/lieu/selectAllLieux.php');

?>

<div class="inscription">
    <a id="patientLink" href="index.php?page=patient">Un patient ? Connectez-vous</a>

    <div class="forms">
        <!-- formulaire d'inscription -->
        <form method='POST' action="controller/medecin/medecinController.php" enctype="multipart/form-data">
            <h1>Inscription</h1>

            <div class="input">
                <p>Nom:</p>
                <input type="text" name="nom" placeholder="nom"><br />
            </div>

            <div class="input">
                <p>Prénom:</p>
                <input type="text" name="prenom" placeholder="prenom"><br />
            </div>

            <div class="input">
                <p>Email:</p>
                <input type="text" name="email" placeholder="email"><br />
            </div>

            <div class="input">
                <p>Numéro de téléphone:</p>
                <input type="text" name="telephone" placeholder="numéro de telephone"><br />
            </div>

            <div class="input">
                <p>Photo de profil:</p>
                <input type="file" id="url" name="photo" accept=".pdf, .jpg, .png">
            </div>
            <!--
            <div class="input">
                <input type="hidden" id="statut" name="statut" value="en attente">
            </div>
            <br>
-->
            <div class="input">
                <p>Spécialité:</p>
                <select id="specialite" name="specialite">
                    <?php
                    foreach ($lesSpecialites as $row) {
                    ?>
                        <option value="<?php echo $row['idspecialite']; ?>"><?php echo $row['categorie']; ?></option>
                    <?php
                    } ?>
                </select>
            </div>

            <div class="input">
                <p>Lieu:</p>
                <select id="lieu" name="lieu">
                    <?php
                    foreach ($lesLieux as $lieu) {
                    ?>
                        <option value="<?php echo $lieu['idlieu']; ?>"><?php echo $lieu['nom'] . " " . $lieu['adresse']; ?></option>
                    <?php
                    } ?>
                </select>
            </div>
            <div class="input">
                <p>Mot de passe:</p>
                <input type="password" name="password" placeholder="mot de passe"><br />
            </div>

            <div class="input">
                <p>Réécrivez le mot de passe:</p>
                <input type="password" name="secondpassword" placeholder="réecrivez le mot de passe"><br />
            </div>
            <input type="hidden" name="action" value="inscription">
            <button type="submit" name="InscriptionMedecin">Envoyez une demande d'inscription</button>
        </form>

        <!-- formulaire de connexion -->
        <form method='POST' action="controller/medecin/medecinController.php">
            <h1 class="connexion">Connexion</h1>

            <div class="input">
                <p>Email:</p>
                <input type="text" name="email" placeholder="email"><br />
            </div>

            <div class="input">
                <p>Mot de passe:</p>
                <input type="password" name="password" placeholder="mot de passe"><br />
            </div>
            <input type="hidden" name="action" value="connexion">
            <button type="submit" name="ConnexionMedecin">Se connecter !</button>
        </form>
    </div>
    
    <!-- Lien de connexion administrateur -->
    <div class="admin-link">
        <a href="index.php?page=admin_login" id="adminLink">
            Connexion Administrateur
        </a>
    </div>

</div>

<style>
.admin-link {
    text-align: center;
    margin-top: 30px;
    padding: 20px;
    border-top: 1px solid #e0e0e0;
}

#adminLink {
    display: inline-block;
    padding: 12px 24px;
    border: 1px solid #2a9d8f;
    border-radius: 8px;
    background-color: white;
    color: #2a9d8f;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
}

#adminLink:hover {
    background-color: #2a9d8f;
    color: white;
}

#adminLink:active {
    background-color: #2a9d8f;
}
</style>