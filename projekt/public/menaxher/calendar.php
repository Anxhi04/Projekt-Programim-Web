<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Calendar</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/projekt/public/assets/inspinia/css/bootstrap.min.css">
    <!-- Në <head> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Font Awesome nga CDN (për shkak të problemeve me fonts) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- iCheck CSS -->
    <link rel="stylesheet" href="/projekt/public/assets/inspinia/css/plugins/iCheck/custom.css">

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="/projekt/public/assets/inspinia/css/plugins/fullcalendar/fullcalendar.css">
    <link rel="stylesheet" href="/projekt/public/assets/inspinia/css/plugins/fullcalendar/fullcalendar.print.css" media="print">

    <!-- Animate.css -->
    <link rel="stylesheet" href="/projekt/public/assets/inspinia/css/animate.css">

    <!-- Inspinia style -->
    <link rel="stylesheet" href="/projekt/public/assets/inspinia/css/style.css">

    <style>

        .swal2-container {
            z-index: 99999 !important;
        }

        .swal2-popup {
            z-index: 99999 !important;
        }

        /* Stilizime ekzistuese për ngjyrat rozë... */
        .fc-event {
            background-color: #FF69B4 !important;
            border-color: #FF1493 !important;
            color: #ffffff !important;
        }

        .fc-event:hover {
            background-color: #FF1493 !important;
            border-color: #C71585 !important;
        }

        .external-event {
            background-color: #FF69B4 !important;
            border-color: #FF1493 !important;
            color: #ffffff !important;
        }

        .external-event:hover {
            background-color: #FF1493 !important;
            border-color: #C71585 !important;
        }

        .navy-bg {
            background-color: #FF69B4 !important;
        }

        .fc-selected {
            background-color: #FF1493 !important;
            border-color: #C71585 !important;
        }

        /* Stilizime të reja për layout pa sidebar */
        #page-wrapper {
            margin-left: 0 !important;
            padding-left: 0 !important;
        }

        #wrapper {
            padding-left: 0 !important;
        }

        .wrapper-content {
            padding: 20px;
            margin: 0;
        }

        .footer {
            margin-left: 0 !important;
        }

        /* Ngjyra roz për të gjitha eventet */
        .fc-event {
            background-color: #FF69B4 !important;
            border-color: #FF1493 !important;
            color: #ffffff !important;
        }

        .fc-event:hover {
            background-color: #FF1493 !important;
            border-color: #C71585 !important;
        }

        /* Ngjyra roz për eventet e jashtme */
        .external-event {
            background-color: #FF69B4 !important;
            border-color: #FF1493 !important;
            color: #ffffff !important;
        }

        .external-event:hover {
            background-color: #FF1493 !important;
            border-color: #C71585 !important;
        }

        .navy-bg {
            background-color: #FF69B4 !important;
        }

        .fc-selected {
            background-color: #FF1493 !important;
            border-color: #C71585 !important;
        }
    </style>

</head>

<body>

<div id="wrapper">


    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn  " href="#">
                        <img src="/projekt/public/assets/inspinia/ikona/profile.png" alt="logo">
                    </a>
                    <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                        </div>
                    </form>
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <span class="m-r-sm text-muted welcome-message">Welcome to Glam Book</span>
                    </li>
                    <li>
                        <a href="/projekt/public/login.php">
                            <i class="fa fa-sign-out"></i> Log out
                        </a>
                    </li>
                </ul>

            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-8">
                <h2>Calendar</h2>
                <p>Here u will find all the reservations that has been done for your bussines</p>
            </div>
        </div>
        <div class="wrapper wrapper-content">
            <div class="row animated fadeInDown">
                <div class="col-lg-3">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Draggable Events</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a>
                                    <button class="btn" data-toggle="modal" data-target="#myModal14" style="background: none">Add event</button>                               </a>

                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#" class="dropdown-item">Config option 1</a>
                                    </li>
                                    <li><a href="#" class="dropdown-item">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div id='external-events'>
                                <p>Drag a event and drop into callendar.</p>
                                <div class='external-event navy-bg'>Go to shop and buy some products.</div>
                                <div class='external-event navy-bg'>Check if produkts are missing</div>
                                <div class='external-event navy-bg'>Send documents to John.</div>
                                <div class='external-event navy-bg'>Phone to Sandra.</div>
                                <div class='external-event navy-bg'>Chat with Michael.</div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Booking Calendar </h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#" class="dropdown-item">Config option 1</a>
                                    </li>
                                    <li><a href="#" class="dropdown-item">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div>
                <strong>Copyright</strong> Glam Book &copy; 2026
            </div>
        </div>

    </div>
</div>

<!-- Mainly scripts -->
<script src="/projekt/public/assets/inspinia/js/jquery-3.1.1.min.js"></script>


<!-- Popper.js -->
<script src="/projekt/public/assets/inspinia/js/popper.min.js"></script>

<!-- Bootstrap JS -->
<script src="/projekt/public/assets/inspinia/js/bootstrap.js"></script>

<!-- Moment.js -->
<script src="/projekt/public/assets/inspinia/js/plugins/fullcalendar/moment.min.js"></script>

<!-- jQuery Plugins -->
<script src="/projekt/public/assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/projekt/public/assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="/projekt/public/assets/inspinia/js/plugins/pace/pace.min.js"></script>
<script src="/projekt/public/assets/inspinia/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="/projekt/public/assets/inspinia/js/plugins/iCheck/icheck.min.js"></script>

<!-- FullCalendar -->
<script src="/projekt/public/assets/inspinia/js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="/projekt/public/assets/inspinia/js/plugins/fullcalendar/moment.min"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Custom and plugin javascript -->
<script src="/projekt/public/assets/inspinia/js/inspinia.js"></script>
<script>

    document.addEventListener("DOMContentLoaded", function() {

        // Merr të dhënat me fetch
        fetch('/projekt/public/menaxher/api/calendar_events.php')
            .then(response => response.json())
            .then(eventsdata => {

                console.log("Events data:", eventsdata);

                // Initialize iCheck
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green'
                });

                // Initialize external events
                $('#external-events div.external-event').each(function() {
                    $(this).data('event', {
                        title: $.trim($(this).text()),
                        stick: true,
                        color: '#FF69B4'
                    });

                    $(this).draggable({
                        zIndex: 1111999,
                        revert: true,
                        revertDuration: 0
                    });
                });

                // Initialize FullCalendar
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    editable: true,
                    droppable: true,
                    events: eventsdata,
                    eventClick: function(calEvent, jsEvent, view) {
                        let actionButtons = '';
                        console.log("Clicked event data:", calEvent);
                        //keto butona do duken vetem nese eventi eshte nga db dhe statusi eshte pending
                        if (calEvent.from_db && calEvent.status === 'pending') {

                            actionButtons = `
                                   <hr>
                                   <button id="confirmBtn" class="btn  btn-sm" >Confirm</button>
                                   <button id="cancelBtn" class="btn btn-white btn-sm">Cancel</button>
                               `;
                        }


                        Swal.fire({
                            title: calEvent.title,
                            html: `
                            <div style="text-align: left;">
                                ${(calEvent.start)
                                ? `<p><strong>Start:</strong> ${moment(calEvent.start).format('LLLL')}</p>`
                                : ''}

                                ${(calEvent.end)
                                ? `<p><strong>End:</strong> ${moment(calEvent.end).format('LLLL')}</p>`
                                : ''}

                                ${(calEvent.employee && calEvent.employee !== "NULL" && calEvent.employee.trim() !== "")
                                ? `<p><strong>Employee:</strong> ${calEvent.employee}</p>`
                                : ''}
                                ${(calEvent.description && calEvent.description !== "NULL" && calEvent.description.trim() !== "")
                                ? `<p><strong>Description:</strong> ${calEvent.description}</p>`
                                : ''}
                                ${(calEvent.status && calEvent.status !== "NULL" && calEvent.status.trim() !== "")
                                ? `<p><strong>Status:</strong> ${calEvent.status}</p>`
                                : ''}

                            </div>
                              <div style="text-align:left;">
                               ...
                             ${actionButtons}
                          </div>
                        `,
                            icon: 'info',
                            confirmButtonText: 'Close',
                            customClass: {
                                container: 'swal2-container-custom'
                            }
                        });
                        setTimeout(() => {
                            document.getElementById('confirmBtn')?.addEventListener('click', () => {
                                updateReservation(calEvent, 'confirmed');
                            });

                            document.getElementById('cancelBtn')?.addEventListener('click', () => {
                                updateReservation(calEvent, 'canceled');
                            });
                        }, 200);

                    },
                    drop: function() {
                        if ($('#drop-remove').is(':checked')) {
                            $(this).remove();
                        }
                    }
                });
            })
            .catch(error => console.error("Error:", error));
        function updateReservation(event, status) {
            console.log("Updating reservation:", event.id, "to status:", status);
            fetch('/projekt/public/menaxher/api/update_reservation.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    id: event.id,
                    status: status,
                    email: event.user_email
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', data.message, 'success');
                        event.status = status;
                        $('#calendar').fullCalendar('updateEvent', event);
                    } else {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                });
        }


        // Button click handler
        document.getElementById('saveNewEventBtn').addEventListener('click', function() {
            const title = document.getElementById('newEventTitle').value;
            const description = document.getElementById('newEventDescription').value;
            console.log(description)

            if (title) {
                const newEvent = document.createElement('div');
                newEvent.className = 'external-event navy-bg';
                newEvent.innerText = title;

                document.getElementById('external-events').appendChild(newEvent);

                $(newEvent).data('event', {
                    title: title,
                    description: description,
                    stick: true,
                    color: '#FF69B4'
                });

                $(newEvent).draggable({
                    zIndex: 1,
                    revert: true,
                    revertDuration: 0
                });

                $('#myModal14').modal('hide');
                document.getElementById('newEventForm').reset();
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Please enter a title for the event.",
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                        container: 'swal2-container-custom',
                    }
                });
            }
        });
    });
</script>
<!-- Modal shtimin e event -->
<div class="modal inmodal" id="myModal14" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Add new event</h4>
                <small>This event will be shown on draggable events list</small>
            </div>
            <div class="modal-body">
                <form id="newEventForm">
                    <div class="form-group">
                        <label>The name of event</label>
                        <input type="text" class="form-control" id="newEventTitle" placeholder="Write a name for this event here ..." required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" id="newEventDescription" rows="3" placeholder="Description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-pink" id="saveNewEventBtn">Add Event</button>
            </div>
        </div>
    </div>
</div>
</body>

</html>