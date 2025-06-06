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
            </tr>

            <?php foreach ($mesPatients as $patient) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($patient['nom']); ?></td>
                    <td><?php echo htmlspecialchars($patient['prenom']); ?></td>
                    <td><?php echo htmlspecialchars($patient['email']); ?></td>
                    <td><?php echo htmlspecialchars($patient['telephone']); ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <h1>Aucun patient pour le moment</h1>
    <?php } ?>
</center>