<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team_name = $_POST['team_name'];
    $game_id = $_POST['game_id'];

    $sql = "INSERT INTO teams (team_name, game_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $team_name, $game_id);

    if ($stmt->execute()) {
        echo "<div class='success'>✅ Team added successfully!</div>";
    } else {
        echo "<div class='error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Team</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-image: url(https://i.pinimg.com/736x/62/50/b0/6250b09b79eb4582b34459659587fadc.jpg);

        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        color: #fff;
    }

    .container {
        background: rgba(0,0,0,0.85);
        padding: 3vh 3vw;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.7);
        width: 400px;
        max-width: 90%;
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(-20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h2 {
        margin-bottom: 3vh;
        font-size: 3vh;
        text-shadow: 1px 1px 6px rgba(0,0,0,0.7);
    }

    label {
        display: block;
        margin-top: 2vh;
        margin-bottom: 0.5vh;
        font-size: 1.8vh;
        font-weight: bold;
        text-align: left;
    }

    input {
        width: 100%;
        padding: 1.2vh 1vw;
        border-radius: 8px;
        border: none;
        font-size: 1.6vh;
        margin-bottom: 2vh;
        background: rgba(255,255,255,0.1);
        color: #fff;
    }

    input::placeholder {
        color: #ccc;
    }

    button {
        width: 100%;
        padding: 1.5vh 0;
        font-size: 1.8vh;
        background: linear-gradient(135deg, #4e54c8, #8f94fb);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 5px 12px rgba(0,0,0,0.6);
        transition: all 0.3s ease;
    }

    button:hover {
        background: linear-gradient(135deg, #8f94fb, #4e54c8);
        transform: translateY(-2px);
        box-shadow: 0 7px 15px rgba(0,0,0,0.7);
    }

    .menu-link {
        display: inline-block;
        margin-top: 3vh;
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        padding: 1vh 2vw;
        border-radius: 8px;
        background: linear-gradient(135deg, #8f94fb, #4e54c8);
        box-shadow: 0 4px 10px rgba(0,0,0,0.5);
        transition: 0.3s;
    }

    .menu-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.6);
        background: linear-gradient(135deg, #4e54c8, #8f94fb);
    }

    .success, .error {
        font-size: 1.6vh;
        margin-bottom: 2vh;
        font-weight: bold;
        padding: 1vh;
        border-radius: 6px;
    }

    .success { background: rgba(0,255,0,0.2); color: #7CFC00; }
    .error { background: rgba(255,0,0,0.2); color: #FF6347; }

</style>
</head>
<body>

<div class="container">
    <h2>🏆 Add a New Team</h2>
    <form method="POST">
        <label>Team Name:</label>
        <input type="text" name="team_name" placeholder="Enter team name" required>

        <label>Game ID:</label>
        <input type="number" name="game_id" placeholder="Enter game ID" required>

        <button type="submit">➕ Add Team</button>
    </form>
    <a class="menu-link" href="index.h.html">⬅ Back to Homepage</a>
</div>

</body>
</html>
