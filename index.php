<?php
// Load the database configuration file
//table Name
$tableName = "mytable";
//database name
$dbName = "test";
$servername = "localhost";
$username = "root";
$password = "";

$con = mysqli_connect($servername, $username, $password,$dbName);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>CSV FILE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="jumbotron text-center">
        <p>Upload Your CSV file HERE!!</p>
    </div>

    <div class="row">
        <!-- Import link -->
        <div class="col-md-12 head text-center">
            <div class="float-right">
                <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm')"><i
                        class="plus"></i>
                    Import</a><br><br>
            </div>
        </div>
        <!-- CSV file upload form -->
        <div class="col-md-12 text-center" id="importFrm" style="display: none;">
            <div style="text-align:center;">
                <form action=" mytable.php" method="post" enctype="multipart/form-data">
                    <center>
                        <input type="file" name=" file" id="file" />
                    </center><br><br>
                    <input type="submit" class="btn btn-primary text-center" onclick="myfun()" name=" importSubmit"
                        value=" IMPORT">
                </form>

            </div>
</body>
<!-- Show/hide CSV upload form -->
<script>
function formToggle(ID) {
    var element = document.getElementById(ID);
    if (element.style.display === "none") {
        element.style.display = "block";
    } else {
        element.style.display = "none";
    }
}

function myfun() {
    alert("File Uploaded Successfully!!");
}
</script>

</html>