
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "config.php";

    // Read all input fields
    $name = trim($_POST["Name"]);
    $department = trim($_POST["Department"]);
    $cnname = trim($_POST["Company_Name"]);
    $salary = trim($_POST["Package"]);
    $mno = trim($_POST["Mobileno"]);
    $add = trim($_POST["Address"]);
    $sid = trim($_POST["sid"]);
    $img = "Uploads/" . basename($_FILES["fileUpload"]["name"]); // ✅ correct
    move_uploaded_file($_FILES["fileUpload"]["tmp_name"], $img);

    // INSERT INTO PARENT (alumni)
    $sql = "INSERT INTO alumni (Name, Department, Company_Name, Package, Image) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssis", $name, $department, $cnname, $salary, $img);
        $result1 = mysqli_stmt_execute($stmt);

        if ($result1) {
            $last_id = mysqli_insert_id($link); // Get last inserted ID

            // INSERT INTO CHILD (personal) using same ID
            $sql2 = "INSERT INTO personal (id, name, department, Mobileno, Address, sid) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stm = mysqli_prepare($link, $sql2)) {
                mysqli_stmt_bind_param($stm, "isssss", $last_id, $name, $department, $mno, $add, $sid);
                $result2 = mysqli_stmt_execute($stm);

                if ($result2) {
                    header("location: index.php");
                    exit();
                } else {
                    echo "Error inserting into personal table.";
                }

                mysqli_stmt_close($stm);
            }
        } else {
            echo "Error inserting into alumni table.";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($link);
}
?>

<?php include "upload.php";?>
<html>
    <head>
    <style>
body {
    font-family: Arial, sans-serif;
    background: blue;
    padding: 40px;
}

h2 {
    text-align: center;
    color: yellow;
    margin-bottom: 30px;
    font-weight: bold;
    font-size: 40px
}

form {
    background: #ffffff;
    max-width: 600px;
    margin: auto;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
    color: #444;
}

form input[type="text"],
form input[type="file"],
form textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

form textarea {
    resize: vertical;
}

form input[type="submit"],
form a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
    margin-right: 10px;
}

form input[type="submit"]:hover,
form a:hover {
    background-color: #388e3c;
}

form a {
    background-color: #e53935;
}

form a:hover {
    background-color: #c62828;
}
</style>
</head>
<body>
<h2><i>Create Record</i></h2>

<p>Please fill this form and submit to add employee record to the database.</p>
 
<form action="" method="post" enctype="multipart/form-data">
<label>Name</label>
<input type="text" name="Name"><br><br>
<label>Department</label>
<input type="text" name="Department"><br><br>
<label>Company name</label>
<input type="text" name="Company_Name"><br><br>
<label>Package</label>
<input type="text" name="Package"><br><br>
<label>Mobile Number</label>
<input type="text" name="Mobileno"><br><br>
<textarea id="user-address" name="Address" rows="4" cols="50" placeholder="Address"></textarea><br><br>
 
<label>Student ID</label>
<input type="text" name="sid"><br><br>
 
<label>Upload Photo</label>
<input type="file" name="fileUpload" id="chooseFile"><br><br>

<?php if(!empty($resMessage)) {
    echo $resMessage['message'];
}
?>
<br><br><br><br>
<input type="submit" value="Submit">
<a href="index.php">Cancel</a>
</form> 
</body>
</html>