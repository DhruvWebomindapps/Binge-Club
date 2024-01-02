let slots = [];
let selectedSlots = [];
$(document).ready(function() {

    //get slots
    let screen_id = $(".screen_id").val();
    let date = $("#selectedDate").val();
    getSlots(screen_id, date);

    //get first slot price
    let amount = 0;
    if (slots.length > 0) {
        amount = slots[0]?.amount;
    }
    $('#screen_price').text('₹' + amount)


    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
    var slidesPerPage = 6;
    var syncedSecondary = true;
    sync1.owlCarousel({
        items: 1,
        center: true,
        slideSpeed: 2000,
        nav: true,
        autoplay: false,
        dots: true,
        loop: true,
        responsiveRefreshRate: 200,
        navText: ["<div class='nav-btn prev-slide'><i class='fas fa-chevron-left'></i></div>",
            "<div class='nav-btn next-slide'><i class='fas fa-chevron-right'></i></div>"
        ],
    }).on("changed.owl.carousel", syncPosition);
    sync2.on("initialized.owl.carousel", function() {
        sync2.find(".owl-item").eq(0).addClass("current");
    });

    function syncPosition(el) {
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }
        sync2
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = sync2.find(".owl-item.active").length - 1;
        var start = sync2.find(".owl-item.active").first().index();
        var end = sync2.find(".owl-item.active").last().index();

        if (current > end) {
            sync2.data("owl.carousel").to(current, 100, true);
        }
        if (current < start) {
            sync2.data("owl.carousel").to(current - onscreen, 100, true);
        }
    }

    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            sync1.data("owl.carousel").to(number, 100, true);
        }
    }
    sync2.on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).index();
        sync1.data("owl.carousel").to(number, 300, true);
    });
});
$(document).on('click', '.dateBySlot', function() {
    var date = $(this).data('date');
    var screen_id = $(".screen_id").val();
    $('#screen_date').val(date)
    getSlots(screen_id, date);
});

const getSlots = async (screen_id, date) => {
    selectedSlots = [];
    const url = `${window.location.origin}/getTimeSlots?screen_id=${screen_id}&date=${date}`;
    const response = await fetch(url);

    // Storing data in form of JSON
    var data = await response.json();
    slots = data;

    loadSlots(data);
}

const loadSlots = (items) => {
    var data = '';
    if (items.length > 0) {
        items.map((item) => {
            data += `
        <div class="reason-box col-lg-4 col-md-4 col-6 text-center ${!item.isActive ? 'disable' : ''} ">
            <input type="checkbox" class="timeSlot-btn" id="${item.id}" data-id="${item.id}"  data-amount="${item.amount}" data-additional="${item.additional_amount}" data-slot="${item.slot}" name="time"
            value="Hidden Wall Bed" ${!item.isActive ? 'disabled' : ''}>
            <label for="${item.id}" class="w-100">${item.slot}</label>
            <p>₹${item.amount}</p>
        </div>
    `;
        })
    } else {
        data += `<p>No Slots Available</p>`;
    }
    $('#slots').html("")
    $('#slots').append(data)
}

//  time slot selected after click
$(document).on('change', '.timeSlot-btn', function() {
    $(this).toggleClass('time-selected');

    var id = $(this).data('id');
    var amount = $(this).data('amount')
    var slot = $(this).data('slot')
    var additional_amount = $(this).data('additional')
    //select the slots 
    var index = selectedSlots.findIndex(s => s.id == id);
    if (index > -1) {
        selectedSlots.splice(index, 1)
    } else {
        selectedSlots.push({
            id,
            amount,
            slot,
            additional_amount
        })
    }
    $('#selectedSlots').val(JSON.stringify(selectedSlots));
    $('#slot_id').val(id)
    $('#slot_name').val(slot)
    $('#slot_amount').val(amount)
    $('#screen_price').text('₹' + amount)
    $('#additional_amount').val(additional_amount)
});


