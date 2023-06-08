<?php

// Database connection parameters
$host = 'localhost';
$username = 'lucky';
$password = '6%b48fCbUNZPfnQ';
$database = 'computers';

try {
    // Create a connection to the database
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check the connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    session_start(); // Start the session

    // Check if the login form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        // Get the username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate the username and password (You can customize the validation logic)
        if (verifyCredentials($username, $password)) {
            // Authentication successful for admin or user
            echo '<p class="success" style="color: #00FF00; font-weight: bold; font-size: 20px; ">Login Successful!</p>';

            // Determine the role and store it in the session
            $role = isAdmin($username) ? 'admin' : 'user';
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $role;

            // Redirect to the home page or any other page
            header('Location: index.php');
            exit;
        } else {
            // Authentication failed
            echo '<p class="Invalid" style="color: #ff0000; font-weight: bolder; font-size: 15px; ">Invalid Username or Password.</p>';

            // Store the user's login status in the session
            $_SESSION['loggedin'] = false;
        }
    }

    // Close the database connection
    mysqli_close($conn);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Function to verify the given credentials
function verifyCredentials($username, $password)
{
    global $conn; // Reference the database connection object

    // Check against the admins table
    $queryAdmin = "SELECT password FROM admins WHERE username = ?";
    $stmtAdmin = mysqli_prepare($conn, $queryAdmin);
    mysqli_stmt_bind_param($stmtAdmin, "s", $username);
    mysqli_stmt_execute($stmtAdmin);
    $resultAdmin = mysqli_stmt_get_result($stmtAdmin);

    if (mysqli_num_rows($resultAdmin) === 1) {
        $row = mysqli_fetch_assoc($resultAdmin);
        $hashedPassword = $row['password'];

        // Verify the provided password against the hashed password
        if (password_verify($password, $hashedPassword)) {
            return true;
        }
    }

    // Check against the users table
    $queryUser = "SELECT password FROM users WHERE username = ?";
    $stmtUser = mysqli_prepare($conn, $queryUser);
    mysqli_stmt_bind_param($stmtUser, "s", $username);
    mysqli_stmt_execute($stmtUser);
    $resultUser = mysqli_stmt_get_result($stmtUser);

    if (mysqli_num_rows($resultUser) === 1) {
        $row = mysqli_fetch_assoc($resultUser);
        $hashedPassword = $row['password'];

        // Verify the provided password against the hashed password
        if (password_verify($password, $hashedPassword)) {
            return true;
        }
    }

    return false;
}

// Function to check if the given username belongs to an admin
function isAdmin($username)
{
    global $conn; // Reference the database connection object

    // Check against the admins table
    $query = "SELECT * FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        return true;
    }

    return false;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            background-color: whitesmoke;
            font-family: Arial, sans-serif;
        }

        .login-form {
            background-color: #fff;
            padding: 50px;
            border-radius: 5px;
            width: 300px;
            margin: 20px auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .login-form input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .login-form .register-link {
            text-align: center;
            margin-top: 10px;
        }
        
        .login-form .register-link a {
            color: #333;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
            <div class="register-link">
                <a href="register.php">Register a new user</a>
            </div>
        </form>
    </div>
</body>
</html>
