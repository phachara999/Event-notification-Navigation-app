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

  <title>KU activity notification - จัดการหน่วยงานย่อย</title>

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
                            <h6 class=" m-0 font-weight-bold text-primary">ตารางจัดการหน่วยงานย่อย</h6>
                            <button data-toggle="modal" data-target="#create-modal" class="btn btn-success">
                                <i class="fa fa-plus"> </i> เพิ่มหน่วยงานย่อย
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0"
                                    id="myTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อ</th>
                                            <th>สังกัดหน่วยงานหลัก</th>
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

        <div class="modal fade" id="create-modal" tabindex="-1" role="dialog" aria-labelledby="create-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3  class="modal-title font-weight-bold" id="create-modalLabel">
                            เพิ่มหน่วยงานย่อย
                        </h3>
                    </div>
                    <div class="modal-body">
                        <label class="font-weight-bold" for="">ชื่อ : </label>
                        <input placeholder="ขื่อหน่วยงานย่อย" class="form-control" type="text" id="create-name" />
                        <label class="font-weight-bold" for="">สังกัดหน่วยงานหลัก : </label>
                        <select class="form-control" name="" id="create-faculty"></select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ยกเลิก
                        </button>
                        <button id="confirm-create" type="button" class="btn btn-primary">
                            เพิ่ม
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="create-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title font-weight-bold" id="create-modalLabel">
                            แก้ไขหน่วยงานย่อย
                        </h3>
                    </div>
                    <div class="modal-body">
                        <input style="display: none" type="text" id="id" />
                        <label class="font-weight-bold" for="">ชื่อ : </label>
                        <input id="edit-name" class="form-control" type="text" />
                        <label class="font-weight-bold" for="">สังกัดหน่วยงานหลัก : </label>
                        <select class="form-control" name="" id="faculty"></select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ยกเลิก
                        </button>
                        <button id="confirm-edit" type="button" class="btn btn-primary">
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
                var data;
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
                $("#confirm-create").click((e) => {
                    let dataCreate = {
                        name: $("#create-name").val(),
                        faculty_id: $("#create-faculty").val(),
                    };
                    console.log(dataCreate);
                    $.ajax({
                        url: "./api/addBranch.php",
                        type: "POST",
                        data: dataCreate,
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status == "success") {
                                Swal.fire({
                                    title: "เพิ่มสำเร็จ",
                                    icon: "success",
                                }).then(() => {
                                    $("#create-name").val("");
                                    $("#create-modal").modal("hide");
                                    setfaculty();
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
                });
                $("#confirm-edit").click((e) => {
                    let dataUpdate = {
                        id: $("#id").val(),
                        name: $("#edit-name").val(),
                        faculty_id: $("#faculty").val(),
                    };

                    $.ajax({
                        url: "./api/editBranch.php",
                        type: "POST",
                        data: dataUpdate,
                        success: function (response) {
                            let res = JSON.parse(response);
                            if (res.status == "success") {
                                Swal.fire({
                                    title: "แก้ไขสำเร็จ",
                                    icon: "success",
                                }).then(() => {
                                    $("#edit-modal").modal("hide");
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
                });

                function editBranch(id) {
                    $.ajax({
                        url: `./api/getBranch.php?id=${id}`,
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
                                $("#id").val(res.id);
                                $("#edit-name").val(res.name);
                                setfaculty(res.faculty_id);
                                $("#edit-modal").modal("show");
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

                function delEvent(id) {
                    Swal.fire({
                        title: "ยืนยันการลบหน่วยงานย่อย",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ยกเลิก",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "./api/deleteBranch.php",
                                type: "POST",
                                data: { id: id },
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
                    });
                }

                async function setfaculty(id) {
                    if (id) {
                        let facultyOptions = `<option value="">เลือก</option>`;
                        let facultys = await getfaculty();
                        facultyOptions += facultys.map((faculty) => {
                            return faculty.id == id
                                ? `<option selected value="${faculty.id}">${faculty.name}</option>`
                                : `<option value="${faculty.id}">${faculty.name}</option>`;
                        });
                        $("#faculty").html(facultyOptions);
                    } else {
                        let facultyOptions = `<option value="">เลือก</option>`;
                        let facultys = await getfaculty();
                        facultyOptions += facultys.map((faculty) => {
                            return `<option value="${faculty.id}">${faculty.name}</option>`;
                        });
                        $("#create-faculty").html(facultyOptions);
                    }
                }
                function getfaculty() {
                    return new Promise((resolve, reject) => {
                        $.ajax({
                            url: "./api/getFaculty.php",
                            type: "GET",
                            success: function (response) {
                                resolve(JSON.parse(response));
                            },
                            error: function (error) {
                                reject(error);
                            },
                        });
                    });
                }

                function loadDataFromApi() {
                    $.ajax({
                        url: "./api/getBranch.php",
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
                            title: "แก้ไขหน่วยงานย่อย",
                            class: "btn btn-warning",
                            style: "margin-right:5px;",
                            click: function () {
                                editBranch(item.id);
                            },
                        });
                        var delButton = $("<button>", {
                            title: "ลบหน่วยงานย่อย",
                            class: "btn btn-danger",
                            style: "margin-left:5px;",
                            click: function () {
                                delEvent(item.id);
                            },
                        });

                        delButton.append(
                            '<i style="margin-left:2px;" class="fa fa-trash"></i>'
                        );
                        editButton.append(
                           '<i  style="margin-left:2px;" class="fas fa-edit"></i>'
                        );
                        tableBody.append(
                            $("<tr>").append(
                                $("<td  class='text-center'>").text(sequenceNumber),
                                $("<td>").text(item.name),
                                $("<td>").text(item.faculty_name),
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
                function reloadData() {
                    $("#myTable").DataTable().destroy();         
                    loadDataFromApi();
                }

                loadDataFromApi();
                setfaculty();
            });
        </script>

</body>

</html>