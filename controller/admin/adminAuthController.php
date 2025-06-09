<?php
// controller/admin/adminAuthController.php

session_start();
include_once('../../bdd/bdd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'connexion') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            header("Location: ../../index.php?page=admin_login&error=empty_fields");
            exit();
        }
        
        try {
            // Vérification des identifiants admin
            $stmt = $bdd->prepare("SELECT * FROM administrateur WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Vérification du mot de passe (simple comparaison pour le moment)
            if ($admin && $admin['password'] === $password) {
                // Connexion réussie
                $_SESSION['idadmin'] = $admin['idAdministrateur'];
                $_SESSION['admin_nom'] = $admin['nom'];
                $_SESSION['admin_prenom'] = $admin['prenom'];
                $_SESSION['admin_email'] = $admin['email'];
                $_SESSION['is_admin'] = true;
                
                header("Location: ../../index.php?page=admin_dashboard");
                exit();
            } else {
                header("Location: ../../index.php?page=admin_login&error=invalid_credentials");
                exit();
            }
        } catch (PDOException $e) {
            header("Location: ../../index.php?page=admin_login&error=database_error");
            exit();
        }
    }
    
    if ($action === 'deconnexion') {
        // Déconnexion admin
        unset($_SESSION['idadmin']);
        unset($_SESSION['admin_nom']);
        unset($_SESSION['admin_prenom']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['is_admin']);
        
        header("Location: ../../index.php?page=accueil");
        exit();
    }
}

// Si aucune action valide, redirection vers la page de connexion
header("Location: ../../index.php?page=admin_login");
exit();
?>

