let disabled_str = "enabled";
let god_str = "no_god";

function drawCalendar(cal) {
    let loading = document.querySelector("#loading");
    let calendar = document.querySelector("#calendar");
    let currentRow = document.createElement("tr");
    currentRow.classList.add("days");
    currentRow.classList.add("calRow");

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
        td.classList.add("past");
        currentRow.appendChild(td);
        colCount++;
    }

    if (colCount % 7 === 0) {
        currentRow.classList.remove("days");
        calendar.appendChild(currentRow);
        currentRow = document.createElement("tr");
        currentRow.classList.add("days");
        currentRow.classList.add("calRow");

    }

    for(let day = 1; day <= cal.numberOfDays; day++) {
        let td = document.createElement("td");
        td.classList.add("top");

        let num = document.createElement("p");
        num.innerText = day;
        td.appendChild(num);

        let counter = 0;
        if ((cal.days[day-1] != null)) {
            for (let appointment of cal.days[day-1]) {
                let a = document.createElement("a");
                a.innerText = ("0" + appointment.hour).slice(-2) + ":" + ("0" + appointment.minute).slice(-2) + " (" + appointment.current + "/" + appointment.limit + " fő)";
                a.href="attend.php?day=" + appointment.dayid + "&appid="+appointment.id;
                a.classList.add("appointment");
                a.classList.add(disabled_str.toString());
                //For past years and months
                if (parseInt(currentCalendar.year) < parseInt(serverDate.year) || parseInt(currentCalendar.month) < parseInt(serverDate.month)) {
                    a.classList.add("past");
                }

                //For current month
                if (parseInt(currentCalendar.year) <= parseInt(serverDate.year) && parseInt(currentCalendar.month) <= parseInt(serverDate.month) && day < parseInt(serverDate.day)) {
                    a.classList.add("past");
                }

                if (parseInt(currentCalendar.year) === parseInt(serverDate.year) && parseInt(currentCalendar.month) === parseInt(serverDate.month) && day === parseInt(serverDate.day)) {
                    if (parseInt(appointment.hour) < parseInt(serverDate.hour)) {
                        a.classList.add("past");
                    }
                    if (parseInt(appointment.hour) === parseInt(serverDate.hour) && parseInt(appointment.minute) < parseInt(serverDate.min)) {
                        a.classList.add("past");
                    }
                }



                if (parseInt(appointment.limit) === parseInt(appointment.current)) {
                    a.classList.add("text-danger")
                    a.classList.add("full")
                }
                else {
                    a.classList.add("text-success")
                }
                a.classList.add(god_str);


                td.appendChild(a);
                if (counter < cal.days[day-1].length ) {
                    td.appendChild(document.createElement("br"));
                }
                counter++;
            }
        }





        if (parseInt(currentCalendar.year) === parseInt(serverDate.year) && parseInt(currentCalendar.month) === parseInt(serverDate.month) && day === parseInt(serverDate.day)) {
            td.classList.add("today");
        }

        if (parseInt(currentCalendar.year) < parseInt(serverDate.year) || parseInt(currentCalendar.month) < parseInt(serverDate.month)) {
            td.classList.add("past");
        }

        //For current month
        if (parseInt(currentCalendar.year) <= parseInt(serverDate.year) && parseInt(currentCalendar.month) <= parseInt(serverDate.month) && day < parseInt(serverDate.day)) {
            td.classList.add("past");
        }

        currentRow.appendChild(td);
        colCount++;

        if (colCount % 7 === 0) {
            calendar.appendChild(currentRow);
            currentRow = document.createElement("tr");
            currentRow.classList.add("days");
            currentRow.classList.add("calRow");

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
    let magyarCsodasNeveAHonapnak;
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
function disableAllAppointments() {
    disabled_str = "disabled";
    let as = document.querySelectorAll(".appointment");
    console.log(as);
    for (let a of as) {
        a.classList.add("disabled")
    }
}

function enableGodMode() {
    god_str = "admin";
    let as = document.querySelectorAll(".appointment");
    console.log(as);
    for (let a of as) {
        a.classList.add("admin")
    }
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

