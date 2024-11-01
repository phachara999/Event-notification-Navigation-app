import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:fluttermapapi/screen/list_event.dart';

class EventList extends StatelessWidget {
  const EventList({super.key});

  @override
  Widget build(BuildContext context) {
    return DefaultTabController(
        length: 4,
        child: Scaffold(
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
            bottom: const TabBar(
              dividerColor: Colors.green,
              labelColor: Colors.green,
              indicatorColor: Colors.green,
              labelStyle: TextStyle(fontFamily: 'leelawad', fontSize: 16),
              tabs: <Widget>[
                Tab(
                  text: 'กำลังจัด',
                  icon: Icon(CupertinoIcons.calendar_today),
                ),
                Tab(
                  text: 'ภายใน7วัน',
                  icon: Icon(Icons.calendar_view_week),
                ),
                Tab(
                  text: 'ภายใน30วัน',
                  icon: Icon(Icons.calendar_month),
                ),
                Tab(
                  text: 'จัดไปแล้ว',
                  icon: Icon(Icons.history),
                ),
              ],
            ),
          ),
          body: const TabBarView(
            children: [
              Listevent(events: "today"),
              Listevent(events: "7day"),
              Listevent(events: "1month"),
              Listevent(events: "done"),
            ],
          ),
        ));
  }
}
