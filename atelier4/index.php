<?php
// Noms d'utilisateur et mots de passe corrects
$valid_users = [
    'admin' => 'secret',
    'user' => 'utilisateur'
];

// Vérifier si l'utilisateur a envoyé des identifiants
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
    // Envoyer un header HTTP pour demander les informations
    header('WWW-Authenticate: Basic realm="Zone Protégée - Connectez-vous avec admin/secret ou user/utilisateur"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Vous devez entrer un nom d\'utilisateur et un mot de passe pour accéder à cette page.';
    exit;
}

// Vérifier les identifiants envoyés
$username = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

if (!isset($valid_users[$username]) || $valid_users[$username] !== $password) {
    // Si les identifiants sont incorrects
    header('WWW-Authenticate: Basic realm="Zone Protégée - Identifiants incorrects"');
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
    <title>Page protégée - Atelier 4</title>
    <style>
        .section { 
            border: 1px solid #ccc; 
            padding: 15px; 
            margin: 10px 0; 
            border-radius: 5px;
        }
        .admin-section { 
            background-color: #ffe6e6; 
            border-left: 4px solid #ff0000;
        }
        .user-section { 
            background-color: #e6f7ff; 
            border-left: 4px solid #007bff;
        }
        .public-section { 
            background-color: #f0f0f0; 
            border-left: 4px solid #6c757d;
        }
    </style>
</head>
<body>
    <h1>Atelier 4 - Authentification via Header HTTP</h1>
    
    <!-- Section publique (visible par tous) -->
    <div class="section public-section">
        <h2>📋 Section Publique</h2>
        <p>Cette section est visible par <strong>tous les utilisateurs</strong> connectés.</p>
        <p><strong>Vous êtes connecté en tant que :</strong> <?php echo htmlspecialchars($username); ?></p>
        <p><strong>Rôle détecté :</strong> <?php echo htmlspecialchars($role); ?></p>
    </div>

    <!-- Section Admin (visible seulement par admin) -->
    <?php if ($role === 'admin'): ?>
    <div class="section admin-section">
        <h2>🔧 Section Administrateur</h2>
        <p><strong>Cette section est réservée aux administrateurs uniquement !</strong></p>
        <ul>
            <li>Gestion des utilisateurs</li>
            <li>Configuration du système</li>
            <li>Logs et statistiques</li>
            <li>Paramètres avancés</li>
        </ul>
        <p><em>Seul l'admin peut voir ces informations confidentielles.</em></p>
    </div>
    <?php endif; ?>

    <!-- Section User (visible par tous les utilisateurs connectés) -->
    <div class="section user-section">
        <h2>👤 Section Utilisateur</h2>
        <p><strong>Cette section est accessible à tous les utilisateurs connectés.</strong></p>
        <ul>
            <li>Profil utilisateur</li>
            <li>Historique des activités</li>
            <li>Paramètres personnels</li>
            <?php if ($role === 'user'): ?>
            <li><strong>Options basiques (limitées pour les users)</strong></li>
            <?php else: ?>
            <li><strong>Options avancées (étendues pour les admins)</strong></li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- Section différente selon le rôle -->
    <div class="section <?php echo $role === 'admin' ? 'admin-section' : 'user-section'; ?>">
        <h2>🎯 Contenu Personnalisé</h2>
        <?php if ($role === 'admin'): ?>
            <p><strong>Bienvenue Administrateur !</strong> Vous avez un accès complet au système.</p>
            <p>Vous pouvez : modifier les paramètres, gérer les utilisateurs, consulter les logs.</p>
        <?php else: ?>
            <p><strong>Bienvenue Utilisateur !</strong> Vous avez un accès standard.</p>
            <p>Vous pouvez : consulter votre profil, modifier vos préférences.</p>
        <?php endif; ?>
    </div>

    <div class="section public-section">
        <h3>📝 Informations techniques</h3>
        <p>Cette page utilise l'<strong>authentification HTTP Basic</strong> via les headers :</p>
        <ul>
            <li><strong>Header de requête :</strong> Authorization (envoyé par le navigateur)</li>
            <li><strong>Header de réponse :</strong> WWW-Authenticate (envoyé par le serveur)</li>
        </ul>
        <p><em>Aucun cookie ou session n'est utilisé - tout passe par les headers HTTP !</em></p>
    </div>

    <br>
    <a href="../index.html">Retour à l'accueil</a> | 
    <a href="<?php echo $_SERVER['PHP_SELF']; ?>">Actualiser la page</a>
</body>
</html>
