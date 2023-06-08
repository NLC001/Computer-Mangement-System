<?php
include 'functions.php';
// Database connection parameters
$host = 'localhost';
$username = 'lucky';
$password = '6%b48fCbUNZPfnQ';
$database = 'computers';

// Create a connection to the database
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the computer ID is provided in the query parameters
if (isset($_GET['id'])) {
    $computerId = $_GET['id'];

    // Delete the computer record from the database based on the provided ID
    $sql = "DELETE FROM computer_services WHERE id = '$computerId'";
    $result = mysqli_query($conn, $sql);

    // Check if the deletion was successful
    if ($result) {
        //echo "Computer deleted successfully";
    } else {
        echo "Error deleting computer: " . mysqli_error($conn);
    }
} else {
    echo "Invalid computer ID";
}

// Close the database connection
mysqli_close($conn);
?>
<?php
// Database connection parameters and other PHP logic...

// Output the HTML content
?>
<html>
<head>
    <title>Delete Computer</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #333;
        }

        .message {
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .message.success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .message.error {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>

    <?php
    // Check if the computer ID is provided in the query parameters and perform deletion logic...

    // Display the success or error message
    if ($result) {
        echo "<div class='message success'>Computer deleted successfully</div>";
    } else {
        echo "<div class='message error'>Error deleting computer: " . mysqli_error($conn) . "</div>";
    }
    ?>
 <h2>Delete Computer</h2>
    <!-- Additional content if needed -->
</body>
</html>
<?php
// Your existing code

// After displaying a message or at the end of the file
echo '<p></p>';
redirectButton();
?>


