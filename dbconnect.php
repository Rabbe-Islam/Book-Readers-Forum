<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "book_readers_forum";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Server Error!");
}


// Function to fetch all column data from any table
function fetchDataById($table, $condition = '', $selectiveColumns = '*', $extraFilter = '') {
    global $conn;

    // Prepare the SQL statement with selective columns and condition
    $sql = "SELECT $selectiveColumns FROM $table";
    if (!empty($condition)) {
        $sql .= " WHERE $condition";
    }
    if (!empty($extraFilter)) {
        $sql .= " $extraFilter";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if ($selectiveColumns === '*') {
            // Fetch a single row if all columns are selected
            $data = $result->fetch_assoc();
        } else {
            // Fetch all rows if specific columns are selected
            $data = $result->fetch_all(MYSQLI_ASSOC);
        }
        $stmt->close();
        return $data;
    } else {
        $stmt->close();
        return false;
    }
}



// Function to DELETE row data from any table
function deleteDataById($table, $condition = '') {
    global $conn;

    // Prepare the SQL statement with selective columns and condition
    $sql = "DELETE FROM $table";
    if (!empty($condition)) {
        $sql .= " WHERE $condition";
    }
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        return false;
    }

    return true;
}



// Function to INSERT new row data in any table
function insertDataRow($table, $selectiveColumns, $columnValues = '') {
    global $conn;

    // Prepare the SQL statement with selective columns and condition
    $sql = "INSERT INTO $table ($selectiveColumns) VALUES ($columnValues)";

    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    if ($result === false) {
        return false;
    }

    return true;
}
?>