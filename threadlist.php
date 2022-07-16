<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome to Alpha Forums</title>
</head>

<body>

    <?php include "partials/_dbconnect.php"; ?>
    <?php include "partials/_header.php"; ?>


    <?php
        echo file_exists('http://localhost/forum/img/a.jpg');
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `categories` WHERE category_id = '$id';";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }
    ?>

    <?php
        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'POST'){
            // insert thread in db
            $th_title = $_POST['title'];
            $th_desc = $_POST['desc'];

            $th_title = str_replace("<", "&lt;", $th_title);
            $th_title = str_replace(">", "&gt;", $th_title);
            $th_desc = str_replace("<", "&lt;", $th_desc);
            $th_desc = str_replace(">", "&gt;", $th_desc);
            
            $email = $_SESSION['useremail'];

            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `date`) VALUES ('$th_title', '$th_desc', '$id', '$email', current_timestamp());";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;

        };
    ?>

    <!-- category container starts here -->
    <div class="cotainer">
        <div class="jumbotron">

            <?php
            if($showAlert){
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your thread has been added successfully! Please wait for someone to response
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                ';
            }
        ?>

            <h1 class="display-4"><?php echo $catname;?> Forums</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>This is a Peer to Peer forum for sharing knowledge. No Spam / Advertising /
                Self-promote in the forums is not allowed. Do not post copyright-infringing material.Do not post
                “offensive” posts, links or images.
                Do not cross post questions.
                Remain respectful of other members at all times.</p>
            <!-- <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a> -->
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo '<div class="container">
        <h1>Start a Discussion</h1>
        <form acrion="'.$_SERVER["REQUEST_URI"].'" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Problem Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" spellcheck="false">
        <small id="emailHelp" class="form-text text-muted">Keep your title as short as possible</small>
    </div>
    <div class="form-group">
        <label for="exampleFormControlTextarea1">Problem Description</label>
        <textarea class="form-control" id="desc" name="desc" rows="3" spellcheck="false"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>';
    }
    else{
        echo '<div class="container">
                <h1>Start a Discussion</h1>
                <p class = "lead">Please login to start a discussion</p>
            </div>';
    }
    ?>

    <div class="container" style="min-height:300px;">
        <h1 class="pt-4">Browse Questions</h1>

        <?php
        include "partials/_time.php";
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id = '$id'";
        $result = mysqli_query($conn,$sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['date'];
            $thread_user_id = $row['thread_user_id'];

            $img_id = $thread_user_id[0];

            // <img src="img/userdefault.jpg" width="54px" class="mr-3" alt="...">
            $filename = 'img/'.$img_id.'.png';
            $location = false;

            if (file_exists($filename)) {
                $location = $filename;
            } else {
                $location = 'img/image.jpg';
            }

        echo '<div class="media my-3">
            <img src="'.$location.'" width="54px" class="mr-3" alt="...">
            <div class="media-body">
                <p class = "my-0">'.$thread_user_id.' <i style = "font-size:5px; position:relative; top:-3px; left:6px;" class="fas fa-circle"></i><span style = "margin-left:9px;"> '.time_ago_in_php($thread_time).'</span></p>
                <h5 class="mt-0"><a class = "text-dark" href = "thread.php?threadid='.$id.'">'.$title.'</a></h5>
                '.nl2br(htmlspecialchars($desc)).'
            </div>
        </div>';

        }
        if($noResult){
            echo '<div style = "display:flex;justify-content:center;margin-top:50px;flex-direction:column;align-items:center;">
                <i class="fas fa-comment-alt" style = "margin-bottom:20px;"></i>
                <b>No Questions Yet</b>
                Be the first person to ask a question
            </div>';
        }
        ?>


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
    <script src="https://kit.fontawesome.com/dcc1e4055b.js" crossorigin="anonymous"></script>
</body>

</html>