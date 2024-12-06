<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost:3307', 'root', '', 'web_quan_ao');

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Trang chủ</title>
    <link href="css/phantrang.css" rel="stylesheet"> <!-- Liên kết tệp CSS -->

</head>

<body>

    <?php
        include 'header.php';
        include 'carousel.php';
    ?>

    <?php  
    if(isset($_GET['trang'] )){
        $page = $_GET['trang'];
    }else{
        $page= 1;  
    }
    if($page == '' || $page == 1){
        $begin = 0;

    }else{
            $begin = ($page * 8) - 8;
        }
        
    $sql = "SELECT * FROM tbl_sanpham, tbl_loaisanpham 
            WHERE tbl_sanpham.loaisanpham_id = tbl_loaisanpham.loaisanpham_id 
            ORDER BY sanpham_id DESC 
            LIMIT $begin, 8";  
          $query = mysqli_query($conn,$sql);
       ?>
    <div class="container mt-5">
        <h1 class="text-center">Sản phẩm mới</h1>
        <hr>
        <div class="row">
            <?php
                while($row = mysqli_fetch_array($query)){
            ?>
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="images/product/<?php echo $row['sanpham_anh'] ?>" class="card-img-top"
                        alt="<?php echo $row['sanpham_tieude'] ?>">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?php echo $row['sanpham_tieude'] ?></h5>
                        <p class="card-text price">Giá bán:
                            <?php echo number_format($row['sanpham_gia'], 0, ',', '.') . ' VNĐ' ?></p>
                        <a href="mua_ngay.php?sanpham_id=<?php echo $row['sanpham_id']; ?>" class="btn btn-info">Mua
                            ngay</a>
                        <a href="view_product.php?sanpham_id=<?php echo $row['sanpham_id']; ?>"
                            class="btn btn-secondary">Xem
                            nhanh</a>
                    </div>
                </div>
            </div>
            <?php
            }
        ?>
        </div>
    </div>

    <div class="pagination-container">
        <?php
            $sql_2 = "select * from tbl_sanpham";
            $query_2 = mysqli_query($conn,$sql_2);
             $count = mysqli_num_rows($query_2);
              $a = ceil($count/8);
            ?>
        <ul class="pagination">
            <?php
                 if($page > 1){
                ?>
            <li class="page-item">
                <a class="page-link" href="?trang=<?php echo $page-1; ?>">Previous</a>
            </li>
            <?php
                            }
                  for($b=1;$b<=$a;$b++){
                 if($page == $b){
                    $active = "active";
                      }else{
                    $active = "";
                   }
                            ?>
            <li class="page-item <?php echo $active ?>">
                <a class="page-link" href="?trang=<?php echo $b ?>"><?php echo $b ?></a>
            </li>

            <?php
                }
                if($page < $a){
                ?>
            <li class="page-item">
                <a class="page-link" href="?trang=<?php echo $page+1; ?>">Next</a>
            </li>
            <?php
                }
                ?>
        </ul>

    </div>

    <?php
       include 'footer.php';
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

</body>

</html>