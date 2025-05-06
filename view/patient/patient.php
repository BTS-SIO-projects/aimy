<div class="inscription">
    <a id="medecinLink" href="index.php?page=medecin">Un professionnel ? Connectez-vous</a>

    <!-- formulaire d'inscription -->
    <div class="forms">
        <form action='controller/patient/patientController.php' method='POST'>
            <h1>Inscription</h1>

            <input type="hidden" name="role" value="patient">

            <div class="input">
                <p>Nom:</p>
                <input type="text" name="nom" placeholder="nom"><br />
            </div>

            <div class="input">
                <p>Prénom:</p>
                <input type="text" name="prenom" placeholder="prenom"><br />
            </div>

            <div class="input">
                <p>Age:</p>
                <input type="number" name="age" placeholder="âge"><br />
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
                <p>Adresse:</p>
                <input type="text" name="adresse" placeholder="adresse"><br />
            </div>

            <div class="input">
                <p>Numéro de Sécurité Sociale:</p>
                <input type="text" name="numeroSecu" placeholder="numero de Sécurité Sociale"><br />
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
            <button type="submit" name="InscriptionPatient">S'inscrire</button>
        </form>

        <!-- formulaire de connexion -->
        <form action='controller/patient/patientController.php' method='POST'>
            <h1 class="connexion">Connexion</h1>

            <div class="input">
                <p>Numéro de Sécurité Sociale:</p>
                <input type="text" name="numeroSecu" placeholder="numeroSecu"><br />
            </div>

            <div class="input">
                <p>Mot de passe:</p>
                <input type="password" name="password" placeholder="mot de passe"><br />
            </div>
            <input type="hidden" name="action" value="connexion">
            <button type="submit" name="ConnexionPatient">Se connecter !</button>

        </form>
    </div>
</div>