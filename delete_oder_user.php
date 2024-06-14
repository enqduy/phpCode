<?php
include_once 'C:\xampp\htdocs\PK_SHOP\classes\order.php';
include_once 'C:\xampp\htdocs\PK_SHOP\classes\user.php';

if (isset($_GET['orderId'])) {
    $user = new user();
    $id = $user->getUserByOrder($_GET['orderId']);
    $result1 = $user->updateStatus($id['id']);

    $order = new order();
    $result = $order-> CancelOrder($_GET['orderId']);
    
    if ($result && $result1) {
        echo '<script type="text/javascript">alert("Hủy đơn hàng thành công!"); history.back();</script>';
    } else {
        echo '<script type="text/javascript">alert("Hủy đơn hàng thất bại!"); history.back();</script>';
    }
}
?>



