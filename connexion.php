<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=taskmanager;charset=utf8', 'root', '');
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

session_start();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//Recuperation des données du formulaire pour la connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $error = '';
    if (empty($email) || empty($password)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse e-mail invalide.';
    } else {
        $user = $db->prepare('SELECT * FROM utilisateurs WHERE email = ? LIMIT 1');
        $user->execute([$email]);
        $user = $user->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            // Stockage des informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['loggedin'] = true;
            session_regenerate_id(true);
            // Connexion réussie, redirection vers la page des tâches
            header('Location: tache.php');
            exit();
        } else { 
            $error = 'Identifiants incorrects. Veuillez réessayer.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Gerer vos taches facilement</title>
    <link rel="stylesheet" href="inscription.css">
</head>

<body>
    <div class="container">
        <div class="cnx">
            <form class="form" method="post" id="login-form">
                <h2>Connexion</h2>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Mot de passe" required />
                <button type="submit">Se connecter</button>
                <p> Pas encore de compte ? <a href="inscription.html" id="show-register">Inscription</a></p>

            </form>
        </div>
    </div>
</body>