<template>
    <div class="row mb-2">
        <div class="col col-md-6">
            <label for="exampleInputEmail1" class="form-label">Select City <span class="mandatorStar">*</span></label>
            <select class="form-select" aria-label="Default select " name="city_id" v-model="timeSlot.city_id" required
                @change="handleCities">
                <option :value="null">Select City</option>
                <option :value="city.id" v-for="city in props.params.cities" :key="city.id">
                    {{ city.name }}
                </option>
            </select>
        </div>

        <div class="col col-md-6">
            <label for="exampleInputEmail1" class="form-label">Select Location <span class="mandatorStar">*</span>
            </label>
            <select class="form-select" aria-label="Default select " name="location_id" v-model="timeSlot.location_id"
                required @change="handleLocation">
                <option value="">Select Location</option>
                <option :value="location.id" v-for="location in locations" :key="location.id">
                    {{ location.name }}
                </option>
            </select>
        </div>

        <div class="col col-md-6">
            <label for="exampleInputEmail1" class="form-label">Select Screen <span class="mandatorStar">*</span></label>
            <select class="form-select" aria-label="Default select " name="screen_id" v-model="timeSlot.screen_id" required
                @change="handleScreens">
                <option value="">Select Screen</option>
                <option :value="screen.id" v-for="screen in screens" :key="screen.id">
                    {{ screen.screen_name }}
                </option>
            </select>
        </div>

        <div class="col col-md-6">
            <div class="mb-3">
                <label class="form-label">Select Date <span class="mandatorStar">*</span></label>
                <input type="date" class="form-control" name="book_date_id" v-model="timeSlot.date" :min="getCurrentDate()"
                    required />
            </div>
        </div>

        <div class="col-lg-12">
            <div class="slot-sections">
                <div class="timeSlotDiv" v-for="(slot, index) in availableSlots" :key="slot.id">
                    <button :class="`timeSlot-btn ${slot.isSelected ? 'selected' : ''
                        }`" type="button" :disabled="!slot.isActive" @click="
        slot.isActive ? handleSlotSelection(index) : false
    ">
                        {{ slot.slot }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-lg-12">
            <button class="btn btn-success" :disabled="formEnable()" @click="handleNext">
                Next
            </button>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import axios from "axios";

const props = defineProps(["params", "orderSummary"]);
const emit = defineEmits(["next"]);
const URL = window._url;

const locations = ref([]);
const screens = ref([]);
const availableSlots = ref([]);

const timeSlot = ref({
    currentStep: props.params.index,
    city_id: props.params.cities[0]?.id,
    city_name: props.params.cities[0]?.name,

    location_id: null,
    location_name: "",

    screen_id: null,
    screen_name: "",
    screen_capacity: 0,
    max_capacity: 0,

    date: null,

    time_slot_id: null,
    time_slot_name: "",
    time_slot_amount: 0,
    time_slot_additional: 0,
    selectedSlots: [],

    //items available
    occasions: [],
    addOns: [],
    cakes: [],
    decorations: [],
    gifts: [],
    snacks: [],
    bouquets: [],
    others: [],
});

let state = timeSlot.value;
let existingDetails = props?.params?.existing?.info;

const formEnable = () => {
    if (
        state?.location_id &&
        state?.screen_id &&
        state?.date &&
        state?.selectedSlots.length > 0
    ) {
        return false;
    }
    return true;
};

onMounted(() => {
    if (!existingDetails) {
        handleCities();
    } else {
        state.city_id = existingDetails.city_id;
        handleCities();
        
        state.city_name = existingDetails.city_name;
        state.location_id = existingDetails.location_id;
        state.location_name = existingDetails.location_name;
        handleLocation();

        state.screen_id = existingDetails.screen_id;
        state.screen_name = existingDetails.screen_name;

        state.screen_capacity = parseInt(existingDetails.get_screen?.capacity);
        state.max_capacity = existingDetails.get_screen?.max_people;

        state.date = existingDetails.book_date;

        getTimeSlots(state);

        setTimeout(() => {
            checkForExistingSlots();
        }, 2000);
    }
});

const getCurrentDate = () => {
    const today = new Date();
    const yyyy = today.getFullYear();
    let mm = today.getMonth() + 1; // Months start at 0!
    let dd = today.getDate();

    if (dd < 10) dd = "0" + dd;
    if (mm < 10) mm = "0" + mm;

    return yyyy + "-" + mm + "-" + dd;
};

const handleNext = () => {
    emit("next", {
        currentStep: props.params.index,
        data: { timeSlot: state },
    });
};

const handleSlotSelection = (index) => {
    let selectedSlot = availableSlots.value[index];
    selectedSlot.isSelected = !selectedSlot.isSelected;

    state.selectedSlots = [];
    availableSlots.value.map((item) => {
        if (item.isSelected) {
            state.time_slot_additional = item.additional_amount;
            state.selectedSlots.push({
                booking_slot_id: null,
                id: item.id,
                amount: item.amount,
                slot: item.slot,
                additional_amount: item.additional_amount,
            });
        }
    });
    formEnable();
};

watch(
    () => [state.city_id, state.location_id, state.screen_id],
    () => {
        emit("updateState", {
            data: { timeSlot: state },
        });
        if (
            state.city_id &&
            state.location_id &&
            state.screen_id &&
            state.date
        ) {
            getTimeSlots(state);
        }
        formEnable();
    }
);

watch(
    () => state.date,
    () => {
        if (state.city_id && state.location_id && state.screen_id) {
            getTimeSlots(state);
        } else {
            alert("Please select city, location,screen");
        }
        formEnable();
    }
);

watch(
    () => state.time_slot_id,
    () => {
        emit("updateState", {
            data: { timeSlot: state },
        });
        formEnable();
    }
);

const getTimeSlots = (state) => {
    axios
        .get(URL + "/getTimeSlots", {
            params: {
                city_id: state.city_id,
                location_id: state.location_id,
                screen_id: state.screen_id,
                date: state.date,
            },
        })
        .then((res) => {
            availableSlots.value = res.data;
        })
        .catch((e) => {
            console.log("error fetching time slots", e);
        });
};

const checkForExistingSlots = () => {
    if (existingDetails) {
        existingDetails.slots.map((item) => {
            //get index from available slots and mark as selected

            let index = availableSlots.value.findIndex(
                (a) => a.id == item.slot_id
            );
            if (index > -1) {
                availableSlots.value[index].isSelected = true;
            }

            //add into selected slots
            state.time_slot_additional = item.additional_amount;
            state.selectedSlots.push({
                booking_slot_id: item.id,
                id: item.slot_id,
                amount: item.amount,
                slot: item.slot_name,
                additional_amount: item.additional_amount,
            });
        });
    }
};

const handleCities = () => {
    var index = props.params.cities.findIndex(
        (item) => item.id == state.city_id
    );

    locations.value = [];
    screens.value = [];

    state.location_id = null;
    state.location_name = "";

    state.screen_id = null;
    state.screen_name = "";

    if (index > -1) {
        let city = props.params.cities[index];
        state.city_name = city.name;
        locations.value = city.locations;
    }
};

const handleLocation = () => {
    var index = locations.value.findIndex(
        (item) => item.id == state.location_id
    );

    screens.value = [];

    state.screen_id = null;
    state.screen_name = "";

    //set values
    state.occasions = [];
    state.addOns = [];
    state.cakes = [];
    state.decorations = [];
    state.gifts = [];
    state.bouquets = [];
    state.snacks = [];
    state.others = [];

    if (index > -1) {
        let location = locations.value[index];
        state.location_name = location.name;
        screens.value = location.screens;

        //assigns values
        state.occasions = location.occasions;
        state.addOns = location.add_ons;
        state.cakes = location.cakes;
        state.decorations = location.decorations;
        state.gifts = location.gifts;
        state.bouquets = location.bouquets;
        state.snacks = location.snacks;
        state.others = location.others;
    }
};

const handleScreens = () => {
    var index = screens.value.findIndex((item) => item.id == state.screen_id);
    let screen = screens.value[index];
    state.screen_name = screen.screen_name;
    state.screen_capacity = screen.capacity;
    state.max_capacity = screen.max_people;
};
</script>
