import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermapapi/screen/Models/Event.dart';
import 'package:fluttermapapi/screen/detail.dart';
import 'package:table_calendar/table_calendar.dart';
import 'package:http/http.dart' as http;

class Calendarscreen extends StatefulWidget {
  const Calendarscreen({super.key});

  @override
  State<Calendarscreen> createState() => _CalendarscreenState();
}

class _CalendarscreenState extends State<Calendarscreen> {
  late Future<List<Event>> futureEvent;
  List<DateTime> _eventDates = [];
  DateTime today = DateTime.now();

  void _ondaySelected(DateTime day, DateTime focusedDay) {
    String date =
        '${day.year}-${day.month.toString().padLeft(2, '0')}-${day.day.toString().padLeft(2, '0')}';
    setState(() {
      futureEvent = fetchEvent(date);
      today = day;
    });
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

    String formattedDate = "$day $month $year";
    return formattedDate;
  }

  String getEventStatus(startDateString, endDateString) {
    DateTime startDate = DateTime.parse(startDateString);
    DateTime endDate = DateTime.parse(endDateString);
    final now = DateTime.now();

    if (now.isBefore(startDate)) {
      final difference = startDate.difference(now);
      final days = difference.inDays;
      final hours = difference.inHours.remainder(24);
      return 'เหลือ ${days > 0 ? '$days วัน' : ''} ${hours > 0 ? '$hours ชม' : ''}'
          .trim();
    } else if (now.isAfter(endDate)) {
      return 'จัดแล้ว';
    } else {
      return 'กำลังจัด';
    }
  }

  Future<List<DateTime>> fetchEventDates() async {
    final response = await http
        .get(Uri.parse('http://10.0.2.2/project-fn/api/getAllMB.php?date=1'));
    if (response.statusCode == 200) {
      List<dynamic> jsonResponse = jsonDecode(response.body);
      return jsonResponse
          .map((data) => DateTime.parse(data['start_date']))
          .toList();
    } else {
      throw Exception('Failed to load event dates');
    }
  }

  Future<List<Event>> fetchEvent(String? date) async {
    final response = await http.get(
        Uri.parse('http://10.0.2.2/project-fn/api/getAllMB.php?date=$date'));
    if (response.statusCode == 200) {
      List<dynamic> jsonResponse = jsonDecode(response.body);
      return jsonResponse.map((data) => Event.fromJson(data)).toList();
    } else {
      throw Exception('Failed to load event');
    }
  }

  List<Event> _getEventsForDay(DateTime day) {
    return _eventDates.any((date) =>
            date.year == day.year &&
            date.month == day.month &&
            date.day == day.day)
        ? [
            Event(
              id: '',
              name: '',
              startdate: day.toIso8601String(),
              enddate: day.toIso8601String(),
              description: '',
              locationid: '',
              personnelid: '',
              facultyid: '',
              branchid: '',
              imagepath: '',
            )
          ]
        : [];
  }

  @override
  void initState() {
    super.initState();
    String initialDate =
        '${today.year}-${today.month.toString().padLeft(2, '0')}-${today.day.toString().padLeft(2, '0')}';
    futureEvent = fetchEvent(initialDate);
    fetchEventDates().then((dates) {
      setState(() {
        _eventDates = dates;
      });
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        title: const Row(
          children: [
            SizedBox(width: 8),
            Text(
              'Ku Activity Notifications',
              style: TextStyle(
                fontWeight: FontWeight.w900,
                fontSize: 30,
                fontFamily: 'leelawad',
                color: Colors.green,
              ),
            ),
          ],
        ),
      ),
      body: Container(
        color: Colors.white,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            const Divider(color: Colors.green),
            Container(
              margin: const EdgeInsets.all(10),
              decoration: BoxDecoration(
                color: Colors.white,
                border: Border.all(color: Colors.green, width: 2.0),
                borderRadius: BorderRadius.circular(10.0),
              ),
              child: TableCalendar(
                focusedDay: today,
                firstDay: DateTime.utc(2024),
                lastDay: DateTime.utc(2028),
                selectedDayPredicate: (day) => isSameDay(day, today),
                onDaySelected: _ondaySelected,
                eventLoader: _getEventsForDay,
                headerStyle: const HeaderStyle(
                    formatButtonVisible: false, titleCentered: true),
                calendarStyle: const CalendarStyle(
                  markerDecoration: BoxDecoration(
                    color: Colors.green,
                    shape: BoxShape.circle,
                  ),
                ),
              ),
            ),
            const Divider(color: Colors.green),
            const Text("อีเว้นท์ทั้งหมด",
                style: TextStyle(fontSize: 20, fontFamily: "leelawad")),
            Expanded(
              child: FutureBuilder<List<Event>>(
                future: futureEvent,
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return const Center(
                        child: CircularProgressIndicator(color: Colors.green));
                  } else if (snapshot.hasError) {
                    return Center(child: Text('Error: ${snapshot.error}'));
                  } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                    return const Center(
                      child: Text('ไม่มีกิจกรรม',
                          style: TextStyle(
                              fontFamily: 'leelawad',
                              fontSize: 18,
                              fontWeight: FontWeight.w500)),
                    );
                  } else {
                    return ListView.builder(
                      padding: const EdgeInsets.fromLTRB(16, 8, 16, 0),
                      itemCount: snapshot.data!.length,
                      itemBuilder: (context, int i) {
                        Event event = snapshot.data![i];
                        String startDate = changeFormatDate(event.startdate);
                        String endtDate = changeFormatDate(event.enddate);
                        return Container(
                          margin: const EdgeInsets.only(bottom: 5),
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(15),
                            boxShadow: [
                              BoxShadow(
                                  color: Colors.grey.shade300,
                                  blurRadius: 5,
                                  offset: const Offset(3, 3))
                            ],
                          ),
                          child: InkWell(
                            onTap: () {
                              Navigator.push(
                                context,
                                MaterialPageRoute<void>(
                                  builder: (BuildContext context) =>
                                      Detail(id: int.parse(event.id)),
                                ),
                              );
                            },
                            child: Padding(
                              padding: const EdgeInsets.fromLTRB(0, 0, 0, 0),
                              child: Row(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Expanded(
                                    flex: 1,
                                    child: Padding(
                                      padding:
                                          const EdgeInsets.fromLTRB(5, 8, 0, 5),
                                      child: Image.network(
                                        'http://10.0.2.2/project-fn/api/getImage.php?event_id=${event.id}&timestamp=${DateTime.now().millisecondsSinceEpoch}',
                                        fit: BoxFit.cover,
                                      ),
                                    ),
                                  ),
                                  Expanded(
                                    flex: 2,
                                    child: Padding(
                                      padding:
                                          const EdgeInsets.fromLTRB(5, 8, 0, 5),
                                      child: Column(
                                        crossAxisAlignment:
                                            CrossAxisAlignment.start,
                                        children: [
                                          Text(
                                            event.name,
                                            style: const TextStyle(
                                                fontFamily: 'leelawad',
                                                fontSize: 20,
                                                fontWeight: FontWeight.w500),
                                          ),
                                          Text(
                                            event.description,
                                            style: const TextStyle(
                                              fontFamily: 'leelawad',
                                              fontSize: 15,
                                              fontWeight: FontWeight.normal,
                                              color: Color.fromARGB(
                                                  255, 141, 136, 136),
                                              overflow: TextOverflow.ellipsis,
                                            ),
                                            maxLines: 2,
                                          ),
                                          const SizedBox(height: 12),
                                          Text(
                                            '$startDate ถึง $endtDate',
                                            style: const TextStyle(
                                              fontFamily: 'leelawad',
                                              fontSize: 14,
                                              fontWeight: FontWeight.bold,
                                              color: Color.fromARGB(
                                                  255, 141, 136, 136),
                                              overflow: TextOverflow.ellipsis,
                                            ),
                                          ),
                                          const SizedBox(height: 5),
                                          Text(
                                            getEventStatus(
                                                event.startdate, event.enddate),
                                            style: const TextStyle(
                                              fontFamily: 'leelawad',
                                              fontSize: 14,
                                              fontWeight: FontWeight.bold,
                                              color: Color.fromARGB(
                                                  255, 6, 168, 0),
                                              overflow: TextOverflow.ellipsis,
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                  )
                                ],
                              ),
                            ),
                          ),
                        );
                      },
                    );
                  }
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}
