let navbar = document.querySelector('.navbar');

document.querySelector('#menu-btn').onclick = () =>{
    navbar.classList.toggle('active');
    searchForm.classList.remove('active');
    cartItem.classList.remove('active');
}
const monthYear = document.getElementById("month-year");
const datesContainer = document.getElementById("dates");
const prevMonthBtn = document.getElementById("prev-month");
const nextMonthBtn = document.getElementById("next-month");

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

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
        datesContainer.appendChild(dayDiv);
        
        // Highlight today's date
        if (date === currentDate.getDate() && currentMonth === new Date().getMonth() && currentYear === new Date().getFullYear()) {
            dayDiv.style.backgroundColor = "#1abc9c";
            dayDiv.style.color = "white";
        }
    }
}

// Event Listeners for buttons
prevMonthBtn.addEventListener("click", () => {
   currentMonth--;
   if (currentMonth < 0) {
       currentMonth = 11; // December
       currentYear--;
   }
   renderCalendar();
});

nextMonthBtn.addEventListener("click", () => {
   currentMonth++;
   if (currentMonth > 11) {
       currentMonth = 0; // January
       currentYear++;
   }
   renderCalendar();
});

// Initial render
renderCalendar();
