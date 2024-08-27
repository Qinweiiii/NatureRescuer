<?php
$conn = mysqli_connect("localhost", "root", "745213", "NatureRescuer");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $eventID = $_POST['eventID'];
    $attr = 0; // 0 means that the activity is joined by user instead of created

    $sql = "INSERT INTO myact (eventID, attr) VALUES ('$eventID', '$attr')";
    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
