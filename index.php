<?php
session_start();

if (!empty($_SESSION["userIn"])) {

    echo "<script>
        alert('Redirect to home page !');
  		document.location.href='home.php';
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

    $sql = "SELECT book_id,  img_path, title, author, publisher, description, quantity FROM $table";

    if (!$result = mysqli_query($conn, $sql)) {
        die("Error: $sql");
    }
    mysqli_close($conn);
    return $result;
}

function selectAllFromLoan($table)
{
    $conn = connectDB();

    $sql = "SELECT * FROM $table";

    if (!$result = mysqli_query($conn, $sql)) {
        die("Error: $sql");
    }
    mysqli_close($conn);
    return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['command'] === 'login') {
        header("Location: login.php");
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

        .panel-shadow {
            box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
        }

        .panel-white {
            border: 1px solid #dddddd;
        }

        .panel-white .panel-heading {
            color: #333;
            background-color: #fff;
            border-color: #ddd;
        }

        .panel-white .panel-footer {
            background-color: #fff;
            border-color: #ddd;
        }

        .post .post-heading {

            height: 70px;
            padding: 20px 15px;
        }

        .post .post-heading .avatar {
            width: 60px;
            height: 60px;
            display: block;
            margin-right: 15px;
        }

        .post .post-heading .meta .title {
            margin-bottom: 0;
        }

        .post .post-heading .meta .title a {
            color: black;
        }

        .post .post-heading .meta .title a:hover {
            color: #aaaaaa;
        }

        .post .post-heading .meta .time {
            margin-top: 8px;
            color: #999;
        }

        .post .post-image .image {
            width: 100%;
            height: auto;
        }

        .post .post-description {
            padding: 15px;
        }

        .post .post-description p {
            font-size: 14px;
        }

        .post .post-description .stats {
            margin-top: 20px;
        }

        .post .post-description .stats .stat-item {
            display: inline-block;
            margin-right: 15px;
        }

        .post .post-description .stats .stat-item .icon {
            margin-right: 8px;
        }

        .post .post-footer {
            border-top: 1px solid #ddd;
            padding: 15px;
        }

        .post .post-footer .input-group-addon a {
            color: #454545;
        }

        .post .post-footer .comments-list {
            padding: 0;
            margin-top: 20px;
            list-style-type: none;
        }

        .post .post-footer .comments-list .comment {
            display: block;
            width: 100%;
            margin: 20px 0;
        }

        .post .post-footer .comments-list .comment .avatar {
            width: 35px;
            height: 35px;
        }

        .post .post-footer .comments-list .comment .comment-heading {
            display: block;
            width: 100%;
        }

        .post .post-footer .comments-list .comment .comment-heading .user {
            font-size: 14px;
            font-weight: bold;
            display: inline;
            margin-top: 0;
            margin-right: 10px;
        }

        .post .post-footer .comments-list .comment .comment-heading .time {
            font-size: 12px;
            color: #aaa;
            margin-top: 0;
            display: inline;
        }

        .post .post-footer .comments-list .comment .comment-body {
            margin-left: 50px;
        }

        .post .post-footer .comments-list .comment > .comments-list {
            margin-left: 50px;
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
                <a class="nav-link" href="index.php" style="color:white;"><i class="fa fa-home" aria-hidden="true"
                                                                             style="color:orange;"></i><strong>
                        Home</strong></a>
            </li>

        </ul>
        <form class="form-inline float-lg-right" action="index.php" method="post">
            <input type="hidden" name="command" value="login">
            <button class="btn btn-outline-warning" type="submit">Log in <i class="fa fa-sign-in fa-1x"
                                                                            aria-hidden="true"></i></button>
        </form>
    </div>
</nav>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <img src="src/img/wallpage.jpg" alt="First slide" style="width:100%; height:455px;">
            <div class="carousel-caption" style="margin-bottom:50px;">
                <h3>Welcome !</h3>
                <p>“Good friends, good books, and a sleepy conscience: this is the ideal life.” </p>
                <button type='button' class='btn btn-danger' data-toggle='modal' data-target=''>
                    <i class='fa fa-info-circle' aria-hidden='true'></i> About Us
                </button>

            </div>
        </div>
        <div class="carousel-item">
            <img src="src/img/gambar2.jpg" alt="Second slide" style="width:100%; height:455px;">
        </div>
        <div class="carousel-item">
            <img src="src/img/gambar3.jpg" alt="Third slide" style="width:100%; height:455px;">
        </div>
    </div>
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="icon-prev" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="icon-next" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


<div class="container">
    <div class="row">

        <?php

        $book = selectAllFromTable("book");

        while ($row = mysqli_fetch_row($book)) {

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
            <button type='button' class='btn btn-outline-warning' data-toggle='modal' data-target='#" . $row[0] . "'>
            <i class='fa fa-info-circle' aria-hidden='true'></i> Detail
            </button>";
            if ($row[6] > 0) {
                echo "
              <button type='button' class='btn btn-outline-success' data-toggle='modal' data-target='#mustLogin'>
              <i class='fa fa-hand-lizard-o' aria-hidden='true'></i> Loan
              </button>
              </center>
            </div>
            <div class='col-md-12'>
               <hr color='white'/>
            </div>";
            } else {
                echo "
              <button type='button' class='btn btn-outline-danger disabled'>
              <i class='fa fa-exclamation' aria-hidden='true'></i> Buku Habis
              </button>
            </center>
            </div>
            <div class='col-md-12'>
               <hr color='white'/>
            </div>";
            }
            date_default_timezone_set("Asia/Jakarta");
            echo '<div class="modal fade bd-example-modal-lg" id="' . $row[0] . '" tabindex="2" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="background-color:rgba(255,255,255,0.9); text-align:center;">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="updateModalLabel"><strong>Detail Buku </strong></h4>
                        </div>
                        <div class="modal-body">
                                                <img class="card-img-top" src="' . $row[1] . '" alt="Card image cap">
                                                <br>
                                                <br>
                                               <h4>' . $row[2] . '</h4>
                                               <p>Author: ' . $row[3] . '</p>
                                               <p>Publisher: ' . $row[4] . '</p>
                                               <p>Description: ' . $row[5] . '</p>
                                               <p>Quantity: ' . $row[6] . '</p>
                                               <br>
                                               <p><strong>Review List</strong></p>
                                               <div id="reviewList">';
            $rev = selectAllFromLoan("review");

            $conn = connectDB();
            while ($revRow = mysqli_fetch_row($rev)) {

                if ($row[0] === $revRow[1]) {
                    $nama = "SELECT username FROM user WHERE user_id = '$revRow[2]' ";
                    $nama2 = mysqli_query($conn, $nama);
                    $nama3 = mysqli_fetch_row($nama2);
                        echo '<div class="container">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="panel panel-white post panel-shadow">
                                              <div class="post-heading">
                                                  <div class="pull-left image">
                                                      <img src="http://bootdey.com/img/Content/user_2.jpg" class="img-circle avatar" alt="user profile image">
                                                  </div>
                                                  <div class="pull-left meta">
                                                      <div class="title h5">
                                                          <a href="#"><b>' . $nama3[0] . '</b></a>
                                                          made a review
                                                      </div>
                                                      <h6 class="text-muted time">' . $revRow[3] . '</h6>
                                                  </div>
                                              </div>
                                              <div class="post-description">
                                                  <p style="font-size:17px;">' . $revRow[4] . '</p>

                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
';
                }
            }
            echo '</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-success" data-dismiss="modal"><i class="fa fa-check"
                                                                                                          aria-hidden="true"></i>
                                Yes
                            </button>
                        </div>
                    </div>
                </div>
            </div>';


        }
        ?>
    </div>
</div>
<br>


<div class="modal fade" id="mustLogin" tabindex="2" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color:rgba(255,255,255,0.7);">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="updateModalLabel"><strong>Anda harus log in !</strong></h4>
            </div>
            <div class="modal-body">
                <p>Untuk dapat meminjam buku, anda harus log in terlebih dahulu :)</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-success" data-dismiss="modal"><i class="fa fa-check"
                                                                                              aria-hidden="true"></i>
                    Yes
                </button>
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
</body>
</html>
