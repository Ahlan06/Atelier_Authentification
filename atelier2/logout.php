<?php
// Démarrer la session
session_start();

// Supprime le cookie d'authentification
setcookie('authToken', '', time() - 3600, '/', '', false, true);

// Détruire la session et le token
session_destroy();

// Redirection vers la page de connexion
header('Location: index.php');
exit();
?>
