<?php include 'checklogin.php'; ?>
<?php
// ดึงข้อมูลจากฐานข้อมูล
require './api/dbconnect.php';
$sql = "SELECT MONTH(start_date) AS event_month, COUNT(*) AS event_count FROM events GROUP BY event_month ORDER BY event_month";
$result = $conn->query($sql);

$months = [
  1 => "มกราคม",
  2 => "กุมภาพันธ์",
  3 => "มีนาคม",
  4 => "เมษายน",
  5 => "พฤษภาคม",
  6 => "มิถุนายน",
  7 => "กรกฎาคม",
  8 => "สิงหาคม",
  9 => "กันยายน",
  10 => "ตุลาคม",
  11 => "พฤศจิกายน",
  12 => "ธันวาคม"
];

// เตรียมอาเรย์สำหรับเก็บผลลัพธ์
$monthlyData = array_fill(1, 12, 0);
$labels = [];
$data = [];

// ดึงข้อมูลจากฐานข้อมูล
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $monthlyData[(int) $row["event_month"]] = (int) $row["event_count"];
  }


  // เตรียมข้อมูลเพื่อใช้ในการสร้างกราฟ
  foreach ($months as $key => $month) {
    $labels[] = $month;
    $data[] = $monthlyData[$key];
  }
} else {
  $labels = [];
  $data = [];
}

$sql = "SELECT DISTINCT(YEAR(start_date)) as YEAR FROM events;";
$result = $conn->query($sql);
$years = [];
while ($row = $result->fetch_assoc()) {
  $years[] = $row["YEAR"];
}

$conn->close();

// กำหนดสีสำหรับกราฟวงกลม
$colors = array(
  "#FF6384",
  "#36A2EB",
  "#FFCE56",
  "#4BC0C0",
  "#9966FF",
  "#FF9F40",
  "#FFCD56",
  "#4D5360",
  "#C9CBCF",
  "#F7464A",
  "#46BFBD",
  "#FDB45C",
  "#949FB1",
  "#4D5360",
  "#AC64AD",
  "#616774",
  "#F57C00",
  "#7CB342",
  "#039BE5",
  "#D32F2F",
  "#FBC02D",
  "#512DA8",
  "#C2185B",
  "#00796B",
  "#F57C00",
  "#388E3C",
  "#0288D1",
  "#D32F2F",
  "#C2185B",
  "#00796B"
);

// ดึงข้อมูลสถานที่และจำนวนกิจกรรมสำหรับกราฟวงกลม
require './api/dbconnect.php';
$sql = "SELECT location.name AS location_name, COUNT(*) AS event_count FROM events JOIN location ON events.location_id = location.id GROUP BY location_id ORDER BY location_id;";
$result = $conn->query($sql);
$locations = array();
$event_counts = array();
$background_colors = array();
if ($result->num_rows > 0) {
  $i = 0;
  while ($row = $result->fetch_assoc()) {
    $locations[] = $row['location_name'];
    $event_counts[] = $row['event_count'];
    $background_colors[] = $colors[$i % count($colors)]; // ใช้สีซ้ำหากเกิน 30 สี
    $i++;
  }
} else {
  $locations = [];
  $event_counts = [];
  $background_colors = [];
}


//$conn->close();

// $data = array(
//   "labels" => $locations,
//   "datasets" => array(
//     array(
//       "data" => $event_counts,
//       "backgroundColor" => $background_colors
//     )
//   )
// );
$conn->close();
// ส่งข้อมูล JSON
// header('Content-Type: application/json');
// echo json_encode($data);


if (isset($_POST["year"])) {
  $year = $_POST["year"];
  require './api/dbconnect.php';
  if ($year == 1) {
    $sql = "SELECT MONTH(start_date) AS event_month, COUNT(*) AS event_count FROM events GROUP BY event_month ORDER BY event_month";
    $result = $conn->query($sql);
  } else {
    $sql = "SELECT MONTH(start_date) AS event_month, COUNT(*) AS event_count FROM events WHERE YEAR(start_date) = ? GROUP BY event_month ORDER BY event_month";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();
  }

  $monthlyData = array_fill(1, 12, 0);

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $monthlyData[(int) $row["event_month"]] = (int) $row["event_count"];
    }
  } else {
    echo json_encode(["status" => "0 results"]);
    exit;
  }

  $conn->close();

  $labels = [];
  $data = [];

  foreach ($months as $key => $month) {
    $labels[] = $month;
    $data[] = $monthlyData[$key];
  }

  echo json_encode(["labels" => $labels, "data" => $data]);
  exit;
}
if (isset($_POST["yearPie"])) {
  $year = $_POST["yearPie"];
  require './api/dbconnect.php';
  if ($year == 1) {
    $sql = "SELECT location.name AS location_name, COUNT(*) AS event_count FROM events JOIN location ON events.location_id = location.id GROUP BY location_id ORDER BY location_id;";
    $result = $conn->query($sql);
  } else {
    $sql = "SELECT location.name AS location_name, COUNT(*) AS event_count FROM events JOIN location ON events.location_id = location.id WHERE YEAR(events.start_date) = ? GROUP BY location_id ORDER BY location_id;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();
  }

  //$monthlyData = array_fill(1, 12, 0);
  $locations = array();
  $event_counts = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $locations[] = $row['location_name'];
      $event_counts[] = $row['event_count'];
    }
  } else {
    echo json_encode(["status" => "0 results"]);
    exit;
  }

  $conn->close();
  $background_colors = array();


  foreach ($locations as $key => $location) {
    $locationLabels[] = $location;
    $dataEvent_counts[] = $event_counts[$key];
    $background_colors[] = $colors[$key % count($colors)];
  }

  echo json_encode(["labels" => $locationLabels, "data" => $dataEvent_counts, "background_colors" => $background_colors]);
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>KU activity notification - Dashboard</title>
  <link rel="icon" type="image/x-icon" href="images/profile_defult.png" />
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet" />

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <?php include 'sideBar.php'; ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <?php include 'nav.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div> -->

          <!-- Content Row -->
          <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xl font-weight-bold text-info text-uppercase mb-1">
                        กิจกรรมที่กําลังดําเนินการ
                      </div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <?php
                          require './api/dbconnect.php';
                          $sql = "select count(*) as total from events WHERE CURRENT_DATE BETWEEN DATE(start_date) AND DATE(end_date)";
                          $result = $conn->query($sql);
                          if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $total = $row["total"];
                            echo "<div class='h5 mb-0 mr-3 font-weight-bold text-gray-800'>" . $total . "</div>";
                          }
                          $conn->close();
                          ?>

                        </div>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xl font-weight-bold text-success text-uppercase mb-1">
                        กิจกรรมที่จะจัดภายใน 7 วัน
                      </div>
                      <?php
                      require './api/dbconnect.php';
                      $sql = "SELECT COUNT(*) as total 
FROM events 
WHERE DATE(end_date) > CURRENT_DATE 
AND DATE(start_date) > CURRENT_DATE 
AND DATE(start_date) <= CURRENT_DATE + INTERVAL 7 DAY;
";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $total = $row["total"];
                        echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>" . $total . "</div>";
                      }
                      $conn->close();
                      ?>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xl font-weight-bold text-primary mb-1">
                        กิจกรรมที่จะจัดภายใน 30 วัน
                      </div>

                      <?php
                      require './api/dbconnect.php';
                      $sql = "SELECT COUNT(*) AS total 
FROM events 
WHERE CURRENT_DATE < DATE(start_date) 
AND DATE(start_date) > CURRENT_DATE + INTERVAL 7 DAY 
AND DATE(start_date) <= CURRENT_DATE + INTERVAL 30 DAY;
";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $total = $row["total"];
                        echo "<div class='h5 mb-0 font-weight-bold text-gray-800'>" . $total . "</div>";
                      }
                      $conn->close();

                      ?>


                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xl font-weight-bold text-warning text-uppercase mb-1">
                        กิจกรรมที่เสร็จสิ้นแล้ว
                      </div>
                      <?php
                      require './api/dbconnect.php';
                      $sql = "SELECT COUNT(*) AS total FROM events WHERE DATE(end_date) < CURRENT_DATE";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $total = $row["total"];
                        echo "  <div class='h5 mb-0 font-weight-bold text-gray-800'>
                        " . $total . "
                      </div>";
                      }
                      $conn->close();
                      ?>

                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Content Row -->

          <div class="row">
            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <div class="d-flex flex-row align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                      กิจกรรม/ปี
                    </h6>
                  </div>
                  <div class="d-flex flex-row align-items-center justify-content-between">
                    <select id="yearbarchart" class="mt-2 w-25 form-control">
                      <option value="1">ทั้งหมด</option>
                      <?php foreach ($years as $year) {
                        echo '<option value="' . $year . '">' . $year . '</option>';
                      }
                      ?>
                    </select>
                    <?php
                    require './api/dbconnect.php';
                    $sql = "SELECT COUNT(*) AS total FROM events;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                      $row = $result->fetch_assoc();
                      $total = $row["total"];
                      echo "  <div class='text-primary font-weight-bold' id='totalEvent'>
                        ทั้งหมด " . $total . " กิจกรรม
                      </div>";
                    }
                    $conn->close();
                    ?>


                  </div>

                </div>
                <div class="card-body">
                  <div class="chart-bar">
                    <canvas id="myBarChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    การใช้งานสถานที่
                  </h6>

                  <select id="yearPiechart" class="mt-2 w-25 form-control p-2">
                    <option value="1">ทั้งหมด</option>
                    <?php foreach ($years as $year) {
                      echo '<option value="' . $year . '">' . $year . '</option>';
                    }
                    ?>
                  </select>

                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                  </div>
                  <div id="detailPiecart" class="mt-4 text-center small">
                    <?php
                    $i = 0;
                    foreach ($locations as $loca) {
                      echo '<span class="mr-2">
            <i class="fas fa-circle" style="color:' . $background_colors[$i] . ';"></i> ' . $loca . '
          </span>';
                      $i++;
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </div>
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->


  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <!-- <script src="js/demo/chart-bar-demo.js"></script> -->
  <!-- <script src="js/demo/chart-pie-demo.js"></script> -->
  <script>
    $(document).ready(function () {
      $("#logoutLink").on("click", function (e) {
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: "./api/logout.php",
          success: function (response) {
            window.location.href = "login.php";
          },
        });
      });

      // Set new default font family and font color to mimic Bootstrap's default styling
      (Chart.defaults.global.defaultFontFamily = "Nunito"),
        '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = "#858796";

      var ctx = document.getElementById("myBarChart");
      var myBarChart = new Chart(ctx, {
        type: "bar",
        data: {
          labels: <?php echo json_encode($labels); ?>,
          datasets: [
            {
              label: "จำนวนกิจกรรม",
              backgroundColor: "#4e73df",
              hoverBackgroundColor: "#2e59d9",
              borderColor: "#4e73df",
              data: <?php echo json_encode($data); ?>,
            },
          ],
        },
        options: {
  maintainAspectRatio: false,
  layout: {
    padding: {
      left: 10,
      right: 25,
      top: 25,
      bottom: 0,
    },
  },
  scales: {
    xAxes: [
      {
        time: {
          unit: "month",
        },
        gridLines: {
          display: false,
          drawBorder: false,
        },
        maxBarThickness: 25,
        scaleLabel: {
          display: true,
          labelString: 'เดือน' // Title สำหรับแกน x
        },
      },
    ],
    yAxes: [
      {
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          max: 3,
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2],
        },
        scaleLabel: {
          display: true,
          labelString: 'จำนวน' // Title สำหรับแกน y
        },
      },
    ],
  },
}

      });

      $("#yearbarchart").on("change", function () {
        var year = $(this).val();
        totalEvents(year);
        $.ajax({
          url: "",
          method: "POST",
          data: { year: year },
          dataType: "JSON",
          success: function (data) {
            if (data.status !== "0 results") {
              myBarChart.data.labels = data.labels;
              myBarChart.data.datasets[0].data = data.data;
              myBarChart.update();
            }
          },
          error: function () {
            console.error("Enter valid data");
          },
        });
      });

      $("#yearPiechart").on("change", function () {
        var yearPie = $(this).val();

        //totalEvents(year);
        //console.log(year);
        $.ajax({
          url: "",
          method: "POST",
          data: { yearPie: yearPie },
          dataType: "JSON",
          success: function (data) {
            if (data.status !== "0 results") {
              // console.log(data);
              myPieChart.data.labels = data.labels;
              myPieChart.data.datasets[0].data = data.data;
              myPieChart.data.datasets[0].backgroundColor = data.background_colors;
              setDetailTextLocation(data.background_colors, data.labels);
              myPieChart.update();
            }
          },
          error: function () {
            console.error("Enter valid data");
          },
        });
      });

      function totalEvents(year) {
        if (year !== "1") {
          $.ajax({
            url: `./api/getEvent.php?id=total&year=${year}`,
            type: "GET",
            success: function (response) {
              let total = JSON.parse(response);
              $("#totalEvent").text("ทั้งหมด " + total.total + " กิจกรรม");
            },
            error: function (error) { },
          });
        } else {
          $.ajax({
            url: `./api/getEvent.php?id=total`,
            type: "GET",
            success: function (response) {
              let total = JSON.parse(response);
              $("#totalEvent").text("ทั้งหมด " + total.total + " กิจกรรม");
            },
            error: function (error) { },
          });
        }
      }

      // Pie Chart Example
      var ctxpie = document.getElementById("myPieChart");
      var myPieChart = new Chart(ctxpie, {
        type: "doughnut",
        data: {
          labels: <?php echo json_encode($locations); ?>,
          datasets: [
            {
              data: <?php echo json_encode($event_counts); ?>,
              backgroundColor: <?php echo json_encode($background_colors); ?>,
              // hoverBackgroundColor: ["#2e59d9", "#17a673", "#2c9faf", "#17a673"],
              hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
          ],
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
          },
          legend: {
            display: false,
          },
          cutoutPercentage: 80,
        },
      });


      function setDetailTextLocation(color, text) {
        $("#detailPiecart").empty();
        for (let i = 0; i < text.length; i++) {
          $("#detailPiecart").append(
            `<span class="mr-2">
            <i class="fas fa-circle" style="color:${color[i]};"></i> ${text[i]}
          </span>`
          );
        }
      }

    });
  </script>
</body>

</html>