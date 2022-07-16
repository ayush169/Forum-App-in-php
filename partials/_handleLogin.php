<?php
$showError = "false";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    include "_dbconnect.php";
    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];

    $sql = "SELECT * FROM `users` WHERE user_email = '$email';";
    $result = mysqli_query($conn,$sql);
    $numRows = mysqli_num_rows($result);
    if($numRows == 1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            // $_SESSION['loggedin_time'] = time(); 
            $_SESSION['name'] = $row['name'];
            $_SESSION['useremail'] = $email;
            // if(!isLoginSessionExpired()) {
            //     header("location: /forum/index.php?loginsuccess=true");
            //     exit();
            // } 
            header("location: /forum/index.php?loginsuccess=true");
            exit();
        }
        else{
            $showError = "Passwords do not match";
        }
    }
    else{
        $showError = "Username is incorrect";
    }
    header("location: /forum/index.php?loginsuccess=false&error=$showError");
}

?>


<!-- session checking -->
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
    //}

?> -->