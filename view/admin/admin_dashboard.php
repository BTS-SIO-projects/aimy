<?php
// Vérification de l'authentification admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: index.php?page=admin_login");
    exit();
}

include_once('controller/medecin/selectAllMedecins.php');
include_once('controller/specialite/specialiteController.php');
include_once('controller/lieu/selectAllLieux.php');

// Traitement des actions de validation/refus
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $medecin_id = intval($_GET['id']);
    
    if ($action === 'valider' || $action === 'refuser') {
        $nouveau_statut = ($action === 'valider') ? 'valider' : 'refuser';
        
        try {
            include_once('bdd/bdd.php');
            $stmt = $bdd->prepare("UPDATE medecin SET statut = :statut WHERE idmedecin = :id");
            $stmt->bindParam(':statut', $nouveau_statut);
            $stmt->bindParam(':id', $medecin_id);
            $stmt->execute();
            
            $message = ($action === 'valider') ? "Médecin validé avec succès!" : "Médecin refusé.";
            echo "<script>alert('$message'); window.location.href='index.php?page=admin_dashboard';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Erreur lors de la mise à jour.'); window.location.href='index.php?page=admin_dashboard';</script>";
        }
    }
}

// Récupération des médecins avec leurs informations complètes
try {
    include_once('bdd/bdd.php');
    $stmt = $bdd->prepare("
        SELECT m.*, s.categorie as specialite_nom, l.nom as lieu_nom, l.adresse as lieu_adresse
        FROM medecin m 
        LEFT JOIN specialite s ON m.idspecialite = s.idspecialite 
        LEFT JOIN lieu l ON m.idlieu = l.idlieu 
        ORDER BY 
            CASE m.statut 
                WHEN 'en attente' THEN 1 
                WHEN 'valider' THEN 2 
                WHEN 'refuser' THEN 3 
            END, 
            m.nom, m.prenom
    ");
    $stmt->execute();
    $medecins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $medecins = [];
    $error_message = "Erreur lors de la récupération des données.";
}

// Calcul des statistiques
$stats = [
    'en_attente' => 0,
    'valider' => 0,
    'refuser' => 0,
    'total' => count($medecins)
];

foreach ($medecins as $medecin) {
    if (isset($stats[$medecin['statut']])) {
        $stats[$medecin['statut']]++;
    }
}
?>

<div class="admin-dashboard">
    <!-- En-tête administrateur -->
    <div class="admin-header">
        <h2>Administration AIMY</h2>
        <div class="admin-user-info">
            <span>Connecté en tant que: <strong><?php echo $_SESSION['admin_prenom'] . ' ' . $_SESSION['admin_nom']; ?></strong></span>
            <a href="index.php?page=deconnexion" class="btn-deconnexion">
                Déconnexion
            </a>
        </div>
    </div>

    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- Statistiques -->
    <div class="stats-section">
        <h3>Statistiques des Médecins</h3>
        <div class="stats-grid">
            <div class="stat-card stat-pending">
                <div class="stat-number"><?php echo $stats['en_attente']; ?></div>
                <div class="stat-label">En attente</div>
            </div>
            <div class="stat-card stat-approved">
                <div class="stat-number"><?php echo $stats['valider']; ?></div>
                <div class="stat-label">Validés</div>
            </div>
            <div class="stat-card stat-rejected">
                <div class="stat-number"><?php echo $stats['refuser']; ?></div>
                <div class="stat-label">Refusés</div>
            </div>
            <div class="stat-card stat-total">
                <div class="stat-number"><?php echo $stats['total']; ?></div>
                <div class="stat-label">Total</div>
            </div>
        </div>
    </div>

    <!-- Liste des médecins -->
    <div class="medecins-section">
        <h3>Gestion des Médecins</h3>
        
        <?php if (empty($medecins)): ?>
            <div class="no-medecins">
                <p>Aucun médecin enregistré pour le moment.</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table class="medecins-table">
                    <thead>
                        <tr>
                            <th>Nom & Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Spécialité</th>
                            <th>Lieu</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medecins as $medecin): ?>
                            <tr class="row-<?php echo str_replace(' ', '-', $medecin['statut']); ?>">
                                <td class="medecin-name">
                                    <strong><?php echo htmlspecialchars($medecin['nom'] . ' ' . $medecin['prenom']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($medecin['email']); ?></td>
                                <td><?php echo htmlspecialchars($medecin['telephone']); ?></td>
                                <td><?php echo htmlspecialchars($medecin['specialite_nom'] ?? 'Non spécifiée'); ?></td>
                                <td>
                                    <?php echo htmlspecialchars($medecin['lieu_nom'] ?? 'Non spécifié'); ?>
                                    <?php if ($medecin['lieu_adresse']): ?>
                                        <br><small><?php echo htmlspecialchars($medecin['lieu_adresse']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo str_replace(' ', '-', $medecin['statut']); ?>">
                                        <?php echo ucfirst($medecin['statut']); ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <?php if ($medecin['statut'] === 'en attente'): ?>
                                        <a href="index.php?page=admin_dashboard&action=valider&id=<?php echo $medecin['idmedecin']; ?>" 
                                           class="btn-action btn-valider" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir valider ce médecin ?')">
                                            Valider
                                        </a>
                                        <a href="index.php?page=admin_dashboard&action=refuser&id=<?php echo $medecin['idmedecin']; ?>" 
                                           class="btn-action btn-refuser" 
                                           onclick="return confirm('Êtes-vous sûr de vouloir refuser ce médecin ?')">
                                            Refuser
                                        </a>
                                    <?php else: ?>
                                        <span class="no-action">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
/* Styles pour l'administration - Cohérent avec la charte graphique AIMY */
.admin-dashboard {
    min-height: 90vh;
    padding: 20px;
    background-color: #f5f5f5;
    font-family: 'Arial', sans-serif;
}

.admin-header {
    background-color: #2a9d8f;
    color: white;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.admin-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
}

.admin-user-info {
    display: flex;
    align-items: center;
    gap: 15px;
}

.btn-deconnexion {
    background-color: rgba(255,255,255,0.2);
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.btn-deconnexion:hover {
    background-color: rgba(255,255,255,0.3);
    color: white;
    text-decoration: none;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
    text-align: center;
}

.stats-section {
    margin-bottom: 30px;
}

.stats-section h3 {
    color: #333;
    margin-bottom: 15px;
    font-weight: 600;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-left: 4px solid #2a9d8f;
}

.stat-card.stat-pending {
    border-left-color: #ffc107;
}

.stat-card.stat-approved {
    border-left-color: #2a9d8f;
}

.stat-card.stat-rejected {
    border-left-color: #dc3545;
}

.stat-card.stat-total {
    border-left-color: #6c757d;
}

.stat-number {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
}

.stat-label {
    color: #666;
    font-weight: 600;
}

.medecins-section h3 {
    color: #333;
    margin-bottom: 20px;
    font-weight: 600;
}

.table-container {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.medecins-table {
    width: 100%;
    border-collapse: collapse;
}

.medecins-table th {
    background-color: #2a9d8f;
    color: white;
    padding: 15px 12px;
    text-align: left;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 14px;
}

.medecins-table td {
    padding: 12px;
    border-bottom: 1px solid #e0e0e0;
    color: #555;
}

.medecins-table tr:hover {
    background-color: #f8f9fa;
}

.medecin-name {
    font-weight: 600;
    color: #333;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.status-en-attente {
    background-color: #fff3cd;
    color: #856404;
}

.status-valider {
    background-color: #d4edda;
    color: #155724;
}

.status-refuser {
    background-color: #f8d7da;
    color: #721c24;
}

.actions-cell {
    text-align: center;
}

.btn-action {
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    margin: 0 2px;
    transition: all 0.3s ease;
}

.btn-valider {
    background-color: #2a9d8f;
    color: white;
}

.btn-valider:hover {
    background-color: #21867a;
    color: white;
    text-decoration: none;
}

.btn-refuser {
    background-color: #dc3545;
    color: white;
}

.btn-refuser:hover {
    background-color: #c82333;
    color: white;
    text-decoration: none;
}

.no-action {
    color: #999;
    font-style: italic;
}

.no-medecins {
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 8px;
    color: #666;
}

/* Styles pour les lignes selon le statut */
.row-en-attente {
    background-color: #fff9e6;
}

.row-valider {
    background-color: #e8f5e8;
}

.row-refuser {
    background-color: #ffeaea;
}

/* Responsive */
@media (max-width: 768px) {
    .admin-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .medecins-table {
        font-size: 14px;
    }
    
    .medecins-table th,
    .medecins-table td {
        padding: 8px;
    }
}
</style>

