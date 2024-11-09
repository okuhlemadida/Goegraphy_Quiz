<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    define("servername", "cs3-dev.ict.ru.ac.za");
    define("username", "MindUnits");
    define("password", "F0fmG6R1");
    define("database", "MindUnits");
    $conn= new mysqli(servername,username,password,database);
    if($conn->connect_error){
        die("<p classes=\"error\"><strong>Connection failed:</strong>" . $conn->connect_error ."</p>");
    }
    $sql= "SELECT * FROM users ";
    $results =$conn->query($sql);
    if($results===FALSE){
        die("Query failed to execute");
    }
    $conn->close();

    ?>
</body>
</html>