<template>
    <div class="row ps-2 mb-4">
        <div class="col-md-8 table-responsive bg-white rounded p-3 mr-4">
            <p>Basic Information</p>
            <table class="table">
                <thead>
                    <template v-if="basicDetails">
                        <tr>
                            <td>Name</td>
                            <td>{{ basicDetails?.name }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ basicDetails?.phone }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ basicDetails?.email }}</td>
                        </tr>
                        <tr>
                            <td>No Of People</td>
                            <td>{{ basicDetails?.no_of_people }}</td>
                        </tr>
                    </template>

                    <template v-if="timeSlot">
                        <tr>
                            <td>City</td>
                            <td>{{ timeSlot?.city_name }}</td>
                        </tr>
                        <tr>
                            <td>Location</td>
                            <td>{{ timeSlot?.location_name }}</td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td>{{ timeSlot?.date }}</td>
                        </tr>
                        <tr>
                            <td>Screen</td>
                            <td>{{ timeSlot?.screen_name }}</td>
                        </tr>
                        <tr>
                            <td>Slot</td>
                            <td>
                                <ul>
                                    <li v-for="( slot, index) in timeSlot?.selectedSlots" :key="index">
                                        {{ slot.slot }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </template>
                </thead>
            </table>
            <template v-if="
                occasions?.selectedItems?.length > 0 ||
                cakes?.selectedItems?.length > 0 ||
                decorations?.selectedItems?.length > 0 ||
                gifts?.selectedItems?.length > 0 ||
                snacks?.selectedItems?.length > 0 ||
                bouquets?.selectedItems?.length > 0 ||
                others?.selectedItems?.length > 0
            ">
                <p>Selected Items</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item Type</th>
                            <th>Items Name</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="
                            occasions &&
                            occasions?.selectedItems?.length > 0
                        ">
                            <td>Occasion</td>
                            <td>
                                <ul>
                                    <li v-for="(
                                                        occasion, index
                                                    ) in occasions.selectedItems" :key="index">
                                        {{ occasion.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li v-for="(
                                                        occasion, index
                                                    ) in occasions.selectedItems" :key="index">
                                        {{ occasion.price>0 ? occasion.price : '-' }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr v-if="cakes && cakes?.selectedItems?.length > 0">
                            <td>Cakes</td>
                            <td>
                                <ul>
                                    <li v-for="(
                                                        cake, index
                                                    ) in cakes.selectedItems" :key="index">
                                        {{ cake.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li v-for="(
                                                        cake, index
                                                    ) in cakes.selectedItems" :key="index">
                                        {{ cake.price }}
                                    </li>
                                </ul>
                            </td>
                        </tr>

                        <tr v-if="
                            decorations &&
                            decorations?.selectedItems?.length > 0
                        ">
                            <td>Decorations</td>
                            <td>
                                <ul>
                                    <li v-for="(
                                                        decoration, index
                                                    ) in decorations.selectedItems" :key="index">
                                        {{ decoration.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li v-for="(
                                                        decoration, index
                                                    ) in decorations.selectedItems" :key="index">
                                        {{ decoration.price }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr v-if="gifts && gifts?.selectedItems?.length > 0">
                            <td>Gifts</td>
                            <td>
                                <ul>
                                    <li v-for="(
                                                        gift, index
                                                    ) in gifts.selectedItems" :key="index">
                                        {{ gift.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li v-for="(
                                                        gift, index
                                                    ) in gifts.selectedItems" :key="index">
                                        {{ gift.price }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr v-if="snacks && snacks?.selectedItems?.length > 0">
                            <td>Snacks</td>
                            <td>
                                <ul>
                                    <li v-for="(snack, index) in snacks.selectedItems" :key="index">
                                        {{ snack.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li v-for="(snack, index) in snacks.selectedItems" :key="index">
                                        {{ snack.price }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr v-if="bouquets && bouquets?.selectedItems?.length > 0">
                            <td>Bouquets</td>
                            <td>
                                <ul>
                                    <li v-for="( bouquet, index) in bouquets.selectedItems" :key="index">
                                        {{ bouquet.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li v-for="( bouquet, index ) in bouquets.selectedItems" :key="index">
                                        {{ bouquet.price }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr v-if="others && others?.selectedItems?.length > 0">
                            <td>Others</td>
                            <td>
                                <ul>
                                    <li v-for="( other, index) in others.selectedItems" :key="index">
                                        {{ other.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li v-for="( other, index) in others.selectedItems" :key="index">
                                        {{ other.price }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
        </div>
        <div class="col-lg-3 table-responsive bg-white rounded p-3">
            <p>Total Summary</p>
            <table class="table">
                <!-- <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                    </tr>
                </thead> -->
                <tbody>
                    <tr>
                        <td>Slot Price</td>
                        <td>{{ calculateTotal().slotPrice }}</td>
                    </tr>
                    <tr>
                        <td>Additional Person Price</td>
                        <td>{{ calculateTotal().additionalPrice>0 ? calculateTotal().additionalPrice : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Occasion</td>
                        <td>{{ calculateTotal().occasionPrice>0 ? calculateTotal().occasionPrice : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Cakes</td>
                        <td>{{ calculateTotal().cakePrice>0 ? calculateTotal().cakePrice : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Decoration</td>
                        <td>{{ calculateTotal().decorationPrice>0 ? calculateTotal().decorationPrice : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Gift</td>
                        <td>{{ calculateTotal().giftPrice>0 ? calculateTotal().giftPrice : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Snacks</td>
                        <td>{{ calculateTotal().snacksPrice>0 ? calculateTotal().snacksPrice : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Bouquets</td>
                        <td>{{ calculateTotal().bouquetPrice>0 ? calculateTotal().bouquetPrice : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Others</td>
                        <td>{{ calculateTotal().otherPrice>0 ? calculateTotal().otherPrice : '-' }}</td>
                    </tr>
                    <!-- <tr>
                        <td>Total</td>
                        <td>{{ calculateTotal().total }}</td>
                    </tr>
                    <tr>
                        <td>GST</td>
                        <td>{{ calculateTotal().gst }}</td>
                    </tr> -->
                    <tr>
                        <td>Total</td>
                        <td>{{ calculateTotal().grandTotal }}</td>
                    </tr>

                    <tr>
                        <td>Payment Status</td>
                        <td>
                            <select v-model="paymentInfo.payment_status" id="">
                                <option value="success">Success</option>
                                <option value="pending">Pending</option>
                                <option value="cancel">Cancel</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Payment Type</td>
                        <td>
                            <select v-model="paymentInfo.payment_type" id="">
                                <option value="paid">Paid</option>
                                <option value="partially-paid">
                                    Partially Paid
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Advance</td>
                        <td>
                            <input type="text" @change="calculateAdvance" v-model="paymentInfo.advance" />
                        </td>
                    </tr>
                    <tr>
                        <td>Balance</td>
                        <td>
                            <input type="text" @change="calculateAdvance" v-model="paymentInfo.balance" readonly />
                        </td>
                    </tr>
                    <tr>
                        <td>Notes</td>
                        <td>
                            <textarea name="" id="" v-model="paymentInfo.notes"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-2">
                <a v-if="existingDetails" class="btn btn-primary mr-2" @click="handlePrevious">Prev</a>
                <button :disabled="isEnable" @click="handleTheaterBooking" type="button"
                    class="btn btn-success px-5 ms-auto">
                    Book
                </button>
            </div>
        </div>
    </div>

    <div class="row text-center">
        <div class="col-lg-12" v-if="isSuccess">
            <div class="alert alert-success">
                Your order has been places successfully
                <a :href="URL">Click here for new order</a>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";

const props = defineProps(["params", "orderSummary"]);
const emit = defineEmits(["prev"]);

const timeSlot = props.orderSummary?.timeSlot;
const basicDetails = props.orderSummary?.basicDetails;
const occasions = props.orderSummary?.occasions;
const cakes = props.orderSummary?.cakes;
const decorations = props.orderSummary?.decorations;
const gifts = props.orderSummary?.gifts;
const snacks = props.orderSummary?.snacks;
const bouquets = props.orderSummary?.bouquets;
const others = props.orderSummary?.others;

let existingDetails = props?.params?.existing?.info;

const isSubmit = () => {
    if (
        timeSlot?.location_id &&
        timeSlot?.screen_id &&
        timeSlot?.date &&
        timeSlot?.selectedSlots.length > 0 &&
        basicDetails?.name &&
        // basicDetails?.email &&
        basicDetails?.phone
    ) {
        return false;
    }

    // if (
    //     timeSlot?.location_id &&
    //     timeSlot?.screen_id &&
    //     timeSlot?.date &&
    //     timeSlot?.time_slot_id &&
    //     basicDetails?.name &&
    //     basicDetails?.email &&
    //     basicDetails?.phone &&
    //     basicDetails?.no_of_people &&
    //     occasions?.selectedItems.length > 0
    // ) {
    //     return false;
    // }

    return true;
};

let isEnable = ref(isSubmit());

const isSuccess = ref(false);

watch(props, () => { });

const URL = window._url + "/admin/booking";

const handlePrevious = () => {
    emit("prev", {
        currentStep: props.params.index,
    });
};

const calculateTotal = () => {
    let slotPrice = 0;
    let additionalPrice = 0;
    let occasionPrice = 0;
    let cakePrice = 0;
    let decorationPrice = 0;
    let giftPrice = 0;
    let snacksPrice = 0;
    let bouquetPrice = 0;
    let otherPrice = 0;
    let total = 0;
    let gst = 0;
    let grandTotal = 0;

    if (basicDetails?.no_of_people > timeSlot?.screen_capacity) {
        let totalPeople =
            basicDetails?.no_of_people - timeSlot?.screen_capacity;
        additionalPrice += timeSlot?.time_slot_additional * totalPeople;
    }

    timeSlot?.selectedSlots.map((item) => {
        slotPrice += item?.amount;
    });

    //occasion
    occasions?.selectedItems.map((item) => {
        occasionPrice += parseFloat(item.price);
    });

    //cakes
    cakes?.selectedItems.map((item) => {
        cakePrice += parseFloat(item.price);
    });

    //decoration
    decorations?.selectedItems.map((item) => {
        decorationPrice += parseFloat(item.price);
    });

    //gifts
    gifts?.selectedItems.map((item) => {
        giftPrice += parseFloat(item.price);
    });

    // snacks
    snacks?.selectedItems.map((item) => {
        snacksPrice += parseFloat(item.price);
    });

    // bouquets
    bouquets?.selectedItems.map((item) => {
        bouquetPrice += parseFloat(item.price);
    });

    // others
    others?.selectedItems.map((item) => {
        otherPrice += parseFloat(item.price);
    });


    total +=
        slotPrice +
        additionalPrice +
        occasionPrice +
        cakePrice +
        decorationPrice +
        giftPrice +
        snacksPrice +
        bouquetPrice +
        otherPrice;

    // gst += (total * 13) / 100;

    grandTotal = total + parseFloat(gst);

    return {
        slotPrice,
        additionalPrice,
        occasionPrice,
        cakePrice,
        decorationPrice,
        giftPrice,
        snacksPrice,
        bouquetPrice,
        otherPrice,
        total,
        gst,
        grandTotal,
    };
};

onMounted(() => {
    calculateAdvance()
})

const paymentInfo = ref({
    payment_status: existingDetails ? existingDetails.status : "pending",
    payment_type: existingDetails ? existingDetails.payment_type : "paid",
    advance: existingDetails ? existingDetails.advance : calculateTotal().grandTotal,
    balance: existingDetails ? existingDetails.balance : 0,
    notes: existingDetails ? existingDetails.notes : "",
});

let state = paymentInfo.value;

const calculateAdvance = () => {
    state.balance = calculateTotal().grandTotal - state.advance;
};

const handleTheaterBooking = () => {
    if (!isSubmit()) {
        isEnable.value = true;
        axios
            .post(URL, {
                booking_id: existingDetails ? existingDetails.id : null,
                items: props.orderSummary,
                total_slot_amount: calculateTotal().slotPrice,
                total_additional_amount: calculateTotal().additionalPrice,
                total: calculateTotal().total,
                gst: calculateTotal().gst,
                grandTotal: calculateTotal().grandTotal,
                payment_status: state.payment_status,
                payment_type: state.payment_type,
                advance: state.advance,
                balance: state.balance,
                notes: state.notes,
            })
            .then((res) => {
                if (res.data.success) {
                    isSuccess.value = true;
                    props.orderSummary = null;
                    window.location.href = URL;
                } else {
                    isSuccess.value = false;
                    alert("something went wrong");
                }
            })
            .catch((e) => {
                console.log("error storing data", e);
            });
    }
};
</script>
