<template>
    <div class="row" v-if="props?.orderSummary?.timeSlot?.occasions">
        <div class="col-lg-2 mt-4 text-center" v-for="item in props.orderSummary.timeSlot.occasions" :key="item.id">
            <div class="package imageDivpackage" @click="handleSelectItem(item)">
                <div :class="`package-img mx-auto ${checkIfExist(item.id) ? 'selected' : ''}`">
                    <img :src="`${URL}storage/${item.get_package_image[0]?.package_image}`" class="" />
                </div>
                <div class="">
                    <h5>{{ item.title }}</h5>
                    <!-- <h6>
                        {{ item.price }}
                    </h6> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-lg-12">
            <a v-if="existingDetails" class="btn btn-primary mr-2" @click="handlePrevious">Prev</a>

            <a class="btn btn-success" @click="handleNext">Next</a>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
const props = defineProps(["params", "orderSummary"]);
const emit = defineEmits(["next"]);

const URL = window._asset;

const occasions = ref({
    name: "",
    partner_name: "",
    selectedItems: [],
});

let state = occasions.value;
let existingDetails = props?.params?.existing?.occasions;

watch(state, () => {
    emit("updateState", {
        data: { occasions: state },
    });
});

const handleNext = () => {
    emit("next", {
        currentStep: props.params.index,
        data: { occasions: state },
    });
};

const handlePrevious = () => {
    emit("prev", {
        currentStep: props.params.index,
    });
};

const handleSelectItem = (item) => {
    let index = state.selectedItems.findIndex((i) => i.id == item.id);
    if (index > -1) {
        state.selectedItems.splice(index, 1);
    } else {
        state.selectedItems.push({
            booking_item_id: null,
            id: item.id,
            title: item.title,
            price: item.price,
        });
    }
};

const checkIfExist = (id, booking_item_id) => {
    if (booking_item_id) {
        return state.selectedItems.findIndex((i) => i.type_id == id) > -1;
    }

    return state.selectedItems.findIndex((i) => i.id == id) > -1;
};

onMounted(() => {
    if (existingDetails) {
        existingDetails.map((item) => {
            item["booking_item_id"] = item.id;
            state.selectedItems.push({
                booking_item_id: item.id,
                id: item.type_id,
                title: item.title,
                price: item.price,
            });
        });
    }
});
</script>
