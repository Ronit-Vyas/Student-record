 
  
 
<?php
// Include config file
require_once "config.php";
echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alumni Records</title>
    <link rel="stylesheet" href= "tablest.css">
</head>
<body>
    <div class="container">
        <h1>Student Records</h1>
';

// Attempt select query execution
$sql = "SELECT * FROM alumni ORDER BY id ASC";
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        echo '<table>';
        echo "<thead>";
        echo "<tr>";
        echo "<th>Id</th>";
        echo "<th>Name</th>";
        echo "<th>Department</th>";
        echo "<th>Company Name</th>";
        echo "<th>Package</th>";
        
        echo "<th>Action</th>";

        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['Department'] . "</td>";
            echo "<td>" . $row['Company_Name'] . "</td>";

            echo "<td>" . $row['Package'] . "</td>";
            echo "<td>";
            echo "<a href='read.php?id=" . $row['id'] . "'>View Record</a>";
            
            echo "</td>";
            echo "</tr>";
        }
       
        // Free result set
        mysqli_free_result($result);
    } else {
        echo '<em>No records were found.</em>';
    }
} else {
    echo "Oops! Something went wrong. Please try again later.";
}

// Close connection
mysqli_close($link);
?>
<html>
    <body>
    <p>&nbsp;&nbsp;<a style="text-decoration: none;  " href="create.php">Create New Records</a> | 
 
</body>
 