<?php
// Demand a GET parameter
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['who']) ) {
    die('Not logged in');
}
// If the user requested logout go back to index.php
else if ( isset($_POST['cancel']) ) {
    header('Location: view.php');
    return;
}
elseif (isset($_POST['make']) && isset($_POST['year'])
    && isset($_POST['mileage'])) {
	if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION["error"] = "Mileage and year must be numeric";
        header('Location: add.php');
        return;
       // $failure = 'Mileage and year must be numeric';
    }	
	else if(strlen($_POST['make']) < 1 ) {
        $_SESSION["error"] = "Make is required";
        header('Location: add.php');
        return;
       // $failure = 'Make is required';
    }
	else{
        $_SESSION["success"] = "Record inserted";
        header('Location: view.php');
       
		$stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :make, :year, :mileage)');
			$stmt->execute(array(
                ':make' => $_POST['make'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage'])
            );
            return;
			
		}
	}
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Sabiha Tahsin Soha</title>
<?php  ?>
</head>
<body>
<div class="container">
 <h1>Tracking Autos for <?php echo $_SESSION['who']; ?></h1>
 
 <?php
    if ( isset($_SESSION["error"])) {
        echo ('<p style="color: red;">' . htmlentities($_SESSION["error"]) . "</p>\n");
            unset($_SESSION["error"]);
    }
   
    ?>
 

<form method="post">
        <p>Make:
            <input type="text" name="make" size="40"></p>
        <p>Year:
            <input type="text" name="year"></p>
        <p>Mileage:
            <input type="text" name="mileage"></p>
        <p><input type="submit" value="Add"  name= "add"/>
            <input type="submit" value="Cancel"  name="cancel"/>
        </p>
      
</form>

</div>
</body>	