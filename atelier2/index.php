<?php
// Démarrer une session utilisateur qui sera en mesure de pouvoir gérer les Cookies
session_start();

// Exercice 2 : Générer un token unique si il n'existe pas
if (!isset($_SESSION['auth_token'])) {
    $_SESSION['auth_token'] = bin2hex(random_bytes(16));
}

// Vérifier si l'utilisateur est déjà en possession d'un cookie valide
if (isset($_COOKIE['authToken']) && isset($_SESSION['auth_token']) && $_COOKIE['authToken'] === $_SESSION['auth_token']) {
    // Rediriger vers la page appropriée
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'user') {
        header('Location: page_user.php');
    } else {
        header('Location: page_admin.php');
    }
    exit();
}

// Gérer la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification des identifiants admin
    if ($username === 'admin' && $password === 'secret') {
        // Exercice 1 : Cookie valable 1 minute (60 secondes)
        setcookie('authToken', $_SESSION['auth_token'], time() + 60, '/', '', false, true);
        $_SESSION['user_role'] = 'admin';
        header('Location: page_admin.php');
        exit();
    } 
    // Exercice 3 : Ajout de l'utilisateur "user"
    else if ($username === 'user' && $password === 'utilisateur') {
        // Exercice 1 : Cookie valable 1 minute (60 secondes)
        setcookie('authToken', $_SESSION['auth_token'], time() + 60, '/', '', false, true);
        $_SESSION['user_role'] = 'user';
        header('Location: page_user.php');
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <h1>Atelier authentification par Cookie</h1>
    <h3>Pages accessibles :</h3>
    <ul>
        <li><strong>Admin:</strong> login 'admin' / mot de passe 'secret' → <a href="page_admin.php">page_admin.php</a></li>
        <li><strong>User:</strong> login 'user' / mot de passe 'utilisateur' → <a href="page_user.php">page_user.php</a></li>
    </ul>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <button type="submit">Se connecter</button>
    </form>
    <br>
    <a href="../index.html">Retour à l'accueil</a>  
</body>
</html>
