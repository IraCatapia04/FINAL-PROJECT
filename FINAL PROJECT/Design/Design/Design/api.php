<?php
header('Content-Type: application/json');
$teamMembers = [
    ['name' => 'Aaron Angelo Aquino', 'link' => 'aaron/aaron.html', 'image' => 'aaron.jpg'],
    ['name' => 'Aljon Nuestro', 'link' => 'aljon/aljon.html', 'image' => 'aljon.jpg'],
    ['name' => 'Jacob Alocon', 'link' => 'jacob/jacob.html', 'image' => 'jacob.jpg'],
    ['name' => 'Ira Christine Catapia', 'link' => 'ira/ira.html', 'image' => 'IRA.JPG'],
    ['name' => 'Rafael Cena', 'link' => 'rafael/rafael.html', 'image' => 'rafael.jpg']
];
$query = strtolower(trim($_GET['q']));
$results = array_filter($teamMembers, function($member) use ($query) {
    return strpos(strtolower($member['name']), $query) !== false;
});
echo json_encode(array_values($results));
?>