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

    <style>
    #maincontainer {
        min-height: 100vh;
    }
    </style>
</head>

<body>
    <?php include "partials/_dbconnect.php"; ?>
    <?php include "partials/_header.php"; ?>
    <?php $started = microtime(true); ?>

    <!-- search results -->

    <div class="container my-3" id="maincontainer">
        <h1 style="margin: 80px 0px 20px 0px;">Search results for <?php echo $_GET['search'];?></h1>
        <hr>
        <?php
        $noResults = true;
        $query = $_GET['search'];
        $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title, thread_desc) AGAINST ('$query');";
        $result = mysqli_query($conn,$sql);
        $has_printed = false;
        if($result){
        while($row = mysqli_fetch_assoc($result)){
            $num = mysqli_num_rows($result);
            $noResults = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['date'];
            $thread_user_id = $row['thread_user_id'];

            // time elapsed in search query
            $ended = microtime(true);
            $difference = ($ended - $started);
            $queryTime = number_format($difference, 5);

            if($has_printed == false){
            echo '<p style = "color: #70757a;">About '.$num.' results ('.$queryTime. ' seconds)</p>';
            $has_printed = true;
            }
            //displaying search results
            echo ' 
                    <div class="result">
                        <h3><a href="thread.php?threadid='.$id.'" class="text-dark">'.$title.'</a></h3>
                        <p>'.$desc.'</p>
                    </div>
            ';
        }
    }

        if($noResults){
            
            echo '<div class="jumbotron jumbotron-fluid">
                    <div class="container" style = "margin-top:-50px;">
                        <p class = "display-4">Sorry, we could not find any search result matching '.$query.'</p>
                        <p class = "lead">Suggestions:<ul>
                            <li>Make sure that all words are spelled correctly.</li>
                            <li>Try different keywords.</li>
                            <li>Try more general keywords.</li>
                            </ul>
                        </p>
                    </div>
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
</body>

</html>