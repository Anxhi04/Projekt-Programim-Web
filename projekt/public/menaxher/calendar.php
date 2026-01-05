<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css" rel="stylesheet">

    <style>
        body {
            padding: 30px;
            background: rgba(236,206,211,0.53);
        }
        #calendar {
            background: #fff;
            padding: 15px;
            border-radius: 6px;
        }
        .fc-state-active {
            background-color: rgba(255, 192, 203, 0.88);
            border-color: #dc8795;
            color: #ffffff;
        }
        .fc-event {
            background-color: #dc8795 !important;
            border-color: #dc8795 !important;
            color: #fff !important;
        }


    </style>
</head>
<body>

<h2>Reservations</h2>

<div id="calendar"></div>

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

<!-- moment.js -->
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js"></script>

<script>
    $(document).ready(function () {

        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },

            selectable: true,
            editable: false,

            events: [
                {
                    title: 'Test Booking',
                    start: '2026-01-10',
                    color: '#dc8795',
                },
                {
                    title: 'Another Event',
                    start: '2026-01-12',
                    color: 'rgba(255,192,203,0.88)',
                    end: '2026-01-13'
                }
            ]
        });

    });
</script>

</body>
</html>
