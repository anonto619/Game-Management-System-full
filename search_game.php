<?php
include 'db_connect.php';

$result = null;
if (isset($_GET['q']) && $_GET['q'] !== '') {
    $q = $_GET['q'];

    if (is_numeric($q)) {
        $sql = "SELECT * FROM games WHERE game_id = ? OR game_name LIKE ? OR category LIKE ?";
        $stmt = $conn->prepare($sql);
        $like = "%$q%";
        $stmt->bind_param("iss", $q, $like, $like);
    } else {
        $sql = "SELECT * FROM games WHERE game_name LIKE ? OR category LIKE ?";
        $stmt = $conn->prepare($sql);
        $like = "%$q%";
        $stmt->bind_param("ss", $like, $like);
    }

    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Games</title>
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
    background: #000; /* Solid black background */
    color: #fff;
}

/* Heading */
h2 {
    margin: 4vh 0 3vh 0;
    text-align: center;
    font-size: 4vh;
    background: linear-gradient(90deg, #4facfe, #00f2fe);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 0 8px rgba(0,0,0,0.7);
}

/* Search Form */
form {
    text-align: center;
    margin-bottom: 4vh;
}

input[type="text"] {
    padding: 1.5vh 1.5vw;
    font-size: 2vh;
    border: none;
    border-radius: 10px;
    width: 25vw;
    max-width: 350px;
    margin-right: 1vw;
    background: rgba(255,255,255,0.05);
    color: #fff;
    outline: none;
    transition: 0.3s;
}

input[type="text"]:focus {
    box-shadow: 0 0 12px #4facfe;
    background: rgba(255,255,255,0.1);
}

button {
    padding: 1.5vh 2.5vw;
    font-size: 2vh;
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    border: none;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 5px 8px rgba(0,0,0,0.6);
    transition: all 0.3s ease;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.8);
    background: linear-gradient(135deg, #8f94fb, #4e54c8);
}

/* Table Container */
.table-container {
    width: 90%;
    max-height: 65vh;
    overflow-y: auto;
    margin-bottom: 4vh;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    background: rgba(20,20,20,0.95);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(79,172,254,0.5);
}

th, td {
    padding: 1.8vh 1.5vw;
    text-align: center;
    font-size: 1.8vh;
    white-space: nowrap;
    transition: all 0.2s;
}

th {
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
    color: #fff;
    text-shadow: 0 0 4px rgba(0,0,0,0.5);
    position: sticky;
    top: 0;
    z-index: 1;
}

tr:nth-child(even) {
    background: rgba(255,255,255,0.07);
}

tr:hover {
    background: rgba(79,172,254,0.15);
    transform: scale(1.02);
    box-shadow: 0 0 15px #4facfe inset;
}

/* Menu Link */
.menu-link {
    text-decoration: none;
    background: linear-gradient(135deg, #8f94fb, #4e54c8);
    color: #fff;
    padding: 1.5vh 3vw;
    border-radius: 10px;
    font-size: 2vh;
    font-weight: bold;
    box-shadow: 0 5px 12px rgba(0,0,0,0.6);
    transition: all 0.3s ease;
}

.menu-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.7);
    background: linear-gradient(135deg, #4e54c8, #8f94fb);
}

/* Scrollbar Styling */
.table-container::-webkit-scrollbar { width: 10px; }
.table-container::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); border-radius: 5px; }
.table-container::-webkit-scrollbar-thumb { background: rgba(143,148,251,0.7); border-radius: 5px; }

/* Responsive */
@media screen and (max-width: 768px) {
    input[type="text"] { width: 65%; font-size: 1.8vh; }
    th, td { font-size: 1.5vh; padding: 1.2vh 0.5vw; }
    .menu-link { font-size: 1.8vh; padding: 1.2vh 2vw; }
}
</style>
</head>
<body>

<h2>🔍 Search Games</h2>

<form method="GET">
    <input type="text" name="q" placeholder="Enter ID, Name, or Category..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
    <button type="submit">Search</button>
</form>

<?php if ($result !== null): ?>
    <div class="table-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Game Name</th>
                <th>Category</th>
                <th>Max Players</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['game_id']; ?></td>
                        <td><?php echo $row['game_name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['max_players']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4">No games found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
<?php endif; ?>

<a class="menu-link" href="index.h.html">⬅ Back to Homepage</a>

</body>
</html>
