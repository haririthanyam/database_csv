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
        <h3>Database For Your CSV file is Created!!</h3>
    </div>
</body>

</html>
<?php
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

//get the first row fields 
if(isset($_POST['importSubmit'])){
$fields = "";
$fieldsInsert = "";
$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
$update = -1;
if (($handle = $csvFile) !== FALSE) {
     if(($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {
        $num = count($data);
        $fieldsInsert .= '(';
        for ($c=0; $c < $num; $c++) {
            //echo $data[$c];
            if($data[$c] == "password" || $data[$c] == "Password"){
              $update = $c;
              //echo $update;
            }
            $fieldsInsert .=($c==0) ? '' : ', ';
            $fieldsInsert .="`".$data[$c]."`";
            $fields .="`".$data[$c]."` varchar(500) DEFAULT NULL,";
        }

        $fieldsInsert .= ')';
    }
    //drop if already existed
    $droptable = "DROP TABLE IF EXISTS `".$tableName."`";
    mysqli_query($con,$droptable);
    
    //create table
    $sql = "CREATE TABLE `".$tableName."` (
              `".$tableName."Id` int(100) unsigned  NOT NULL AUTO_INCREMENT,
              ".$fields."
              PRIMARY KEY (`".$tableName."Id`)
            ) ";

    $retval = mysqli_query($con,$sql);
    if($retval){
           while(($data = fgetcsv($handle, 1000000, ",")) !== FALSE) {

                $num = count($data);
                $fieldsInsertvalues="";
                
                
                //get field values of each row
                
                for ($c=0; $c < $num; $c++) {
                    $fieldsInsertvalues .=($c==0) ? '(' : ', ';
                    if($c == $update){
                       $color = "";
                       $color .=MD5("'".$data[$c]."'");
                       $fieldsInsertvalues .="'".$color."'";
                       //echo $fieldsInsertvalues;   
                    }
                    else{
                       $fieldsInsertvalues .="'".$data[$c]."'";
                    }
                    //$fieldsInsertvalues .="'".$data[$c]."'";
                    
                   
                }
            
                
                $fieldsInsertvalues .= ')';
               // echo $fieldsInsertvalues;
                //insert the values to table
                $sql = "INSERT INTO ".$tableName." ".$fieldsInsert."  VALUES  ".$fieldsInsertvalues." ";
               // echo $sql;
                mysqli_query($con,$sql);    
        }
    }
        echo "<h2><center>Table Created</center></h2>";   
  }
    $query = "SELECT * FROM $tableName";
    $result = mysqli_query($con, $query);
    if ($result)
    {
        // it return number of rows in the table.
        $row = mysqli_num_rows($result);
          
           if ($row)
              {
                echo "<h3><center><i>Number of rows in the table : $row</i></center></h3>";
              }
        // close the result.
        mysqli_free_result($result);
    }
    else{
        echo "<p><center>Rows cannot he fetched</center></p>";
    }

fclose($csvFile);
}
//To print the data in the table
$hai = "SELECT * FROM $tableName";
$res = mysqli_query($con,$hai);
$rownumber = 0;
echo "<center>";
echo "<table>\n";
while ($row = $res->fetch_assoc()) {
  if (0 == $rownumber) {
    /* first result set row? look at the keys=column nanes */
    echo "<tr>";
    foreach (array_keys($row) as $colname) {
      echo "<td><b>$colname</b></td><td>&nbsp&nbsp</td>";
    }
    echo "</tr>\n";
    echo " ";
  }
  $rownumber ++;

  echo "<tr>";
  foreach (array_values($row) as $colval) {
    echo "<td>$colval</td><td>&nbsp&nbsp</td>";
  }
  echo "</tr>\n";
}
echo "</table>\n";
echo "</center>";
$res->close();
?>
