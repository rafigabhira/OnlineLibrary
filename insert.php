F<?php

session_start();
function connectDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "personal_library";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " + mysqli_connect_error());
    }
    return $conn;
}

$conn = connectDB();


$book_id = $_POST['book_id'];
$user_id = $_SESSION['userID'];

$content = $_POST['review'];
$sql = "INSERT INTO review (book_id, user_id, date, content) VALUES ('$book_id','$user_id',current_date,'$content')";
if ($conn->query($sql) === TRUE) {
    header("Location: home.php");
} else {
    echo "Error updating record: " . $conn->error;
    //showReview();


}


?>