<?php
require 'vendor/autoload.php';

use proj4php\Proj4php;
use proj4php\Proj;
use proj4php\Point;

$proj4 = new Proj4php();
$srcProj = new Proj('EPSG:3857', $proj4); // UTM zona 34N
$dstProj = new Proj('EPSG:4326', $proj4);  // WGS84

// Konekcija
$hostName = "127.0.0.1:3306";
$dbUser = "gisitrs_root";
$dbPassword = "WeAreGisTeam2013";
$dbName = "gisitrs_turista";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    die("Konekcija nije uspela: " . $conn->connect_error);
}

// Dohvati jednu lokaciju (npr. prvu u tabeli)
$sql = "SELECT ST_X(geom) AS x, ST_Y(geom) AS y FROM city";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $point = new Point($row['x'], $row['y'], $srcProj);
    $converted = $proj4->transform($dstProj, $point);

    // Vrati kao JSON
    header('Content-Type: application/json');
    echo json_encode([
        'lat' => $converted->y,
        'lng' => $converted->x
    ]);
} else {
    echo json_encode(['error' => 'Lokacija nije pronađena.']);
}

$conn->close();
?>
