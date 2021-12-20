<?php
include('connect.php');
$sql = "SELECT * FROM car_brand";
$query1 = mysqli_query($conn, $sql);

// $sql2 = "SELECT * FROM car_brand";
// $query2 = mysqli_query($conn, $sql2);



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <!-- Theme style -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0-rc/css/adminlte.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@500&display=swap" rel="stylesheet">

  <script src="assets/jquery.min.js"></script>
  <script src="assets/script-car.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <style>
    body {
      font-family: 'Kanit', sans-serif;
    }
  </style>


</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">คำนวณเงินทุนประกันภัยรถยนต์</p>
        <?php

        ?>

        <form action="" method="post">
          <div class="text-center">
            <div class="row">
              <div class="col pt-2 text-end">
                <h5>ยี่ห้อรถยนต์</h5>
              </div>
              <div class="col">
                <select name="brand" id="brand" style="width: 200px" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                  <option value="0" selected>กรุณาเลือกยี่ห้อ</option>
                  <?php while ($result = mysqli_fetch_assoc($query1)) : ?>
                    <option value="<?= $result["brand_ID"] ?>"><?= $result["Brand_Name"] ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>


            <div class="row">
              <div class="col pt-2 text-end">
                <h5>รุ่นรถยนต์</h5>
              </div>
              <div class="col">
                <select name="model" id="model" style="width: 200px" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                  <option value="0">กรุณาเลือกรุ่น</option>
                </select>

              </div>
            </div>

            <div class="row">
              <div class="col pt-2 text-end">
                <h5>ปีรถยนต์</h5>
              </div>
              <div class="col">
                <select name="year" id="year" style="width: 200px" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                  <option value="0">กรุณาเลือกปี</option>
                </select>
              </div>
            </div>

          </div>
          <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary mt-3">
              คำนวณ <i class="fas fa-calculator"></i>
            </button>
          </div><br>
        </form>
        <?php
        $price = 0;
        // $min = NULL;
        // $max = NULL;
        if (isset($_POST['submit'])) {
          $y = $_POST['year'];
          $m = $_POST['model'];
          $b = $_POST['brand'];




          if ($y == 0 || $m == 0 || $b == 0) {
            echo "<script>";
            echo "alert('กรุณากรอกข้อมูลให้ครบถ้วน')";
            echo "</script>";
          } else {

            $nowYear = date("Y");
            $year = ($nowYear - $y) + 1;
            if ($year == 16) {
              $year = $year - 1;
            }
            $strMinYaer = 'min' . ((string)$year);
            $strMaxYaer = 'max' . ((string)$year);


            $sqlCallData1 = "SELECT * FROM car_info WHERE Model_ID = '$m' ";
            $resultData1 = mysqli_query($conn, $sqlCallData1);

            foreach ($resultData1 as $value) {
              $min = $value[$strMinYaer];
              $max = $value[$strMaxYaer];
            }

            $min = str_replace(',', '', $min);
            $max = str_replace(',', '', $max);
            $price =  ((int)$min + (int)$max) / 2;
            if ($price == 0) {
              $value == NULL;
              echo "<script type=\"text/javascript\">";
              echo "alert(\"ไม่มีข้อมูลสำหรับปีที่คุณเลือก...<<\");";
              echo "</script>";

              exit(0);
            } else {
              $sqlCallData2 = "SELECT Brand_Name FROM car_brand WHERE brand_ID = '$b' ";
              $resultData2 = mysqli_query($conn, $sqlCallData2);

              foreach ($resultData2 as $value) {
                $brand = $value['Brand_Name'];
              }
              //echo $brand;
              $sqlCallData3 = "SELECT Name FROM car_model WHERE id = '$m' ";
              $resultData3 = mysqli_query($conn, $sqlCallData3);

              foreach ($resultData3 as $value) {
                $model = $value['Name'];
              }
              // echo $model;
              $sqlCallData4 = "SELECT Year_Name FROM car_year WHERE Year_Name = '$y' ";
              $resultData4 = mysqli_query($conn, $sqlCallData4);

              foreach ($resultData4 as $value) {
                $year = $value['Year_Name'];
              }
              //echo $year;

              echo '<div class="text-center">';
              echo '<div class="row">';
              echo "<h4>สรุปข้อมูล</h4>";
              echo '</div>';
              echo '</div>';
              echo '<div class="text-left">';
              echo '<div class="row">';
              echo "<h5>ยี่ห้อรถที่คุณเลือก : ",$brand,"</h5>";
              echo '</div>';
              echo '<div class="row">';
              echo "<h5>รุ่นรถที่คุณเลือก : ",$model,"</h5>";
              echo '</div>';
              echo '<div class="row">';
              echo "<h5>ปีที่คุณเลือก : ",$year,"</h5>";
              echo '</div>';
              echo '</div><br>';
              echo '<div class="text-center">';
              echo '<div class="row">';
              echo "<h5>เงินทุนประกันของคุณคือ</h5>";
              echo "<h2><span class='badge badge-danger'>", number_format($price), " บาท</span></h2>";
              echo '</div>';
              echo '</div>';
            }
          }
        }


        ?>





      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

</body>

</html>