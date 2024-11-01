<?php
session_start();
require './api/dbconnect.php';
if (isset($_SESSION["user"])) {
    header("location: msEvent.php");
}
if (isset($_POST['password']) && isset($_POST['username'])) {
    $stmt = $conn->prepare("SELECT `user`.* FROM `user` WHERE username = ?;");
    $stmt->bind_param("s", $_POST['username']);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        if (!$user) {
            $_SESSION['error'] = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            $_SESSION['olddata'] = $_POST['username'];
        } else if (!password_verify($_POST['password'], $user['password'])) {
            $_SESSION['error'] = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            $_SESSION['olddata'] = $_POST['username'];
        } else {
            $_SESSION['user'] = $user;
            $_SESSION['error'] = '';
            $_SESSION['olddata'] = '';
            header("location: index.php");
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login KU activity notification</title>
    <link rel="icon" type="image/x-icon" href="img/icon.png">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet" />

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/stylelogin.css" />
    <link rel="stylesheet" href="css/font.css" />
    <link rel="icon" type="image/x-icon" href="images/profile_defult.png" />
    
</head>

<body class="">
    <section class="ftco-section">
        <div class="container">
            
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="login-wrap p-3 p-md-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <img width="150" src="images/KU_SubLogo_Thai.png" alt="" srcset="">
                        </div>
                        <h3 class="text-center text-success font-weight-bold" >Sign In KU Event Admin</h3>
                        <h4 class="text-success text-center font-weight-bold">ระบบ KU Event สำหรับ ผู้ดูแลระบบ</h4>
                        <?php
                        if (isset($_SESSION["error"])) {
                            echo '<div id="errorAlert" class="alert alert-danger text-center" role="alert">             
                   ' . $_SESSION["error"] . '</div>';
                        }

                        ?>
                        <form id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form"
                            method="POST">
                            <div class="form-group">
                                <input value="<?php
                                if (isset($_SESSION['olddata'])) {
                                    echo $_SESSION['olddata'];
                                } else {
                                    '';
                                }
                                ?>" name="username" type="text" class="form-control rounded-left"
                                    placeholder="Username" required />
                            </div>
                            <div class="form-group d-flex">
                                <input name="password" type="password" class="form-control rounded-left"
                                    placeholder="Password" required />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="vendor/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        if ($('#errorAlert').length) {
            setTimeout(function () {
                $('#errorAlert').fadeOut('slow', function () {
                    $(this).remove();
                });
            }, 3000);
        }
    });
</script>

</html>