<?php
include 'db_connect.php';

$sql = "SELECT * FROM games";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Games List</title>
<style>
/* Body and Background */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-image: url(https://i.pinimg.com/1200x/6e/f3/8c/6ef38cd097dbc682dd5d064b11902eb1.jpg);
    color: #fff;
    overflow-x: hidden;
    animation: fadeIn 1s ease-in-out;
}

/* Heading */
h2 {
    margin: 2vh 0 1vh 0;
    text-align: center;
    font-size: 3vh;
    background: linear-gradient(90deg, #4facfe, #00f2fe);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 1px 1px 8px rgba(0,0,0,0.7);
}

/* Table Container */
.table-container {
    flex: 1;
    width: 95%;
    max-width: 1000px;
    overflow-y: auto;
    padding: 1vh 0;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(20,20,30,0.85);
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 30px rgba(79, 172, 254, 0.3);
    transition: all 0.3s ease-in-out;
}

th, td {
    padding: 1vh 1vw;
    text-align: center;
    font-size: 1.5vh;
    white-space: nowrap;
    transition: all 0.2s;
}

th {
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    color: #fff;
    text-shadow: 0 0 3px rgba(0,0,0,0.5);
    position: sticky;
    top: 0;
    z-index: 1;
}

tr:nth-child(even) { background: rgba(255,255,255,0.05); }
tr:hover { 
    background: rgba(79,172,254,0.1); 
    transform: scale(1.01); 
    box-shadow: 0 0 10px #4facfe inset;
}

/* Highlight warning rows */
.warning {
    background: rgba(255, 0, 0, 0.3) !important;
    color: #ff6b6b;
    font-weight: bold;
}

/* Menu Link */
.menu-link {
    margin: 1vh 0 2vh 0;
    text-decoration: none;
    background: linear-gradient(135deg, #8f94fb, #4e54c8);
    color: #fff;
    padding: 1vh 2vw;
    border-radius: 8px;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(0,0,0,0.5);
    transition: all 0.3s ease;
}

.menu-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.6);
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
}

/* Scrollbar Styling */
.table-container::-webkit-scrollbar { width: 8px; }
.table-container::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 4px; }
.table-container::-webkit-scrollbar-thumb { background: rgba(79,172,254,0.6); border-radius: 4px; }

/* Fade-in animation */
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(20px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>
</head>
<body>

<h2>📋 Games Roster</h2>

<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Max Players</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row_class = ($row['max_players'] == 0 || $row['max_players'] === null) ? "warning" : "";
                echo "<tr class='{$row_class}'>
                        <td>{$row['game_id']}</td>
                        <td>{$row['game_name']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['max_players']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No games found.</td></tr>";
        }
        ?>
    </table>
</div>

<a class="menu-link" href="index.h.html">⬅ Back to Homepage</a>

</body>
</html>
