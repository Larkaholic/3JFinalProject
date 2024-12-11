let navbar = document.querySelector('.navbar');
const searchForm = document.querySelector('.search-form');
const cartItem = document.querySelector('.cart-item');
const monthYear = document.getElementById("month-year");
const datesContainer = document.getElementById("dates");
const prevMonthBtn = document.getElementById("prev-month");
const nextMonthBtn = document.getElementById("next-month");
const appointmentDateField = document.getElementById("appointment-date");
const bookingForm = document.getElementById("booking-form");
const appointmentsTableBody = document.querySelector("#appointments-table tbody");

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

document.querySelector('#menu-btn').onclick = () => {
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');
}

// Event listener for service selection (this should be set up for the buttons in the services section if needed)
document.querySelectorAll(".service-btn").forEach(button => {
    button.addEventListener("click", () => {
        const service = button.getAttribute("data-service");
        serviceInput.value = service;
        serviceField.value = service;  // Set service in the form field
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

// Handle form submission (for booking)
bookingForm.addEventListener("submit", (event) => {
    event.preventDefault();
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const appointmentDate = appointmentDateField.value;

    if (!name || !email || !phone || !appointmentDate) {
        alert("Please fill in all the fields.");
        return;
    }

    // Add the appointment to the table
    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${name}</td>
        <td>${email}</td>
        <td>${phone}</td>
        <td>${appointmentDate}</td>
    `;
    appointmentsTableBody.appendChild(row);

    // Clear form after submission
    bookingForm.reset();
});
