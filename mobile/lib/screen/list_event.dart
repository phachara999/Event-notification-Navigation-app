import 'package:flutter/material.dart';
import 'package:fluttermapapi/screen/Models/Event.dart';
import 'package:fluttermapapi/screen/detail.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class Listevent extends StatefulWidget {
  const Listevent({Key? key, required this.events}) : super(key: key);
  final String events;

  @override
  State<Listevent> createState() => _ListeventState();
}

class _ListeventState extends State<Listevent> {
  late Future<List<Event>> futureEvent;

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

  gettextMessage(String event) {
    switch (event) {
      case "today":
        return "ตอนนี้ไม่มีกิจกรรมที่กำลังจัด";
      case "7day":
        return "ไม่มีกิจกรรมที่จะจัดขึ้นภายใน 7 วัน";
      case "1month":
        return "ไม่มีกิจกรรมที่จะเกิดขึ้นภายใน 30 วัน";
      case "done":
        return "ยังไม่มีกิจกรรมที่จัดขึ้นในปีนี้";
      default:
    }
    return "";
  }

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
      final minutes = difference.inMinutes.remainder(60);
      String remainingTime = 'เหลือเวลา';
      if (days > 0) remainingTime += ' $days วัน';
      if (hours > 0) remainingTime += ' $hours ชม';
      if (minutes > 0 || (days == 0 && hours == 0))
        remainingTime += ' $minutes นาที';
      return remainingTime.trim();
    } else if (now.isAfter(endDate)) {
      return 'จัดแล้ว';
    } else {
      return 'กำลังจัด';
    }
  }

  @override
  void initState() {
    super.initState();
    futureEvent = fetchEvent(widget.events);
  }

  Future<void> _refreshData() async {
    Future<List<Event>> newFutureEvent = fetchEvent(widget.events);
    newFutureEvent.then((value) {
      setState(() {
        futureEvent = newFutureEvent;
      });
    });
  }

  Future<List<Event>> fetchEvent(String? keyword) async {
    final response = await http.get(Uri.parse(
        'http://10.0.2.2/project-fn/api/getAllMB.php?keyword=$keyword'));
    if (response.statusCode == 200) {
      List<dynamic> jsonResponse = jsonDecode(response.body);
      return jsonResponse.map((data) => Event.fromJson(data)).toList();
    } else {
      throw Exception('Failed to load event');
    }
  }

  Color statusColor(String status) {
    switch (status) {
      case 'กำลังจัด':
        return Colors.green;
      case 'จัดแล้ว':
        return Colors.red;
      default:
        return Colors.orange; // For 'เหลือเวลา' status
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: FutureBuilder<List<Event>>(
        future: futureEvent,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(
              child: CircularProgressIndicator(
                color: Colors.green,
              ),
            );
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return Center(
              child: Text(
                gettextMessage(widget.events),
                style: const TextStyle(
                    fontFamily: 'leelawad',
                    fontSize: 18,
                    fontWeight: FontWeight.w500),
              ),
            );
          } else {
            return RefreshIndicator(
              color: Colors.green,
              backgroundColor: Colors.white,
              onRefresh: _refreshData,
              child: Column(
                children: [
                  Align(
                    alignment: Alignment.centerRight,
                    child: Padding(
                      padding: const EdgeInsets.fromLTRB(16, 8, 20, 8),
                      child: Text(
                        "ทั้งหมด ${snapshot.data!.length} กิจกรรม",
                        style: const TextStyle(
                          fontFamily: 'leelawad',
                          fontSize: 18,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ),
                  ),
                  Expanded(
                    child: ListView.builder(
                      padding: const EdgeInsets.fromLTRB(16, 8, 16, 0),
                      itemCount: snapshot.data!.length,
                      itemBuilder: (context, int i) {
                        Event event = snapshot.data![i];
                        String startDate = changeFormatDate(event.startdate);
                        String endtDate = changeFormatDate(event.enddate);
                        String eventStatus =
                            getEventStatus(event.startdate, event.enddate);

                        return Container(
                          margin: const EdgeInsets.only(bottom: 10),
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
                              padding: const EdgeInsets.all(10),
                              child: Row(
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Expanded(
                                    flex: 1,
                                    child: AspectRatio(
                                      aspectRatio: 1,
                                      child: Image.network(
                                        'http://10.0.2.2/project-fn/api/getImage.php?event_id=${event.id}&timestamp=${DateTime.now().millisecondsSinceEpoch}',
                                        fit: BoxFit.cover,
                                      ),
                                    ),
                                  ),
                                  const SizedBox(width: 10),
                                  Expanded(
                                    flex: 2,
                                    child: Column(
                                      crossAxisAlignment:
                                          CrossAxisAlignment.start,
                                      children: [
                                        Text(
                                          event.name,
                                          style: const TextStyle(
                                            fontFamily: 'leelawad',
                                            fontSize: 18,
                                            fontWeight: FontWeight.w500,
                                          ),
                                        ),
                                        const SizedBox(height: 5),
                                        Text(
                                          event.description,
                                          style: const TextStyle(
                                            fontFamily: 'leelawad',
                                            fontSize: 14,
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
                                          eventStatus,
                                          style: TextStyle(
                                            fontFamily: 'leelawad',
                                            fontSize: 14,
                                            fontWeight: FontWeight.bold,
                                            color: statusColor(eventStatus),
                                            overflow: TextOverflow.ellipsis,
                                          ),
                                        ),
                                      ],
                                    ),
                                  )
                                ],
                              ),
                            ),
                          ),
                        );
                      },
                    ),
                  ),
                ],
              ),
            );
          }
        },
      ),
    );
  }
}
