<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$email = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    /*
     * TODO 7 — Authenticate the user.
     *
     * Workflow:
     * 1. Load users with loadUsers().
     * 2. Find the user with findUserByEmail().
     * 3. Verify the submitted password using password_verify().
     * 4. If authentication succeeds:
     *      - call loginUser($user)
     *      - determine where to redirect
     *      - if $_SESSION['intended_url'] exists, use it once
     *      - otherwise redirect to index.php
     * 5. If authentication fails, display ONE generic message such as:
     *      "Invalid email or password."
     *
     * A-HA:
     * password_verify() checks a password against a stored hash.
     * We never "decrypt" the stored password.
     */

    // Your code here.
        $users = loadUsers();
        $user = findUserByEmail($users, $email);

        if ($user !== null && password_verify($password, $user['password_hash'])) {
            loginUser($user);

            $redirect = $_SESSION['intended_url'] ?? 'index.php';
            unset($_SESSION['intended_url']);

            header('Location: ' . $redirect);
            exit;
        }
        $error = "Invalid email or password.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<main class="container narrow">
    <section class="panel">
        <h1>Support Desk Sign In</h1>
        <p>Sign in to access the support ticket application.</p>

        <?php if ($error !== ''): ?>
            <div class="error-box"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= e($email) ?>"
                autocomplete="username"
                required
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >

            <button type="submit">Sign In</button>
        </form>
    </section>
</main>
</body>
</html>
