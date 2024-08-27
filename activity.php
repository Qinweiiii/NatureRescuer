<?php
$conn = mysqli_connect("localhost", "root", "745213", "NatureRescuer");

$eName = "";
$description = "";
$address = "";
$start_time = "";
$end_time = "";
$imgAddr = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the request is for updating an event
    if (isset($_POST['update'])) {
        $eventID = $_POST['eventID'];
        $eName = $_POST['eName'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $imgAddr = $_POST['imgAddr'];

        do {
            if (empty($eName) || empty($description) || empty($address) || empty($start_time) || empty($end_time) || empty($imgAddr)) {
                $errorMessage = "All fields are mandatory";
                break;
            }

            $sql = "UPDATE events SET eName='$eName', description='$description', address='$address', start_time='$start_time', end_time='$end_time', imgAddr='$imgAddr' WHERE eventID='$eventID'";
            $result = $conn->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $conn->error;
                break;
            }

            header("Location: activity.php");
            exit;

        } while (true);

    } else {
        // Handle create event request
        $eName = $_POST['eName'];
        $description = $_POST['description'];
        $address = $_POST['address'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];
        $imgAddr = $_POST['imgAddr'];

        do {
            if (empty($eName) || empty($description) || empty($address) || empty($start_time) || empty($end_time) || empty($imgAddr)) {
                $errorMessage = "All fields are mandatory";
                break;
            }

            $sql = "INSERT INTO events (eName, description, address, start_time, end_time, imgAddr)".
                " VALUES ('$eName', '$description', '$address', '$start_time', '$end_time', '$imgAddr')";
            $result = $conn->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $conn->error;
                break;
            }

            $eventID = $conn->insert_id;
            $attr = 1;

            $sql2 = "INSERT INTO myact (eventID, attr) VALUES ('$eventID', '$attr')";
            $result2 = $conn->query($sql2);

            if (!$result2) {
                $errorMessage = "Invalid query: " . $conn->error;
                break;
            }

            $eName = "";
            $description = "";
            $address = "";
            $start_time = "";
            $end_time = "";
            $imgAddr = "";

            header("Location: activity.php");
            exit;

        } while (true);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Activities</title>
    <link rel="stylesheet" href="activityStyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400;1,700&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Titan+One&display=swap" rel="stylesheet">
</head>
<body>
    <header id="header">
        <div class="logo">
            <img src="./images/logo.png" alt="Website Logo">
        </div>
        <nav class="left-nav">
            <a href="index.html">Home</a>
            <a href="event.php">Volunteer Events</a>
        </nav>
        <nav class="right-nav">
            <a href="activity.php">My Activities</a>
        </nav>
    </header>    
    <div class="actStart">
        Be the Hero to <br /> Rescue Nature
    </div>
    
    <div class="joinAct">
        <h1>Activities I Joined</h1>
        <a href="event.php"><button>Join Activity</button></a>
        <div class="event-list">
            <?php 
                $conn = mysqli_connect("localhost", "root", "745213", "NatureRescuer");
                $sql = "SELECT e.* FROM events e JOIN myact m ON e.eventID = m.eventID WHERE m.attr = 0";
                $result = mysqli_query($conn, $sql);

                while($row = $result -> fetch_assoc()){
                    echo '
                    <div class="event">
                        <div class="event-info">
                            <img src="'.$row['imgAddr'].'" alt="EventImg">
                            <div class="info">
                                <h2>'.$row['eName'].'</h2>
                                <p>
                                    <span>Start</span>: '.$row['start_time'].'<br>
                                    <span>&nbsp;End&nbsp;</span>: '.$row['end_time'].'<br>
                                    <span>Address</span>: '.$row['address'].'
                                </p>
                                <button onclick="quitEvent('.$row['eventID'].')">Quit</button>
                            </div>
                        </div>
                        <div class="event-description">
                            <h3>Description</h3>
                            <p>'.$row['description'].'</p>
                        </div>
                    </div>
                    ';
                }
            ?>
        </div>
    </div>

    <div style="width: 90%; border: 3px dotted darkgreen; background-color: darkgreen; margin-top: 2em;"></div>

    <div class="createAct">
        <h1>Activities I Created</h1>
        <button id="createButton">Create Activity</button>
        <br/><br/><br/>

        <form id="createForm" method="post" style="display: none;">
            <h2 style="margin-bottom: 1em; color: white; font-family: Algerian; font-weight: 400; font-size: 30px;">Create Activity Form</h2>
            <table>
                <tr>
                    <td class="colName">
                        Name
                    </td>
                    <td>
                        <input type="text" name="eName" placeholder="Event Name" class="colInput" required>
                    </td>
                </tr>
                <tr>
                    <td class="colName">
                        Description
                    </td>
                    <td>
                        <input type="text" name="description" placeholder="Description of Event" class="colInput" required>
                    </td>
                </tr>
                <tr>
                    <td class="colName">
                        Address
                    </td>
                    <td>
                        <input type="text" name="address" placeholder="Kuala Lumpur, Malaysia" class="colInput" required>
                    </td>
                </tr>
                <tr>
                    <td class="colName">
                        Start Time
                    </td>
                    <td>
                        <input type="text" name="start_time" placeholder="2024-07-16 12am" class="colInput" required>
                    </td>
                </tr>
                <tr>
                    <td class="colName">
                        End Time
                    </td>
                    <td>
                        <input type="text" name="end_time" placeholder="2024-07-26 24pm" class="colInput" required>
                    </td>
                </tr>
                <tr>
                    <td class="colName">
                        Event Image
                    </td>
                    <td>
                        <input type="text" name="imgAddr" placeholder="Please input a public image url" class="colInput" required>
                    </td>
                </tr>
            </table>
            <button id="submitButton" type="submit" style="padding: 1em; margin-top: 1em;">Submit</button>
        </form>

        <div class="myAct-list">
            <?php
                $sql = "SELECT e.* FROM events e JOIN myact m ON e.eventID = m.eventID WHERE m.attr = 1";
                $result = mysqli_query($conn, $sql);

                while($row = $result -> fetch_assoc()){
                    echo '
                    <div class="myAct">
                        <div class="myAct-info">
                            <img src="'.$row['imgAddr'].'" alt="EventImg">
                            <div class="ma-info">
                                <h2>'.$row['eName'].'</h2>
                                <p>
                                    <span>Start</span>: '.$row['start_time'].'<br>
                                    <span>&nbsp;End&nbsp;</span>: '.$row['end_time'].'<br>
                                    <span>Address</span>: '.$row['address'].'
                                </p>
                                <div>
                                    <button class="updateButton" onclick="showUpdateForm('.$row['eventID'].')">Update</button>
                                    <button class="deleteButton" onclick="deleteEvent('.$row['eventID'].')">Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="myAct-description">
                            <h3>Description</h3>
                            <p>'.$row['description'].'</p>
                        </div>
                        <form id="updateForm'.$row['eventID'].'" method="post" style="display: none; width: 90%; margin: 10px 5%;">
                            <h2 style="margin-bottom: 1em; color: white; font-family: Algerian; font-weight: 400; font-size: 30px;">Update Activity Form</h2>
                            <input type="hidden" name="eventID" value="'.$row['eventID'].'">
                            <input type="hidden" name="update" value="true">
                            <table>
                                <tr>
                                    <td class="colName">
                                        Name
                                    </td>
                                    <td>
                                        <input type="text" name="eName" placeholder="Event Name" class="colInput" value="'.$row['eName'].'" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colName">
                                        Description
                                    </td>
                                    <td>
                                        <input type="text" name="description" placeholder="Description of Event" class="colInput" value="'.$row['description'].'" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colName">
                                        Address
                                    </td>
                                    <td>
                                        <input type="text" name="address" placeholder="Kuala Lumpur, Malaysia" class="colInput" value="'.$row['address'].'" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colName">
                                        Start Time
                                    </td>
                                    <td>
                                        <input type="text" name="start_time" placeholder="2024-07-16 12am" class="colInput" value="'.$row['start_time'].'" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colName">
                                        End Time
                                    </td>
                                    <td>
                                        <input type="text" name="end_time" placeholder="2024-07-26 24pm" class="colInput" value="'.$row['end_time'].'" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="colName">
                                        Event Image
                                    </td>
                                    <td>
                                        <input type="text" name="imgAddr" placeholder="Please input a public image url" class="colInput" value="'.$row['imgAddr'].'" required>
                                    </td>
                                </tr>
                            </table>
                            <button id="updateButton" type="submit" style="padding: 1em; margin-top: 1em;">Update</button>
                        </form>
                    </div>
                    ';
                }
            ?>
        </div>

    </div>

    <script>
        document.getElementById('createButton').addEventListener('click', function() {
            var form = document.getElementById('createForm');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            }
        });

        function showUpdateForm(eventID) {
            var form = document.getElementById('updateForm' + eventID);
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            }
        }

        function quitEvent(eventID) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "quitEvent.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert('You have quit the event');
                    location.reload();
                }
            };
            xhr.send("eventID=" + eventID);
        }

        function deleteEvent(eventID) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deleteEvent.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert('Event deleted successfully');
                    location.reload();
                }
            };
            xhr.send("eventID=" + eventID);
        }
    </script>
</body>
</html>
