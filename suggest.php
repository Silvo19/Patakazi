<?php
require_once __DIR__ . '/includes/functions.php';
header('Content-Type: application/json');
$q = trim((string)($_GET['q'] ?? ''));
$_SESSION['sg'] = array_values(array_filter($_SESSION['sg'] ?? [], fn($t) => $t > time() - 10));
if (mb_strlen($q) < 2 || count($_SESSION['sg']) >= 30) { echo '[]'; exit; }
$_SESSION['sg'][] = time();
session_write_close();
$like = '%' . addcslashes($q, '%_\\') . '%';
$st = db()->prepare("SELECT l.id, l.title, l.type FROM listings l JOIN users u ON u.id = l.owner_id
    WHERE l.status = 'approved' AND u.status = 'active' AND (l.deadline IS NULL OR l.deadline >= CURDATE()) AND l.title LIKE ?
    ORDER BY l.is_featured DESC, l.created_at DESC LIMIT 6");
$st->execute([$like]);
echo json_encode(array_map(fn($r) => ['id' => (int)$r['id'], 'title' => $r['title'], 'type' => type_label($r['type'])], $st->fetchAll()));
