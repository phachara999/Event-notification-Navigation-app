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

     <title>KU activity notification - จัดการสถานที่</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                            <h6 class=" m-0 font-weight-bold text-primary">ตารางจัดการสถานที่</h6>
                            <button data-toggle="modal" data-target="#modal-create" class="btn btn-success">
                                <i class="fa fa-plus"> </i> เพิ่มสถานที่
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0"
                                    id="myTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อสถานที่</th>
                                            <!-- <th>เลขอาคาร</th> -->
                                            <th>ละติจูด</th>
                                            <th>ลองติจูด</th>
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

        <div class="modal fade" id="modal-create" tabindex="-1" role="dialog" aria-labelledby="Create-Label"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title font-weight-bold" id="Create-Label">เพิ่มสถานที่</h3>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex ml-4">
                            <input class="form-check-input" type="checkbox" name="isBding" id="isBding" />
                            <label class="font-weight-bold" for="isBding">ไม่ใช่อาคาร</label>
                        </div>
                        <label class="font-weight-bold" for="">ชื่อ : </label>
                        <input placeholder="ชื่อ" id="CreateLoname" class="form-control" type="text" />

                        <label class="font-weight-bold" for="">เลขอาคาร : </label>
                        <input placeholder="เลขอาคาร" id="CreateLonum" class="form-control" type="number" />
                        <label class="font-weight-bold" for="">ละติจูด : </label>
                        <input placeholder="ละติจูด" id="CreateLolatitude" class="form-control" type="number" />
                        <label class="font-weight-bold" for="">ลองติจูด : </label>
                        <input placeholder="ลองติจูด" id="CreateLolongitude" class="form-control" type="number" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ยกเลิก
                        </button>
                        <button id="confirmCreateLocation" type="button" class="btn btn-primary">
                            เพิ่ม
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title font-weight-bold" id="exampleModalLabel">
                            แก้ไขสถานที่
                        </h3>
                    </div>
                    <div class="modal-body">
                        <input id="Loid" style="display: none" type="text" />
                        <label class="font-weight-bold" for="">ชื่อ : </label>
                        <input id="Loname" class="form-control" type="text" />

                        <label class="font-weight-bold" for="">เลขอาคาร : </label>
                        <input id="editLonum" class="form-control" type="number" />

                        <label class="font-weight-bold" for="">ละติจูด : </label>
                        <input id="Lolatitude" class="form-control" type="number" />
                        <label class="font-weight-bold" for="">ลองติจูด : </label>
                        <input id="Lolongitude" class="form-control" type="number" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ยกเลิก
                        </button>
                        <button id="confirmEditLocation" type="button" class="btn btn-primary">
                            บันทึก
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
                $("#logoutLink").on("click", function (e) {
                    e.preventDefault();
                    $.ajax({
                        type: "POST",
                        url: "./api/logout.php",
                        success: function (response) {
                            var data = JSON.parse(response);
                            Swal.fire({
                                title: "แจ้งเตือน",
                                text: data.message,
                                icon: "success",
                            }).then(() => {
                                // Optionally, redirect to the login page or home page after logout
                                window.location.href = "login.php";
                            });
                        },
                    });
                });
                //ถ้าปืด modal โดยไม่ได้ทำอะไร
                $("#modal-create").on("hidden.bs.modal", function (e) {
                    $("#CreateLonum").removeAttr("disabled");
                    $("#isBding").prop("checked", false);
                });
                var data;
                $("#isBding").change((e) => isBdingtoggle());
                function isBdingtoggle() {
                    if (document.getElementById("isBding").checked) {
                        $("#CreateLonum").attr("disabled", "disabled");
                    } else {
                        $("#CreateLonum").removeAttr("disabled");
                    }
                }

                $("#confirmCreateLocation").on("click", function () {
                    var newDataLocation = {
                        name: $("#CreateLoname").val(),
                        latitude: $("#CreateLolatitude").val(),
                        longitude: $("#CreateLolongitude").val(),
                        building_number: $("#CreateLonum").val() || "-",
                        isBding: document.getElementById("isBding").checked,
                    };
                    console.log($("#CreateLonum").val());

                    if (!document.getElementById("isBding").checked && $("#CreateLonum").val() == '') {
                        Swal.fire({
                            title: "เกิดข้อผิดพลาด",
                            text: "ใส่ข้อมูลให้ถูกต้อง",
                            icon: "error",
                        });
                        return;
                    }

                    $.ajax({
                        url: "./api/addLocation.php",
                        type: "POST",
                        data: newDataLocation,
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status === "success") {
                                Swal.fire({
                                    title: "เพิ่มสำเร็จ",
                                    icon: "success",
                                }).then(() => {
                                    $("#modal-create").modal("hide");
                                    $("#CreateLoname").val("");
                                    $("#CreateLolatitude").val("");
                                    $("#CreateLolongitude").val("");
                                    reloadData();
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
                });

                $("#confirmEditLocation").on("click", function () {
                    var updatedData = {
                        id: $("#Loid").val(),
                        name: $("#Loname").val(),
                        latitude: $("#Lolatitude").val(),
                        longitude: $("#Lolongitude").val(),
                        building_number: $("#editLonum").val() || "999",
                    };
                    $.ajax({
                        url: "./api/editlocation.php",
                        type: "POST",
                        data: updatedData,
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status === "success") {
                                Swal.fire({
                                    title: "อัปเดตสำเร็จ",
                                    icon: "success",
                                }).then(() => {
                                    $("#modal-edit").modal("hide");
                                    reloadData(); // Reload the table data
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
                });

                function editLocation(id) {
                    $.ajax({
                        url: `./api/getLocation.php?id=${id}`,
                        type: "GET",
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status == "error") {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    text: res.message,
                                    icon: "error",
                                });
                            } else {
                                if (res.building_number == "-") {
                                    $("#editLonum").attr("disabled", "disabled");
                                } else {
                                    $("#editLonum").removeAttr("disabled");
                                }
                                $("#Loname").val(res.name);
                                $("#Loid").val(res.id);
                                $("#Lolatitude").val(res.latitude);
                                $("#Lolongitude").val(res.longitude);
                                $("#editLonum").val(res.building_number);
                                $("#modal-edit").modal("show");
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
                function delLocation(id) {
                    Swal.fire({
                        title: "ยืนยันการลบรายการสถานที่",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ยกเลิก",
                    })
                        .then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "./api/deleteLocation.php",
                                    type: "POST",
                                    data: { location_id: id },
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
                        url: "./api/getLocation.php",
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
                        var sequenceNumber = index + 1;
                        var editButton = $("<button>", {
                            title: "แก้ไขสถานที่",
                            class: "btn btn-warning",
                            style: "margin-right:5px;",
                            click: function () {
                                editLocation(item.id);
                            },
                        });
                        var delButton = $("<button>", {
                            title: "ลบสถานที่",
                            class: "btn btn-danger",
                            style: "margin-left:5px;",
                            click: function () {
                                delLocation(item.id);
                            },
                        });
                        if (item.building_number == null) {
                            item.building_number = "-";
                        }

                        delButton.append(
                            '<i style="margin-left:2px;" class="fa fa-trash"></i>'
                        );
                        editButton.append(
                           '<i  style="margin-left:2px;" class="fas fa-edit"></i>'
                        );
                        let locationText = item.building_number == "-" ? item.name : `${item.name} (อาคาร ${item.building_number})`;
                        tableBody.append(
                            $("<tr>").append(
                                $("<td class='text-center'>").text(sequenceNumber),
                                $("<td>").text(locationText),
                                // $("<td>").text(item.building_number ),
                                $("<td>").text(limitDecimalPlaces(item.latitude, 6)),
                                $("<td>").text(limitDecimalPlaces(item.longitude, 6)),
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

                    function limitDecimalPlaces(number, decimalPlaces) {
                        const numbertofixed = parseFloat(number);
                        if (number == null) {
                        return null; // หรือจะคืนค่าอื่นๆ ตามที่ต้องการ
                    }
                        return parseFloat(numbertofixed.toFixed(decimalPlaces));
                    }

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