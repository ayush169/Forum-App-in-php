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
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id = '$id';";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_date = $row['date'];
            $thread_user_id = $row['thread_user_id'];
        }
    ?>

    <?php
        $showAlert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == 'POST'){
            // insert into thread db
            $email = $_SESSION['useremail'];
            $comment = $_POST['comment'];
            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);
            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `date`) VALUES ('$comment', '$id', '$email', current_timestamp());";
            $result = mysqli_query($conn,$sql);
            $showAlert = true;

        };
    ?>

    <!-- category container starts here -->
    <div class="cotainer">

        <div class="jumbotron" style="box-sizing: border-box;">
            <?php
            if($showAlert){
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Your comment has been added successfully!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                ';
            }
        ?>

            <h1 class="display-4"><?php echo $title;?></h1>
            <p class="lead"><?php echo nl2br(htmlspecialchars($desc)); ?></p>
            <hr class="my-4">
            <p>This is a Peer to Peer forum for sharing knowledge. No Spam / Advertising /
                Self-promote in the forums is not allowed. Do not post copyright-infringing material.Do not post
                “offensive” posts, links or images.
                Do not cross post questions.
                Remain respectful of other members at all times.</p>
            <p>Posted by: <b><?php echo $thread_user_id;?></b></p>

            <p style="margin-top:-10px;">
                <?php
                  include "partials/_time.php";
                  echo time_ago_in_php($thread_date);
                ?>
            </p>

            <?php
            $sql1 = "SELECT * FROM `comments` WHERE thread_id = '$id';";
            $result1 = mysqli_query($conn,$sql1);
            $num_comments = mysqli_num_rows($result1);
            ?>

            <i class="far fa-comment-alt" style="font-size:18px;"> <?php echo $num_comments;?></i><br>
            <i class="far fa-thumbs-up" style="font-size:18px; margin-top:13px;"> 0</i><br>
            <i class="far fa-thumbs-down" style="font-size:18px; margin-top:13px;"> 0</i>
            <!-- <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a> -->
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo '<div class="container">
    <h1>Post your Comment</h1>
    <form acrion="'.$_SERVER['REQUEST_URI'].'" method="post">
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Type your comment</label>
            <textarea class="form-control" id="comment" name="comment" rows="2" spellcheck="false"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Post Comment</button>
    </form>
    </div>';
    }
    else{
        echo '<div class="container">
                <h1>Post your Comment</h1>
                <p class = "lead">Please login to post your comment</p>
            </div>';
    }
    ?>

    <div class="container" style="min-height:300px;">
        <h1 class="pt-4">Discussions</h1>

        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id = '$id'";
        $result = mysqli_query($conn,$sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['date'];
            $comment_user_id = $row['comment_by'];

            $img_id = $comment_user_id[0];

            $filename = 'img/'.$img_id.'.png';
            $location = false;

            if (file_exists($filename)) {
                $location = $filename;
            } else {
                $location = 'img/image.jpg';
            }
        
            $like = 0;
            $dislike = 0;
            echo '<div class="media my-3" style = "display:flex;align-items:flex-start;">
                <img src="'.$location.'" width="54px" class="mr-3" alt="...">
                <div class="media-body" style = "margin-top:0px;">
                <p class = "text-dark my-0" style = >'.$comment_user_id.' <i style = "font-size:5px; position:relative; top:-3px; left:6px;" class="fas fa-circle"></i><span style = "margin-left:9px;"> '.time_ago_in_php($comment_time).'</span></p>
                    '.$content.'<br>
                <i id = "like" class="far fa-thumbs-up" style="font-size:18px; color:#979797;cursor:pointer;"> '.$like.'</i>
                <i id = "dislike" class="far fa-thumbs-down" style="font-size:18px; color:#979797; margin-left:20px;cursor:pointer;"> '.$dislike.'</i>
                </div>
                </div>';
            }

            if($noResult){
                echo '<div style = "display:flex;justify-content:center;margin-top:50px;flex-direction:column;align-items:center;">
                    <i class="far fa-comment-alt" style = "margin-bottom:20px;"></i>
                    <b>No Comments Yet</b>
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