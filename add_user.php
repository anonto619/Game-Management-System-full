<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (user_id, name, email, password) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $name, $email, $password);

    if ($stmt->execute()) {
        echo "<div class='success'>✅ User added successfully!</div>";
    } else {
        echo "<div class='error'>❌ Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add User</title>
<style>
/* General Body */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-image: url(https://i.pinimg.com/736x/2d/3c/fb/2d3cfb8647dafd3b71dc56a5357bdcee.jpg);
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    overflow-x: hidden;
    animation: fadeIn 1s ease-in-out;

}

/* Container */
.container {
    background: rgba(20,20,30,0.9);
    padding: 4vh 3vw;
    border-radius: 2vh;
    box-shadow: 0 10px 25px rgba(0,0,0,0.7);
    width: 90%;
    max-width: 450px;
    display: flex;
    flex-direction: column;
    gap: 1.8vh;
    position: relative;
    overflow: hidden;
}

/* Animated gradient overlay */
.container::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, #ff6ec4, #7873f5, #4facfe, #00f2fe);
    animation: gradientMove 6s linear infinite;
    z-index: 0;
    opacity: 0.15;
}

/* Heading */
h2 {
    text-align: center;
    font-size: 3.5vh;
    background: linear-gradient(90deg, #00f2fe, #4facfe);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 1px 1px 8px rgba(0,0,0,0.6);
    z-index: 1;
    position: relative;
}

/* Labels */
label {
    font-weight: bold;
    font-size: 2vh;
    z-index: 1;
    position: relative;
}

/* Inputs */
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
    margin-top: 2vh;
    text-align: center;
    z-index: 1;
    position: relative;
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

/* Alerts */
.success {
    color: #00ff7f;
    text-align: center;
    font-weight: bold;
    margin-bottom: 1vh;
    z-index: 1;
    position: relative;
}

.error {
    color: #ff4d4d;
    text-align: center;
    font-weight: bold;
    margin-bottom: 1vh;
    z-index: 1;
    position: relative;
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

<div class="container">
    <h2>➕ Add New User</h2>

    <form method="POST">
        <label>User ID (Primary Key):</label>
        <input type="number" name="user_id" required placeholder="Enter unique user ID">

        <label>Name:</label>
        <input type="text" name="name" required placeholder="Enter name">

        <label>Email:</label>
        <input type="email" name="email" required placeholder="Enter email">

        <label>Password:</label>
        <input type="password" name="password" required placeholder="Enter password">

        <button type="submit">Add User</button>
    </form>

    <div class="menu-link">
        <a href="index.h.html">⬅ Back to Homepage</a>
    </div>
</div>

</body>
</html>
