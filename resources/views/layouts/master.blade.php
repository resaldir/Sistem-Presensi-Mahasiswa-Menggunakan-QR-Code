<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{!! asset('images/usu.ico') !!}"/>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{!! asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{!! asset('template/bower_components/fullcalendar/dist/fullcalendar.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('template/bower_components/fullcalendar/dist/fullcalendar.print.min.css') !!}" media="print">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! asset('template/bower_components/font-awesome/css/font-awesome.min.css') !!}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('template/bower_components/Ionicons/css/ionicons.min.css') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! asset('template/dist/css/AdminLTE.min.css') !!}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins

         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{!! asset('template/dist/css/skins/_all-skins.min.css') !!}">
    <!-- Morris chart -->
    <link rel="stylesheet" href="{!! asset('template/bower_components/morris.js/morris.css') !!}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{!! asset('template/bower_components/jvectormap/jquery-jvectormap.css') !!}">
    <!-- Date Picker -->
    <link rel="stylesheet" href="{!! asset('template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') !!}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{!! asset('template/bower_components/bootstrap-daterangepicker/daterangepicker.css') !!}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{!! asset('template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') !!}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <title>@yield('title')</title>

</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @include('layouts.header')
        @yield('sidebar')
        @yield('content')
        @include('layouts.footer')
        @yield('script')
    </div>
    <!-- jQuery 3 -->
    <script src="{!! asset('template/bower_components/jquery/dist/jquery.min.js') !!}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{!! asset('template/bower_components/jquery-ui/jquery-ui.min.js') !!}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{!! asset('template/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
    <!-- Morris.js charts -->
    <script src="{!! asset('template/bower_components/raphael/raphael.min.js') !!}"></script>
    <script src="{!! asset('template/bower_components/morris.js/morris.min.js') !!}"></script>
    <!-- Sparkline -->
    <script src="{!! asset('template/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') !!}"></script>
    <!-- jvectormap -->
    <script src="{!! asset('template/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') !!}"></script>
    <script src="{!! asset('template/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') !!}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{!! asset('template/bower_components/jquery-knob/dist/jquery.knob.min.js') !!}"></script>
    <!-- daterangepicker -->
    <script src="{!! asset('template/bower_components/moment/min/moment.min.js') !!}"></script>
    <script src="{!! asset('template/bower_components/bootstrap-daterangepicker/daterangepicker.js') !!}"></script>
    <!-- datepicker -->
    <script src="{!! asset('template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') !!}"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{!! asset('template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') !!}"></script>
    <!-- Slimscroll -->
    <script src="{!! asset('template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') !!}"></script>
    <!-- FastClick -->
    <script src="{!! asset('template/bower_components/fastclick/lib/fastclick.js') !!}"></script>
    <!-- AdminLTE App -->
    <script src="{!! asset('template/dist/js/adminlte.min.js') !!}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{!! asset('template/dist/js/pages/dashboard.js') !!}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{!! asset('template/dist/js/demo.js') !!}"></script>
    <!-- Full Calendar -->
    <!-- fullCalendar -->
    <script src="{!! asset('template//bower_components/moment/moment.js') !!}"></script>
    <script src="{!! asset('template/bower_components/fullcalendar/dist/fullcalendar.min.js') !!}"></script>

    <script src="{!! asset('template/bower_components/fullcalendar/dist/gcal.min.js') !!}"></script>

    <script>

        $(document).ready(function() {

            $('#calendarId').fullCalendar({

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek'
                },

                displayEventTime: false, // don't show the time column in list view

                // THIS KEY WON'T WORK IN PRODUCTION!!!
                // To make your own Google API key, follow the directions here:
                // http://fullcalendar.io/docs/google_calendar/
                googleCalendarApiKey: 'AIzaSyDdS3_0kLYYl5-JlUJy0YBeFLA4X0xqvQI',

                // US Holidays
                events: 'en.indonesian#holiday@group.v.calendar.google.com',

                eventClick: function(event) {
                    // opens events in a popup window
                    window.open(event.url, 'gcalevent', 'width=700,height=600');
                    return false;
                },

                loading: function(bool) {
                    $('#loading').toggle(bool);
                }

            });

        });

    </script>
</body>
</html>