<template>
    <ul class="nav nav-tabs" ref="scrollStart">
        <li class="nav-item" v-for="(item, index) in menuItems" :key="index">
            <button
                :class="`nav-link ${activeMenu == index ? 'active' : ''}`"
                type="button"
                @click="selectTab(index)"
            >
                {{ item.title }}
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <template v-for="(item, index) in menuItems" :key="index">
            <KeepAlive>
                <component
                    :is="item.name"
                    v-if="index == activeMenu"
                    :params="{
                        index,
                        booking: props.booking,
                        location: props.location,
                    }"
                    :orderSummary="bookingDetails"
                    :key="item.id"
                    @next="handleNext"
                    @updateState="handleState"
                />
            </KeepAlive>
        </template>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Occasion from "./Occasion.vue";
import Cakes from "./Cakes.vue";
import Decoration from "./Decoration.vue";
import Gifts from "./Gifts.vue";
import Summary from "./Summary.vue";

const props = defineProps(["booking","location"]);

const scrollStart= ref()

const activeMenu = ref(0);

const getUniqueKey = () => {
    return Math.floor(Math.random() * 10000);
};

const menuItems = ref([
    {
        id: 3 + getUniqueKey(),
        title: "Occasion",
        name: Occasion,
    },
    {
        id: 4 + getUniqueKey(),
        title: "Cakes",
        name: Cakes,
    },
    {
        id: 5 + getUniqueKey(),
        title: "Decorations",
        name: Decoration,
    },
    {
        id: 6 + getUniqueKey(),
        title: "Gifts",
        name: Gifts,
    },
    {
        id: 7 + getUniqueKey(),
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

const handleState = ($event) => {
    var state = $event;
    Object.assign(bookingDetails.value, state.data);
};

const selectTab = (index) => {
    if (index == 4) {
        menuItems.value[index].id = getUniqueKey();
    }
    activeMenu.value = index;
    scrollStart.value.scrollIntoView({ behavior: "smooth" });

};
</script>
