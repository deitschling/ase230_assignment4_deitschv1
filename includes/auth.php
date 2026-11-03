<?php

/*
 * This file is included by pages that need session/authentication behavior.
 *
 * IMPORTANT:
 * session_start() must happen BEFORE any HTML is sent to the browser.
 * PHP uses the session cookie to reconnect this request with server-side
 * session data from an earlier request.
 */
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/*
 * Return the currently authenticated user stored in the session.
 *
 * We store only the information the application needs. We DO NOT store
 * the user's password or password hash in the session.
 */
function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function isLoggedIn(): bool
{
    return currentUser() !== null;
}

function loginUser(array $user): void
{
    /*
     * TODO 1 — Complete login session creation.
     *
     * 1. Regenerate the session ID after successful authentication.
     *    Why? The user's authentication state has just changed.
     *
     * 2. Store ONLY the fields the application needs in $_SESSION['user']:
     *      id, name, email, role
     *
     * Do not store password_hash in the session.
     */

    // Example structure AFTER you implement it:
    // $_SESSION['user'] = [
    //     'id' => ...,
    //     'name' => ...,
    //     'email' => ...,
    //     'role' => ...
    // ];
    session_regenerate_id(true);    //this satisfies 1 by regenerating the session id

    $_SESSION['user'] = [   //this satifies 2 by saving only the necessary information
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role']
    ];
}

function requireLogin(): void
{
    /*
     * TODO 2 — Protect private pages.
     *
     * If the user is NOT logged in:
     * 1. Remember the page they originally requested using $_SERVER['REQUEST_URI'].
     * 2. Redirect to login.php.
     * 3. Stop the current script with exit.
     *
     * A-HA:
     * Hiding a navigation link is NOT access control.
     * The SERVER must reject/redirect unauthorized requests.
     */

    if (!isset($_SESSION['user']['id'])){
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header('Location: login.php');
        exit;
    }

}

function requireRole(string $requiredRole): void
{
    /*
     * TODO 3 — Authorization.
     *
     * First make sure the user is logged in.
     * Then compare currentUser()['role'] with $requiredRole.
     *
     * If the logged-in user does not have permission:
     * return HTTP 403 and stop the request.
     *
     * A-HA:
     * Authentication asks "Who are you?"
     * Authorization asks "Are you allowed to do this?"
     */

    if (!isLoggedIn()){
        requireLogin();
    }
    if (currentUser()['role'] !== $requiredRole){
        http_response_code(403);
        echo "Forbidden: You do not have permission access this page.";
        exit;
    }

}

function setFlash(string $message): void
{
    /*
     * TODO 4 — Store a one-time message in the session.
     *
     * Flash messages are useful because POST handlers normally redirect.
     * The message must survive the redirect, but should appear only once.
     */

    $_SESSION['flash'] = $message;

}

function getFlash(): ?string
{
    /*
     * TODO 5 — Read AND remove the one-time message.
     *
     * Returning the message without removing it would make it appear
     * on every future page request.
     */
    //return null;

    $message = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $message;
}

function logoutUser(): void
{
    /*
     * TODO 6 — End the authenticated session.
     *
     * Suggested sequence:
     * 1. Clear $_SESSION.
     * 2. If PHP is using a session cookie, expire that cookie.
     * 3. Destroy the server-side session.
     *
     * Do not merely redirect and leave the authenticated session alive.
     */

    session_unset();
    //expire the cookie
    setcookie(session_name(), '', time() - 4300. '/');
    session_destroy();
    header('Location: login.php');
    exit;
}
