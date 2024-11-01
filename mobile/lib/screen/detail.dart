import 'package:flutter/material.dart';
import 'package:fluttermapapi/screen/Models/EventDetail.dart';
import 'package:fluttermapapi/screen/map__screen.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:intl/intl.dart';

class Detail extends StatefulWidget {
  const Detail({Key? key, required this.id}) : super(key: key);
  final int id;

  @override
  State<Detail> createState() => _DetailState();
}

class _DetailState extends State<Detail> {
  late Future<EventDetail> futureEvent;
  late EventDetail eventDetails;
  @override
  void initState() {
    super.initState();
    futureEvent = fetchEvent();
  }

  List<String> monthNames = [
    "ม.ค.",
    "ก.พ.",
    "มี.ค.",
    "เม.ย.",
    "พ.ค.",
    "มิ.ย.",
    "ก.ค.",
    "ส.ค.",
    "ก.ย.",
    "ต.ค.",
    "พ.ย.",
    "ธ.ค."
  ];

  String changeFormatDate(String dateToFormat) {
    DateTime date = DateTime.parse(dateToFormat.replaceAll(' ', 'T'));

    int day = date.day;
    String month = monthNames[date.month - 1];
    int year = date.year + 543;

    String hours = date.hour.toString().padLeft(2, '0');
    String minutes = date.minute.toString().padLeft(2, '0');

    String formattedDate =
        "$day เดือน $month พ.ศ. $year เวลา $hours:$minutes น.";
    return formattedDate;
  }

  Future<EventDetail> fetchEvent() async {
    final response = await http.get(Uri.parse(
        'http://10.0.2.2/project-fn/api/getEvent.php?id=${widget.id}'));
    if (response.statusCode == 200) {
      dynamic jsonResponse = jsonDecode(response.body);
      return EventDetail.fromJson(jsonResponse);
    } else {
      throw Exception('Failed to load event');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      appBar: AppBar(
        backgroundColor: Colors.white,
        iconTheme: const IconThemeData(
          color: Colors.green,
        ),
        elevation: 0,
        title: const Row(
          children: [
            Text(
              'Ku Activity Notifications',
              style: TextStyle(
                fontWeight: FontWeight.w900,
                fontSize: 30,
                fontFamily: 'leelawad',
                color: Colors.green,
              ),
            )
          ],
        ),
      ),
      body: SingleChildScrollView(
        child: FutureBuilder<EventDetail>(
          future: futureEvent,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const Center(child: CircularProgressIndicator());
            } else if (snapshot.hasError) {
              return Center(child: Text('Error: ${snapshot.error}'));
            } else if (!snapshot.hasData) {
              return const Center(child: Text('No data available'));
            } else {
              eventDetails = snapshot.data!;
              //print(eventDetails.longitude);
              return buildEventCard(eventDetails);
            }
          },
        ),
      ),
      floatingActionButton: Padding(
        padding: const EdgeInsets.only(bottom: 20),
        child: FloatingActionButton.extended(
          label: const Text(
            'แผนที่',
            style: TextStyle(
                fontFamily: 'leelawad', fontSize: 20, color: Colors.black),
          ),
          icon: const Icon(
            Icons.gps_fixed,
            color: Colors.black,
          ),
          backgroundColor: Colors.green,
          onPressed: () {
            Navigator.push(
              context,
              MaterialPageRoute<void>(
                builder: (BuildContext context) => MapScreen(
                  latitude: double.parse(eventDetails.latitude!),
                  longitude: double.parse(eventDetails.longitude!),
                  namedestination: eventDetails.name!,
                ),
              ),
            );
          },
        ),
      ),
    );
  }

  Widget buildEventCard(EventDetail event) {
    String formattedStartTime = changeFormatDate(event.startDate!);
    String formattedEndTime = changeFormatDate(event.endDate!);

    return Padding(
        padding: const EdgeInsets.fromLTRB(17, 10, 0, 0),
        child: Container(
            width: MediaQuery.of(context).size.width - 30,
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(15),
              boxShadow: [
                BoxShadow(
                  color: Colors.grey.shade300,
                  blurRadius: 5,
                  offset: const Offset(3, 3),
                )
              ],
            ),
            child: Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Center(
                    child: Container(
                      margin: const EdgeInsets.only(bottom: 5),
                      padding: const EdgeInsets.all(16),
                      decoration: BoxDecoration(
                        color: const Color.fromARGB(255, 255, 255, 255),
                        borderRadius: BorderRadius.circular(20),
                      ),
                      child: Text(
                        'ชื่อกิจกรรม : ${event.name}',
                        style: const TextStyle(
                          fontSize: 20,
                          fontFamily: 'leelawad',
                          // fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),
                  ),
                  ClipRRect(
                    borderRadius: BorderRadius.circular(20),
                    child: Image.network(
                      'http://10.0.2.2/project-fn/api/getImage.php?event_id=${event.id}&timestamp=${DateTime.now().millisecondsSinceEpoch}',
                      fit: BoxFit.cover,
                      width: 300,
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        buildInfoSection(
                            Icons.calendar_today,
                            'วันเวลาจัดกิจกรรม',
                            'วันที่ $formattedStartTime\nถึง\nวันที่ $formattedEndTime'),
                        buildInfoSection(
                            Icons.location_on,
                            'สถานที่จัดกิจกรรม',
                            event.roomId == null
                                ? event.locationName!
                                : '${event.locationName} ห้อง ${event.roomName} - เลขที่ห้อง ${event.roomNumber}'),
                        buildInfoSection(Icons.person, 'ผู้รับผิดชอบ',
                            '${event.personnelFname} ${event.personnelLname}'),
                        buildInfoSection(Icons.business, 'หน่วยงานที่รับผิดชอบ',
                            '${event.facultyName} - ${event.branchName}'),
                        const SizedBox(height: 16),
                        const Text(
                          'รายละเอียด',
                          style: TextStyle(
                              fontSize: 18,
                              fontWeight: FontWeight.bold,
                              color: Colors.green,
                              fontFamily: 'leelawad'),
                        ),
                        const SizedBox(height: 8),
                        Text(
                          event.description!,
                          style: const TextStyle(fontSize: 16),
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            )));
  }

  Widget buildInfoSection(IconData icon, String title, String content) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16.0),
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Icon(icon, color: Colors.green, size: 24),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                    fontFamily: 'leelawad',
                    color: Colors.green,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  content,
                  style: const TextStyle(fontSize: 14, fontFamily: 'leelawad'),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
