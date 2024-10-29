<?php
// public/register.php

require '../includes/db.php';
require '../includes/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $code = $_POST['code'];
    $password = $_POST['password'];

    // Validação simples
    if (empty($name) || empty($email) || empty($code) || empty($password)) {
        $errors[] = 'Por favor, preencha todos os campos.';
    }

    if (empty($errors)) {
        // Hash da senha
        $passwordHash = hashPassword($password);

        // Recupera o título da API
        $title = fetchTitleFromAPI();

        // Insere o usuário no banco de dados
        $stmt = $pdo->prepare('INSERT INTO users (name_user, email_user, password_user, title_user, code_user) VALUES (?, ?, ?, ?, ?)');
        if ($stmt->execute([$name, $email, $passwordHash, $title, $code])) {
            header('Location: login.php');
            exit();
        } else {
            $errors[] = 'Erro ao cadastrar o usuário.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
</head>

<body>
    <h1>Cadastro de Usuário</h1>
    <form method="POST">
        <label for="name">Nome:</label><br>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="code">Código Único:</label><br>
        <input type="text" id="code" name="code" required><br>

        <label for="password">Senha:</label><br>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Cadastrar</button>
    </form>

    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>