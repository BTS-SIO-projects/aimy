<!-- Partie Parametres  -->
<div id="mid">
    <h1>Editer votre profil</h1>
</div>
<form enctype="multipart/form-data" action="controller/patient/parametreController.php" method='POST'>

    <!-- changer sa pfp -->
    <?php
    if (isset($_SESSION['idmedecin'])) {
    ?>
        <div class="edit">
            <label for="lienImage">changer de photo de profil</label>
            <input type="file" accept="image/*" name="lienImage" id="file">
            <input type="submit" name="validerPfp" value="valider"><br>

        <?php } ?>
        <!-- changer son nom -->
        <input type="submit" name="nomSuivant" value="changer de nom">
        <?php
        if (isset($_POST['nomSuivant']) and !isset($_POST['annulerNom'])) { ?>
            <input type="text" name="nouveauNom" placeholder="Nom">
            <input type="submit" name="sauvegarderNom" value="sauvegarder">
            <input type="submit" name="annulerNom" value="annuler"><br>
        <?php    } ?>
        <!-- changer son prenom -->
        <input type="submit" name="prenomSuivant" value="changer de prénnom">
        <?php
        if (isset($_POST['prenomSuivant']) and !isset($_POST['annulerPrenom'])) { ?>
            <input type="text" name="nouveauPrenom" placeholder="Prénom">
            <input type="submit" name="sauvegarderPrenom" value="sauvegarder">
            <input type="submit" name="annulerPrenom" value="annuler"><br>
        <?php    } ?>

        <!-- passer en mode nuit (changer le css) -->
        <p>Mode sombre</p>
        <select name="modeSombre" onchange="setModeSombre(this)">
            <option value="Activé" <?php if (isset($_COOKIE['modeSombre']) && $_COOKIE['modeSombre'] == 'Activé') echo 'selected'; ?>>Activé</option>
            <option value="Désactivé" <?php if (!isset($_COOKIE['modeSombre']) || $_COOKIE['modeSombre'] == 'Désactivé') echo 'selected'; ?>>Désactivé</option>
        </select>
        <input type="submit" name="sombre" value="Enregistrer">
        <!-- setModeSombre est appelée lorsqu'un nouvel élément est sélectionné dans le menu déroulant 
	Cette fonction stocke la valeur sélectionnée dans un cookie nommé "modeSombre" qui est valide pour l'ensemble du site (path=/)
	Lorsque la page est chargée, les options du menu déroulant sont générées avec PHP et la valeur sélectionnée est rétablie
	à partir du cookie si elle correspond à la valeur stockée dans le cookie.-->
        <script>
            function setModeSombre(selectElem) {
                var selectedValue = selectElem.value;
                document.cookie = "modeSombre=" + selectedValue + "; path=/";
            }
        </script>


        <!-- changer son mot de passe -->
        <br><input type="submit" name=" mdpSuivant" value="changer de mot de passe">
        <?php
        if (isset($_POST['mdpSuivant']) and !isset($_POST['annulerMdp'])) { ?>
            <input type="password" name="ancienMdp" placeholder="ancien mot de passe">
            <input type="password" name="nouveauMdp" placeholder="nouveau mot de passe">
            <input type="submit" name="sauvegarderMdp" value="sauvegarder">
            <input type="submit" name="annulerMdp" value="annuler">
        <?php }
        echo "<p>" . $error . "</p>";
        ?>
        <!-- supprimer son compte -->
        <input type="submit" name="delete" value="Supprimer mon compte">
        <?php if (isset($_POST['delete'])) { ?>
            <p>Êtes-vous sûr ?</p>
            <input type="submit" name="oui" value="oui">
            <input type="submit" name="non" value="non">
        <?php    } ?>
        </div>
</form>