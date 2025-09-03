<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>System Reports</title>
<style>
/* General Body */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 2vh 2vw;
    min-height: 100vh;
    background: #000; /* Solid black background */
    color: #fff;
}

/* Heading */
h2 {
    text-align: center;
    font-size: 4vh;
    margin-bottom: 3vh;
    background: linear-gradient(90deg, #4facfe, #00f2fe);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 0 8px rgba(0,0,0,0.7);
}

/* Sections */
.section {
    background: rgba(20,20,20,0.95);
    padding: 2vh 2vw;
    margin-bottom: 3vh;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(79,172,254,0.3);
    transition: transform 0.3s, box-shadow 0.3s;
}

.section:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(79,172,254,0.6);
}

.section h3 {
    margin-top: 0;
    margin-bottom: 1.5vh;
    font-size: 2.5vh;
    color: #8f94fb;
    text-shadow: 0 0 8px #4facfe;
}

/* Report Items */
.report-item {
    padding: 0.8vh 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    font-size: 1.8vh;
    transition: all 0.2s;
}

.report-item:last-child {
    border-bottom: none;
}

.report-item:hover {
    color: #00f2fe;
    text-shadow: 0 0 5px #4facfe;
}

/* Buttons & Links */
a.menu-link, #downloadPdf {
    display: inline-block;
    margin: 3vh auto;
    text-decoration: none;
    background: linear-gradient(135deg, #8f94fb, #4e54c8);
    color: #fff;
    padding: 1vh 2vw;
    border-radius: 8px;
    font-weight: bold;
    text-align: center;
    box-shadow: 0 5px 15px rgba(79,172,254,0.5);
    transition: 0.3s;
    cursor: pointer;
}

a.menu-link:hover, #downloadPdf:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 18px rgba(79,172,254,0.8);
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
}

/* Responsive */
@media screen and (max-width: 768px) {
    h2 { font-size: 3vh; }
    .section h3 { font-size: 2vh; }
    .report-item { font-size: 1.6vh; }
}
</style>
</head>
<body>

<h2>📊 System Reports</h2>

<!-- PDF Button -->
<button id="downloadPdf">⬇️ View / Download PDF</button>

<div class="section">
    <h3>📋 Games</h3>
    <?php
    $games = $conn->query("SELECT * FROM games");
    if ($games->num_rows > 0) {
        while ($row = $games->fetch_assoc()) {
            echo "<div class='report-item'>Game: {$row['game_name']} ({$row['category']}) | Max Players: {$row['max_players']}</div>";
        }
    } else {
        echo "<div class='report-item'>No games found.</div>";
    }
    ?>
</div>

<div class="section">
    <h3>👥 Teams</h3>
    <?php
    $teams = $conn->query("SELECT t.team_name, g.game_name 
                            FROM teams t
                            JOIN games g ON t.game_id = g.game_id");
    if ($teams->num_rows > 0) {
        while ($row = $teams->fetch_assoc()) {
            echo "<div class='report-item'>Team: {$row['team_name']} | Game: {$row['game_name']}</div>";
        }
    } else {
        echo "<div class='report-item'>No teams found.</div>";
    }
    ?>
</div>

<div class="section">
    <h3>🙋 Players</h3>
    <?php
    $players = $conn->query("SELECT p.player_id, u.name, t.team_name, p.ranking
                             FROM players p
                             JOIN users u ON p.user_id = u.user_id
                             JOIN teams t ON p.team_id = t.team_id");
    if ($players->num_rows > 0) {
        while ($row = $players->fetch_assoc()) {
            echo "<div class='report-item'>Player: {$row['name']} | Team: {$row['team_name']} | Rank: {$row['ranking']}</div>";
        }
    } else {
        echo "<div class='report-item'>No players found.</div>";
    }
    ?>
</div>

<div class="section">
    <h3>⚔️ Matches</h3>
    <?php
    $matches = $conn->query("SELECT m.match_id, t1.team_name AS team1, t2.team_name AS team2, m.match_date, m.status, m.result
                             FROM matches m
                             JOIN teams t1 ON m.team1_id = t1.team_id
                             JOIN teams t2 ON m.team2_id = t2.team_id");
    if ($matches->num_rows > 0) {
        while ($row = $matches->fetch_assoc()) {
            echo "<div class='report-item'>Match #{$row['match_id']}: {$row['team1']} vs {$row['team2']} | Date: {$row['match_date']} | Status: {$row['status']} | Result: {$row['result']}</div>";
        }
    } else {
        echo "<div class='report-item'>No matches recorded.</div>";
    }
    ?>
</div>

<a class="menu-link" href="index.h.html">⬅ Back to Homepage</a>

<!-- Include html2pdf.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.getElementById("downloadPdf").addEventListener("click", () => {
    const element = document.createElement('div');
    document.querySelectorAll('.section').forEach(sec => {
        element.appendChild(sec.cloneNode(true));
    });

    const opt = {
        margin:       0.5,
        filename:     'system_reports.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(element).save();
});
</script>

</body>
</html>
