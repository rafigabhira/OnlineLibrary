<?php
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $conn = connectDB();
        $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        if (!$result = mysqli_query($conn, $sql)) {
            die("Error: $sql");
            $_SESSION["error"] = 'Your username or password is invalid';
        }

        while ($row = mysqli_fetch_row($result)) {


            $_SESSION["userIn"] = $row[1];
            $_SESSION["userID"] = $row[0];
            $_SESSION["userRole"] = $row[3];
            unset($_SESSION['error']);
            echo "<script>alert('Login success !'); document.location.href='home.php'; </script>";
        }
        if (!(($num = mysqli_num_rows($result)) === 1)) {
            $_SESSION['error'] = 'Your username or password is invalid';
        }
        mysqli_close($conn);
    } else {

        echo "<script>alert('Username and password is empty')</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login user !</title>
    <link rel="stylesheet" href="src/css/style.css">
    <script type="text/javascript" src="src/js/jquery-3.1.1.min.js"></script>
    <script src="src/js/typed.js"></script>
    <script>
        $(function () {
            $("#typed").typed({
                stringsElement: $('#typed-strings'),
                typeSpeed: 30,
                backDelay: 1500,
                loop: false,
                contentType: 'html',
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="login">
        <div id="typed-strings">
            <span><strong>Hello !</strong></span>
            <p>Pilih <strong>Bukunya !</strong></p>
            <p>dan <strong>Selamat membaca !</strong></p>
            <p>Please <strong>Login :)</strong></p>
        </div>
        <span id="typed" style="white-space:pre;"></span>
        <br><br>
        <form method="post" action="login.php">
            <input id="username" type="text" name="username" placeholder="Username" required="required"
                   class="input-txt"/>
            <input id="password" type="password" name="password" placeholder="Password" required="required"
                   class="input-txt"/>
            <div class="login-footer">
                <button class="btn btn--right">Sign in</button>
            </div>
        </form>

    </div>
    <span>
            <?php
            if (isset($_SESSION["error"])) {
                echo '<script>alert("Your username or password is invalid")</script>';
            }
            ?>
        </span>
</div>

</body>
</html>
