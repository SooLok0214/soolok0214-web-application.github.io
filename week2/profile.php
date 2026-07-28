<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli(
    "localhost",
    "EventBooking",
    "",
    "eventbooking"
);

if ($conn->connect_error) {
    die("Database connection failed.");
}

$conn->set_charset("utf8mb4");

$email = mysqli_real_escape_string(
    $conn,
    $_SESSION["email"]
);


$userSql = "
    SELECT user_id, name, email, phone_number, joinyear
    FROM users
    WHERE email = '$email'
";

$userResult = mysqli_query($conn, $userSql);
$user = mysqli_fetch_assoc($userResult);


if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}


$bookingSql = "
    SELECT
        events.event_name,
        events.event_date,
        bookings.booked_at
    FROM bookings
    JOIN events
    ON bookings.event_id = events.event_id
    WHERE bookings.email = '$email'
    AND bookings.booking_status = 'confirmed'
    ORDER BY events.event_date
";

$bookingResult = mysqli_query($conn, $bookingSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>User Profile</title>

    <style>
        table {
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

    <h1>User Profile</h1>

    <table>
        <tr>
            <th>User ID</th>
            <td><?= ($user["user_id"]) ?></td>
        </tr>

        <tr>
            <th>Name</th>
            <td><?= ($user["name"]) ?></td>
        </tr>

        <tr>
            <th>Email</th>
            <td><?= ($user["email"]) ?></td>
        </tr>

        <tr>
            <th>Phone Number</th>
            <td><?= ($user["phone_number"]) ?></td>
        </tr>

        <tr>
            <th>Join Year</th>
            <td><?= ($user["joinyear"]) ?></td>
        </tr>
    </table>


    <h2>My Tickets</h2>

    <?php if ($bookingResult->num_rows > 0) { ?>

        <table>
            <tr>
                <th>No.</th>
                <th>Event</th>
                <th>Event Date</th>
                <th>Price</th>
                <th>Booked At</th>
            </tr>

            <?php
            $number = 1;

            while ($booking = $bookingResult->fetch_assoc()) {
            ?>

                <tr>
                    <td>
                        <?= $number++ ?>
                    </td>

                    <td>
                        <?= $booking["event_name"] ?>
                    </td>

                    <td>
                        <?= date(
                            "d/m/Y",
                            strtotime($booking["event_date"])
                        ) ?>
                    </td>

                    <td>
                        RM <?= number_format($booking["price"], 2) ?>
                    </td>

                    <td>
                        <?= date(
                            "d/m/Y",
                            strtotime($booking["booked_at"])
                        ) ?>
                    </td>
                </tr>

            <?php } ?>

        </table>

    <?php } else { ?>

        <p>You have not booked an event yet.</p>

        <a href="booking.php">Book an Event</a>

    <?php } ?>

</body>

</html>

<?php $conn->close(); ?>