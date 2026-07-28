<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "EventBooking", "", "eventbooking");

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");

$email = $_SESSION["email"];
$filterDate = $_GET["event_date"] ?? "";


if (isset($_POST["event_id"])) {

    $eventID = (int) $_POST["event_id"];

    $check = $conn->prepare("
        SELECT booking_id
        FROM bookings
        WHERE email = ?
        AND event_id = ?
        AND booking_status = 'confirmed'
    ");

    $check->bind_param("si", $email, $eventID);
    $check->execute();

    if ($check->get_result()->num_rows == 0) {

        $event = $conn->query("
            SELECT available
            FROM events
            WHERE event_id = $eventID
        ")->fetch_assoc();

        if ($event && $event["available"] > 0) {

            $insert = $conn->prepare("
                INSERT INTO bookings
                (email, event_id, booking_status)
                VALUES (?, ?, 'confirmed')
            ");

            $insert->bind_param("si", $email, $eventID);
            $insert->execute();

            $conn->query("
                UPDATE events
                SET available = available - 1
                WHERE event_id = $eventID
                AND available > 0
            ");
        }
    }

    header(
        "Location: booking.php?event_date=" .
            urlencode($filterDate)
    );
    exit();
}


$bookedEventIDs = [];

$booked = $conn->prepare("
    SELECT event_id
    FROM bookings
    WHERE email = ?
    AND booking_status = 'confirmed'
");

$booked->bind_param("s", $email);
$booked->execute();

$result = $booked->get_result();

while ($row = $result->fetch_assoc()) {
    $bookedEventIDs[] = (int) $row["event_id"];
}


$dateResult = $conn->query("
    SELECT DISTINCT DATE(event_date) AS event_day
    FROM events
    ORDER BY event_day
");


if ($filterDate == "") {

    $eventsResult = $conn->query("
        SELECT *
        FROM events
        ORDER BY event_date
    ");
} else {

    $events = $conn->prepare("
        SELECT *
        FROM events
        WHERE DATE(event_date) = ?
        ORDER BY event_date
    ");

    $events->bind_param("s", $filterDate);
    $events->execute();

    $eventsResult = $events->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Book Event</title>

    <style>
        table {
            width: 800px;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>

<body>

    <p>
        <a href="booking.php">Booking</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </p>

    <h1>Book Your Event Ticket</h1>

    <form method="GET">

        <select
            name="event_date"
            onchange="this.form.submit()">

            <option value="">All Dates</option>

            <?php while ($date = $dateResult->fetch_assoc()) { ?>

                <option
                    value="<?= $date["event_day"] ?>"
                    <?= $filterDate == $date["event_day"]
                        ? "selected"
                        : "" ?>>

                    <?= date(
                        "d/m/Y",
                        strtotime($date["event_day"])
                    ) ?>

                </option>

            <?php } ?>

        </select>

    </form>

    <br>

    <table>

        <tr>
            <th>No.</th>
            <th>Date</th>
            <th>Event</th>
            <th>Price</th>
            <th>Available</th>
            <th>Action</th>
        </tr>

        <?php
        $number = 1;

        while ($event = $eventsResult->fetch_assoc()) {

            $eventID = (int) $event["event_id"];
            $available = (int) $event["available"];

            $isBooked = in_array(
                $eventID,
                $bookedEventIDs
            );
        ?>

            <tr>

                <td><?= $number++ ?></td>

                <td>
                    <?= date(
                        "d/m/Y",
                        strtotime($event["event_date"])
                    ) ?>
                </td>

                <td>
                    <?= ($event["event_name"]) ?>
                </td>

                <td>
                    RM <?= number_format($event["price"], 2) ?>
                </td>

                <td><?= $available ?> / 5</td>

                <td>

                    <form method="POST">

                        <input
                            type="hidden"
                            name="event_id"
                            value="<?= $eventID ?>">

                        <?php if ($isBooked) { ?>

                            <button disabled>Booked</button>

                        <?php } elseif ($available <= 0) { ?>

                            <button disabled>Full</button>

                        <?php } else { ?>

                            <button type="submit">
                                Book Ticket
                            </button>

                        <?php } ?>

                    </form>

                </td>

            </tr>

        <?php } ?>

    </table>

</body>

</html>

<?php $conn->close(); ?>