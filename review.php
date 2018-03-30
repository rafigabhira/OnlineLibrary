<?php

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

$rev = selectAllFromLoan("review");

$conn = connectDB();
while ($revRow = mysqli_fetch_row($rev)) {

    if ($_POST['book_id'] === $revRow[1]) {
        $nama = "SELECT username FROM user WHERE user_id = '$revRow[2]' ";
        $nama2 = mysqli_query($conn, $nama);
        $nama3 = mysqli_fetch_row($nama2);


        echo '<div class="container">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="panel panel-white post panel-shadow">
                                              <div class="post-heading">
                                                  <div class="pull-left image">
                                                      
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
                              </div>';
    }
}

?>