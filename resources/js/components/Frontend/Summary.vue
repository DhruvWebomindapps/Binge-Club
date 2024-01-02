<template>
    <div class="row ps-2 mb-4">
        <div class="col-md-8 table-responsive bg-white rounded p-3 mr-4">
            <!-- <p>Basic Information</p> -->
            <table class="table table-bordered">
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
                            <td>{{ timeSlot?.time_slot_name }}</td>
                        </tr>
                    </template>
                </thead>
            </table>
            <template
                v-if="
                    occasions?.selectedItems?.length > 0 ||
                    cakes?.selectedItems?.length > 0 ||
                    decorations?.selectedItems?.length > 0 ||
                    gifts?.selectedItems?.length > 0
                "
            >
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
                        <tr
                            v-if="
                                occasions &&
                                occasions?.selectedItems?.length > 0
                            "
                        >
                            <td>Occasion</td>
                            <td>
                                <ul>
                                    <li
                                        v-for="(
                                            occasion, index
                                        ) in occasions.selectedItems"
                                        :key="index"
                                    >
                                        {{ occasion.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li
                                        v-for="(
                                            occasion, index
                                        ) in occasions.selectedItems"
                                        :key="index"
                                    >
                                        {{ occasion.price > 0  ? occasion.price : '-' }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr v-if="cakes && cakes?.selectedItems?.length > 0">
                            <td>Cakes</td>
                            <td>
                                <ul>
                                    <li
                                        v-for="(
                                            cake, index
                                        ) in cakes.selectedItems"
                                        :key="index"
                                    >
                                        {{ cake.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li
                                        v-for="(
                                            cake, index
                                        ) in cakes.selectedItems"
                                        :key="index"
                                    >
                                        {{ cake.price }}
                                    </li>
                                </ul>
                            </td>
                        </tr>

                        <tr
                            v-if="
                                decorations &&
                                decorations?.selectedItems?.length > 0
                            "
                        >
                            <td>Decorations</td>
                            <td>
                                <ul>
                                    <li
                                        v-for="(
                                            decoration, index
                                        ) in decorations.selectedItems"
                                        :key="index"
                                    >
                                        {{ decoration.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li
                                        v-for="(
                                            decoration, index
                                        ) in decorations.selectedItems"
                                        :key="index"
                                    >
                                        {{ decoration.price }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        <tr v-if="gifts && gifts?.selectedItems?.length > 0">
                            <td>Gifts</td>
                            <td>
                                <ul>
                                    <li
                                        v-for="(
                                            gift, index
                                        ) in gifts.selectedItems"
                                        :key="index"
                                    >
                                        {{ gift.title }}
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li
                                        v-for="(
                                            gift, index
                                        ) in gifts.selectedItems"
                                        :key="index"
                                    >
                                        {{ gift.price }}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>
            <template v-else>
                <div>
                    <p>You have not selected any items</p>
                </div>
            </template>
            <div class="mt-4">
                <label class="form-label">Description</label>
                <textarea name="notes" v-model="notes" rows="3" class="w-100 form-control" placeholder="Additional information"></textarea>
            </div>
        </div>
        <div class="col-lg-3 table-responsive bg-white rounded p-3">
            <div class="total-summary">
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
                        <tr v-if="occasions?.selectedItems.length > 0">
                            <td>Occasion</td>
                            <td>{{ calculateTotal().occasionPrice > 0  ? calculateTotal().occasionPrice : '-' }}</td>
                        </tr>
                        <tr v-if="cakes?.selectedItems.length > 0">
                            <td>Cakes</td>
                            <td>{{ calculateTotal().cakePrice }}</td>
                        </tr>
                        <tr v-if="decorations?.selectedItems.length > 0">
                            <td>Decoration</td>
                            <td>{{ calculateTotal().decorationPrice }}</td>
                        </tr>
                        <tr v-if="gifts?.selectedItems.length > 0">
                            <td>Gift</td>
                            <td>{{ calculateTotal().giftPrice }}</td>
                        </tr>
                        <!-- <tr>
                            <td>Total</td>
                            <td>{{ calculateTotal().total }}</td>
                        </tr>
                        <tr>
                            <td>GST</td>
                            <td>{{ calculateTotal().gst }}</td>
                        </tr> -->
                        <tr style="font-weight: bold">
                            <td>Total</td>
                            <td>{{ calculateTotal().grandTotal }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <button
                        :disabled="isEnable"
                        @click="handleTheaterBooking"
                        type="button"
                        class="btn btn-success px-5 ms-auto"
                    > Book
                    </button>
                </div>
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
import { ref, watch } from "vue";

const props = defineProps(["params", "orderSummary"]);

const occasions = props.orderSummary?.occasions;
const cakes = props.orderSummary?.cakes;
const decorations = props.orderSummary?.decorations;
const gifts = props.orderSummary?.gifts;

const notes = ref('');

const isSubmit = () => {
    return false;
    // if (occasions?.selectedItems.length > 0) {
    //     return false;
    // }

    // return true;
};

let isEnable = isSubmit();

const isSuccess = ref(false);

watch(props, () => {});

const URL = window._url + "/booking/package/store";

const handleTheaterBooking = () => {
    if (!isSubmit()) {
        isEnable = true;
        axios
            .post(URL, {
                booking_id: props.params.booking?.id,
                items: props.orderSummary,
                total: calculateTotal().total,
                gst: calculateTotal().gst,
                grandTotal: calculateTotal().grandTotal,
                notes : notes.value
            })
            .then((res) => {
                if (res.data.success) {
                    let paymentUrl =
                        window._url +
                        "/initiate-payment/" +
                        props.params.booking?.id;
                    window.location.href = paymentUrl;
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

const calculateTotal = () => {
    let slotPrice = props.params.booking?.grand_total_amount;
    let occasionPrice = 0;
    let cakePrice = 0;
    let decorationPrice = 0;
    let giftPrice = 0;
    let total = 0;
    let gst = 0;
    let grandTotal = 0;

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

    total +=
        parseFloat(slotPrice) +
        occasionPrice +
        cakePrice +
        decorationPrice +
        giftPrice;

    // gst += (total * 13) / 100;

    grandTotal = total + parseFloat(gst);

    return {
        slotPrice,
        occasionPrice,
        cakePrice,
        decorationPrice,
        giftPrice,
        total,
        gst,
        grandTotal,
    };
};
</script>
