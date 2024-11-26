<?php
header('Content-Type: application/json');

$teamMembers = [
    ['image' => 'aaron.jpg', 'name' => 'Aaron Angelo Aquino', 'link' => 'aaron/aaron.html'],
    ['image' => 'aljon.jpg', 'name' => 'Aljon Nuestro', 'link' => 'aljon/aljon.html'],
    ['image' => 'jacob.jpg', 'name' => 'Jacob Alocon', 'link' => 'jacob/jacob.html'],
    ['image' => 'IRA.JPG', 'name' => 'Ira Christine Catapia', 'link' => 'ira/ira.html'],
    ['image' => 'rafael.jpg', 'name' => 'Rafael Cena', 'link' => 'rafael/rafael.html']
];

$query = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

$results = array_filter($teamMembers, function($member) use ($query) {
    return strpos(strtolower($member['name']), $query) !== false;
});

echo json_encode(array_values($results));
?>