<?php
header('Content-Type: application/json');

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST allowed']);
    exit;
}

// Read JSON body
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['item_id']) || !isset($data['quantity'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing item_id or quantity']);
    exit;
}

try {
    $db = new SQLite3('cafe.sqlite');

    $stmt = $db->prepare('INSERT INTO Orders (item_id, quantity) VALUES (:item_id, :quantity)');
    $stmt->bindValue(':item_id', $data['item_id'], SQLITE3_INTEGER);
    $stmt->bindValue(':quantity', $data['quantity'], SQLITE3_INTEGER);
    $stmt->execute();

    echo json_encode(['status' => 'success']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
