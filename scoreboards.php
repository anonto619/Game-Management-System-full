<?php
include 'db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $match_id = $_POST['match_id'];
    $team_id = $_POST['team_id'];
    $position = $_POST['position'];

    $sql = "INSERT INTO scoreboards (match_id, team_id, position) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $match_id, $team_id, $position);

    if ($stmt->execute()) {
        $message = "<div class='success'>✅ Scoreboard entry added successfully!</div>";
    } else {
        $message = "<div class='error'>❌ Error: " . $conn->error . "</div>";
    }
}

// Fetch matches for dropdown
$matches = $conn->query("SELECT m.match_id, t1.team_name AS team1, t2.team_name AS team2, m.match_date 
                         FROM matches m
                         JOIN teams t1 ON m.team1_id = t1.team_id
                         JOIN teams t2 ON m.team2_id = t2.team_id
                         ORDER BY m.match_date ASC");

// Fetch teams for dropdown
$teams = $conn->query("SELECT team_id, team_name FROM teams ORDER BY team_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Scoreboard Management</title>
<style>
/* Styles remain the same as before */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-image: url(https://i.pinimg.com/736x/27/39/68/27396892b1699d5ee725ed19cc05e4be.jpg);

    color: #fff;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 3vh 2vw;
}

h2, h3 {
    text-align: center;
    text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
}

.container {
    background: rgba(0,0,0,0.85);
    padding: 3vh 3vw;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.7);
    width: 500px;
    max-width: 95%;
    margin-bottom: 3vh;
}

form label {
    display: block;
    margin-top: 2vh;
    margin-bottom: 0.5vh;
    font-size: 1.8vh;
    font-weight: bold;
    text-align: left;
}

input, select {
    width: 100%;
    padding: 1vh 1vw;
    border-radius: 8px;
    border: none;
    font-size: 1.6vh;
    margin-bottom: 2vh;
    background: rgba(255,255,255,0.1);
    color: #fff;
}

input::placeholder, select option {
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

.table-container {
    width: 90%;
    max-width: 800px;
    max-height: 50vh;
    overflow-y: auto;
    margin-top: 2vh;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(0,0,0,0.85);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.7);
}

th, td {
    padding: 1.2vh 1vw;
    text-align: center;
    font-size: 1.5vh;
    white-space: nowrap;
}

th {
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    color: #fff;
    text-shadow: 0 0 3px rgba(0,0,0,0.5);
}

tr:nth-child(even) { background: rgba(255,255,255,0.05); }
tr:hover { background: rgba(255,255,255,0.1); transform: scale(1.01); transition: 0.2s; }

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

.table-container::-webkit-scrollbar { width: 8px; }
.table-container::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 4px; }
.table-container::-webkit-scrollbar-thumb { background: rgba(143,148,251,0.6); border-radius: 4px; }

@media screen and (max-width: 768px) {
    input, select { font-size: 1.4vh; }
    th, td { font-size: 1.2vh; padding: 0.8vh 0.5vw; }
}
</style>
</head>
<body>

<div class="container">
    <h2>🏆 Scoreboard Management</h2>
    <?php if($message) echo $message; ?>
    <form method="POST">
        <label>Match:</label>
        <select name="match_id" required>
            <option value="">-- Select a Match --</option>
            <?php
            if ($matches->num_rows > 0) {
                while ($row = $matches->fetch_assoc()) {
                    echo "<option value='{$row['match_id']}'>Match #{$row['match_id']}: {$row['team1']} vs {$row['team2']} ({$row['match_date']})</option>";
                }
            }
            ?>
        </select>

        <label>Team:</label>
        <select name="team_id" required>
            <option value="">-- Select a Team --</option>
            <?php
            if ($teams->num_rows > 0) {
                while ($row = $teams->fetch_assoc()) {
                    echo "<option value='{$row['team_id']}'>{$row['team_name']}</option>";
                }
            }
            ?>
        </select>

        <label>Position:</label>
        <input type="number" name="position" placeholder="Enter Position">

        <button type="submit">➕ Add to Scoreboard</button>
    </form>
    <a class="menu-link" href="index.h.html">⬅ Back to Homepage</a>
</div>

<h3>Current Scoreboards</h3>
<div class="table-container">
<?php
$result = $conn->query("SELECT s.scoreboard_id, m.match_id, t.team_name, s.position
                        FROM scoreboards s
                        JOIN matches m ON s.match_id = m.match_id
                        JOIN teams t ON s.team_id = t.team_id
                        ORDER BY s.position ASC");

if ($result->num_rows > 0) {
    echo "<table>
          <tr><th>ID</th><th>Match</th><th>Team</th><th>Position</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
              <td>{$row['scoreboard_id']}</td>
              <td>{$row['match_id']}</td>
              <td>{$row['team_name']}</td>
              <td>{$row['position']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p style='text-align:center; margin-top:2vh;'>No scoreboard records yet.</p>";
}
?>
</div>

</body>
</html>
