<center class="table-container">
    <?php if (count($mesPatients) > 0) { ?>
        <h3>Mes Patients</h3>
        <p>Nombre total de patients : <strong><?php echo count($mesPatients); ?></strong></p>

        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Message</th>
            </tr>

            <?php foreach ($mesPatients as $index => $patient) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($patient['nom']); ?></td>
                    <td><?php echo htmlspecialchars($patient['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($patient['email']); ?></td>
                    <td><?php echo htmlspecialchars($patient['telephone']); ?></td>
                    <td>
                        <button type="button" class="form-button" onclick="toggleForm(<?php echo $index; ?>)">Nouveau message</button>

                        <form method="POST" action="controller/message/messageController.php" id="form-<?php echo $index; ?>" style="display:none; margin-top:10px;">
                            <input type="hidden" name="action" value="ajouter">
                            <input type="hidden" name="idpatient" value="<?php echo $patient['idpatient']; ?>">
                            <input type="hidden" name="idmedecin" value="<?php echo $_SESSION['idmedecin']; ?>">
                            <input type="text" name="titre" placeholder="Titre" required><br>
                            <textarea name="description" placeholder="Votre message" required></textarea><br>
                            <button type="submit" class="form-button">Envoyer</button>
                            <button type="button" class="form-button" onclick="toggleForm(<?php echo $index; ?>)">Annuler</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <h1>Aucun patient pour le moment</h1>
    <?php } ?>
</center>

<script>
    function toggleForm(index) {
        const form = document.getElementById('form-' + index);
        if (form.style.display === "none" || form.style.display === "") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
</script>