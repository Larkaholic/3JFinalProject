let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();
const monthYear = document.getElementById("month-year");
const datesContainer = document.getElementById("dates");
const prevMonthBtn = document.getElementById("prev-month");
const nextMonthBtn = document.getElementById("next-month");
const appointmentDateField = document.getElementById("appointment-date");
const serviceField = document.getElementById("service-field");
const bookingForm = document.getElementById("booking-form");

// Event listener for service selection
document.querySelectorAll(".service-btn").forEach(button => {
    button.addEventListener("click", () => {
        const service = button.getAttribute("data-service");
        serviceField.value = service;
    });
});

// Calendar rendering function
function renderCalendar() {
    monthYear.innerText = `${currentDate.toLocaleString('default', { month: 'long' })} ${currentYear}`;
    
    // Clear the previous dates
    datesContainer.innerHTML = "";

    // Get the first day of the month
    const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
    
    // Get the last date of the month
    const lastDateOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    
    // Fill in the days before the first day of the month
    for (let i = 1; i < firstDayOfMonth; i++) {
        const inactiveDay = document.createElement("div");
        inactiveDay.classList.add("inactive");
        datesContainer.appendChild(inactiveDay);
    }
    
    // Fill in the days of the month
    for (let date = 1; date <= lastDateOfMonth; date++) {
        const dayDiv = document.createElement("div");
        dayDiv.innerText = date;
        dayDiv.classList.add("calendar-day");
        dayDiv.addEventListener("click", () => {
            appointmentDateField.value = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${date.toString().padStart(2, '0')}`;
        });
        datesContainer.appendChild(dayDiv);
        
        // Highlight today's date
        if (date === currentDate.getDate() && currentMonth === currentDate.getMonth() && currentYear === currentDate.getFullYear()) {
            dayDiv.classList.add("today");
        }
    }
}

// Switch to previous month
prevMonthBtn.addEventListener("click", () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    renderCalendar();
});

// Switch to next month
nextMonthBtn.addEventListener("click", () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar();
});

// Initial render
renderCalendar();

// Handle form submission
bookingForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const appointmentDate = appointmentDateField.value;
    const service = serviceField.value;

    if (name && email && phone && appointmentDate && service) {
        alert(`Booking confirmed for ${name} on ${appointmentDate} for ${service}`);
        bookingForm.reset();
        serviceField.value = "";
    } else {
        alert("Please fill all the fields.");
    }
});
