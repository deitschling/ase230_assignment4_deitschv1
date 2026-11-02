<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/auth.php';

requireLogin();

/*
 * TODO 10 — Enforce authorization HERE, on the server.
 *
 * Only a manager should be able to update ticket status.
 *
 * Do not rely on the fact that detail.php hides the form from agents.
 * A user can manually send a POST request directly to this file.
 *
 * Use requireRole(...).
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$newStatus = trim($_POST['status'] ?? '');

if (!$id || !in_array($newStatus, allowedStatuses(), true)) {
    http_response_code(400);
    exit('Invalid ticket update.');
}

$tickets = loadTickets();

if (!updateTicketStatus($tickets, $id, $newStatus)) {
    http_response_code(404);
    exit('Ticket not found.');
}

if (!saveTickets($tickets)) {
    http_response_code(500);
    exit('Could not save ticket update.');
}

/*
 * TODO 11 — Set a one-time success message before redirecting.
 */

header('Location: detail.php?id=' . urlencode((string)$id));
exit;
