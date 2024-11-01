<?php include 'checklogin.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="images/profile_defult.png" />

      <title>KU activity notification - จัดการกิจกรรม</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="css/modaldetail.css" rel="stylesheet">
    

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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class=" m-0 font-weight-bold text-primary">ตารางจัดการกิจกรรม</h6>
                            <a href="addEvent.php" class="btn btn-success">
                                <i class="fa fa-plus"> </i> เพิ่มกิจกรรม
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0"
                                    id="myTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อกิจกรรม</th>
                                            <th>วัน - เวลาเริ่มต้น</th>
                                            <th>วัน - เวลาสิ้นสุด</th>
                                            <th>สถานที่</th>
                                            <th>สถานะ</th>
                                            <th>รายละเอียด</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody class="" id="tableBody">
                                        <!-- ที่นี่จะเพิ่มข้อมูลในภายหลัง -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>


        <div id="modal-detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-detail-label"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold" id="modal-detail-label">รายละเอียดกิจกรรม</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="event-details">
  <div class="event-content">
    <div class="event-image">
      <img id="imageDisplay" src="" alt="โปสเตอร์กิจกรรม" class="poster">
    </div>
    <div class="event-info">
      <table class="event-table">
        <tr>
          <th>ชื่อกิจกรรม</th>
          <td id="showname"></td>
        </tr>
        <tr>
          <th>วัน - เวลาเริ่มต้น</th>
          <td id="showdate"></td>
        </tr>
        <tr>
          <th>วัน - เวลาสิ้นสุด</th>
          <td id="showdateend"></td>
        </tr>
        <tr>
          <th>สถานที่</th>
          <td id="showplace"></td>
        </tr>
        <tr>
          <th>รายละเอียด</th>
          <td class="details" id="showdetail"></td>
        </tr>
        <tr>
          <th>หน่วยงานหลักที่รับผิดชอบ</th>
          <td id="showFaculty"></td>
        </tr>
        <tr>
          <th>หน่วยงานรองที่รับผิดชอบ</th>
          <td id="showBranch"></td>
        </tr>
        <tr>
          <th>บุคลากรที่รับผิดชอบ</th>
          <td id="showPersonel"></td>
        </tr>
      </table>
    </div>
  </div>
</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ปิด
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Page level custom scripts -->
        <!-- <script src="js/demo/datatables-demo.js"></script> -->
        <script>
            $(document).ready(function () {
                var data;
              const monthNames = [
                    "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", 
                    "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", 
                    "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
                ];

                function editEvent(id) {
                    // ตรวจสอบว่าข้อมูลไม่เป็น null และมีความยาวมากกว่า 0
                    window.location.href = `editEvent.php?id=${id}`;
                }

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

                function showdetail(id) {
                    $.ajax({
                        url: `./api/getEvent.php?id=${id}`,
                        type: "GET",
                        success: function (response) {
                            let res = JSON.parse(response);
                            var startDate = changeFormatDate(res.start_date);
                            var endDate = changeFormatDate(res.end_date);
                            console.log(res);
                                //show all detail
                             $("#showdate").html(
                                startDate
                             )
                             $("#showdateend").html(
                                endDate
                             )
                             $("#showplace").html(res.location_name);
                             $("#showdetail").html(res.description);
                             $("#showFaculty").html(res.faculty_name);
                             $("#showBranch").html(res.branch_name);
                             $("#showPersonel").html(`${res.personnel_fname} ${res.personnel_lname}`);
                             $("#showname").html(res.name);
                             //show img
                            $.ajax({
                                url: `./api/getImage.php?event_id=${id}`,
                                type: "GET",
                                xhrFields: {
                                    responseType: "blob", // Important for binary data
                                },
                                success: function (data) {
                                    var url = URL.createObjectURL(data);
                                    $("#imageDisplay").attr("src", url);
                                },
                                error: function () {
                                    alert("Failed to load image. Please check the image ID.");
                                },
                            });
                            $("#modal-detail").modal("show");
                        },
                        error: function (error) { },
                    });
                }

                function delEvent(id) {
                    Swal.fire({
                        title: "ยืนยันการลบรายการกิจกรรม",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ยกเลิก",
                    })
                        .then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "./api/deleteEvent.php",
                                    type: "POST",
                                    data: { event_id: id },
                                    success: function (response) {
                                        let res = JSON.parse(response);
                                        if (res.status == "success") {
                                            Swal.fire({
                                                title: "ลบสำเร็จ",
                                                icon: "success",
                                            }).then(() => {
                                                reloadData();
                                            });
                                        } else {
                                            Swal.fire({
                                                title: "เกิดข้อผิดพลาด",
                                                text: res.message,
                                                icon: "error",
                                            });
                                        }
                                    },
                                    error: function (error) {
                                        let res = JSON.parse(error.responseText);
                                        Swal.fire({
                                            title: "เกิดข้อผิดพลาด",
                                            text: res.message,
                                            icon: "error",
                                        });
                                    },
                                });
                            }
                        })
                        .catch((error) => { });
                }

                function loadDataFromApi() {
                    $.ajax({
                        url: "./api/getEvent.php",
                        type: "GET",
                        success: function (response) {
                            data = JSON.parse(response);

                            updateDataTable(data);
                        },
                        error: function (error) { },
                    });
                }

                function updateDataTable(data) {
                    var tableBody = $("#tableBody");
                    tableBody.empty();
                    $.each(data, function (index, item) {
                        var startDate = changeFormatDate(item.start_date);
                        var endDate = changeFormatDate(item.end_date);
                        var sequenceNumber = index + 1;
                        var editButton = $("<button>", {
                            class: "btn btn-warning",
                            style: "margin-right:5px;",
                            title: "แก้ไขรายการกิจกรรม",
                            click: function () {
                                editEvent(item.id);
                            },
                        });
                        var delButton = $("<button>", {
                            class: "btn btn-danger",
                            style: "margin-left:5px;",
                            title: "ลบรายการกิจกรรม",
                            click: function () {
                                delEvent(item.id);
                            },
                        });
                        var detailButton = $("<button>", {
                            class: "btn btn-info text-center",
                            style: "margin-left:5px;",
                            title: "ดูรายละเอียด",
                            click: function () {
                                showdetail(item.id);
                            },
                        });
                        delButton.append(
                            '<i style="margin-left:2px;" class="fa fa-trash"></i>'
                        );
                        editButton.append(
                           '<i  style="margin-left:2px;" class="fas fa-edit"></i>'
                        );
                        detailButton.append(
                            '<i class="fa fa-search px-2"></i>'
                        );
                        tableBody.append(
                            $("<tr>").append(
                                $("<td class='text-center'>").text(sequenceNumber),
                                $("<td>").text(item.name),
                                $("<td>").text(startDate),
                                $("<td>").text(endDate),
                                $("<td>").text(item.location_name),
                                $("<td>").text(item.status).css({"color": getStatusColor(item.status),"font-weight" : "bold"}),
                                $("<td>").append(detailButton),
                                $("<td class='text-center'>").append(editButton, delButton)
                            )
                        );
                    });

                    // เปิดใช้ DataTables
                    $("#myTable").DataTable({
                        "sScrollX": "100%",
                        "sScrollXInner": "100%",
                        "bScrollCollapse": true,
                        language: {
                            url: "https://cdn.datatables.net/plug-ins/1.10.24/i18n/Thai.json",
                        },
                    });
                }
                function changeFormatDate(dateToformat) {
                    const date = new Date(dateToformat.replace(' ', 'T'));

                    const day = date.getDate();
                    const month = monthNames[date.getMonth()];
                    const year = date.getFullYear() + 543;
                    const hours = date.getHours().toString().padStart(2, '0');
                    const minutes = date.getMinutes().toString().padStart(2, '0');

                    const formattedDate = `${day} ${month} ${year}  ${hours}:${minutes} น.`;
                    return formattedDate;
                }
                function getStatusColor(status) {   
                    switch(status) {
                            case 'วันนี้':
                                color = "#36b9cc"; 
                                break;
                            case '7 วัน':
                                color = "green"; 
                                break;
                            case '30 วัน':
                                color = "blue"; 
                                break;
                            case 'จัดแล้ว':
                                color = "orange";
                                break;
                            default:
                                color = "black"; // สีดำเป็นค่าเริ่มต้น
                        }
                     return color;
                }

                function reloadData() {
                    $("#myTable").DataTable().destroy();
                    loadDataFromApi();
                }

                loadDataFromApi();
            });
        </script>

</body>

</html>