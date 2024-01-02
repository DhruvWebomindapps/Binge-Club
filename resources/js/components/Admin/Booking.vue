<template>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" v-for="(item, index) in menuItems" :key="index">
            <button
                :class="`nav-link ${activeMenu == index ? 'active' : ''}`"
                type="button"
                @click="props.existing ? null : selectTab(index)"
            >
                {{ item.title }}
            </button>
        </li>
    </ul>

    <div class="tab-content mt-4">
        <template v-for="(item, index) in menuItems" :key="index">
            <KeepAlive>
                <component
                    :is="item.name"
                    v-if="index == activeMenu"
                    :params="{
                        index,
                        cities: props.cities,
                        existing: props.existing,
                    }"
                    :orderSummary="bookingDetails"
                    :key="item.id"
                    @next="handleNext"
                    @prev="handlePrev"
                    @updateState="handleState"
                />
            </KeepAlive>
        </template>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import BasicDetails from "./BasicDetails.vue";
import TimeSlot from "./TimeSlot.vue";
import Occasion from "./Occasion.vue";
import Addons from "./Addons.vue";
import Bouquets from "./Bouquets.vue";
import Cakes from "./Cakes.vue";
import Decoration from "./Decoration.vue";
import Gifts from "./Gifts.vue";
import Others from "./Others.vue";
import Snacks from "./Snacks.vue";
import Summary from "./Summary.vue";

const props = defineProps(["cities", "existing"]);
const emit = defineEmits(["next"]);

onMounted(() => {});

const activeMenu = ref(0);

const getUniqueKey = () => {
    return Math.floor(Math.random() * 10000);
};

const menuItems = ref([
    {
        id: 1 + getUniqueKey(),
        title: "Select Date and Time",
        name: TimeSlot,
    },
    {
        id: 2 + getUniqueKey(),
        title: "Basic Info",
        name: BasicDetails,
    },
    {
        id: 3 + getUniqueKey(),
        title: "Packages",
        name: Occasion,
    },
    {
        id: 4 + getUniqueKey(),
        title: "Cakes",
        name: Cakes,
    },
    {
        id: 5 + getUniqueKey(),
        title: "Bouquets",
        name: Bouquets,
    },
    {
        id: 6 + getUniqueKey(),
        title: "Snacks",
        name: Snacks,
    },
    {
        id: 7 + getUniqueKey(),
        title: "Decorations",
        name: Decoration,
    },
    {
        id: 8 + getUniqueKey(),
        title: "Gifts",
        name: Gifts,
    },
    {
        id: 9 + getUniqueKey(),
        title: "Others",
        name: Others,
    },
    {
        id: 10 + getUniqueKey(),
        title: "Summary",
        name: Summary,
    },
]);

const bookingDetails = ref({});

const handleNext = ($event) => {
    var state = $event;
    Object.assign(bookingDetails.value, state.data);
    if (state.currentStep < menuItems.value.length) {
        selectTab(state.currentStep + 1);
    }
};

const handlePrev = ($event) => {
    var state = $event;
    if (state.currentStep > 0) {
        selectTab(state.currentStep - 1);
    }
};

const handleState = ($event) => {
    var state = $event;
    Object.assign(bookingDetails.value, state.data);
};

const selectTab = (index) => {
    if (index == 9) {
        menuItems.value[index].id = getUniqueKey();
    }
    activeMenu.value = index;
};
</script>
