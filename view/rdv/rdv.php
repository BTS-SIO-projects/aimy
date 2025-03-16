<?php
include('controller/lieu/selectAllLieux.php');
include('controller/medecin/selectAllMedecins.php');

?>

<div class="rdv">
    <a id="listeRdvLink" href="index.php?page=liste_rdv">Liste de vos rendez-vous</a><br>
    <h2 class="form-title">Ajout d'un rendez-vous</h2>
    <div class="form-container">
        <form method="POST" action="controller/rdv/rdvController.php">
            <?php if (isset($_SESSION['idpatient'])) { ?>
                <input type="hidden" name="idpatient" value="<?php echo $_SESSION['idpatient']; ?>">
            <?php } else { ?>
                <div class="form-group">
                    <label for="idpatient">Patient :</label>
                    <select id="idpatient" name="idpatient" required>
                        <?php foreach ($lesPatients as $lePatient) { ?>
                            <option value="<?php echo $lePatient['idpatient']; ?>">
                                <?php echo $lePatient['nom'] . " " . $lePatient['prenom']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <input type="hidden" name="idmedecin" value="<?php echo $_SESSION['idmedecin']; ?>">
            <?php } ?>
            <!-- Date -->
            <div class="form-group">
                <label for="daterdv">Date :</label>
                <input type="date" id="daterdv" name="daterdv" required>
            </div>

            <!-- Heure -->
            <div class="form-group">
                <label for="heurerdv">Heure :</label>
                <input type="time" id="heurerdv" name="heurerdv" required>
            </div>

            <!-- Motif -->
            <div class="form-group">
                <label for="motif">Motif :</label>
                <input type="text" id="motif" name="motif" placeholder="Motif de la consultation" required>
            </div>

            <!-- Lieu -->
            <div class="form-group">
                <label for="idlieu">Lieu :</label>
                <select id="idlieu" name="idlieu" required>
                    <?php foreach ($lesLieux as $leLieu) { ?>
                        <option value="<?php echo $leLieu['idlieu']; ?>">
                            <?php echo $leLieu['typeLieu'] . ": " . $leLieu['adresse']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Médecin -->
            <?php if (isset($_SESSION['idpatient'])) { ?>
                <div class="form-group">
                    <label for="idmedecin">Médecin :</label>
                    <select id="idmedecin" name="idmedecin" required>
                        <?php foreach ($lesMedecins as $leMedecin) { ?>
                            <option value="<?php echo $leMedecin['idmedecin']; ?>">
                                <?php echo $leMedecin['nom'] . " " . $leMedecin['prenom']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>

            <!-- Bouton Ajouter -->
            <div class="form-group">
                <input type="hidden" name="statut" value="en attente">
                <input type="hidden" name="action" value="ajouter">
                <button type="submit" name="AjouterRdv" class="form-button">Ajouter</button>
            </div>
        </form>
    </div>

</div>