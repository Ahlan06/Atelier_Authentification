<?php
// Noms d'utilisateur et mots de passe corrects
$valid_users = [
    'admin' => 'secret',
    'user' => 'utilisateur'
];

// Vérifier si l'utilisateur a envoyé des identifiants
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    // Envoyer un header HTTP pour demander les informations
    header('WWW-Authenticate: Basic realm="Zone Protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Vous devez entrer un nom d\'utilisateur et un mot de passe pour accéder à cette page.';
    exit;
}

// Vérifier les identifiants envoyés
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

if (!isset($valid_users[$username]) || $valid_users[$username] !== $password) {
    // Si les identifiants sont incorrects
    header('WWW-Authenticate: Basic realm="Zone Protégée"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Nom d\'utilisateur ou mot de passe incorrect.';
    exit;
}

// Si les identifiants sont corrects - Déterminer le rôle
$role = ($username === 'admin') ? 'admin' : 'user';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atelier 4 - Authentification HTTP</title>
</head>
<body>
    <h1>Atelier 4 - Authentification via Header HTTP</h1>
    
    <p>Vous êtes connecté en tant que : <strong><?php echo htmlspecialchars($username); ?></strong></p>
    <p>Rôle : <strong><?php echo htmlspecialchars($role); ?></strong></p>

    <!-- Section visible par tous -->
    <div>
        <h2>Section Publique</h2>
        <p>Cette section est visible par tous les utilisateurs connectés.</p>
    </div>

    <!-- Section Admin (visible seulement par admin) -->
    <?php if ($role === 'admin'): ?>
    <div>
        <h2>Section Administrateur</h2>
        <p>Cette section est réservée aux administrateurs uniquement.</p>
        <p>Contenu confidentiel pour l'admin.</p>
    </div>
    <?php endif; ?>

    <!-- Section différente selon le rôle -->
    <div>
        <h2>Contenu Personnalisé</h2>
        <?php if ($role === 'admin'): ?>
            <p>Bienvenue Administrateur ! Vous avez un accès complet.</p>
        <?php else: ?>
            <p>Bienvenue Utilisateur ! Vous avez un accès standard.</p>
        <?php endif; ?>
    </div>

    <br>
    <a href="../index.html">Retour à l'accueil</a>
</body>
</html>
