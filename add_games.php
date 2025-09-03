<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $game_id = intval($_POST['game_id']); 
    $game_name = trim($_POST['game_name']);
    $category = trim($_POST['category']);
    $max_players = intval($_POST['max_players']);

    $check = $conn->prepare("SELECT game_id FROM games WHERE game_id=?");
    $check->bind_param("i", $game_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<div class='alert'>Error: Game ID already exists.</div>";
    } else {
        $sql = "INSERT INTO games (game_id, game_name, category, max_players) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issi", $game_id, $game_name, $category, $max_players);

        if ($stmt->execute()) {
            header("Location: view_games.php?success=1");
            exit();
        } else {
            echo "<div class='alert'>Error: " . $conn->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Game</title>
<style>
/* General Body */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
     background-image: url(https://i.pinimg.com/736x/41/a3/26/41a326e56c49e28ccce8be93ab898c4c.jpg);
    color: #fff;
    margin: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    overflow-x: hidden;
    animation: fadeIn 1s ease-in-out;
}

/* Heading */
h2 {
    margin-top: 5vh;
    font-size: 3.5vh;
    background: linear-gradient(90deg, #00f2fe, #4facfe);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
    text-shadow: 1px 1px 8px rgba(0,0,0,0.6);
}

/* Form Container */
form {
    background: rgba(20,20,30,0.85);
    padding: 4vh 3vw;
    margin: 3vh 0;
    border-radius: 2vh;
    box-shadow: 0 10px 25px rgba(0,0,0,0.7);
    width: 90%;
    max-width: 450px;
    display: flex;
    flex-direction: column;
    gap: 1.8vh;
    border: 1px solid rgba(255,255,255,0.1);
    position: relative;
    overflow: hidden;
}

form::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, #ff6ec4, #7873f5, #4facfe, #00f2fe);
    animation: gradientMove 6s linear infinite;
    z-index: 0;
    opacity: 0.2;
}

/* Labels and Inputs */
label {
    font-weight: bold;
    font-size: 2vh;
    margin-bottom: 0.5vh;
    z-index: 1;
    position: relative;
}

input {
    padding: 1.2vh;
    border-radius: 1vh;
    border: none;
    font-size: 1.8vh;
    outline: none;
    background: rgba(255,255,255,0.05);
    color: #fff;
    z-index: 1;
    position: relative;
    transition: 0.3s;
}

input:focus {
    box-shadow: 0 0 12px #4facfe;
    background: rgba(255,255,255,0.1);
}

/* Button */
button {
    padding: 1.5vh;
    font-size: 2vh;
    border: none;
    border-radius: 1vh;
    background: linear-gradient(135deg, #ff6ec4, #7873f5);
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: 0.4s;
    box-shadow: 0 5px 15px rgba(0,0,0,0.6);
    z-index: 1;
    position: relative;
}

button:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.8);
    background: linear-gradient(135deg, #4facfe, #00f2fe);
}

/* Menu Link */
.menu-link {
    margin-bottom: 5vh;
    z-index: 1;
}

.menu-link a {
    color: #00f2fe;
    text-decoration: none;
    font-size: 2vh;
    transition: 0.3s;
}

.menu-link a:hover {
    color: #ff6ec4;
    text-shadow: 0 0 10px #ff6ec4;
}

/* Alert */
.alert {
    text-align: center;
    margin: 2vh 0;
    padding: 1vh;
    background: rgba(255,0,0,0.2);
    color: #ff6b6b;
    border-radius: 1vh;
    font-weight: bold;
}

/* Animations */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}

@keyframes gradientMove {
    0% {transform: rotate(0deg);}
    50% {transform: rotate(180deg);}
    100% {transform: rotate(360deg);}
}

</style>
</head>
<body>

<h2>➕ Add a New Game</h2>

<form method="POST">
    <label>Game ID (Primary Key):</label>
    <input type="number" name="game_id" required placeholder="Enter unique game ID">

    <label>Game Name:</label>
    <input type="text" name="game_name" required placeholder="Enter game name">

    <label>Category:</label>
    <input type="text" name="category" placeholder="Enter category">

    <label>Max Players:</label>
    <input type="number" name="max_players" placeholder="Enter max players">

    <button type="submit">Add Game</button>
</form>

<div class="menu-link">
    <a href="index.h.html">⬅ Back to Menu</a>
</div>

</body>
</html>
