document.addEventListener("DOMContentLoaded", function() {
    var calendarTable = document.querySelector(".calendar-table");
    var monthYear = document.querySelector(".month-year");
    var prevBtn = document.querySelector(".prev-btn");
    var nextBtn = document.querySelector(".next-btn");
  
    var currentDate = new Date();
    var currentMonth = currentDate.getMonth();
    var currentYear = currentDate.getFullYear();
  
    renderCalendar(currentMonth, currentYear);
  
    prevBtn.addEventListener("click", function() {
      currentMonth--;
      if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
      }
      renderCalendar(currentMonth, currentYear);
    });
  
    nextBtn.addEventListener("click", function() {
      currentMonth++;
      if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
      }
      renderCalendar(currentMonth, currentYear);
    });
  
    function renderCalendar(month, year) {
      var firstDay = new Date(year, month, 1);
      var lastDay = new Date(year, month + 1, 0);
      var daysInMonth = lastDay.getDate();
      var startDay = firstDay.getDay();
      var endDay = lastDay.getDay();
  
      var tbody = calendarTable.querySelector("tbody");
      tbody.innerHTML = "";
  
      monthYear.textContent = getMonthName(month) + " " + year;
  
      var date = 1;
      for (var i = 0; i < 6; i++) {
        var row = document.createElement("tr");
        for (var j = 0; j < 7; j++) {
          if (i === 0 && j < startDay) {
            var cell = document.createElement("td");
            cell.classList.add("other-month");
            row.appendChild(cell);
          } else if (date > daysInMonth) {
            break;
          } else {
            var cell = document.createElement("td");
            cell.textContent = date;
            if (
              date === currentDate.getDate() &&
              month === currentDate.getMonth() &&
              year === currentDate.getFullYear()
            ) {
              cell.classList.add("today");
            }
            row.appendChild(cell);
            date++;
          }
        }
        tbody.appendChild(row);
      }
    }
  
    function getMonthName(month) {
      var monthNames = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
      ];
      return monthNames[month];
    }
  });

  