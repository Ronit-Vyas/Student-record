 

<?php
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include config file
    require_once "config.php";
    echo '
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alumni Records</title>
    <link rel="stylesheet" href= "viestyle.css">
</head>
<body>
     
    ';

    // Prepare a select statement with proper JOINs
    $sql = "SELECT 
                alumni.Name AS alumni_name, 
                alumni.Department AS alumni_dept, 
                alumni.Company_Name, 
                alumni.Package, 
                alumni.Image, 
                personal.name AS personal_name,
                personal.department AS personal_dept, 
                personal.Mobileno , 
                personal.Address, 
                personal.sid 
            FROM alumni
            INNER JOIN personal ON alumni.id = personal.id 
            WHERE alumni.id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Set parameter
        $param_id = trim($_GET["id"]);

        // Bind variables
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Execute
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Extract values
                $alumni_name = $row["alumni_name"];
                $alumni_dept = $row["alumni_dept"];
                $company_name = $row["Company_Name"];
                $package = $row["Package"];
                $mobileno = $row["Mobileno"];
                $address = $row["Address"];
                $sid = $row["sid"];
                $image = $row["Image"];
            } else {
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close
        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
} else {
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
 

</head>
<body>    
<h2>View Record</h2>
<table class="table-container">
    <tr>
        <td>
<label>Name :</label> &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
</td>
<td>
<?php echo htmlspecialchars($alumni_name); ?> 
</td>
</tr>
<td>
<label>Department:</label>&nbsp;
</td>
<td>
<?php echo htmlspecialchars($alumni_dept); ?> 
</td>
</tr>
<tr>
    <td>
<label>Company Name:</label> &nbsp;
</td>
<td>
<?php echo htmlspecialchars($company_name); ?> 
</td>
</tr>
<tr>
    <td>
<label>Package:</label> &nbsp;
</td>
<td>
<?php echo htmlspecialchars($package); ?> 
</td>
</tr>
<tr>
    <td>
<label>Mobile Number:</label> &nbsp;
</td>
<td>
<?php echo htmlspecialchars($mobileno); ?><br><br><br>
</td>
</tr>
<tr>
    <td>
<label>Address:</label> &nbsp;
</td>
<td>
<?php echo htmlspecialchars($address); ?><br><br><br>
</td>
</tr>
<tr>
    <td>
<label>Student ID:</label>
</td>
<td>
<?php echo htmlspecialchars($sid); ?><br><br><br>
</td>
</tr>
<tr>
    <td>
<label>Image:</label>
</td>
<td>
<p><img src="<?php echo htmlspecialchars($image); ?>" width="150" height="150" alt="Image"></p>
</td>
</tr>
<tr>
    <td style="column-span: 3">
    <a   href="index.php">Back</a> 
    </td>
</tr>
</table>
</body>
</html>
