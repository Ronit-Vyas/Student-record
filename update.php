<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];

    // Alumni table
    $name = trim($_POST["name"]);
    $department = trim($_POST["department"]);
    $company = trim($_POST["company"]);
    $package = trim($_POST["package"]);
    $image = trim($_POST["image"]);

    // Personal table
    $mobile = trim($_POST["mobile"]);
    $address = trim($_POST["address"]);
    $sid = trim($_POST["sid"]);

    // Update alumni table
    $sql1 = "UPDATE alumni
             SET Name=?, Department=?, Company_Name=?, Package=?, Image=?
             WHERE id=?";

    $stmt1 = mysqli_prepare($link, $sql1);

    mysqli_stmt_bind_param(
        $stmt1,
        "sssisi",
        $name,
        $department,
        $company,
        $package,
        $image,
        $id
    );

    // Update personal table
    $sql2 = "UPDATE personal
             SET Name=?, Department=?, Mobileno=?, Address=?, sid=?
             WHERE id=?";

    $stmt2 = mysqli_prepare($link, $sql2);

    mysqli_stmt_bind_param(
        $stmt2,
        "sssssi",
        $name,
        $department,
        $mobile,
        $address,
        $sid,
        $id
    );

    if (mysqli_stmt_execute($stmt1) && mysqli_stmt_execute($stmt2)) {

        header("Location: index.php");
        exit();

    } else {

        echo "Error : ".mysqli_error($link);

    }

    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
    mysqli_close($link);

} else {

    if (!isset($_GET["id"])) {
        die("Invalid Request");
    }

    $id = $_GET["id"];

    $sql = "SELECT alumni.*, personal.Mobileno,
                   personal.Address,
                   personal.sid
            FROM alumni
            INNER JOIN personal
            ON alumni.id = personal.id
            WHERE alumni.id=?";

    $stmt = mysqli_prepare($link, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $row = mysqli_fetch_assoc($result);

    } else {

        die("Record not found.");

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Alumni</title>
</head>

<body>

<h2>Update Record</h2>

<form method="post">

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <label>Name</label><br>
    <input type="text" name="name" value="<?php echo $row['Name']; ?>"><br><br>

    <label>Department</label><br>
    <input type="text" name="department" value="<?php echo $row['Department']; ?>"><br><br>

    <label>Company Name</label><br>
    <input type="text" name="company" value="<?php echo $row['Company_Name']; ?>"><br><br>

    <label>Package</label><br>
    <input type="text" name="package" value="<?php echo $row['Package']; ?>"><br><br>

    <label>Image URL</label><br>
    <input type="text" name="image" value="<?php echo $row['Image']; ?>"><br><br>

    <img src="<?php echo $row['Image']; ?>" width="150"><br><br>

    <label>Mobile</label><br>
    <input type="text" name="mobile" value="<?php echo $row['Mobileno']; ?>"><br><br>

    <label>Address</label><br>
    <textarea name="address"><?php echo $row['Address']; ?></textarea><br><br>

    <label>Student ID</label><br>
    <input type="text" name="sid" value="<?php echo $row['sid']; ?>"><br><br>

    <input type="submit" value="Update">

</form>

</body>
</html>