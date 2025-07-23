<?php

header("Access-Control-Allow-Origin: *");
require_once "../../connect.php";
header('Content-Type: application/json');

// GET: all events with category
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT e.*, c.name AS category_name FROM events e LEFT JOIN categories c ON e.category_id = c.id";
    // Perubahan 2: Gunakan sintaks procedural mysqli_query($connect, ...)
    $res = mysqli_query($connect, $query); 
    $events = [];
    // Perubahan 3: Gunakan sintaks procedural mysqli_fetch_assoc($res)
    while ($row = mysqli_fetch_assoc($res)) { 
        $events[] = [
            "id" => $row['id'],
            "title" => $row['title'],
            "start" => $row['start'],
            "end" => $row['end'],
            "description" => $row['description'],
            "category_id" => $row['category_id'],
            "category_name" => $row['category_name']
        ];
    }
    echo json_encode($events);
    exit;
}
?>