var slot_id = 0;
var start_time = '';
var end_time = '';
var slot_amount = 0;
var userName = '';
var userWhatsapp = '';
var userEmail = '';
var decorationYesNo = '';
var location_id = '';
var screen_id = '';
var screen_name = '';
var selectedDate = '';
var package_id = '';
var package_title = '';
var package_price = 0;
var package_qty = 0;
var userNickName = '';
var userParterName = '';
var cake_id = '';
var cake_title = '';
var cake_qty = 0;
var cake_price = 0;
var cakeData = [];
var decoration_id = '';
var decoration_title = '';
var decoration_qty = 0;
var decoration_price = 0;
var decorationData = [];
var gift_id = '';
var gift_title = '';
var gift_qty = '';
var gift_price = 0;
var giftData = [];
var total_amount = 0;
var number_of_people = 0;
var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

$(document).ready(function() {
    selectedDate = $("#selectedDate").val();
    console.log(selectedDate);
    const dateCalendar = document.getElementById('dateCalendar');
    const yearSelect = document.getElementById('yearSelect');
    const monthSelect = document.getElementById('monthSelect');
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    const startDateInput = document.getElementById('startDate');
    let currentMonth = new Date().getMonth();
    let currentYear = new Date().getFullYear();

    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
        'October',
        'November', 'December'
    ];

    function populateYearDropdown() {
        const currentYear = new Date().getFullYear();
        for (let year = currentYear - 10; year <= currentYear + 10; year++) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }
        yearSelect.value = currentYear;
    }

    function populateMonthDropdown() {
        for (let i = 0; i < months.length; i++) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = months[i];
            monthSelect.appendChild(option);
        }
        monthSelect.value = currentMonth;
    }

    function generateCalendarItems(year, month) {
        const items = [];
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        const header = document.createElement('div');
        header.className = 'calendar-item header';

        const monthElement = document.createElement('p');
        monthElement.className = 'month';
        monthElement.textContent = months[month];
        header.appendChild(monthElement);

        const monthElement2 = document.createElement('p');
        monthElement2.className = 'month2';
        monthElement2.textContent = months[month];
        header.appendChild(monthElement2);

        const yearElement = document.createElement('p');
        yearElement.className = 'year';
        yearElement.textContent = year;
        header.appendChild(yearElement);

        items.push(header);

        for (const weekday of weekdays) {
            const item = document.createElement('div');
            item.className = 'calendar-item weekday dateBySlot';
            item.textContent = weekday;
            items.push(item);
        }

        for (let i = 0; i < firstDay; i++) {
            const item = document.createElement('div');
            item.className = 'calendar-item empty ';
            items.push(item);
        }


        for (let day = 1; day <= daysInMonth; day++) {
            const item = document.createElement('div');
            item.className = 'calendar-item dateBySlot';
            const date = new Date(year, month, day + 1);
            item.setAttribute('data-date', date.toISOString().split('T')[0]);
            item.textContent = day;

            // Check if the date is in the past
            if (date < new Date()) {
                item.classList.add('past-date'); // Add a class to style past dates
            } else {
                const isoDate = date.toISOString().split('T')[0];
                item.setAttribute('data-date', isoDate);
                item.textContent = day;

                // Check if the date is the selected date
                if (isoDate === selectedDate) {
                    item.classList.toggle(
                        'Prevselected-date'); // Add a class to style the selected date
                    item.style.backgroundColor = '#fff';
                } else {
                    item.classList.add('available-date');
                    item.style.backgroundColor = '#fff';
                }
                // Add this check to change background color of today's date
                const today = new Date();
                if (date.getFullYear() === today.getFullYear() && date.getMonth() === today.getMonth() &&
                    day === today.getDate()) {
                    item.style.backgroundColor = '#fff'; // Change the color as per your preference
                }
            }
            items.push(item);
        }
        return items;
    }


    function showCalendar(year, month) {
        dateCalendar.innerHTML = '';
        const calendarItems = generateCalendarItems(year, month);
        calendarItems.forEach(item => dateCalendar.appendChild(item));

        calendarItems.forEach(item => {
            item.addEventListener('click', () => {
                startDateInput.value = item.getAttribute('data-date');
                calendarItems.forEach(i => i.classList.remove('b-t-active'));

                // Remove Prevselected-date from all items
                calendarItems.forEach(i => i.classList.remove('Prevselected-date'));

                item.classList.add('b-t-active');
                item.classList.add('Prevselected-date');
            });
        });
    }
    function updateCalendar() {
        showCalendar(currentYear, currentMonth);
        const currentDate = new Date();
        prevButton.disabled = (currentYear === currentDate.getFullYear() && currentMonth === currentDate
            .getMonth());
    }

    startDateInput.addEventListener('change', () => {
        const selectedDate = new Date(startDateInput.value);
        currentYear = selectedDate.getFullYear();
        currentMonth = selectedDate.getMonth();
        yearSelect.value = currentYear;
        monthSelect.value = currentMonth;
        updateCalendar();
    });

    yearSelect.addEventListener('change', () => {
        currentYear = parseInt(yearSelect.value);
        updateCalendar();
    });

    monthSelect.addEventListener('change', () => {
        currentMonth = parseInt(monthSelect.value);
        updateCalendar();
    });

    prevButton.addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendar();
    });

    nextButton.addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    });

    populateYearDropdown();
    populateMonthDropdown();
    updateCalendar();





    //  crowsel
    $('#sync1').owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        dots: true,
        autoplay: 3000,
        smartSpeed: 700,

        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            }
        }
    });

    $('#sync2')
        .owlCarousel({
            loop: true,
            margin: 30,
            nav: true,
            dots: true,
            autoplay: 3000,
            smartSpeed: 700,

            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });


    $(".date_id").on('change', function() {
        console.log("kk");
        $(".slot_error").empty();
        var date = $(this).val();
        var screen_id = $(".screen_id").val();
        if (screen_id != '') {
            $.ajax({
                type: "get",
                url: "{{ url('getSlots') }}",
                data: {
                    screen_id: screen_id,
                    date: date
                },
                success: function(response) {
                    // console.log(response);
                    $("#slots").empty();
                    $("#slots").append(response);
                }
            });
        } else {
            // alert("Please select screen");
        }
    });
});





//  get selected date
$(document).on('click', '.Prevselected-date', function() {
    selectedDate = $(this).data('date');
});

function onlyNumberKey(evt) {
    // Only ASCII character in that range allowed
    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;
    return true;
}
// Initialize a variable to keep track of the current scroll position
var currentScrollPosition = 0;
// Function to scroll to the next response
function scrollToNextResponse(DynamicId) {
    //currentScrollPosition += 200; // Adjust the scroll distance as needed
    var coordinates = $('#' + DynamicId).offset();
    window.scrollTo(coordinates.left, coordinates.top)
    //  $('html, body').animate({
    //      scrollTop: currentScrollPosition
    //  }, 'fast');
}