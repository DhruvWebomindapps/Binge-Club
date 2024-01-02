<template>
    <div class="row" v-if="props?.params?.location?.occasions">
        <div
            class="col-lg-2 mt-4 text-center"
            v-for="item in props?.params?.location?.occasions"
            :key="item.id"
        >
            <div class="package imageDivpackage"
                @click="handleSelectItem(item)"
            >
                <div :class="`package-img mx-auto ${
                    checkIfExist(item.id) ? 'selected' : ''
                }`">
                    <img
                        :src="`${URL}storage/${item.get_package_image[0]?.package_image}`"
                        class=""
                    />
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
            <a class="btn btn-success" @click="handleNext">Next</a>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
const props = defineProps(["params", "orderSummary"]);
const emit = defineEmits(["next"]);

const URL = window._asset;

const occasions = ref({
    name: "",
    partner_name: "",
    selectedItems: [],
});

let state = occasions.value;

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
