<?php
// Démarre la session
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Rediriger selon le rôle
    if ($_SESSION['user_role'] === 'admin') {
        header('Location: page_admin.php');
    } else {
        header('Location: page_user.php');
    }
    exit();
}

// Gérer le formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérification simple des identifiants
    if ($username === 'admin' && $password === 'secret') {
        // Stocker les informations utilisateur dans la session
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_role'] = 'admin';

        // Rediriger vers la page admin
        header('Location: page_admin.php');
        exit();
    } 
    elseif ($username === 'user' && $password === 'utilisateur') {
        // Stocker les informations utilisateur dans la session
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_role'] = 'user';

        // Rediriger vers la page user
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
    <title>Connexion</title>
</head>
<body>
    <h1>Atelier authentification par Session</h1>
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
