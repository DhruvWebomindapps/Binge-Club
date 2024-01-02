<template>
    <div class="row">
        <div
            class="col-lg-3 mt-4 text-center"
            v-for="item in props.orderSummary.timeSlot.addOns"
            :key="item.id"
        >
            <div
                :class="`package imageDivpackage ${
                    checkIfExist(item.id) ? 'selected' : ''
                }`"
                @click="handleSelectItem(item)"
            >
                <div class="package-img mx-auto">
                    <img :src="`${URL}storage/${item.image_url}`" class="" />
                </div>
                <div class="">
                    <h5>{{ item.title }}</h5>
                    <h6>
                        {{ item.price }}
                    </h6>
                </div>
            </div>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-lg-12">
            <a class="btn btn-success" @click="handleNext">Next</a>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
const props = defineProps(["params", "orderSummary"]);
const emit = defineEmits(["next"]);

const URL = window._asset;

const addOns = ref({
    name: "",
    partner_name: "",
    selectedItems: [],
});

let state = addOns.value;

watch(state, () => {
    emit("updateState", {
        data: { addOns: state },
    });
});

const handleNext = () => {
    emit("next", {
        currentStep: props.params.index,
        data: { occasions: state },
    });
};

const handleSelectItem = (item) => {
    let index = state.selectedItems.findIndex((i) => i.id == item.id);
    if (index > -1) {
        state.selectedItems.splice(index, 1);
    } else {
        state.selectedItems.push(item);
    }
};

const checkIfExist = (id) => {
    return state.selectedItems.findIndex((i) => i.id == id) > -1;
};
</script>
