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

    <title>KU activity notification - จัดการบุคลากร</title>

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
                            <h6 class=" m-0 font-weight-bold text-primary">ตารางจัดการบุคลากร</h6>
                            <button id="createPersonal" data-toggle="modal" data-target="#create-modal" class="btn btn-success">
                                <i class="fa fa-plus"> </i> เพิ่มบุคลาการ
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="myTable" width="100%" cellspacing="0"
                                    id="myTable">
                                    <thead class="text-center">
                                        <tr>
                                            <th>ลำดับ</th>
                                            <!-- <th>เลขประจำตัว</th> -->
                                            <th>ชื่อ</th>
                                            <th>นามสกุล</th>
                                            <th>สังกัดหน่วยงานย่อย</th>
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
                        <h3 class="modal-title font-weight-bold" id="create-modalLabel">
                            เพิ่มบุคลากร
                        </h3>
                    </div>
                    <div class="modal-body">
                        <label class="font-weight-bold" for="">ชื่อ : </label>
                        <input placeholder="ชื่อ" id="create-fname" class="form-control" type="text" />
                        <label class="font-weight-bold" for="">นามสกุล : </label>
                        <input placeholder="นามสกุล" id="create-lname" class="form-control" type="text" />
                        <!-- <label class="font-weight-bold" for="">เลขประจำตัว : </label>
                        <input placeholder="เลขประจำตัว" id="create-number" class="form-control" type="number" /> -->
                        <label class="font-weight-bold" for="">สังกัดหน่วยงานหลัก : </label>
                        <select id="create-faculty" class="form-control" name="">
                            <option value="">เลือก</option>
                        </select>
                        <label class="font-weight-bold" for="">สังกัดหน่วยงานย่อย : </label>
                        <select disabled id="create-branch" class="form-control" name="" id="">
                            <option value="">เลือก</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ยกเลิก
                        </button>
                        <button id="confirmCreatePersonal" type="button" class="btn btn-primary">
                            เพิ่ม
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="create-modalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title font-weight-bold" id="create-modalLabel">
                            แก้ไขบุคลากร
                        </h3>
                    </div>
                    <div class="modal-body">
                        <input style="display: none" type="text" name="" id="pOid" />
                        <label class="font-weight-bold" for="">ชื่อ : </label>
                        <input id="edit-fname" class="form-control" type="text" />
                        <label class="font-weight-bold" for="">นามสกุล : </label>
                        <input id="edit-lname" class="form-control" type="text" />
                        <!-- <label class="font-weight-bold" for="">เลขประจำตัว : </label>
                        <input id="edit-number" class="form-control" type="number" /> -->

                        <label class="font-weight-bold" for="">สังกัดหน่วยงานหลัก : </label>
                        <select class="form-control" name="" id="edit-faculty">
                            <option value="1">เลือก</option>
                        </select>
                        <label class="font-weight-bold" for="">สังกัดหน่วยงานย่อย : </label>
                        <select disabled class="form-control" name="" id="edit-branch">
                            <option value="1">เลือก</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            ยกเลิก
                        </button>
                        <button id="confirmEditPersonal" type="button" class="btn btn-primary">
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
                $("#create-modal").on("hidden.bs.modal", function (e) {
                    $("#create-branch").attr("disabled", "disabled");
                });

                $("#edit-faculty").change((e) => setbranchforEdit(e));
                async function setbranchforEdit(e) {
                    let Facultyid = e.target.value;
                    let branchOptions = `<option value="">เลือก</option>`;

                    if (Facultyid) {
                        try {
                            let Branches = await getbranch(Facultyid);

                            branchOptions += Branches.map((Branch) => {
                                return `<option value="${Branch.id}">${Branch.name}</option>`;
                            }).join("");
                        } catch (error) {
                            Swal.fire({
                                title: "มีบางอย่างผิดพลาด",
                                icon: "error",
                                confirmButtonText: "ยืนยัน",
                            });
                        }
                    }

                    $("#edit-branch").html(branchOptions);
                    $("#edit-branch").removeAttr("disabled");
                }
                $("#create-faculty").change((e) => setbranchforCreate(e));
                async function setbranchforCreate(e) {
                    let Facultyid = e.target.value;
                    let branchOptions = `<option value="">เลือก</option>`;
                    if (Facultyid) {
                        try {
                            let Branches = await getbranch(Facultyid);
                            branchOptions += Branches.map((Branch) => {
                                return `<option value="${Branch.id}">${Branch.name}</option>`;
                            }).join("");
                        } catch (error) {
                            Swal.fire({
                                title: "มีบางอย่างผิดพลาด",
                                icon: "error",
                                confirmButtonText: "ยืนยัน",
                            });
                        }
                    }

                    $("#create-branch").html(branchOptions);
                    $("#create-branch").removeAttr("disabled");
                }

                $("#confirmEditPersonal").on("click", function () {
                    var updatedData = {
                        id: $("#pOid").val(),
                        first_name: $("#edit-fname").val(),
                        last_name: $("#edit-lname").val(),
                        // personnel_number: $("#edit-number").val(),
                        faculty_id: $("#edit-faculty").val(), // ตัวอย่างเท่านั้น แต่ควรเป็นในฟอร์มของคุณ
                        branch_id: $("#edit-branch").val(), // ตัวอย่างเท่านั้น แต่ควรเป็นในฟอร์มของคุณ
                    };
                    $.ajax({
                        url: "./api/editPersonal.php", // ต้องแก้ไขเป็น URL ของไฟล์ PHP ที่ทำการอัปเดตบุคลากร
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
                            } else {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    text: "ไม่สามารถอัปเดตข้อมูลได้",
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
                $("#confirmCreatePersonal").on("click", function () {
                    var updatedData = {
                        first_name: $("#create-fname").val(),
                        last_name: $("#create-lname").val(),
                        // personnel_number: $("#create-number").val(),
                        faculty_id: $("#create-faculty").val(),
                        branch_id: $("#create-branch").val(),
                    };


                    $.ajax({
                        url: "./api/addPersonal.php",
                        type: "POST",
                        data: updatedData,
                        success: function (response) {

                            let res = JSON.parse(response);
                            if (res.status === "success") {
                                Swal.fire({
                                    title: "เพิ่มสำเร็จ",
                                    icon: "success",
                                }).then(() => {
                                    $("#create-modal").modal("hide");
                                    $("#create-fname").val(""),
                                        $("#create-lname").val(""),
                                        // $("#create-number").val(""),
                                        reloadData();
                                });
                            } else {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    text: "ไม่สามารถเพิ่มข้อมูลได้",
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

                function getbranch(Facultyid) {
                    if (Facultyid) {
                        return new Promise((resolve, reject) => {
                            $.ajax({
                                url: `./api/getBranch.php?Facultyid=${Facultyid}`,
                                type: "GET",
                                success: function (response) {
                                    resolve(JSON.parse(response));
                                },
                                error: function (error) {
                                    reject(error);
                                },
                            });
                        });
                    } else {
                        return new Promise((resolve, reject) => {
                            $.ajax({
                                url: "./api/getBranch.php",
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
                }

                $("#createPersonal").click(async () => {
                    let faculties = await getfaculty();
                    let branches = await getbranch();
                   
                    let facultyOptions = `<option value="">เลือก</option>`;
                    let branchOptions = `<option value="">เลือก</option>`;

                    // Populate faculty options
                    facultyOptions += faculties
                        .map((faculty) => {
                            return `<option value="${faculty.id}">${faculty.name}</option>`;
                        })
                        .join("");
                    $("#create-faculty").html(facultyOptions);

                    // Populate branch options
                    branchOptions += branches
                        .map((branch) => {
                            return `<option value="${branch.id}">${branch.name}</option>`;
                        })
                        .join("");
                    $("#create-branch").html(branchOptions);
                });

                async function editPersonel(id) {
                    $("#edit-branch").attr("disabled", "disabled");
                    let facultyOptions = `<option value="">เลือก</option>`;
                    let branchOptions = `<option value="">เลือก</option>`;
                    // Fetch faculty and branch data
                    let faculties = await getfaculty();
                    let branches = await getbranch();
                    facultyOptions += faculties
                        .map((faculty) => {
                            return `<option value="${faculty.id}">${faculty.name}</option>`;
                        })
                        .join("");
                    $("#edit-faculty").html(facultyOptions);

                    // Populate branch options
                    branchOptions += branches
                        .map((branch) => {
                            return `<option value="${branch.id}">${branch.name}</option>`;
                        })
                        .join("");
                    $("#edit-branch").html(branchOptions);
                    $.ajax({
                        url: `./api/getPersonnel.php?id=${id}`,
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
                                $("#pOid").val(res.id), $("#edit-fname").val(res.first_name);
                                $("#edit-lname").val(res.last_name);
                                // $("#edit-number").val(res.personnel_number);
                                $("#edit-faculty").val(res.faculty_id); //ใส่ seleted ให้กับอันเก่า
                                $("#edit-branch").val(res.branch_id); //ใส่ seleted ให้กับอันเก่า

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

                function delPersonal(id) {
                    Swal.fire({
                        title: "ยืนยันการลบบุคลากร",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "ยืนยัน",
                        cancelButtonText: "ยกเลิก",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "./api/deletePersonal.php",
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

                function loadDataFromApi() {
                    $.ajax({
                        url: "./api/getPersonnel.php",
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
                            title: "แก้ไขบุคลากร",
                            class: "btn btn-warning",
                            style: "margin-right:5px;",
                            click: function () {
                                editPersonel(item.id);
                            },
                        });
                        var delButton = $("<button>", {
                            title: "ลบบุคลากร",
                            class: "btn btn-danger",
                            style: "margin-left:5px;",
                            click: function () {
                                delPersonal(item.id);
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
                                // $("<td>").text(item.personnel_number),
                                $("<td>").text(item.first_name),
                                $("<td>").text(item.last_name),
                                $("<td>").text(item.branchName),
                                $("<td>").text(item.facultyName),
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
            });
        </script>

</body>

</html>