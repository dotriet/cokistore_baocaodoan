<?php
include('../database/connect.php');
?>

<?php
// Set transaction isolation level
mysqli_query($connect, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");

// Lock the table
//mysqli_query($connect, "LOCK TABLES giaodich WRITE");

if(isset($_POST['themdanhmuc'])){
    $tendanhmuc = $_POST['danhmuc'];
    $sql_insert = mysqli_query($connect,"INSERT INTO category(category_name) values ('$tendanhmuc')");
    
}elseif(isset($_POST['capnhatdanhmuc'])){
    $id_post = $_POST['id_danhmuc'];
    $tendanhmuc = $_POST['danhmuc'];
    $sql_update = mysqli_query($connect,"UPDATE category SET category_name='$tendanhmuc' WHERE category_id='$id_post'");
    header('Location:xulydanhmuc.php');
}
if(isset($_GET['xoa'])){
    $id= $_GET['xoa'];
    $sql_xoa = mysqli_query($connect,"DELETE FROM category WHERE category_id='$id'");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Danh mục</title>
    <link href="../assets/css/boostrap.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body style="background-color:#FF3FA4">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="xulydanhmuc.php">Danh mục</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="xulysanpham.php">Sản phẩm</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="thongtinkhachhang.php">Khách hàng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lichsugiaodich.php">Lịch sử giao dịch</a>
                </li>

            </ul>
            <div style="text-align:right">
                <a href="../include/login.php">Đăng xuất</a>
            </div>
        </div>
    </nav><br><br>
    <div class="container">
        <div class="row">
            <?php
            if(isset($_GET['quanly'])=='capnhat'){
                $id_capnhat = $_GET['id'];
                $sql_capnhat = mysqli_query($connect,"SELECT * FROM category WHERE category_id='$id_capnhat'");
                $row_capnhat = mysqli_fetch_array($sql_capnhat);
                ?>
            <div class="col-md-4">
                <h4>Cập nhật danh mục</h4>
                <label>Tên danh mục</label>
                <form action="" method="POST">
                    <input type="text" class="form-control" name="danhmuc"
                        value="<?php echo $row_capnhat['category_name'] ?>"><br>
                    <input type="hidden" class="form-control" name="id_danhmuc"
                        value="<?php echo $row_capnhat['category_id'] ?>">

                    <input type="submit" name="capnhatdanhmuc" value="Cập nhật danh mục" class="btn btn-default">
                </form>
            </div>
            <?php
            }else{
                ?>
            <div class="col-md-4">
                <h4>Thêm danh mục</h4>
                <label>Tên danh mục</label>
                <form action="" method="POST">
                    <input type="text" class="form-control" name="danhmuc" placeholder="Tên danh mục"><br>
                    <input type="submit" name="themdanhmuc" value="Thêm danh mục" class="btn btn-default">
                </form>
            </div>
            <?php
            } 
                ?>
            <div class="col-md-8">
                <h4>Liệt kê danh mục</h4>
                <?php
                $sql_select = mysqli_query($connect,"SELECT * FROM category ORDER BY category_id DESC"); 
                ?>
                <table class="table table-bordered ">
                    <tr>
                        <th>Thứ tự</th>
                        <th>Tên danh mục</th>
                        <th>Hình ảnh</th>
                        <th>Quản lý</th>
                    </tr>
                    <?php
                    $i = 0;
                    while($row_category = mysqli_fetch_array($sql_select)){ 
                        $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row_category['category_name'] ?></td>
                        <td><img src="../assets/img/<?php echo $row_category['img'] ?>"  alt="" style="width: 50px; height: 50px"></td>
                        <td><a href="?xoa=<?php echo $row_category['category_id'] ?>">Xóa</a> || <a
                                href="?quanly=capnhat&id=<?php echo $row_category['category_id'] ?>">Cập nhật</a></td>
                    </tr>
                    <?php
                    } 
                    ?>
                </table>
            </div>
        </div>
    </div>

</body>

</html>

<?php
// Unlock the table
//mysqli_query($connect, "UNLOCK TABLES");
?>
