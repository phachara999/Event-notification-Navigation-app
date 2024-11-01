import 'package:flutter/material.dart';
import 'package:fluttermapapi/screen/calendarScreen.dart';
import 'package:fluttermapapi/screen/event_list.dart';

class Home extends StatefulWidget {
  const Home({super.key});

  @override
  State<Home> createState() => _HomeState();
}

class _HomeState extends State<Home> {
  int index = 0;
  List page = const [EventList(), Calendarscreen()];
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: page[index],
      bottomNavigationBar: BottomNavigationBar(
        selectedItemColor: Colors.green,
        backgroundColor: Colors.white,
        selectedLabelStyle: const TextStyle(fontFamily: 'leelawad'),
        unselectedLabelStyle: const TextStyle(fontFamily: 'leelawad'),
        onTap: (index) {
          setState(() {
            this.index = index;
          });
        },
        currentIndex: index,
        items: const [
          BottomNavigationBarItem(icon: Icon(Icons.home), label: 'หน้าหลัก'),
          BottomNavigationBarItem(
              icon: Icon(Icons.calendar_month), label: 'ปฏิทิน'),
        ],
      ),
    );
  }
}
