<?php
session_start();
require_once ('pdo.php');

if ( ! isset($_SESSION['who']) ) {
    die('Not logged in');
}
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<title>Sabiha Tahsin Soha</title>

<head></head>
<h1>Tracking Autos for <?php echo $_SESSION['who']; ?></h1>
<?php

if (isset($_SESSION["success"])) {
    echo ('<p style="color: green;">' . htmlentities($_SESSION["success"]) . "</p>\n");
        unset($_SESSION["success"]);
}
?>

<body>
   <h2>Automobiles</h2>
    <ul>

        <?php
        foreach ($rows as $row) {
            echo '<li>';
            echo htmlentities($row['make']) . ' ' . $row['year'] . ' / ' . $row['mileage'];
        };
        echo '</li><br/>';
        ?>
    </ul>

    
<p><a href="add.php">Add New</a>|<a href="logout.php">Logout</a></p>


</body>