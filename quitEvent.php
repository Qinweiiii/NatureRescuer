<?php
$conn = mysqli_connect("localhost", "root", "745213", "NatureRescuer");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventID = $_POST['eventID'];

    $sql = "DELETE FROM myact WHERE eventID = '$eventID' AND attr = 0";
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
