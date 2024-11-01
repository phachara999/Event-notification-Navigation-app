class Event {
  String id;
  String name;
  String startdate;
  String enddate;
  String description;
  String locationid;
  String? roomid;
  String personnelid;
  String facultyid;
  String branchid;
  String imagepath;

  Event({
    required this.id,
    required this.name,
    required this.startdate,
    required this.enddate,
    required this.description,
    required this.locationid,
    this.roomid,
    required this.personnelid,
    required this.facultyid,
    required this.branchid,
    required this.imagepath,
  });

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = {
      'id': id,
      'name': name,
      'start_date': startdate,
      'end_date': enddate,
      'description': description,
      'location_id': locationid,
      'room_id': roomid,
      'personnel_id': personnelid,
      'faculty_id': facultyid,
      'branch_id': branchid,
      'image_path': imagepath,
    };
    return data;
  }

  Event.fromJson(Map<String, dynamic> json)
      : id = json['id'],
        name = json['name'],
        startdate = json['start_date'],
        enddate = json['end_date'],
        description = json['description'],
        locationid = json['location_id'],
        roomid = json['room_id'],
        personnelid = json['personnel_id'],
        facultyid = json['faculty_id'],
        branchid = json['branch_id'],
        imagepath = json['image_path'];
}
