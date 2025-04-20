 
<?php
// Include config file
require_once "config.php";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    $input_name = trim($_POST["Name"]);
    $name = $input_name;

    $input_department = trim($_POST["Department"]);
    $department = $input_department;

    $input_cnname = trim($_POST["Company_Name"]);
    $cnname = $input_cnname;

    $input_salary = trim($_POST["Package"]);
    $salary = $input_salary;

    $input_img = trim($_POST["Image"]);
    $img = $input_img;

    $input_nm = trim($_POST["name"]);
    $nm = $input_nm;

    $input_dept = trim($_POST["department"]);
    $dept = $input_dept;
    $input_add = trim($_POST["Address"]);
    $add = $input_add;
    $input_mno = trim($_POST["Mobileno"]);
    $mno = $input_mno;

    $input_sid = trim($_POST["sid"]);
    $sid = $input_sid;
    
    $sql = "UPDATE alumni SET Name=?, Department=?, Company_Name=?, Package=?, Image=? WHERE id=?";
    $sq = "UPDATE personal SET name=?, department=?, Mobileno=?, Address=?, sid=? WHERE id=?";
    $result1 = mysqli_prepare($link, $sq);
    $result2 = mysqli_prepare($link, $sql);
    if ($result1 && $result2) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($result1, "sssssi",$nm, $dept, $add, $mno,$sid ,$id);
        $last_id = mysqli_insert_id($link);
        mysqli_stmt_bind_param($result2, "sssisi",$name, $department, $cnname, $salary,$img ,$last_id);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($result1) && mysqli_stmt_execute($result2)) {
            // Records updated successfully. Redirect to landing page
            header("location: index.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($result1);
    mysqli_stmt_close($result2);


    // Close connection
    mysqli_close($link);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM employees WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $name = $row["name"];
                    $department = $row["department"];
                    $salary = $row["salary"];
                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
       

        // Close connection
        mysqli_close($link);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<h2>Update Record</h2>
<p>Please edit the input values and submit to update the record.</p>
<form action="<?php echo basename($_SERVER['REQUEST_URI']); ?>" method="post">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo $name; ?>">
    <label>Department</label>
    <input type="text" name="department" value="<?php echo $department; ?>">
    <label>Package</label>
    <input type="text" name="Package" value="<?php echo $salary; ?>">
    <label>Company Name</label>
    <input type="text" name="Comany_Name" value="<?php echo $cnname; ?>">
    <label>Department</label>
    <input type="text" name="d" value="<?php echo $department; ?>">
    <label>Image</label>
    <img src="<?php echo htmlspecialchars($image); ?>" width="150" height="150" alt="Image">    
    
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    <input type="submit" value="Submit">
    <a href="index.php">Cancel</a>
</form>
 