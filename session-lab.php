<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

/*
 * GUIDED WARM-UP — Session Counter
 *
 * Complete the line below so every request increments a value stored
 * in the PHP session.
 *
 * Refresh the page several times. Then:
 * 1. Open another tab in the SAME browser and visit this page.
 * 2. Open a private/incognito window and visit this page.
 * 3. Inspect the browser cookies for the application.
 *
 * Question to think about:
 * Why does the new tab continue the count while the private window
 * usually begins a different session?
 * 
 * A new tab continues the count because the browser has cookies saved linking it to the previous session data to contunue the session from the prior tab.
 * On the flip side, the incognito browser window will have its own set of cookies and session data and then detroy it upon leaving because the point of the 
 * incognito browser is to limit tracking across the web-- including not storing cookies.
 */

//$_SESSION['lab_visits'] = 0; // TODO 0 — replace this line
$_SESSION['lab_visits'] = ($_SESSION['lab_visits'] ?? 0) + 1;   // this starts either as the amount of times the site has been visited OR zero, and then it increments one.
// this works because it accounts for this being the nth time someone has visited this site or the first and will adjust accordingly

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Lab</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<main class="container narrow">
    <section class="panel">
        <h1>Session Warm-Up</h1>
        <p>This session has visited this page:</p>
        <p class="counter"><?= e((string)$_SESSION['lab_visits']) ?> time(s)</p>
        <p><a href="login.php">Continue to Sign In</a></p>
    </section>
</main>
</body>
</html>
