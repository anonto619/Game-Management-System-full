<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $player_id = $_POST['player_id'];
    $user_id = $_POST['user_id'];
    $team_id = $_POST['team_id'];
    $ranking = $_POST['ranking'];

    // Prepare the SQL query
    $sql = "INSERT INTO players (player_id, user_id, team_id, ranking) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $player_id, $user_id, $team_id, $ranking); // iiis = integer, integer, integer, string

    if ($stmt->execute()) {
        echo "<div class='success'>✅ Player added successfully!</div>";
    } else {
        echo "<div class='error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Player</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
     background-image: url(https://i.pinimg.com/736x/ca/62/8f/ca628f02e2558a454c8b77bf1bbb7590.jpg);

    color: #fff;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    background: rgba(0,0,0,0.85);
    padding: 3vh 3vw;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.7);
    width: 450px;
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

.success, .error {
    font-size: 1.6vh;
    margin-bottom: 2vh;
    font-weight: bold;
    padding: 1vh;
    border-radius: 6px;
}

.success { background: rgba(0,255,0,0.2); color: #7CFC00; }
.error { background: rgba(255,0,0,0.2); color: #FF6347; }

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
    box-shadow: 0 6px 15px rgba(0,0,0,0.6);
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
}

@media screen and (max-width: 480px) {
    .container { padding: 5vw; }
    input { font-size: 1.4vh; }
    button { font-size: 1.6vh; }
}
</style>
</head>
<body>

<div class="container">
    <h2>🙋 Add a New Player</h2>
    <form method="POST">
        <label>Player ID:</label>
        <input type="number" name="player_id" placeholder="Enter Player ID" required>

        <label>User ID:</label>
        <input type="number" name="user_id" placeholder="Enter User ID" required>

        <label>Team ID:</label>
        <input type="number" name="team_id" placeholder="Enter Team ID" required>

        <label>Ranking:</label>
        <input type="text" name="ranking" placeholder="Enter Ranking (Optional)">

        <button type="submit">➕ Add Player</button>
    </form>
    <a class="menu-link" href="index.h.html">⬅ Back to Homepage</a>
</div>

</body>
</html>
