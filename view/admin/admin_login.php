<?php
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    header("Location: index.php?page=admin_dashboard");
    exit();
}
?>

<div class="admin-login-page">
    <div class="admin-login-container">
        <div class="admin-login-form">
            <h2>Connexion Administrateur</h2>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="error-message">
                    <?php
                    switch ($_GET['error']) {
                        case 'empty_fields':
                            echo "Veuillez remplir tous les champs.";
                            break;
                        case 'invalid_credentials':
                            echo "Email ou mot de passe incorrect.";
                            break;
                        case 'database_error':
                            echo "Erreur de connexion à la base de données.";
                            break;
                        default:
                            echo "Une erreur est survenue.";
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="controller/admin/adminAuthController.php">
                <div class="input">
                    <p>Email:</p>
                    <input type="email" name="email" placeholder="email" required>
                </div>
                
                <div class="input">
                    <p>Mot de passe:</p>
                    <input type="password" name="password" placeholder="mot de passe" required>
                </div>
                
                <input type="hidden" name="action" value="connexion">
                <button type="submit" class="btn-connexion">Se connecter</button>
            </form>
            
            <div class="back-link">
                <a href="index.php?page=accueil">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles pour la page de connexion admin - Cohérent avec le style AIMY */
.admin-login-page {
    min-height: 90vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f5f5f5;
    font-family: 'Arial', sans-serif;
}

.admin-login-container {
    background: white;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 400px;
    border: 1px solid #e0e0e0;
}

.admin-login-form h2 {
    text-align: center;
    color: #333;
    margin-bottom: 30px;
    font-weight: 600;
    font-size: 24px;
}

.error-message {
    background-color: #f8d7da;
    color: #721c24;
    padding: 12px;
    border-radius: 4px;
    margin-bottom: 20px;
    text-align: center;
    border: 1px solid #f5c6cb;
}

.input {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    width: 100%;
    margin-bottom: 20px;
}

.input p {
    font-weight: 600;
    margin-bottom: 8px;
    color: #555;
}

.input input {
    width: 100%;
    padding: 12px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s ease;
    box-sizing: border-box;
}

.input input:focus {
    outline: none;
    border-color: #2a9d8f;
    box-shadow: 0 0 0 2px rgba(42, 157, 143, 0.1);
}

.btn-connexion {
    width: 100%;
    padding: 12px;
    background-color: #2a9d8f;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 10px;
}

.btn-connexion:hover {
    background-color: #21867a;
}

.back-link {
    text-align: center;
    margin-top: 20px;
}

.back-link a {
    color: #2a9d8f;
    text-decoration: none;
    font-weight: 600;
}

.back-link a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 480px) {
    .admin-login-container {
        margin: 20px;
        padding: 30px 20px;
    }
}
</style>

