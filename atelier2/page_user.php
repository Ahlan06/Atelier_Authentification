<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est bien en possession d'un cookie valide
// Exercice 2 : Vérification avec token unique
if (!isset($_COOKIE['authToken']) || !isset($_SESSION['auth_token']) || $_COOKIE['authToken'] !== $_SESSION['auth_token']) {
    header('Location: index.php');
    exit();
}

// Exercice 3 : Vérifier que c'est bien un user
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page User</title>
</head>
<body>
    <h1>Page User - Accès Restreint</h1>
    <p>Bienvenue User ! Vous êtes connecté avec un token unique.</p>
    <p><strong>Token unique :</strong> <?php echo $_SESSION['auth_token']; ?></p>
    <p><em>Le cookie expirera dans 1 minute</em></p>
    
    <p><strong>Login utilisé :</strong> user</p>
    <p><strong>Mot de passe utilisé :</strong> utilisateur</p>
    
    <br>
    <a href="logout.php">Se déconnecter</a> | 
    <a href="index.php">Retour à la connexion</a> |
    <a href="../index.html">Retour à l'accueil</a>
</body>
</html>
