<?php
session_start(); // Start the session

// Check if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to the login page or display an error message
    header('Location: login.php');
    exit;
}

class Computer {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method to create a computer
    public function createComputer($name, $model, $serialNumber, $specifications) {
        // Prepare the INSERT statement
        $sql = "INSERT INTO computers (name, model, serial_number, specifications)
                VALUES ('$name', '$model', '$serialNumber', '$specifications')";

        // Execute the INSERT statement
        if (mysqli_query($this->conn, $sql)) {
            echo "Computer created successfully.";
        } else {
            echo "Error creating computer: " . mysqli_error($this->conn);
        }
    }

    // Method to retrieve all computers
    public function getComputers() {
        // Prepare the SELECT statement
        $sql = "SELECT * FROM computers";

        // Execute the SELECT statement
        $result = mysqli_query($this->conn, $sql);

        // Check if any records are found
        if (mysqli_num_rows($result) > 0) {
            // Loop through each row and display the computer details
            while ($row = mysqli_fetch_assoc($result)) {
                echo "Name: " . $row['name'] . "<br>";
                echo "Model: " . $row['model'] . "<br>";
                echo "Serial Number: " . $row['serial_number'] . "<br>";
                echo "Specifications: " . $row['specifications'] . "<br>";
                echo "Status_name: " . $row['Status_name'] . "<br>";
                echo "repair_types_name: " . $row['repair_types_name'] . "<br><br>";
            }
        } else {
            echo "No computers found.";
        }
    }

    // Method to update a computer
    public function updateComputer($id, $name, $model, $serialNumber, $specifications, $Status_name, $repair_types_name) {
        // Prepare the UPDATE statement
        $sql = "UPDATE computers SET
                name = '$name',
                model = '$model',
                serial_number = '$serialNumber',
                specifications = '$specifications',
                Status_id = '$Status_name',
                repair_types_name = '$repair_types_name'
                WHERE id = $id";

        // Execute the UPDATE statement
        if (mysqli_query($this->conn, $sql)) {
            echo "Computer updated successfully.";
        } else {
            echo "Error updating computer: " . mysqli_error($this->conn);
        }
    }

    // Method to delete a computer
    public function deleteComputer($id) {
        // Prepare the DELETE statement
        $sql = "DELETE FROM computers WHERE id = $id";

        // Execute the DELETE statement
        if (mysqli_query($this->conn, $sql)) {
            echo "Computer deleted successfully.";
        } else {
            echo "Error deleting computer: " . mysqli_error($this->conn);
        }
    }
}
?>
<html>
<head>
    <title>Computer Management System</title>
   <style>
    body {
         background-color: #f1f1f1;
        font-family: Arial, sans-serif;
    }

    h1 {
        color: #333;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        width: 400px;
        margin: 0 auto;
        margin-left: 50px; /* Add this line to adjust the form to the left */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    input[type="text"],
    textarea {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        padding: 10px 16px;
        cursor: pointer;
        border-radius: 4px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ccc;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    a {
        text-decoration: none;
        color: #333;
    }

    a:hover {
        color: #4CAF50;
    }
</style>
</head>
<body>
    <h1>Computer Management System</h1>

    <!-- Form for creating or updating a computer -->
    <form action="process.php" method="POST">
        <input type="hidden" name="id" value="">
        <label>Name:</label>
        <input type="text" name="name" value=""><br><br>
        <label>Model:</label>
        <input type="text" name="model" value=""><br><br>
        <label>Serial Number:</label>
        <input type="text" name="serial_number" value=""><br><br>
        <label>Specifications:</label>
        <textarea name="specifications"></textarea><br><br>
        
        <!-- Submit button for creating or updating a computer -->
        <input type="submit" name="submit" value="Save">
    </form>
    <hr>

    <!-- Display existing computers -->
    <h2> Registered Computers</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Model</th>
            <th>Serial Number</th>
            <th>Specifications</th>
            <th>Status Name</th>
            <th>Repair Type Name</th>
            <th>Action</th>
        </tr>
         <?php
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

       // Fetch all computers from the database
$sql = "SELECT * FROM computer_services";
$result = mysqli_query($conn, $sql);

// Check if any records are found
if (mysqli_num_rows($result) > 0) {
    // Loop through each row and display the computer details in table rows
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['model'] . "</td>";
        echo "<td>" . $row['serial_number'] . "</td>";
        echo "<td>" . $row['specifications'] . "</td>";
        echo "<td>" . $row['Status_name'] . "</td>";
        echo "<td>" . $row['repair_types_name'] . "</td>";
        echo "<td>";
        echo "<a href='edit.php?id=" . $row['id'] . "'>Edit</a> | ";
        echo "<a href='delete.php?id=" . $row['id'] . "'>Delete</a>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No computers found</td></tr>";
}



        // Close the database connection
        mysqli_close($conn);
?>
    </table>
<html>
<style>
    .search-form {
        position: fixed;
        top: 30px;
        right: 10px;
        display: flex;
        align-items: center;
        height: 30px;
    }

    .search-input {
        width: 150px;
        padding: 4px;
        border: none;
        border-radius: 4px;
    }

    .search-button {
        padding: 4px 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .search-button:hover {
        background-color: #45a049;
    }
</style>

<div class="search-form">
    <form method="POST" action="search.php">
        <input type="text" name="searchQuery" class="search-input" placeholder="Enter search query">
        <button type="submit" name="search" class="search-button">Search</button>
    </form>
</div>

    </style>
</head>
</html>


<a href="logout.php" style="color: #ffffff; background-color: #ff0000; padding: 2px 50%; text-decoration: none; border-radius: 5px;">Logout</a>