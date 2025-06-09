<!-- view/admin/admin.php -->
<?php include('view/commun/header.php'); ?>

<div class="container">
    <h2>Administration AIMY - Gestion des Médecins</h2>
    
    <!-- Statistiques des médecins -->
    <div class="stats-container">
        <h3>Statistiques des Médecins</h3>
        <?php 
        $stats = ['en attente' => 0, 'valider' => 0, 'refuser' => 0, 'total' => 0];
        foreach ($medecins as $medecin) {
            $stats[$medecin['statut']]++;
            $stats['total']++;
        }
        ?>
        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="stat-number"><?= $stats['en attente'] ?></div>
                <div class="stat-label">En attente</div>
            </div>
            <div class="stat-card validated">
                <div class="stat-number"><?= $stats['valider'] ?></div>
                <div class="stat-label">Validés</div>
            </div>
            <div class="stat-card refused">
                <div class="stat-number"><?= $stats['refuser'] ?></div>
                <div class="stat-label">Refusés</div>
            </div>
            <div class="stat-card total">
                <div class="stat-number"><?= $stats['total'] ?></div>
                <div class="stat-label">Total</div>
            </div>
        </div>
    </div>

    <!-- Liste des médecins -->
    <div class="medecins-container">
        <h3>Gestion des Médecins</h3>
        <table class="medecins-table">
            <thead>
                <tr>
                    <th>NOM & PRÉNOM</th>
                    <th>EMAIL</th>
                    <th>TÉLÉPHONE</th>
                    <th>SPÉCIALITÉ</th>
                    <th>LIEU</th>
                    <th>STATUT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medecins as $medecin): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($medecin['nom']) ?> <?= htmlspecialchars($medecin['prenom']) ?></strong></td>
                    <td><?= htmlspecialchars($medecin['email']) ?></td>
                    <td><?= htmlspecialchars($medecin['telephone']) ?></td>
                    <td><?= htmlspecialchars($medecin['specialite']) ?></td>
                    <td><?= htmlspecialchars($medecin['lieu']) ?></td>
                    <td>
                        <span class="status-badge status-<?= str_replace(' ', '-', $medecin['statut']) ?>">
                            <?= ucfirst($medecin['statut']) ?>
                        </span>
                    </td>
                    <td class="actions">
                        <?php if ($medecin['statut'] == 'en attente'): ?>
                            <a href="index.php?page=admin&action=update&id=<?= $medecin['idmedecin'] ?>&statut=valider" 
                               class="btn btn-validate" 
                               onclick="return confirm('Êtes-vous sûr de vouloir valider ce médecin ?')">
                               Valider
                            </a>
                            <a href="index.php?page=admin&action=update&id=<?= $medecin['idmedecin'] ?>&statut=refuser" 
                               class="btn btn-refuse" 
                               onclick="return confirm('Êtes-vous sûr de vouloir refuser ce médecin ?')">
                               Refuser
                            </a>
                        <?php elseif ($medecin['statut'] == 'valider'): ?>
                            <a href="index.php?page=admin&action=update&id=<?= $medecin['idmedecin'] ?>&statut=refuser" 
                               class="btn btn-refuse" 
                               onclick="return confirm('Êtes-vous sûr de vouloir refuser ce médecin ?')">
                               Refuser
                            </a>
                        <?php elseif ($medecin['statut'] == 'refuser'): ?>
                            <a href="index.php?page=admin&action=update&id=<?= $medecin['idmedecin'] ?>&statut=valider" 
                               class="btn btn-validate" 
                               onclick="return confirm('Êtes-vous sûr de vouloir valider ce médecin ?')">
                               Valider
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.stats-container {
    margin-bottom: 30px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 15px;
}

.stat-card {
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    color: white;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.stat-card.pending { background: linear-gradient(135deg, #f39c12, #e67e22); }
.stat-card.validated { background: linear-gradient(135deg, #27ae60, #2ecc71); }
.stat-card.refused { background: linear-gradient(135deg, #e74c3c, #c0392b); }
.stat-card.total { background: linear-gradient(135deg, #3498db, #2980b9); }

.stat-number {
    font-size: 2.5em;
    font-weight: bold;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 1.1em;
    opacity: 0.9;
}

.medecins-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.medecins-table th {
    background: #52c4a0;
    color: white;
    padding: 15px;
    text-align: left;
    font-weight: 600;
}

.medecins-table td {
    padding: 15px;
    border-bottom: 1px solid #eee;
}

.medecins-table tr:hover {
    background-color: #f8f9fa;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.9em;
    font-weight: 500;
}

.status-en-attente {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-valider {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-refuser {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.actions {
    white-space: nowrap;
}

.btn {
    padding: 8px 16px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.9em;
    font-weight: 500;
    margin-right: 5px;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-validate {
    background-color: #28a745;
    color: white;
}

.btn-validate:hover {
    background-color: #218838;
}

.btn-refuse {
    background-color: #dc3545;
    color: white;
}

.btn-refuse:hover {
    background-color: #c82333;
}
</style>

<?php include('view/commun/footer.php'); ?>
