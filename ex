<!--  
<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "config.php";

    // Prepare a select statement
    $sql =  "SELECT alumni.Name, alumni.Department, alumni.Company_Name, alumni.Package , alumni.Image ,personal.name , personal.department, personal.Mobileno, personal.Address , personal.sid   FROM location INNER JOIN alumni ON personal alumni.id = personal.id";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
       
        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $name = $row["Name"];
                $dept = $row["Department"];
                $cmpnm=$row["Company_Name"];
            
                $salary = $row["Package"];
                $mno = $row["Mobileno"];

                $name = $row["Address"];
                $dept = $row["sid"];
              
                $img = $row["Image"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }

        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>    
 
<h1>&nbsp;View Record</h1>
&nbsp;
<label>Name:</label>
<p>&nbsp;&nbsp;<?php echo $row["Name"]; ?></p>
&nbsp;
<label>Department:</label>
<p>&nbsp;&nbsp;<?php echo $row["Department"]; ?></p>
&nbsp;
<label>Company Name:</label>
<p>&nbsp;&nbsp;<?php echo $row["Company_Name"]; ?></p>

<label>Package :</label>
<p>&nbsp;&nbsp;<?php echo $row["Package"]; ?></p>
 
<label>Mobile number :</label>
<p>&nbsp;&nbsp;<?php echo $row["Mobileno"]; ?></p>
 
<label>Address :</label>
<p>&nbsp;&nbsp;<?php echo $row["Address"]; ?></p>
 
<label>Student ID :</label>
<p>&nbsp;&nbsp;<?php echo $row["sid"]; ?></p>
 
<label>Image :</label>
<p> <?php echo "<img src='" . $row["Image"] . "' width='150' height='150'><br><br>" ?></p>
<p>&nbsp;&nbsp;<a href="index.php">Back</a></p>


</body>
</html> -->