<?php
header('Content-Type: application/json');

try {
    $db = new SQLite3('cafe.sqlite');
    $result = $db->query('SELECT id, name, price, type, image FROM Menu');

    $menu = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $menu[] = $row;
    }

    echo json_encode($menu);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
