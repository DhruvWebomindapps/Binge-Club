let slotCount = {
    monday: 0,
    tuesday: 0,
    wednesday: 0,
    thursday: 0,
    friday: 0,
    saturday: 0,
    sunday: 0,
};

let constraintCount = 0;
let constSubCount = 0;

let deletedSlotIds = [];
let deletedConstraints = [];

let slots = [
    {
        day: "monday",
        slots: [],
    },
    {
        day: "tuesday",
        slots: [],
    },
    {
        day: "wednesday",
        slots: [],
    },
    {
        day: "thursday",
        slots: [],
    },
    {
        day: "friday",
        slots: [],
    },
    {
        day: "saturday",
        slots: [],
    },
    {
        day: "sunday",
        slots: [],
    },
];

var slotData = "";

$(document).ready(function () {
    //check for existing slots
    let existingSlots = $("#existing_slots").val();

    if (existingSlots && existingSlots != "") {
        existingSlots = JSON.parse(existingSlots);
        existingSlots.map((ext_slot, ind) => {
            let index = slots.findIndex((x) => x.day == ext_slot.day);
            if (index > -1) {
                let slot = slots[index];
                slot.slots = ext_slot.slots;
            }
        });
    }

    //check for existing constrained
    let constraints = $("#existing_constrained").val();
    if (constraints && constraints != "") {
        const_data = "";
        constraints = JSON.parse(constraints);
        console.log("constrained", constraints);
        constraints.map((ext_const, ind) => {
            const_data += mainRow(ext_const.date, ext_const.slots);
        });
        $("#screen-constrained-table").append(const_data);
    }

    //map slots
    slots.map((slotDay, index) => {
        slotData += "<tr>";
        slotData += `
            <td>
                <input name="day[]" type="text" class="form-control"
            name="amount[0]"
            value="${slotDay.day}"
            readonly>
            </td>
            <td>
                <table class="table">
                 <thead>
                    <tr>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Amount</th>
                        <th>Additional Person Amount</th>
                        <th>
                            <a data-id="body-${slotDay.day}" data-day="${
            slotDay.day
        }" class="btn btn-primary addSlots create" type="button"><i
                                 class="fa fa-plus"></i></a>

                            ${
                                index == 0
                                    ? `<input type="checkbox" class="copySlots mt-2" value="${index}" id="checkbox-${slotDay.day}" name="forAll">`
                                    : ``
                            }

                        </th>
                    </tr> 
                  </thead> 
                <tbody id="body-${slotDay.day}">`;

        if (slotDay.slots.length > 0) {
            slotDay.slots.map((slot, index) => {
                slotData += getSlot(
                    slotDay.day,
                    slot.amount,
                    slot.start_time,
                    slot.end_time,
                    slot.additional_amount,
                    slot.id,
                    index
                );
            });
        }

        slotData += " </tbody></table></td></tr>";
    });

    $("#screen-slots-table").html("");
    $("#screen-slots-table").append(slotData);
});

const getSlot = (
    slotDay,
    amount,
    start_time = "",
    end_time = "",
    addition_amount = 0,
    id = null,
    rowIndex
) => {
    let index = slotCount[slotDay] + 1;
    slotCount[slotDay] = index;

    let template = `
                    <tr id="slot-${slotDay}-${index}">
                    <input type="hidden"  name="id[${slotDay}][]" value="${id}" />
                    <td>${getTimeStops(
                        "07:00 AM",
                        "11:30 PM",
                        "start_time[" + slotDay + "][]",
                        start_time,
                        "start_time"
                    )}</td>
                    <td>${getTimeStops(
                        "07:00 AM",
                        "11:30 PM",
                        "end_time[" + slotDay + "][]",
                        end_time,
                        "end_time"
                    )}</td>
                    <td> <input type="text" class="form-control amount"
                        name="amount[${slotDay}][]" onkeypress="return onlyNumberKey(event)"
                        value="${amount}"
                        required></td>

                        <td> <input type="text" class="form-control addition_amount"
                        name="addition_amount[${slotDay}][]" onkeypress="return onlyNumberKey(event)"
                        value="${addition_amount}"
                        required></td>

                        <td><a class="btn btn-danger deleteSlot" data-slot-id="${id}" data-day="${slotDay}" data-row-index="${rowIndex}" data-id="slot-${slotDay}-${index}" type="button"><i class="fas fa-trash"></i></a></td>
                    </tr>
                `;

    return template;
};

function duration() {
    let items = [1, 2, 3];
    var data = '<select class="form-control" name="duration[]">';
    items.map((item) => {
        data += `<option>${item}</option>`;
    });
    data += "</select>";
    return data;
}

function getTimeStops(
    start,
    end,
    name = "start_time[]",
    value = "",
    time_name
) {
    var startTime = moment(start, "hh:mm A");
    var endTime = moment(end, "hh:mm A");

    if (endTime.isBefore(startTime)) {
        endTime.add(1, "day");
    }

    var timeStops = [];

    while (startTime <= endTime) {
        timeStops.push(new moment(startTime).format("hh:mm A"));
        startTime.add(15, "minutes");
    }

    var data = `<select class="form-control ${time_name}" name="${name}">`;
    timeStops.map((item) => {
        data += `<option ${item == value ? "selected" : ""}>${item}</option>`;
    });
    data += "</select>";
    return data;
}

//slot constrained
const mainRow = (date = "", slots = []) => {
    constraintCount++;

    var data = "";
    data += `
        <tr id="row-${constraintCount}">
            <td><input type="date" name="constraint_date[]" value="${date}" id="row-${constraintCount}-date" class="form-control" /></td>
            <td>
                 <table class="table">
                      <thead>
                        <tr>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Amount</th>
                            <th>Additional Person Amount</th>
                            <th><a class="btn btn-primary addConstSlot" data-count="${constraintCount}" data-id="screen-constrain-slots-${constraintCount}" type="button"><i class="fa fa-plus"></i></a></th>
                        </tr>
                      </thead>
                      <tbody id="screen-constrain-slots-${constraintCount}">`;

    if (slots.length > 0) {
        slots.map((slot) => {
            data += subRow(
                date,
                slot.amount,
                slot.start_time,
                slot.end_time,
                slot.additional_amount,
                slot.id
            );
        });
    }

    data += `</tbody>
                 </table>
            </td>
            <td>
            <a class="btn btn-danger deleteSlot" data-constrained-id="${date}" data-id="row-${constraintCount}"  type="button"><i class="fas fa-trash"></i></a></td>
        </tr>
    `;

    return data;
};

const subRow = (
    selectedDate,
    amount = 0,
    start_time = "",
    end_time = "",
    addition_amount = 0,
    id = null
) => {
    constSubCount++;

    return `
      <tr id="sub-row-${constSubCount}">
            <input type="hidden" name="const_id[${selectedDate}][]" value="${id}" />
            <td>${getTimeStops(
                "07:00 AM",
                "11:30 PM",
                "const_start_time[" + selectedDate + "][]",
                start_time
            )}</td>
            <td>${getTimeStops(
                "07:00 AM",
                "11:30 PM",
                "const_end_time[" + selectedDate + "][]",
                end_time
            )}</td>
            <td><input type="text" class="form-control"
                 name="const_amount[${selectedDate}][]" onkeypress="return onlyNumberKey(event)"
                value="${amount}"
                required></td>

            <td><input type="text" class="form-control"
                 name="const_additional_amount[${selectedDate}][]" onkeypress="return onlyNumberKey(event)"
                value="${addition_amount}"
                required></td>
                
            <td>
            <a class="btn btn-danger deleteSubRow" data-slot-id="${id}" data-id="sub-row-${constSubCount}" data-count="${constSubCount}" type="button"><i class="fas fa-trash"></i></a>
            </td>
      </tr>
    `;
};

$(document).on("click", ".slotConst", function () {
    $("#screen-constrained-table").append(mainRow());
});

$(document).on("click", ".deleteRow", function () {
    if (confirm("Are you sure you want to delete this?")) {
        var id = $(this).data("count");
        $(`#row-${id}`).remove();
    }
});

$(document).on("click", ".addSlots", function () {
    var id = $(this).data("id");
    var day = $(this).data("day");

    let slotsIndex = slots.findIndex((s) => s.day == day);

    let rowIndex = slots[slotsIndex].slots.push({
        slotDay: day,
        amount: 0,
        start_time: "",
        end_time: "",
        addition_amount: 0,
        id: null,
    });

    $(`#${id}`).append(getSlot(day, 0, "", "", 0, null, rowIndex));
});

$(document).on("click", ".deleteSlot", function () {
    if (confirm("Are you sure you want to delete this?")) {
        var slotId = $(this).data("slot-id");
        var constraintId = $(this).data("constrained-id");

        //removing push items
        var day = $(this).data("day");
        var rowIndex = $(this).data("row-index");

        var dayIndex = slots.findIndex((s) => s.day == day);
        slots[dayIndex].slots.splice(rowIndex - 1, 1);

        var id = $(this).data("id");
        if (slotId || constraintId) {
            updateDeleteItems(slotId, constraintId);
        }

        $(`#${id}`).remove();
    }
});

$(document).on("click", ".addConstSlot", function () {
    var id = $(this).data("id");
    var count = $(this).data("count");

    var selectedDate = $(`#row-${count}-date`).val();

    if (selectedDate && selectedDate != "") {
        $(`#${id}`).append(subRow(selectedDate));
        $(`#row-${count}-date`).attr("readonly", true);
    } else {
        alert("Please select the date");
    }
});

$(document).on("click", ".deleteSubRow", function () {
    if (confirm("Are you sure you want to delete this?")) {
        var id = $(this).data("id");
        var slotId = $(this).data("slot-id");
        if (slotId) {
            updateDeleteItems(slotId);
        }
        $(`#${id}`).remove();
    }
});

const updateDeleteItems = (id, constraintId = null) => {
    if (constraintId) {
        deletedConstraints.push(constraintId);
        $("#deleted_constraint").val(JSON.stringify(deletedConstraints));
    } else {
        deletedSlotIds.push(id);
        $("#deleted_slots").val(JSON.stringify(deletedSlotIds));
    }
};

$(document).on("change", ".start_time", function () {
    var startTime = $(this).val();
    var row = $(this).closest("tr");
    var endTime = row.find(".end_time").val();
    if (endTime != "07:00 AM") {
        checkTime(startTime, endTime);
    }
});
$(document).on("change", ".end_time", function () {
    var endTime = $(this).val();
    var row = $(this).closest("tr");
    var startTime = row.find(".start_time").val();
    checkTime(startTime, endTime);
});

function checkTime(startTime, endTime) {
    var start = new Date("2000-01-01 " + startTime);
    var end = new Date("2000-01-01 " + endTime);

    // Compare the Date objects
    if (start > end) {
        alert("start time can't be less than end time");
        return;
    }
}

$(document).on("change", ".copySlots", function () {
    var value = $(this).val();
    let currentSlots = slots[value];

    slots.map((slot, index) => {
        if (index != value) {
            let day = slots[value].day;
            slot.slots = currentSlots.slots;
            loadSlotsOnChange(slot, day);
        }
    });

    // slots.map((slot) => loadSlotsOnChange(slot));
    // console.log("slots", slots);
});

loadSlotsOnChange = (slot, day) => {
    var data = "";
    slot.slots.map((st, index) => {
        let selecterl = "#slot-" + day + "-" + (index + 1);
        let amount = $(selecterl + " .amount").val();
        let addition_amount = $(selecterl + " .addition_amount").val();
        let start_time = $(selecterl + " .start_time").val();
        let end_time = $(selecterl + " .end_time").val();
        console.log(slot.day, index, selecterl);
        data += getSlot(
            slot.day,
            amount,
            start_time,
            end_time,
            addition_amount,
            st.id,
            index
        );
    });

    $(`#body-${slot.day}`).html("");
    $(`#body-${slot.day}`).append(data);
};
