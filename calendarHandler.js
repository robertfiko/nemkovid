function drawCalendar(cal) {
    let loading = document.querySelector("#loading");
    let calendar = document.querySelector("#calendar");
    let currentRow = document.createElement("tr");
    currentRow.className = "calRow";
    let colCount = 0;

    let calRows = document.querySelectorAll(".calRow")
    for (let calRow of calRows) {
        calRow.remove();
    }


    //Hiding loading content
    loading.style.display = "none";

    //Creating offset cells
    for(let i = 1; i <= cal.offset; i++)  {
        let td = document.createElement("td");
        currentRow.appendChild(td);
        colCount++;
    }

    if (colCount % 7 == 0) {
        calendar.appendChild(currentRow);
        currentRow = document.createElement("tr");
        currentRow.className = "calRow";

    }

    for(let day = 1; day <= cal.numberOfDays; day++) {
        let td = document.createElement("td");

        let num = document.createElement("p");
        num.innerText = day;

        let btn = document.createElement("a");
        btn.innerText = "Jelentkezés";
        btn.href = "attend.php";
        btn.classList.add("btn");
        btn.classList.add("btn-outline-warning")

        let p = document.createElement("p");
        p.innerText = cal.days[day-1];

        td.appendChild(num);

        td.appendChild(p);
        td.appendChild(btn);

        if (parseInt(currentCalendar.year) === parseInt(serverDate.year) && parseInt(currentCalendar.month) === parseInt(serverDate.month) && day === parseInt(serverDate.day)) {
            td.classList.add("today");
        }
        currentRow.appendChild(td);
        colCount++;

        if (colCount % 7 == 0) {
            calendar.appendChild(currentRow);
            currentRow = document.createElement("tr");
            currentRow.className = "calRow";

        }
    }

    let calc = (7 - (colCount % 7)) % 7;


    for(let i = 0; i < calc  ; i++) {
        let td = document.createElement("td");
        currentRow.appendChild(td);
        colCount++;
    }
    calendar.appendChild(currentRow);

    updateHeader();
}
function getCal(month, year) {
    return fetch('calendar.php?function=getCal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            month: month,
            year: year
        })
    })
        .then(response => response.json())
        .then(data => data)
}
function getServerDate() {
    return fetch('calendar.php?function=current', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: ""
    })
        .then(response => response.json())
        .then(data => data)
}
function updateHeader() {
    let magyarCsodasNeveAHonapnak = "";
    switch(currentCalendar.month) {
        case 1: magyarCsodasNeveAHonapnak = "Január"; break;
        case 2: magyarCsodasNeveAHonapnak = "Február"; break;
        case 3: magyarCsodasNeveAHonapnak = "Március"; break;
        case 4: magyarCsodasNeveAHonapnak = "Április"; break;
        case 5: magyarCsodasNeveAHonapnak = "Május"; break;
        case 6: magyarCsodasNeveAHonapnak = "Június"; break;
        case 7: magyarCsodasNeveAHonapnak = "Július"; break;
        case 8: magyarCsodasNeveAHonapnak = "Augusztus"; break;
        case 9: magyarCsodasNeveAHonapnak = "Szeptember"; break;
        case 10: magyarCsodasNeveAHonapnak = "Október"; break;
        case 11: magyarCsodasNeveAHonapnak = "November"; break;
        case 12: magyarCsodasNeveAHonapnak = "December"; break;
        default:
            magyarCsodasNeveAHonapnak = currentCalendar.month;
    }
    document.querySelector("#calHeader").innerHTML = currentCalendar.year + " " + magyarCsodasNeveAHonapnak;
}

let currentCalendar;
let serverDate;
let prevBtn = document.querySelector("#prev");
let nextBtn = document.querySelector("#next");

prevBtn.addEventListener('click', () => {
    let year = currentCalendar.year;
    let month = currentCalendar.month;

    if (month === 1) {
        month = 12;
        year--;
    }
    else {
        month--;
    }

    getCal(month, year).then(calendar => {
        currentCalendar = calendar;
        drawCalendar(currentCalendar);
    });

});
nextBtn.addEventListener('click', () => {
    let year = currentCalendar.year;
    let month = currentCalendar.month;

    if (month === 12) {
        year++;
        month = 1;
    }
    else {
        month++;
    }

    getCal(month, year).then(calendar => {
        currentCalendar = calendar;
        drawCalendar(currentCalendar);
    });

})


getServerDate().then(date => {
    serverDate = date;
    console.log(date);
    getCal(date.month, date.year).then(calendar => {
        currentCalendar = calendar;
        drawCalendar(currentCalendar);
    });
})

