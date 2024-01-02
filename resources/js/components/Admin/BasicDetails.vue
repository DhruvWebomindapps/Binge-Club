<template>
    <div class="row mb-2">
        <div class="col-lg-4">
            <label class="form-label"
                >Name <span class="mandatorStar">*</span></label
            >
            <input
                type="text"
                class="form-control"
                name="name"
                v-model="basicDetails.name"
                placeholder="Enter name"
                required
            />
        </div>
        <div class="col-lg-4">
            <label class="form-label">
                Email <span class="mandatorStar">*</span></label
            >
            <input
                type="email"
                class="form-control"
                name="email"
                placeholder=" Enter email"
                v-model="basicDetails.email"
                required
            />
        </div>
        <div class="col-lg-4">
            <label class="form-label"
                >Phone <span class="mandatorStar">*</span></label
            >
            <input
                type="text"
                class="form-control"
                name="phone"
                id="phone_id"
                maxlength="10"
                placeholder="Phone"
                v-model="basicDetails.phone"
                onkeypress="return onlyNumberKey(event)"
                required
            />
        </div>
        <div class="col-lg-4">
            <label for="exampleInputEmail1" class="form-label"
                >No Of People ({{
                    props.orderSummary?.timeSlot?.screen_capacity
                }}
                allowed)<span class="mandatorStar">*</span></label
            >
            <select
                id="number"
                class="number_of_people form-select"
                name="number_of_people"
                required
                v-model="basicDetails.no_of_people"
            >
                <option :value="people" v-for="people in additionPeopleValues" :key="people">
                    {{ people }}
                </option>

                <!-- <option value="0">Select</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                <option value="4">Four</option>
                <option value="5">Five</option>
                <option value="6">Six</option>
                <option value="7">Seven</option>
                <option value="8">Eight</option> -->
            </select>
        </div>
        <div class="col-lg-4">
            <label for="exampleInputEmail1" class="form-label"
                >Addition Price Per Person<span class="mandatorStar"
                    >*</span
                ></label
            >
            <input
                type="text"
                :value="props.orderSummary?.timeSlot?.time_slot_additional"
                readonly
            />
        </div>
    </div>
    <div class="row text-center">
        <div class="col-lg-12">
            <a
                v-if="existingDetails"
                class="btn btn-primary mr-2"
                @click="handlePrevious"
                >Prev</a
            >
            <a class="btn btn-success" @click="handleNext">Next</a>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";

const props = defineProps(["params", "orderSummary"]);
const emit = defineEmits(["next"]);

const existingDetails = props?.params?.existing?.info;

let min = props.orderSummary?.timeSlot?.screen_capacity;
let max = props.orderSummary?.timeSlot?.max_capacity;

const basicDetails = ref({
    name: existingDetails ? existingDetails.name : null,
    email: existingDetails ? existingDetails.email : null,
    phone: existingDetails ? existingDetails.phone : null,
    no_of_people: existingDetails ? existingDetails.number_of_people : min,
});

let state = basicDetails.value;

const additionPeopleValues = ref([]);

watch(state, () => {
    emit("updateState", {
        data: { basicDetails: state },
    });
});

const handleNext = () => {
    emit("next", {
        currentStep: props.params.index,
        data: { basicDetails: state },
    });
};

const handlePrevious = () => {
    emit("prev", {
        currentStep: props.params.index,
    });
};

onMounted(() => {
    for (let i = 1; i <= max; i++) {
        additionPeopleValues.value.push(i);
    }
});
</script>
