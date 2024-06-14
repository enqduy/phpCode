<?php
include_once 'lib/session.php';
include_once 'classes/product.php';
include_once 'classes/cart.php';

$cart = new cart();
$totalQty = $cart->getTotalQtyByUserId();

$product = new product();
$list = mysqli_fetch_all($product->getFeaturedProducts(), MYSQLI_ASSOC);
?>
<?php
    if (isset($_GET['search'])) {
        $search = addslashes($_GET['search']);
        if (empty($search)) {
            echo '<script type="text/javascript">alert("Yêu cầu dữ liệu không được để trống!");</script>';
        } else {
            $list = $product->getProductByName($search);
           
        }
    } 
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
    <title>Trang chủ</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
        $(function() {
            $('.fadein img:gt(0)').hide();
            setInterval(function() {
                $('.fadein :first-child').fadeOut().next('img').fadeIn().end().appendTo('.fadein');
            }, 4500);
        });
    </script>
</head>

<body>
    <nav>
        <label class="logo"><a href="index.php">PK-STORE</a> <img src="./images/LOGOPK-1.png" alt=""></label>
        <ul>
            <li><a href="index.php" class="active">Trang chủ <i class=" fas fa-home"></i> </a></li>
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
                <li><a href="login.php" id="signin">Đăng nhập <i class="fas fa-arrow-right-to-bracket"></i></a></li>
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
        <h1>PK-STORE, GÌ CŨNG CÓ</h1>
        <form class="c-search" action="" method="get">
            <input type="text" name="search" placeholder="Nhập tên sản phẩm...">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
    
    <style>
       
        .flag {
            width: 350px;
            height: 50px;
            background-color: red;
            position: relative;
            margin-left: -5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white; /* Màu chữ */
            font-weight: bold;
            font-size: 20px;
        }
        .flag::after {
            content: '';
            position: absolute;
            top: 0;
            right: -20px;
            width: 0;
            height: 0;
            border-top: 21px solid transparent;
            border-bottom: 30px solid transparent;
            border-left: 20px solid red;
        }
    </style>

    <br>
    <div class="flag-container">
        <div class="flag">Gợi ý dành riêng cho bạn</div>
    </div>

    <div class="container" style="grid-template-columns: auto auto auto auto;">
        
        
        <?php
        if ($list) {
        foreach ($list as $key => $value) { ?>
            <div class="card">
                <div class="imgBx">
                    <a href="detail.php?id=<?= $value['id'] ?>"><img src="admin/uploads/<?= $value['image'] ?>" alt="" title="<?= $value['name'] ?>"></a>
                </div>
                <div class="content">
                    <div class="productName">
                        <a href="detail.php?id=<?= $value['id'] ?>" title="<?= $value['name'] ?>">
                            <h3><?= $value['name'] ?></h3>
                        </a>
                    </div>
                    <div>
                        Đã bán: <?= $value['soldCount'] ?>
                    </div>
                    <div class="original-price">
                        <?php
                        if ($value['promotionPrice'] < $value['originalPrice']) { ?>
                            Giá gốc: <del><?= number_format($value['originalPrice'], 0, '', ',') ?>VND</del>
                        <?php } else { ?>
                            <p>...</p>
                        <?php } ?>
                    </div>
                    <div class="price">
                        Giá bán: <?= number_format($value['promotionPrice'], 0, '', ',') ?>VND
                    </div>
                    <div class="action">
                        <a class="add-cart" href="add_cart.php?id=<?= $value['id'] ?>">Thêm vào giỏ</a>
                        <a class="detail" href="detail.php?id=<?= $value['id'] ?>">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php }?>
        <?php } else { ?>
            <h3>Chưa có sản phẩm nào...</h3>
        <?php } ?>
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