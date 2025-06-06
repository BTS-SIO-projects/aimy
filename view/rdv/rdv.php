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
                <input type="time" id="heurerdv" name="heurerdv" step="3600" required>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('daterdv');
        const timeInput = document.getElementById('heurerdv');

        // Si les champs ne sont pas présents (autre page), on ne fait rien
        if (!dateInput || !timeInput) return;

        // Empêcher la sélection de jours passés
        const today = new Date().toISOString().split('T')[0];
        dateInput.setAttribute('min', today);

        // Bloquer les week-ends
        dateInput.addEventListener('input', function() {
            if (!this.value) return; // évite erreur si champ vide

            const selectedDate = new Date(this.value);

            if (isNaN(selectedDate.getTime())) return; // évite erreur si date invalide

            const day = selectedDate.getDay();

            if (day === 0 || day === 6) {
                alert('Les rendez-vous ne peuvent pas être pris le week-end.');
                this.value = '';
            }
        });

        // Bloquer les horaires hors plage et les minutes ≠ 00
        timeInput.addEventListener('input', function() {
            if (!this.value || !this.value.includes(':')) return;

            const [hourStr, minuteStr] = this.value.split(':');
            const hour = parseInt(hourStr, 10);
            const minutes = parseInt(minuteStr, 10);

            if (isNaN(hour) || isNaN(minutes)) return;

            if (hour < 8 || hour > 19) {
                alert('Veuillez choisir une heure entre 08:00 et 19:00.');
                this.value = '';
            } else if (minutes !== 0) {
                alert('Seules les heures pleines sont autorisées (ex: 09:00, 10:00...).');
                this.value = '';
            }
        });

    });
</script>