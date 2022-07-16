<?php 

session_start();
// fixed-top
echo '
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" >
        <a class="navbar-brand" href="/forum">Alpha Forums</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/forum">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Top Categories
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">';

                $sql = "SELECT category_name, category_id FROM `categories` limit 3";
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_assoc($result)){
                    $id = $row['category_id'];
                    $cat = $row['category_name'];
                    echo '<a class="dropdown-item" href="threadlist.php?catid='.$id.'">'.$cat.'</a>';
                }
               echo' </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
            </ul>
            <div class="mx-2 row">';
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
                echo '<form class="form-inline my-2 my-lg-0" action = "search.php" method = "get">
                <input class="form-control mr-sm-2" name = "search" type="search" placeholder="Search" aria-label="Search" spellcheck="false">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
                <p class = "text-light my-0 ml-2 mr-1"> ' .$_SESSION["name"].'</p>
                <a href = "partials/_logout.php" class="btn btn-outline-success ml-2">logout</a>
                </form>';
            }
            else{
                echo '<form class="form-inline my-2 my-lg-0" action = "search.php" method = "get">
                <input class="form-control mr-sm-2" name = "search" type="search" placeholder="Search" aria-label="Search" spellcheck="false">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
                </form>
                <button class="btn btn-outline-success ml-2" data-toggle="modal" data-target="#loginModal">login</button>
                <button class="btn btn-outline-success mx-2" data-toggle="modal" data-target="#signupModal">signup</button>
                ';
            }
            
            echo '</div>
        </div>
    </nav>
';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true"){
    echo '<div class="alert alert-success alert-dismissible fade show mt-0 mb-0" role="alert">
             Your account has been created!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
else if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false"){
    $error = $_GET['error'];
    echo '<div class="alert alert-danger alert-dismissible fade show mt-5 mb-0" role="alert">
            '.$error.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}
else if(isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == "false"){
    $error = $_GET['error'];
    echo '<div class="alert alert-danger alert-dismissible fade show mt-5 mb-0" role="alert">
            '.$error.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>';
}

?>