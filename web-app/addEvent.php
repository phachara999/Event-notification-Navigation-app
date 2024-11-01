<?php include 'checklogin.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KU activity notification - เพิ่มกิจกรรม</title>
    <link rel="icon" type="image/x-icon" href="images/profile_defult.png" />
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css" />
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">  
    <style>
   input::placeholder {
    opacity: 1 !important;
    color: grey !important;
}
input[type=text] {
  /* background-color: #3CBC8D; */
  color: black !important;
}
select {
  color: black !important;
}

    </style>
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

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="card p-3">
                        <h3 class="font-weight-bold text-primary" >เพิ่มกิจกรรม</h3>
                        <div class="row mt-2">
                            <div class="col-md-11">
                                <div class="">
                                    <h6  class="font-weight-bold text-primary">ชื่อกิจกรรม :</h6>
                                    <input placeholder="กรอกชื่อกิจกรรม" id="name" name="eventName" class="form-control"
                                        type="text" />
                                </div>
                            </div>

                            <div class="col-md-11 pt-2">
                                <h6  class="font-weight-bold text-primary">อาคาร :</h6>
                                <select id="Bding" name="Bding" class="form-control"
                                    aria-label="Default select example"></select>
                            </div>
                            <div class="col-md-11  pt-2">
                                <h6  class="font-weight-bold text-primary">ห้อง :</h6>
                                <select id="room" name="room" class="form-control">
                                    <option selected value="">เลือก</option>
                                </select>
                            </div>
                            <div class="col-md-11  pt-2">
                                <h6  class="font-weight-bold text-primary">บุคลากรที่รับผิดชอบ :</h6>
                                <select id="personnel" name="personnel" class="form-control"></select>
                            </div>
                            <div class="col-md-11  pt-2">
                                <h6  class="font-weight-bold text-primary">หน่วยงานหลักที่รับผิดชอบ :</h6>
                                <select id="mainOrg" name="mainOrg" class="form-control"></select>
                            </div>
                            <div class="col-md-11  pt-2">
                                <h6  class="font-weight-bold text-primary">หน่วยงานรองที่รับผิดชอบ :</h6>
                                <select id="subOrg" name="subOrg" class="form-control">
                                    <option selected value="">เลือก</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6  pt-2">
                                <div>
                                    <h6  class="font-weight-bold text-primary">เลือกรูปที่ต้องการ :</h6>
                                    <input accept="image/png, image/jpeg" class="form-control form-control-lg" id="img" name="img" type="file" />
                                </div>
                            </div>
                        </div>
                        <div class="m-3">
                                <img width="300" class="img-thumbnail p-2 d-none"  id="previewImg" alt="">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6  pt-2">
                                <h6  class="font-weight-bold text-primary">เลือกวันที่และเวลา:</h6>
                                <div class="input-group">
                                    <span>
                                        <i class="fas fa-fw fa-calendar-alt"></i>
                                    </span>

                                    <input name="time_period" type="text" class="form-control pull-right"
                                        id="datetimepicker" />
                                </div>
                            </div>
                            <div class="col-md-11  pt-2">
                                <h6  class="font-weight-bold text-primary">รายละเอียด :</h6>
                                <textarea id="detail" name="detail" class="form-control" style="width: 100%"
                                    rows="17"></textarea>
                            </div>
                        </div>
                        <button onclick="confirm()" class="btn btn-primary my-2 btn-block">
                            <i class="fas fa-save"></i>
                            เพิ่มกิจกรรม
                        </button>
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


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
    <script>
        $(function () {
             $("#img").change(function () {
                if (this.files && this.files[0]) {   
                    var imgUrl = URL.createObjectURL(this.files[0]);
                    $('#previewImg').removeClass('d-none').attr("src", imgUrl);
                }
            });
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
            $("#Bding").change(async (e) => {
                $("#room").removeAttr("disabled");
                let locationId = e.target.value;
                let RoomOptions = `<option value="">เลือก</option>`;

                if (locationId) {
                    try {
                        let Rooms = await getRoom(locationId);
                        if (Rooms.message === "room not found") {
                            RoomOptions = `<option value="999">เลือก</option>`;
                            //จัดการกับห้องทำให้ต้องเลืิกเท่านั้นเมื่อเลือกตัวเลือกที่มีห้อง*
                            $("#room").attr("disabled", "disabled");
                            $("#room").html(RoomOptions);
                            return;
                        }

                        RoomOptions += Rooms.map((Room) => {
                            if(Room.room_number == Room.name){
                                return `<option value="${Room.id}">${Room.room_number}</option>`;
                            }
                            return `<option value="${Room.id}">${Room.room_number} ${Room.name}</option>`;
                        }).join("");
                    } catch (error) {
                        Swal.fire({
                            title: "มีบางอย่างผิดพลาด",
                            icon: "error",
                            confirmButtonText: "ยืนยัน",
                        });
                    }
                }

                $("#room").html(RoomOptions);
            });
            $("#mainOrg").change(async (e) => {
                $("#subOrg").removeAttr("disabled");
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

                $("#subOrg").html(branchOptions);
            });
            async function setaddEvent() {
                let LocationOptions = `<option value="">เลือก</option>`;
                let PersonalOptions = `<option value="">เลือก</option>`;
                let facultyOptions = `<option value="">เลือก</option>`;

                let Locations = await getLocation();
                let Personals = await getPersonal();
                let Facultys = await getfaculty();

                // Populate faculty options
                LocationOptions += Locations.map((Location) => {
                    if(Location.building_number == null){
                        return `<option value="${Location.id}">${Location.name}</option>`;
                    }
                    return `<option value="${Location.id}">${Location.name} (อาคาร ${Location.building_number})</option>`;
                }).join("");

                facultyOptions += Facultys.map((Faculty) => {
                    return `<option value="${Faculty.id}">${Faculty.name}</option>`;
                }).join("");
                PersonalOptions += Personals.map((Personal) => {
                    return `<option value="${Personal.id}">${Personal.first_name +
                        " " +
                        Personal.last_name
                        }</option>`;
                }).join("");

                $("#Bding").html(LocationOptions);
                $("#personnel").html(PersonalOptions);
                $("#mainOrg").html(facultyOptions);
            }
            //Date and Time picker
            $("#datetimepicker").daterangepicker({
                timePicker: true,
                timePickerIncrement: 15,
                locale: {
                    format: "YYYY-MM-DD HH:mm:ss",
                    applyLabel: "Apply",
                    cancelLabel: "Cancel",
                    customRangeLabel: "Custom Range",
                },
            });
            setaddEvent();
        });

        function getPersonal() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "./api/getPersonnel.php",
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
        function getRoom(locationId) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `./api/getRoom.php?locationId=${locationId}`,
                    type: "GET",
                    success: function (response) {
                        try {
                            resolve(JSON.parse(response));
                        } catch (e) {
                            reject(new Error("Failed to parse JSON response"));
                        }
                    },
                    error: function (error) {
                        reject(error);
                    },
                });
            });
        }

        function getLocation() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "./api/getLocation.php",
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
        }

        function confirm() {
            let name = $("#name").val();
            let detail = $("#detail").val();
            let Bding = $("#Bding").val();
            let room = $("#room").val();
            let personnel = $("#personnel").val();
            let mainOrg = $("#mainOrg").val();
            let subOrg = $("#subOrg").val();
            let reteDate = $("#datetimepicker").val();
            let img = $("#img")[0].files[0];
            if (
                Bding == "" ||
                room == "" ||
                name == "" ||
                detail == "" ||
                reteDate == "" ||
                !img ||
                personnel == "" ||
                mainOrg == "" ||
                subOrg == "" ||
                img == undefined
            ) {
                Swal.fire({
                    title: "โปรดใส่ข้อมูลให้ถูกต้อง",
                    icon: "error",
                    confirmButtonText: "ยืนยัน",
                });
                return;
            }

            if (!img.type.startsWith("image/")) {
                Swal.fire({
                    title: "ไฟล์ต้องเป็นรูปภาพ",
                    icon: "error",
                    confirmButtonText: "ยืนยัน",
                });
                return;
            }

            Swal.fire({
                title: "ยืนยันการบันทึก",
                icon: "info",
                showCancelButton: true,
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ยกเลิก",
            }).then((resp) => {
                if (resp.isConfirmed) {
                    let formData = new FormData();
                    formData.append("name", name);
                    formData.append("detail", detail);
                    formData.append("Bding", Bding);
                    formData.append("room", room);
                    formData.append("personnel", personnel);
                    formData.append("mainOrg", mainOrg);
                    formData.append("subOrg", subOrg);
                    formData.append("reteDate", reteDate);
                    formData.append("img", img);

                    $.ajax({
                        type: "POST",
                        url: "./api/addEvent.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log(response);
                            let res = JSON.parse(response);
                            if (res.status == "success") {
                                window.location.href = "msEvent.php";
                            } else {
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    text: res.message,
                                    icon: "error",
                                    confirmButtonText: "ยืนยัน",
                                });
                            }
                        },
                        error: function (error) {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                text: "ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์",
                                icon: "error",
                                confirmButtonText: "ยืนยัน",
                            });
                        },
                    });
                }
            });
        }
    </script>
</body>

</html>