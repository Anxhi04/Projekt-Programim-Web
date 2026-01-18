<?php
require_once __DIR__ . "/guard.php";
include('partials/header.php');
?>
<DOCTYPE html>
    <html>
         <head>
             <link href="css\book-service.css" rel="stylesheet">
<!--             <link href="/Projekt-Programim-Web/projekt/includes/css/book-service.css" rel="stylesheet">-->
             <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



         </head>
         <body>
         <h6>Our Services</h6>
         <p class="text"> Select a service and choose your prefered date and time</p>
         <br>
             <div class="container">

             </div>
             <form method="post">
                 <div class="book-info justify-content-center my-4" id="book">
                     <div class="card">
                         <div class="card-header">
                         </div>
                         <div class="card-body">
                             Select date:
                             <input type="date" class="form-control" id="dateInput">
                             <br>
                             <div class="d-flex flex-wrap gap-2 hidden" id="timeSlots">
                                 <span>Select time:</span>
                             </div>
                             <br>
                             <div class="card mb-3 total-info" id="total-info" >
                                 <div class="card-body text-success">
                                     <div class="summary-item">
                                         <span class="label">Service:</span>
                                         <span class="text-end"></span>
                                     </div>
                                     <div class="summary-item">
                                         <span class="label">Date:</span>
                                         <span class="text-end"></span>
                                     </div>
                                     <div class="summary-item">
                                         <span class="label">Time:</span>
                                         <span class="text-end"></span>
                                     </div>
                                     <div class="summary-item">
                                         <span class="label">Duration:</span>
                                         <span class="text-end"></span>
                                     </div>

                                 </div>
                                 <div class="card-footer bg-transparent ">
                                     <div class="summary-item">
                                         <span class="label">Total:</span>
                                         <span class="text-end"></span>
                                     </div>
                                 </div>
                             </div>
                             <br>
                             <div class="d-grid gap-2 d-md-block" >
                                 <button class="btn btn-primary" id="bookBtn" type="submit" >📆Book</button>
                             </div>
                         </div>
                     </div>
                 </div>
             </form>

         <script>
                 document.addEventListener("DOMContentLoaded", async () => {
                 const container = document.querySelector(".container");
                 const book = document.getElementById("book");
                 const timeslots = document.getElementById("timeSlots");
                 const dateInput = document.getElementById("dateInput");
                 const bookBtn = document.getElementById("bookBtn");
                 const totalInfo = document.getElementById("total-info");

                 // 4 span-at te summary (Service, Date, Time, Duration)
                 const infoSpans = document.querySelectorAll(".summary-item .text-end");
                 const totalSpan = document.querySelector(".card-footer .text-end");

                 let selectedServiceId = null;
                 let selectedServiceTitle = null;
                 let selectedServiceDuration = null;
                 let selectedServicePrice = null;
                 let selectedTime = null;


                //sigurojme qe cmimi te jete numer
                 function formatPrice(p) {
                 const n = Number(p);
                 if (Number.isNaN(n)) return "0.00";
                 return n.toFixed(2);
             }

                 // TIMESLOTS
                 function renderTimeSlots(duration) {
                 timeslots.innerHTML = "<span>Select time:</span>";

                 const startHour = 9;
                 const endHour = 20;

                 let startMinutes = startHour * 60;
                 const endMinutes = endHour * 60;

                 while (startMinutes + duration <= endMinutes) {
                 const h = String(Math.floor(startMinutes / 60)).padStart(2, "0");
                 const m = String(startMinutes % 60).padStart(2, "0");
                 const timeLabel = `${h}:${m}`;


                 //krijojme butonat ku do ruhen timeslots

                 const btn = document.createElement("button");
                 btn.type = "button";
                 btn.className = "btn btn-outline-secondary time-slot";
                 btn.textContent = timeLabel;
                 //kur klikojme nje buton pra orar --> shfaqim summary dhe butoni book
                 btn.addEventListener("click", () => {
                 timeslots.querySelectorAll(".time-slot").forEach(b => b.classList.remove("active-slot"));
                 btn.classList.add("active-slot");

                 selectedTime = timeLabel;
                     if (new Date(dateInput.value + " " + selectedTime) < new Date()) {
                         Swal.fire({
                             title: 'Warning!',
                             text: 'You cannot book in the past',
                             icon: 'warning'
                         });

                         return;
                     }
                     if (new Date(dateInput.value + " " + selectedTime) .getDay() == 0 || new Date(dateInput.value + " " + selectedTime).getDay() == 6) {
                         Swal.fire({
                             title: 'Warning!',
                             text: 'You cannot book on weekends',
                             icon: 'warning'
                         });

                         return;
                     }
                     if (
                         new Date(`${dateInput.value}T${selectedTime}`) < new Date() ||
                         new Date(`${dateInput.value}T${selectedTime}`) >
                         new Date(new Date().setDate(new Date().getDate() + 30))
                     ) {
                         Swal.fire({
                             title: 'Warning!',
                             text: 'You can only book from now up to 30 days in advance',
                             icon: 'warning'
                         });

                         return;
                     }




                     // plotesojme te dhenat ne summary
                 infoSpans[0].textContent = selectedServiceTitle || "";
                 infoSpans[1].textContent = dateInput.value || "";
                 infoSpans[2].textContent = selectedTime || "";
                 infoSpans[3].textContent = selectedServiceDuration ? `${selectedServiceDuration} min` : "";

                 if (totalSpan) totalSpan.textContent = selectedServicePrice != null ? `${formatPrice(selectedServicePrice)}€` : "";

                 totalInfo.classList.remove("total-info");
                 bookBtn.style.display = "inline-block";
                 totalInfo.scrollIntoView({ behavior: "smooth", block: "end" });
             });

                 timeslots.appendChild(btn);
                 startMinutes += duration;
             }

                 timeslots.classList.remove("hidden");
                 timeslots.style.display = "flex";
             }
                 //sigurojme qe oraret te gjenerohen vetem kur kemi zgjedhdur sherbimin dhe daten
                 function tryGenerateSlots() {
                 if (!selectedServiceDuration) return;
                 if (!dateInput.value) return;

                 selectedTime = null;
                 // fsheh butonin book deri sa t zgjidhet nje orar
                 bookBtn.style.display = "none";
                 renderTimeSlots(selectedServiceDuration);
             }

                 //  SERVICES RENDER --> marrim te dhenat nga backend tik shfaqim ne front
                 function renderServiceCards(list) {
                 container.innerHTML = "";

                 list.forEach(service => {
                 const card = document.createElement("div");

                 card.className = "card";

                 card.innerHTML = `
        <div class="card-header">${service.category ?? ""}</div>
        <div class="card-body">
          <h5 class="card-title">${service.name ?? ""}</h5>
          <p class="card-text">${service.description ?? ""}</p>
          <div class="price-time">
            <span>${formatPrice(service.price)}€</span>
            <span>${service.duration_minutes ?? ""} min</span>
          </div>
        </div>
      `;

                 // klik te card-i -> vendos selectedService...
                 card.addEventListener("click", () => {
                 selectedServiceId = service.id;
                 selectedServiceTitle = service.name ?? "";
                 selectedServiceDuration = Number(service.duration_minutes) || null;
                 selectedServicePrice = Number(service.price) || 0;

                 book.querySelector(".card-header").innerText = `Book ${selectedServiceTitle}`;
                 book.style.display = "block";
                 book.scrollIntoView({ behavior: "smooth", block: "start" });

                 // mbush summary
                 infoSpans[0].textContent = selectedServiceTitle;
                 infoSpans[3].textContent = selectedServiceDuration ? `${selectedServiceDuration} min` : "";
                 if (totalSpan) totalSpan.textContent = `${formatPrice(selectedServicePrice)}€`;
                 //nese zgjidhet data te gjenerohen oraret
                 tryGenerateSlots();
             });

                 container.appendChild(card);
             });
             }

                 //  FETCH SERVICES nga db
                 async function loadServices() {

                 const res = await fetch("/Projekt-Programim-Web/projekt/includes/api/services.php?business_id=1");
                 if (!res.ok) throw new Error("Nuk u moren services nga serveri");
                 const list = await res.json();
                 renderServiceCards(list);
             }

                 // kur ndryshon data
                 dateInput.addEventListener("change", () => {
                     infoSpans[1].textContent = dateInput.value;
                 tryGenerateSlots();
             });

                 // kur klikojme book
                 bookBtn.addEventListener("click", async (e) => {
                 e.preventDefault();

                 if (!selectedServiceId || !dateInput.value || !selectedTime) {
                     Swal.fire({
                         title: 'Warning!',
                         text: 'Select service, date and time first!',
                         icon: 'warning'
                     });
                 return;
             }
                //dergon te dhenat nga front ne back permes form

                 const data = new FormData();
                 const userId = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;
                 const today= new Date().toISOString().split('T')[0];
                 data.append("action", "book");
                 data.append("service_id", selectedServiceId);
                 data.append("date", dateInput.value);
                 data.append("time", selectedTime);
                 data.append("createdAt", today);

                 const resp = await fetch("/Projekt-Programim-Web/projekt/includes/bookservicepart2.php", {
                 method: "POST",
                 body: data
             });
                 const result = await resp.json();
                 if(result.status==200){
                     window.Swal.fire({
                         title: 'Success!',
                         text: 'Booking is done we sill send u an email confirmation!',
                         icon: 'success'
                     });;
                 }else if(result.status==300){
                     window.Swal.fire({
                         title: 'Failed!',
                         text: result.message || 'Booking failed!',
                         icon: 'error'
                     });;;
                 }
                     if (!resp.ok) {
                         Swal.fire({
                             title: 'Failed!',
                             text: 'Gabim nga serveri. Provoni perseri me vone',
                             icon: 'error'
                         });;;
                         return;
                     }

             });
                 try {
                 await loadServices();
             } catch (err) {
                 console.error(err);
                 container.innerHTML = "<p>gabim gjate ngarkimit te sherbimeve</p>";
             }
             });

         </script>
         <!-- SCRIPT PËR UPDATE STATUS -->
         <script>
             function updateReservations() {
                 fetch("update_reservation_status.php")
                     .then(response => response.json())
                     .then(data => {
                         data.forEach(reservation => {
                             const row = document.getElementById("res-" + reservation.id);
                             if (row) {
                                 row.querySelector(".status").innerText = reservation.status;
                             }
                         });
                     });
             }

             // ekzekuto menjëherë
             updateReservations();

             // përsërit çdo 60 sekonda
             setInterval(updateReservations, 60000);
         </script>

         </body>
    </html>


