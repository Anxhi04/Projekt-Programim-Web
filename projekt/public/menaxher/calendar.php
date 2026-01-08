<?php
require_once __DIR__ . "/../../includes/guard.php";
?>
<!doctype html>
<html lang="sq">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <!-- Bootstrap (solid, pa gradient) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- FullCalendar core (global build) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.20/index.global.min.js"></script>

    <!-- FullCalendar Bootstrap 5 theme plugin -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.20/index.global.min.js"></script>

    <style>
        body{
            background: rgba(239, 214, 229, 0.8);
            padding:12px;
        }

        #calendar{
            max-width: 980px;
            margin: 0 auto;
            background:#fff;
            padding:10px;
            border-radius:8px;
            box-shadow:0 6px 16px rgba(91,33,182,.18);
        }

        .fc{ font-size: 0.88rem; }
        .fc .fc-toolbar{ margin-bottom: 8px !important; }

        .fc .fc-toolbar-title{
            color: rgba(255, 20, 147, 0.8);
            font-weight:700;
            font-size: 1.05rem;
        }
        .fc-next-button,
        .fc-prev-button{
            width:35px;
            height:35px;
        }


        /* vija me te dukshme */
        .fc-theme-bootstrap5 .fc-scrollgrid,
        .fc-theme-bootstrap5 td,
        .fc-theme-bootstrap5 th{
            border:1.4px solid #c7b6f2 !important;
        }

        /* header diteve */
        .fc-col-header-cell{ background:#f0e9ff; }
        .fc-col-header-cell-cushion{
            color: rgba(255, 20, 147, 0.65)!important;
            font-weight:700;
            padding:6px 0;
        }
        .bi{
            color: white;
        }

        /* numrat e diteve */
        .fc .fc-daygrid-day-number{
            color: rgba(255, 20, 147, 0.8)!important;
            font-weight:600;
        }

        /* SOT (nuk e heqim!) */
        .fc .fc-day-today{
            background: rgba(236,72,153,.18) !important;
        }

        .fc .fc-daygrid-day-frame{ padding:2px; }

        /* evente solid */
        /* EVENTE – roze/lejla te buta */
        .fc-event {
            background: rgba(239, 165, 205, 0.62) !important;   /* lejla pastel */
            border: 1px solid rgb(184, 14, 184) !important;
            color: rgb(202, 33, 202) !important;        /* tekst lejla e errët */
            border-radius: 6px;
            padding: 2px 6px;
            font-weight: 600;
            box-shadow: none;
        }

        /* event alternativ (pak roze, jo forte) */
        .fc-event.alt {
            background: rgba(179, 21, 179, 0.52) !important;   /* roze shume e bute */
            border-color: rgba(255, 20, 147, 0.8) !important;
            color: rgba(255, 20, 147, 0.8) !important;
        }



        /* Ikonat brenda butonave (mos i bej te bardha, se do ngaterroj ngjyrat) */
        .fc .fc-button .bi{
            color: purple !important;
        }




        /* butoni aktiv (month/week/day/list i zgjedhur) */
        .fc .fc-button.fc-button-active{
            background-color:#c4b5fd !important;
            border-color:#a78bfa !important;
            color:#4c1d95 !important;
            font-weight:700;
        }

        /* today pak me i theksuar */
        .fc .fc-today-button{
            background-color: #caa9ed !important;
            border-color: #ab85d1 !important;
            color:#581c87 !important;
            font-weight:700;
        }

        /* prev/next pak me kompakt */
        .fc .fc-prev-button,
        .fc .fc-next-button{
            width:35px;
            height:35px;
            padding:0 !important;
        }

        .btn-group button{
            background: rgba(179, 102, 179, 0.9) !important;
            border: purple !important;
        }
        .btn-group button:hover{
            background: #a435a4 !important;
            border: purple !important;
        }





        /* LIST VIEW styling */
        .fc .fc-list{ border-radius: 8px; overflow: hidden; }
        .fc .fc-list-day-cushion{ background: #f0e9ff !important; }
        .fc .fc-list-day-text,
        .fc .fc-list-day-side-text{ color:#5b21b6 !important; font-weight:700; }

        .fc .fc-list-event:hover td{ background:#f7f3ff; }
        .fc .fc-list-event-time,
        .fc .fc-list-event-title{ color:#5b21b6 !important; font-weight:600; }
        .fc .fc-list-event-dot{ border-color:#ec4899 !important; }
        .fc .fc-list-table td,
        .fc .fc-list-table th{ border-color:#c7b6f2 !important; }

        /* prev / next (shigjetat) */
        .fc .fc-prev-button,
        .fc .fc-next-button {
            background: rgba(179, 102, 179, 0.9) !important;
            border: purple !important;
            color: #4c1d95 !important;
        }


    </style>
</head>

<body>
<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <h4 class="m-0" style="color:#5b21b6;font-weight:800;">Kalendar</h4>
    </div>

    <div id="calendar"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded',async function () {
        //marrim rezervimet qe jane bere nga endpointi jon
        const book_res = await fetch("api/calendar_events.php");
        const events = await book_res.json();
        console.log(events);

        //aksesojme qelizat e datave ne kalendar
        const cell = document.getElementsByTagName("td");
        console.log(cell);


        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            themeSystem: 'bootstrap5',

            // default view
            initialView: 'dayGridMonth',

            // kompakt
            height: 'auto',
            contentHeight: 'auto',
            aspectRatio: 1.75,

            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // <-- te katerta
            },

            navLinks: true,
            selectable: true,
            dayMaxEvents: 2,

            // per weekly/daily me kompakt
            slotMinTime: '08:00:00',
            slotMaxTime: '20:00:00',

            events: [
                { title: 'Event Rozë', start: '2026-01-07T10:00:00' },
                { title: 'Event Lejlë', start: '2026-01-09', classNames: ['alt'] },
                { title: 'Takim', start: '2026-01-10T12:00:00' }
            ],

            dateClick(info) {
                alert('Klikove daten: ' + info.dateStr);
            }
        });

        calendar.render();

    });

</script>

</body>
</html>
