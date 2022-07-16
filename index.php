<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <style>
    @media only screen and (max-width: 600px) {
        .w-100 {
            height: 200px;
        }
    }
    </style>

    <title>Welcome to Alpha Forums</title>
</head>

<body>
    <?php include "partials/_dbconnect.php"; ?>
    <?php include "partials/_header.php"; ?>

    <!-- <?php
        // function isLoginSessionExpired() {
        //     $login_session_duration = 5; 
        //     $current_time = time(); 
        //     if(isset($_SESSION['loggedin_time']) and isset($_SESSION["useremail"])){  
        //         if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){ 
        //             return true; 
        //         } 
        //     }
        //     return false;
        // }

    ?> -->

    <?php

        if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true ){
            session_destroy();
        }
    ?>


    <!-- slider -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/slider_1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider_2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/slider_3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- category container starts here -->
    <div class="cotainer">
        <h2 class="text-center my-2">Alpha Forums - Browse Categories</h2>
        <div class="row mx-2">

            <!-- fetch all the categories -->
            <?php
            $sql = "SELECT * FROM `categories`;";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
              $id = $row['category_id'];
              $cat = $row['category_name'];
              $desc = $row['category_description'];
              echo '<div class="col my-2" style = "display: flex; justify-content: center;">
                      <div class="card" style="width: 18rem; box-sizing: border-box;">
                          <img src="img/'.$cat.'.jpg" style = "width:17.87rem; height:200px; box-sizing: border-box;" class="card-img-top" alt="...">
                          <div class="card-body" style = "box-sizing: border-box; height:226px">
                              <h5 class="card-title text-center"><a href = "threadlist.php?catid='.$id.'">'.$cat.'</a></h5>
                              <p class="card-text">'.substr($desc,0,105).'...</p>
                              <a href="threadlist.php?catid='.$id.'" class="btn btn-primary" style = "position:absolute;bottom:10px;left:72px;">View Threads</a>
                          </div>
                      </div>
                    </div>';
            }

            ?>

        </div>
    </div>

    <?php include "partials/_footer.php"; ?>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>