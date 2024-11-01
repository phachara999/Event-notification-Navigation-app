class EventDetail {
  int? id;
  String? name;
  String? startDate;
  String? endDate;
  String? description;
  int? locationId;
  int? roomId;
  int? personnelId;
  int? facultyId;
  int? branchId;
  String? imagePath;
  String? branchName;
  String? facultyName;
  String? locationName;
  String? personnelFname;
  String? personnelLname;
  int? personnelNumber;
  String? roomName;
  String? roomNumber;
  String? latitude;
  String? longitude;

  EventDetail(
      {this.id,
      this.name,
      this.startDate,
      this.endDate,
      this.description,
      this.locationId,
      this.roomId,
      this.personnelId,
      this.facultyId,
      this.branchId,
      this.imagePath,
      this.branchName,
      this.facultyName,
      this.locationName,
      this.personnelFname,
      this.personnelLname,
      this.personnelNumber,
      this.roomName,
      this.roomNumber,
      this.latitude,
      this.longitude});

  EventDetail.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    name = json['name'];
    startDate = json['start_date'];
    endDate = json['end_date'];
    description = json['description'];
    locationId = json['location_id'];
    roomId = json['room_id'];
    personnelId = json['personnel_id'];
    facultyId = json['faculty_id'];
    branchId = json['branch_id'];
    imagePath = json['image_path'];
    branchName = json['branch_name'];
    facultyName = json['faculty_name'];
    locationName = json['location_name'];
    personnelFname = json['personnel_fname'];
    personnelLname = json['personnel_lname'];
    personnelNumber = json['personnel_number'];
    roomName = json['room_name'];
    roomNumber = json['room_number'];
    latitude = json['latitude'];
    longitude = json['longitude'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = <String, dynamic>{};
    data['id'] = id;
    data['name'] = name;
    data['start_date'] = startDate;
    data['end_date'] = endDate;
    data['description'] = description;
    data['location_id'] = locationId;
    data['room_id'] = roomId;
    data['personnel_id'] = personnelId;
    data['faculty_id'] = facultyId;
    data['branch_id'] = branchId;
    data['image_path'] = imagePath;
    data['branch_name'] = branchName;
    data['faculty_name'] = facultyName;
    data['location_name'] = locationName;
    data['personnel_fname'] = personnelFname;
    data['personnel_lname'] = personnelLname;
    data['personnel_number'] = personnelNumber;
    data['room_name'] = roomName;
    data['room_number'] = roomNumber;
    data['latitude'] = latitude;
    data['longitude'] = longitude;
    return data;
  }
}
