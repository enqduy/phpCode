<?php
include 'classes/user.php';
$user = new user();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass_check = $user->getPassword($email);
    if ($pass_check === true) {
        header("Location:./login.php");
    }
}
?>

<?php
include_once 'lib/session.php';
include_once 'classes/product.php';
include_once 'classes/cart.php';

$cart = new cart();
$totalQty = $cart->getTotalQtyByUserId();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://use.fontawesome.com/2145adbb48.js"></script>
    <script src="https://kit.fontawesome.com/a42aeb5b72.js" crossorigin="anonymous"></script>
    <title>Đăng nhập</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
        $(function() {
            $('.fadein img:gt(0)').hide();
            setInterval(function() {
                $('.fadein :first-child').fadeOut().next('img').fadeIn().end().appendTo('.fadein');
            }, 5000);
        });
    </script>
</head>

<body>
    <nav>
        <label class="logo"><a href="index.php">PK-STORE</a>  <img src="./images/LOGOPK-1.png" alt=""></label>
        <ul>
            <li><a href="index.php">Trang chủ <i class=" fas fa-home"></i></a></li>
            <li><a href="productList.php">Sản phẩm <i class="fas fa-mobile"></i></a></li>

            <li><a href="order.php" id="order">Đơn hàng <i class="fas fa-parachute-box"></i></a></li>
            <li>
                <a href="checkout.php">
                    Giỏ hàng
                    <i class="fa fa-shopping-bag"></i>
                    <sup class="sumItem">
                        <?= ($totalQty['total']) ? $totalQty['total'] : "0" ?>
                    </sup>
                </a>
            </li>
            <?php
            if (isset($_SESSION['user']) && $_SESSION['user']) { ?>
                <li><a href="info.php" id="signin">Thông tin cá nhân <i class="fas fa-user"></i></a></li>
                <li><a href="logout.php" id="signin">Đăng xuất <i class="fas fa-arrow-right-from-bracket"></i></a></li>
            <?php } else { ?>
                <li><a href="register.php" id="signup">Đăng ký <i class="fas fa-user-plus"></i></a></li>
                <li><a href="login.php" id="signin" class="active">Đăng nhập <i class="fas fa-arrow-right-to-bracket"></i></a></li>
            <?php } ?>
        </ul>
    </nav>
        <section class="banner">
        <div class="fadein">
            <?php
            // display images from directory
            // directory path
            $dir = "./images/slider/";

            $scan_dir = scandir($dir);
            foreach ($scan_dir as $img) :
                if (in_array($img, array('.', '..')))
                    continue;
            ?>
                <img src="<?php echo $dir . $img ?>" alt="<?php echo $img ?>">
            <?php endforeach; ?>
        </div>
    </section>
    <div class="featuredProducts">
        <h1>Lấy lại mật khẩu</h1>
    </div>
    <div class="container-single">
        <div class="login">
            <form action="forgot_password.php" method="post" class="form-login">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email..." required>

                
                <p style="color: red;"><?= !empty($pass_check) ? $pass_check : '' ?></p>

                <input type="submit" value="Gửi">
            </form>
        </div>
    </div>
    </div>
    <footer>
        <div class="social">
            <a href="https://www.facebook.com/profile.php?id=100025197438617"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        </div>
        <ul class="list">
            <li>
                <a href="./">Trang Chủ</a>
            </li>
            <li>
                <a href="productList.php">Sản Phẩm</a>
            </li>
        </ul>
        <p class="copyright">copy by PK-STORE.com 2024</p>
    </footer>
</body>

</html>