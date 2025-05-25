<?php
// Create (or open if exists) SQLite database file
$db = new PDO('sqlite:cafe.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Create Menu table
$db->exec("CREATE TABLE IF NOT EXISTS Menu (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    price REAL NOT NULL,
    type TEXT NOT NULL,
    image TEXT
)");

// Create Orders table
$db->exec("CREATE TABLE IF NOT EXISTS Orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    item_id INTEGER,
    quantity INTEGER,
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(item_id) REFERENCES Menu(id)
)");

// Check if data already exists
$result = $db->query("SELECT COUNT(*) as count FROM Menu");
$row = $result->fetch(PDO::FETCH_ASSOC);

if ($row['count'] == 0) {
    // Insert initial menu items
    $db->exec("INSERT INTO Menu (name, price, type, image) VALUES
        ('Caramel Latte', 99.00, 'beverage', 'images/caramel-latte.jpg'),
        ('Espresso', 99.00, 'beverage', 'images/espresso.jpg'),
        ('Iced Mocha', 89.00, 'beverage', 'images/mocha.jpg'),
        ('Vanilla Cold Brew', 89.00, 'beverage', 'images/vanilla.jpg'),
        ('Blueberry Muffin', 79.00, 'pantry', 'images/muffin.jpg'),
        ('Chocolate Croissant', 99.00, 'pantry', 'images/croissant.jpg'),
        ('Banana Bread', 89.00, 'pantry', 'images/banana.jpg'),
        ('Cinnamon Roll', 79.00, 'pantry', 'images/cinnamon.jpg')");
    echo "Database and tables created, data inserted.";
} else {
    echo "Database already initialized.";
}
?>
