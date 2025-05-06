<?php
include("controller/document/documentController.php");
?>

<div id="document-container">
    <h1 id="document-title">Gérez vos documents médicaux</h1>
    <p id="document-description">
        Conservez vos documents et vos informations de santé dans un endroit sécurisé.
        Partagez-les avec les praticiens lors de la prise de rendez-vous.
    </p>
    <form id="document-form" method="post" action="controller/document/documentController.php" enctype="multipart/form-data">
        <label for="idrdv">Rdv :</label>
        <select id="idrdv" name="idrdv" required>
            <?php
            foreach ($lesRdvs as $leRdv) {
                if (isset($_SESSION['idmedecin'])) {
                    $lePatient = $patient->selectWherePatient($leRdv['idpatient']);
            ?>
                    <option value="<?php echo $leRdv['idrdv']; ?>">
                        <?php echo $leRdv['daterdv'] . ", " . $leRdv['heureRdv'] . ", " . $lePatient['nom'] . " " . $lePatient['prenom']; ?>
                    </option>
                <?php
                } else {
                    $leMedecin = $medecin->selectWhereMedecin($leRdv['idmedecin']);
                ?>
                    <option value="<?php echo $leRdv['idrdv']; ?>">
                        <?php echo $leRdv['daterdv'] . ", " . $leRdv['heureRdv'] . ", " . $leMedecin['nom'] . " " . $leMedecin['prenom']; ?>
                    </option>
                <?php
                }
                ?>
            <?php
            } ?>
        </select>
        <br>
        <label for="url">Ajouter un fichier :</label>
        <input type="file" id="url" name="url" accept=".pdf, .jpg, .png">
        <label for="description">Quel est ce document :</label>
        <input type="text" id="description" name="description" required>
        <br>
        <!-- Champs cachés pour transmettre les données -->
        <?php if (isset($_SESSION['idpatient'])) { ?>
            <input type="hidden" name="idpatient" value="<?php echo $_SESSION['idpatient']; ?>">
        <?php } else { ?>
            <input type="hidden" name="idmedecin" value="<?php echo $_SESSION['idmedecin']; ?>">
        <?php } ?>
        <input type="hidden" name="action" value="ajouter">

        <input id="document-submit" type="submit" name="Valider" value="Valider">
    </form>
</div>