<?php
session_start();

if (empty($_SESSION["userIn"])) {

    echo "<script>
        alert('You must login !');
  		document.location.href='login.php';
        </script>";
    exit;
}

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
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function selectAllFromTable($table)
{
    $conn = connectDB();

    $userId = $_SESSION["userID"];
    $sql = "SELECT book_id FROM $table WHERE user_id = $userId ";
    $result = mysqli_query($conn, $sql);


    $hasil = array();
    while ($row = mysqli_fetch_row($result)) {
        array_push($hasil, mysqli_query($conn, "SELECT book_id,  img_path, title, author, publisher, description, quantity FROM book WHERE book_id = $row[0]"));
    }
    return $hasil;
}

function deleteBook($id)
{
    $conn = connectDB();

    $sql = "DELETE FROM loan WHERE book_id = $id";
    $result = mysqli_query($conn, $sql);

    $sql = "SELECT quantity FROM book WHERE book_id = '$id' ";
    $result = mysqli_query($conn, $sql);
    $Object = mysqli_fetch_row($result);
    $sql = "UPDATE book SET quantity = $Object[0]+1 WHERE book_id = '$id' ";

    if ($result = mysqli_query($conn, $sql)) {
        echo "New record created successfully <br/>";
        header("Location: list.php");
    } else {
        die("Error: $sql");
    }
    mysqli_close($conn);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['command'] === 'logout') {
        $_SESSION['login'] = false;
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        echo "<script> alert('Success logout !');
             document.location.href='index.php';
                 </script>";
        die;
    } else if ($_POST['command'] === 'kembaliin') {
        deleteBook($_POST['userid']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lol's Library</title>
    <link rel="stylesheet" href="src/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/icon/css/font-awesome.min.css">
    <style>
        body {
            background-color: #373a3c;
        }

        #avatar-container {
            position: relative;
        }

        #avatar-container p {
            float: left;
        }

        #avatar-image-btn {
        }

        #avatar-image-btn img {
        }

        #avatar-image-btn button {
            position: absolute;
            top: 180px;
            right: 44.5%;
            cursor: pointer;

        }

        li a:hover {
            background-color: #00BFFF;
            color: white;
            padding: 20px;
            transition: 0.5s;
            border-radius: 3px;
        }

        .container {
            margin-top: 40px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 15px;
            padding-right: 15px;

        }

        .row {
            margin-right: -15px;
            margin-left: -15px;
        }

    </style>
</head>
<body>
<div class="titlepage"
     style="background-color:#00BFFF; height:70px; text-align:center; font-size:40px;  line-height: 70px; color:white;">
    Library<span class="tag tag-warning" style="font-size:12px">of Success</span>
</div>
<nav class="navbar navbar-dark bg-inverse">
    <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
    <div class="collapse navbar-toggleable-md" id="navbarResponsive">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="home.php" style="color:white;"><i class="fa fa-home" aria-hidden="true"
                                                                            style="color:orange;"></i>
                    Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="list.php" style="color:white;"><i class="fa fa-list" aria-hidden="true"
                                                                            style="color:orange;"></i><strong> Loan
                        list </strong></a>
            </li>
        </ul>
        <form class="form-inline float-lg-right" action="list.php" method="post">
            <input type="hidden" name="command" value="logout">
            <button class="btn btn-outline-danger" type="submit">Log out <i class="fa fa-sign-out"
                                                                            aria-hidden="true"></i>
            </button>
        </form>
    </div>
</nav>
<div id="avatar-container">
    <div id="avatar-image-btn">
        <img src="src/img/wallpage.jpg" alt="My avatar" width="100%" height="400px"/>
        <button id="btnAvatar" class="btn btn-danger" type="button" name="button"><i class="fa fa-users"
                                                                                     aria-hidden="true"></i>
            About Us
        </button>
    </div>
</div>


<div class="container">
    <div class="row">

        <?php

        $book = selectAllFromTable("loan");

        $size = count($book);
        for ($i = 0; $i < $size; $i++) {

            while ($row = mysqli_fetch_row($book[$i])) {

                echo "
           <div class='col-md-1' style='text-align:center;'>
             <h1 style='color:#00BFFF'><i class='fa fa-lightbulb-o' aria-hidden='true'></i></h1>
           </div>
            <div class='col-md-7'>
            <center>
             <p style='color:	#FFFFF0; font-size:24px;'> <strong>$row[2]</strong></p>
             <p style='color:	#FFFFF0;'><strong><i class='fa fa-user' aria-hidden='true' style='color:#5cb85c;'></i>  Author </strong><br>$row[3]</p>
             <p style='color:	#FFFFF0;'><strong><i class='fa fa-building-o' aria-hidden='true' style='color:#f0ad4e;'></i>  Publisher </strong><br>$row[4]</p>
             <p style='color: #FFFFF0;'><strong><i class='fa fa-book' aria-hidden='true' style='color:#a04a48;'></i> Quantity </strong><br>$row[6]</p>
             <p></center><center>
              <button class='btn btn-secondary btn-block' type='button' data-toggle='collapse' data-target='#description$row[0]' aria-expanded='false' aria-controls='collapseExample'>
              <i class='fa fa-quote-left' aria-hidden='true'></i>
 Description
              </button>
              </center>
            </p>
            <div class='collapse' id='description$row[0]'>
              <div class='card card-block' style='color:black; text-align: justify; text-justify: inter-word;'>
                $row[5]
              </div>
            </div>
           </div>
           <div class='col-md-4'>
            <center>
            <img class='rounded' src='$row[1]' alt='bookpic' width='150px' height='200px'/>
            <br>
            <br>
              <button  type='button' class='btn btn-outline-info' data-toggle='modal' data-target='#kembalikan' onclick='setUpdateData($row[0])'>
              Kembalikan
              </button>
            </div>
            <div class='col-md-12'>
               <hr color='white'/>
            </div>";
            }
        }
        ?>
    </div>
</div>
<br>

<div class="modal fade" id="kembalikan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="opacity:0.7;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="updateModalLabel"><strong>Apakah anda ingin mengembalikan buku ini
                        ?</strong></h4>
            </div>
            <div class="modal-footer">
                <form action="list.php" method="post">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><strong><i
                                    class="fa fa-times-circle" aria-hidden="true"></i>
                            No</strong></button>
                    <input type="hidden" id="update-userid" name="userid">
                    <input type="hidden" id="update-command" name="command" value="kembaliin">
                    <button type="submit" class="btn btn-outline-success"><strong><i class="fa fa-check"
                                                                                     aria-hidden="true"></i>
                            Yes</strong></button>
                </form>
            </div>
        </div>
    </div>
</div>

<blockquote class="blockquote" style="margin-left:20%; margin-right:20%;">
    <p class="mb-0" style="color:white; font-style:oblique;">“A reader lives a thousand lives before he dies, said
        Jojen. The man who never reads lives only one.” </p>
    <footer class="blockquote-footer">George R.R. Martin in <cite title="Source Title">A Dance with Dragons </cite>
    </footer>
</blockquote>

<br>
<div class="footer navbar" style="background-color:#00BFFF; border-radius:0px; height:120px;">
</div>

<script src="src/js/jquery-3.1.1.min.js"></script>
<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
<script src="src/bootstrap/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/scrollreveal@3.3.2/dist/scrollreveal.min.js"></script>

<script>
    var fooReveal = {
        delay: 200,
        distance: '90px',
        easing: 'ease-in-out',
        scale: 1.1
    };

    window.sr = ScrollReveal();

    sr.reveal('.col-md-1', fooReveal);
    sr.reveal('.col-md-7', fooReveal);
    sr.reveal('.col-md-4', fooReveal);
    sr.reveal('.col-md-12', fooReveal);
    sr.reveal('.blockquote', fooReveal);
    sr.reveal('.mb-0', fooReveal);
    sr.reveal('.blockquote-footer', fooReveal);
</script>
<style>
    /* Ensure elements load hidden before ScrollReveal runs */
    .sr .fooReveal {
        visibility: hidden;
    }
</style>
<script>
    function setUpdateData(id) {
        $("#update-userid").val(id);
    }
</script>
</body>
</html>
