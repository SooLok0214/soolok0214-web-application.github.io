<?php

$game = $_GET["game"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Game</title>

    <style>
        .game-box {
            width: 300px;
            border: 1px solid black;
            padding: 30px;
            text-align: center;
        }

        .number {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin: 10px;
        }
    </style>

</head>

<body>

    <?php

    if (isset($_GET["limit"])) {

        echo "<script>
            alert('Game $game can only be updated 2 times.');
          </script>";
    }

    ?>

    <div class="game-box">

        <h1>GAME <?php echo $game; ?></h1>

        <form action="check.php" method="POST">

            <input type="hidden"
                name="game"
                value="<?php echo $game; ?>">

            <button class="number" name="number" value="0">0</button>
            <button class="number" name="number" value="1">1</button>
            <button class="number" name="number" value="2">2</button>

            <br>

            <button class="number" name="number" value="3">3</button>
            <button class="number" name="number" value="4">4</button>
            <button class="number" name="number" value="5">5</button>

        </form>

        <br>

        <button onclick="window.location.href='gamelist.php'">
            Back
        </button>

    </div>

</body>

</html>