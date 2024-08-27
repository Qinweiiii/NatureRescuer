<?php
$conn = mysqli_connect("localhost", "root", "745213", "NatureRescuer");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventID = $_POST['eventID'];

    $sql1 = "DELETE FROM myact WHERE eventID = '$eventID'";
    $sql2 = "DELETE FROM events WHERE eventID = '$eventID'";
    
    if (mysqli_query($conn, $sql1) && mysqli_query($conn, $sql2)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
