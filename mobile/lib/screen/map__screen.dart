import 'dart:async';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_polyline_points/flutter_polyline_points.dart';
import 'package:fluttermapapi/constants.dart';
import 'package:google_maps_directions/google_maps_directions.dart' as gmd;
import 'package:google_maps_directions/google_maps_directions.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:location/location.dart';

class MapScreen extends StatefulWidget {
  const MapScreen(
      {Key? key,
      required this.latitude,
      required this.longitude,
      required this.namedestination})
      : super(key: key);
  final double latitude;
  final double longitude;
  final String namedestination;

  @override
  State<MapScreen> createState() => _MapScreenState();
}

class _MapScreenState extends State<MapScreen> {
  final Completer<GoogleMapController> _controller = Completer();
  Set<Marker> markers = {};
  Set<Polyline> polylines = {};
  bool goset = false;
  bool _isLoading = true;
  bool _isFollowing = true;
  LocationData? _currentPosition; //เอาไว้ใส่ make จุดเริ่ม
  LocationData? sorucPosition;
  LatLng? destination;
  List<LatLng> posylineCoordinates = [];
  double? distance;
  String? duration;
  StreamSubscription<LocationData>? _locationSubscription;
  bool closeTap = false;

  void getPolypoints() async {
    if (sorucPosition == null || destination == null) return;

    PolylinePoints polylinePoints = PolylinePoints();
    PolylineResult polylineResult =
        await polylinePoints.getRouteBetweenCoordinates(
      googleApiKey: google_api_key,
      request: PolylineRequest(
        origin:
            PointLatLng(sorucPosition!.latitude!, sorucPosition!.longitude!),
        destination: PointLatLng(destination!.latitude, destination!.longitude),
        mode: TravelMode.driving,
      ),
    );

    if (polylineResult.points.isNotEmpty) {
      if (mounted) {
        setState(() {
          posylineCoordinates.clear();
          polylines.clear(); // Clear previous polylines
          for (var point in polylineResult.points) {
            posylineCoordinates.add(LatLng(point.latitude, point.longitude));
          }
          polylines.add(
            Polyline(
              polylineId: const PolylineId('route'),
              points: posylineCoordinates,
              color: Colors.green,
              width: 6,
            ),
          );
        });
      }
    }
  }

  _determinePosition() async {
    Location location = Location();

    bool serviceEnabled;
    PermissionStatus permissionGranted;

    serviceEnabled = await location.serviceEnabled();
    if (!serviceEnabled) {
      serviceEnabled = await location.requestService();
      if (!serviceEnabled) {
        return;
      }
    }

    permissionGranted = await location.hasPermission();
    if (permissionGranted == PermissionStatus.denied) {
      permissionGranted = await location.requestPermission();
      if (permissionGranted != PermissionStatus.granted) {
        return;
      }
    }

    location.getLocation().then((location) async {
      try {
        DistanceValue distanceBetween = await gmd.distance(
          location.latitude!,
          location.longitude!,
          destination!.latitude,
          destination!.longitude,
          googleAPIKey: google_api_key,
        );
        DurationValue durationBetween = await gmd.duration(
          location.latitude!,
          location.longitude!,
          destination!.latitude,
          destination!.longitude,
          googleAPIKey: google_api_key,
        );

        if (mounted) {
          setState(() {
            duration = durationBetween.text;
            distance = distanceBetween.meters / 1000;
            _currentPosition = location;
            sorucPosition = location;
            _isLoading = false;
          });

          getPolypoints();
        }
      } catch (e) {
        showDialog(
          context: context,
          builder: (BuildContext context) {
            return AlertDialog(
              title: const Text(
                'Error',
                style: TextStyle(fontFamily: 'leelawad', fontSize: 30),
              ),
              content: const Text(
                'มีข้อผิดพลาดบางอย่างเกิดขี้น',
                style: TextStyle(
                  fontSize: 20,
                  fontFamily: 'leelawad',
                ),
              ),
              actions: <Widget>[
                TextButton(
                  child: const Text('OK'),
                  onPressed: () {
                    Navigator.of(context).pop();
                  },
                ),
              ],
            );
          },
        );
      }
    });

    GoogleMapController googleMapController = await _controller.future;
    _locationSubscription =
        location.onLocationChanged.listen((newLocation) async {
      DistanceValue distanceBetween = await gmd.distance(
        newLocation.latitude!,
        newLocation.longitude!,
        destination!.latitude,
        destination!.longitude,
        googleAPIKey: google_api_key,
      );
      DurationValue durationBetween = await gmd.duration(
        newLocation.latitude!,
        newLocation.longitude!,
        destination!.latitude,
        destination!.longitude,
        googleAPIKey: google_api_key,
      );

      if (mounted) {
        setState(() {
          duration = (durationBetween.seconds / 60).toStringAsFixed(0);
          distance = distanceBetween.meters / 1000;
          _currentPosition = newLocation;
          sorucPosition = newLocation;
          getPolypoints();
          if (_isFollowing) {
            googleMapController.animateCamera(CameraUpdate.newCameraPosition(
              CameraPosition(
                zoom: 16,
                target: LatLng(newLocation.latitude!, newLocation.longitude!),
              ),
            ));
          }
        });
      }
    });
  }

  @override
  void dispose() {
    _locationSubscription?.cancel(); // ยกเลิก subscription ของ location
    super.dispose();
  }

  @override
  void initState() {
    //37.4116, -122.0713
    destination = LatLng(37.4116, -122.0713);
    // destination = LatLng(widget.latitude, widget.longitude);
    super.initState();
    _determinePosition();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      extendBodyBehindAppBar: true,
      appBar: AppBar(
        backgroundColor: Colors.transparent,
        iconTheme: const IconThemeData(
          color: Colors.green, //change your color here
        ),
        elevation: 0,
        title: const Row(
          children: [
            Text(
              'Maps',
              style: TextStyle(
                fontWeight: FontWeight.w900,
                fontSize: 30,
                fontFamily: 'leelawad',
                color: Colors.green,
              ),
            )
          ],
        ),
        actions: [
          IconButton(
            icon: Icon(_isFollowing ? Icons.location_off : Icons.location_on),
            onPressed: () {
              setState(() {
                _isFollowing = !_isFollowing;
              });
            },
          ),
        ],
      ),
      body: _isLoading
          ? const Center(
              child: CircularProgressIndicator(
                color: Colors.green,
              ),
            )
          : Stack(
              children: [
                Positioned.fill(
                  child: GoogleMap(
                    onMapCreated: (GoogleMapController controller) async {
                      _controller.complete(controller);
                    },
                    onCameraMoveStarted: () {
                      // Update _isFollowing to false when user manually moves the map
                      if (_isFollowing) {
                        setState(() {
                          _isFollowing = false;
                        });
                      }
                    },
                    myLocationEnabled: true,
                    myLocationButtonEnabled: false,
                    markers: {
                      // Marker(
                      //   markerId: const MarkerId('soruce'),
                      //   position: LatLng(sorucPosition!.latitude!,
                      //       sorucPosition!.longitude!),
                      // ),
                      Marker(
                        markerId: const MarkerId('destination_location'),
                        position: destination!,
                      ),
                    },
                    polylines: polylines,
                    mapType: MapType.normal,
                    initialCameraPosition: CameraPosition(
                      target: LatLng(
                          sorucPosition!.latitude!, sorucPosition!.longitude!),
                      zoom: 16,
                    ),
                  ),
                ),
                AnimatedPositioned(
                  duration: const Duration(milliseconds: 300),
                  curve: Curves.easeInOut,
                  bottom: closeTap ? -120 : 0,
                  left: 0,
                  right: 0,
                  child: Container(
                    padding: const EdgeInsets.fromLTRB(16, 0, 16, 16),
                    decoration: BoxDecoration(
                      color: const Color.fromARGB(255, 161, 255, 117),
                      borderRadius: const BorderRadius.only(
                        topLeft: Radius.circular(20),
                        topRight: Radius.circular(20),
                      ),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.grey.withOpacity(1),
                          spreadRadius: 5,
                          blurRadius: 7,
                          offset: const Offset(0, 3),
                        ),
                      ],
                    ),
                    child: Column(
                      children: [
                        Padding(
                          padding: const EdgeInsets.fromLTRB(0, 8, 0, 8),
                          child: Icon(
                            closeTap
                                ? CupertinoIcons.arrow_up_circle_fill
                                : CupertinoIcons.arrow_down_circle_fill,
                            color: Colors.green,
                            size: 30.0,
                          ),
                        ),
                        Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            const Text(
                              "คุณ",
                              style: TextStyle(
                                color: Colors.black,
                                fontFamily: "leelawad",
                                fontSize: 20,
                              ),
                              textAlign: TextAlign.center,
                            ),
                            Image.asset(
                              'assets/images/arrow.png',
                              width: 150,
                            ),
                            Flexible(
                              child: Text(
                                widget.namedestination,
                                style: const TextStyle(
                                  color: Colors.black,
                                  fontFamily: "leelawad",
                                  fontSize: 20,
                                ),
                                textAlign: TextAlign.center,
                                overflow: TextOverflow.ellipsis,
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 5),
                        Text(
                          "$duration นาที",
                          style: const TextStyle(
                            color: Colors.black,
                            fontFamily: "leelawad",
                            fontSize: 20,
                          ),
                          textAlign: TextAlign.center,
                        ),
                        const SizedBox(height: 5),
                        Text(
                          "${distance!.toStringAsFixed(1)} กม.",
                          style: const TextStyle(
                            color: Colors.black,
                            fontFamily: "leelawad",
                            fontSize: 20,
                          ),
                          textAlign: TextAlign.center,
                        ),
                      ],
                    ),
                  ),
                ),
                Positioned(
                  bottom: closeTap ? 10 : 120,
                  left: 0,
                  right: 0,
                  child: InkWell(
                    onTap: () {
                      setState(() {
                        closeTap = !closeTap;
                      });
                    },
                    child: Container(
                      height: 50,
                      key: ValueKey<bool>(closeTap),
                      padding: const EdgeInsets.symmetric(horizontal: 100),
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.circular(10),
                      ),
                    ),
                  ),
                ),
              ],
            ),
    );
  }
}
