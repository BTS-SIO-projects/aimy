<!-- view/medecin/liste_patients.php -->
<?php
include('controller/medecin/selectAllMedecins.php');
?>
<center class="table-container">
    <h3>Mes Patients</h3>
    
    <!-- Formulaire de recherche -->
    <div class="search-container">
        <form method="GET" action="">
            <input type="hidden" name="page" value="liste_patients">
            <input type="text" name="search" placeholder="Rechercher par nom ou prénom..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Rechercher</button>
            <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
                <a href="?page=liste_patients" class="btn btn-secondary btn-sm">Réinitialiser</a>
            <?php endif; ?>
        </form>
    </div>
    
    <?php if (count($mesPatients) > 0) { ?>
        <p>Nombre total de patients : <strong><?php echo count($mesPatients); ?></strong>
        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
            <small>(Filtré par : "<?php echo htmlspecialchars($_GET['search']); ?>")</small>
        <?php endif; ?>
        </p>

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
        <p>Aucun patient trouvé
        <?php if(isset($_GET['search']) && !empty($_GET['search'])): ?>
            pour la recherche "<?php echo htmlspecialchars($_GET['search']); ?>"
        <?php endif; ?>
        </p>
    <?php } ?>
</center>
