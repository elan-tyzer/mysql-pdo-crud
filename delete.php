
<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Metode tidak diizinkan.");
}

$token = $_POST["csrf_token"] ?? "";

if (!is_string($token) ||
    !hash_equals($_SESSION["csrf_token"], $token)) {
    http_response_code(403);
    exit("Token keamanan tidak valid.");
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit("ID buku tidak valid.");
}

$stmt = $pdo->prepare("DELETE FROM buku WHERE id = :id");
$stmt->execute(["id" => $id]);

header("Location: index.php");
exit;
?>
