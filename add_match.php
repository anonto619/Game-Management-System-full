<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];
    $date = $_POST['match_date'];
    $status = $_POST['status'];

    $sql = "INSERT INTO matches (team1_id, team2_id, match_date, status) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $team1, $team2, $date, $status);

    if ($stmt->execute()) {
        echo "<div class='success'>✅ Match recorded successfully!</div>";
    } else {
        echo "<div class='error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Match</title>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-image: url(https://i.pinimg.com/736x/0d/7f/9e/0d7f9e3a1b360559eba1b49d2ae31f8c.jpg);

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

    input, select {
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
        box-shadow: 0 6px 12px rgba(0,0,0,0.6);
        background: linear-gradient(135deg, #4e54c8, #8f94fb);
    }

    @media screen and (max-width: 480px) {
        .container { padding: 5vw; }
        input, select { font-size: 1.4vh; }
        button { font-size: 1.6vh; }
    }
</style>
</head>
<body>

<div class="container">
    <h2>⚔️ Record a New Match</h2>
    <form method="POST">
        <label>Team 1 ID:</label>
        <input type="number" name="team1" placeholder="Enter Team 1 ID" required>

        <label>Team 2 ID:</label>
        <input type="number" name="team2" placeholder="Enter Team 2 ID" required>

        <label>Match Date:</label>
        <input type="date" name="match_date" required>

        <label>Status:</label>
        <input type="text" name="status" placeholder="Scheduled / Completed / Cancelled">

        <button type="submit">➕ Add Match</button>
    </form>
    <a class="menu-link" href="index.h.html">⬅ Back to Homepage</a>
</div>

</body>
</html>
