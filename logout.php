<?php
require_once __DIR__ . '/includes/auth.php';

/*
 * TODO 8 — Complete logout.
 *
 * Logout changes authentication state, so this starter expects POST.
 *
 * 1. Reject non-POST requests with HTTP 405.
 * 2. Call logoutUser().
 * 3. Redirect to login.php.
 */

http_response_code(501);
echo 'Logout is not implemented yet.';

if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    echo "Not a vaild request method."
    exit;
}
logoutUser($user);
header('Location: login.php');
exit;
