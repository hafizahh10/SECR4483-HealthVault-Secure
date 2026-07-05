<?php
// search.php - Secure Patient Search

require_once 'db_config.php';

$keyword = trim($_GET['keyword'] ?? '');

$stmt = $pdo->prepare("
    SELECT id, name, illness_history
    FROM patient_records
    WHERE name LIKE ?
");

$stmt->execute(["%{$keyword}%"]);

$results = $stmt->fetchAll();

if (count($results) > 0) {

    foreach ($results as $row) {

        echo "<div>";

        echo "Result found for keyword: "
            . htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8')
            . "<br>";

        echo "Patient: "
            . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8')
            . " | History: "
            . htmlspecialchars($row['illness_history'], ENT_QUOTES, 'UTF-8');

        echo "</div><hr>";
    }

} else {

    echo "No records found for: "
        . htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8');
}
?>