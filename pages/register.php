<?php
require_once("../Model/user.class.php");
if(isset($_GET['e']) && isset($_GET['p'])){
$user = new User();
$login =$user->login_user($_GET['e'], $_GET['p']);

if($login){
    $_SESSION['is_logged_in'] = true;
    $_SESSION['user_data']=$login;

    $user->change_status($login['user_id'], "approved");
    $_SESSION['user_type'] = $_SESSION['user_data']['user_type'];
    if($_SESSION['user_type']=="admin"){
        $_SESSION['is_admin']= true;
    } else {
            $_SESSION['is_admin'] = false;
    }
    header("location:../index.php");
} else {

    echo "<script>alert('Please Register Again.');window.location.href='register.php';</script>";
}

}


if (isset($_POST['register_user'])) {


    $username=$_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = md5($_POST['user_password']);

    $link = "http://localhost/cvmaker/pages/register.php?e={$user_email}&p={$user_password}";
    $to_email = $user_email;
    $subject = "CV Maker Account Activation";
    $body = "Hi,Dear user, Please Click on this link to activate your account ".$link;
    $headers = "From: CV Maker";
    $result = mail($to_email, $subject, $body, $headers);
    $user = new User("", $username, $user_email, $user_password,"user","pending");

    if ($result && $user->insert_user()) {
        echo "<script>alert('Please Check your email!')</script>";
        header("location:register.php");
    } else {
        echo "<script>alert('Please Check your email!')</script>";
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Registration Page</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <!-- Toastr -->
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="../index.php"><b>Admin</b>LTE</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="register.php" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" required name="username" placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" required name="user_email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" required name="user_password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" required name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" name="register_user" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i>
                        Sign up using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i>
                        Sign up using Google+
                    </a>
                </div>

                <a href="login.php" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->




    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Toaster -->
    <script src="../plugins/toastr/toastr.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>


</body>

</html>