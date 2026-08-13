<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Game List</title>

    <style>
        .box {
            width: 400px;
            border: 1px solid black;
            padding: 30px;
        }

        .game-title {
            margin-bottom: 5px;
        }

        .game-button {
            width: 350px;
            height: 50px;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .record-button {
            width: 350px;
            height: 50px;
            margin-top: 20px;
            font-size: 18px;
        }
    </style>

</head>

<body>

    <div class="box">

        <h3 class="game-title">Game 1</h3>

        <button class="game-button"
            onclick="window.location.href='game.php?game=1'">
            Game 1
        </button>


        <h3 class="game-title">Game 2</h3>

        <button class="game-button"
            onclick="window.location.href='game.php?game=2'">
            Game 2
        </button>


        <h3 class="game-title">Game 3</h3>

        <button class="game-button"
            onclick="window.location.href='game.php?game=3'">
            Game 3
        </button>


        <button class="record-button"
            onclick="window.location.href='record.php'">
            View Record
        </button>

    </div>

</body>

</html>