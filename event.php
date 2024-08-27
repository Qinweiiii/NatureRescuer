<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Events</title>
    <link rel="stylesheet" href="eventStyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Black+Ops+One&family=Bona+Nova+SC:ital,wght@0,400;0,700;1,400&family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Titan+One&display=swap" rel="stylesheet">
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
    <div class="eventStart">
        Volunteer Events <br /> & Activities
    </div>
    <div class="event-list">
        <?php 
            $conn = mysqli_connect("localhost", "root", "745213", "NatureRescuer");
            $sql = "SELECT * FROM events";
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
                            <button onclick="registerEvent('.$row['eventID'].')">Register</button>
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
    <script>
        function registerEvent(eventID) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "registerEvent.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert('You have registered for the event.');
                }
            };
            xhr.send("eventID=" + eventID);
        }
    </script>
</body>
</html>
