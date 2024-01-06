<?php
header('Content-Type: application/json');

$servername = "your_database_server";
$username = "your_username";
$password = "your_password";
$dbname = "hospital_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get all patients
    $patients = array();

    $sql = "SELECT * FROM patients";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
    }

    echo json_encode($patients);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add a patient
    $data = json_decode(file_get_contents("php://input"), true);

    $name = mysqli_real_escape_string($conn, $data["name"]);
    $age = (int)$data["age"];

    $sql = "INSERT INTO patients (name, age) VALUES ('$name', $age)";
    
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => "Patient added successfully!"]);
    } else {
        echo json_encode(["error" => "Error: " . $sql . "<br>" . $conn->error]);
    }
}

$conn->close();
?>