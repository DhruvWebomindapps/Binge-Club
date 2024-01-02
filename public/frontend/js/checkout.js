var allitems = [];
$(document).ready(function() {
    calculateTotal();
    console.log("Cane");
});
$(document).on('click', '.item', function() {
    $(this).toggleClass('selected');
    calculateTotal();
});

function calculateTotal() {
    var items = [];
    let cakePrice = 0;
    let decorationPrice = 0;
    let giftPrice = 0;
    let snackPrice = 0;
    let bouquetPrice = 0;
    let otherPrice = 0;
    var total = parseFloat($('#slot_price').val());
    console.log(total);

    $('.item.selected').each(function() {
        var itemType = $(this).data('type');
        var itemId = $(this).data('id');
        var itemTitle = $(this).data('name');
        var itemPrice = parseFloat($(this).data('price'));

        total += itemPrice;
        items.push({
            type: itemType,
            id: itemId,
            title: itemTitle,
            price: itemPrice
        });

        switch (itemType) {
            case 'cakes':
                cakePrice += itemPrice
                break;
            case 'bouquets':
                bouquetPrice += itemPrice
                break;
            case 'gifts':
                giftPrice += itemPrice
                break;
            case 'decorations':
                decorationPrice += itemPrice
                break;
            case 'snacks':
                snackPrice += itemPrice
                break;
            case 'others':
                otherPrice += itemPrice
                break;
            default:
                break;
        }
    });
    if(cakePrice>0){
        $('#cakes-col').show();
    }else{
        $('#cakes-col').hide();
    }
    if(bouquetPrice>0){
        $('#bouquets-col').show();
    }else{
        $('#bouquets-col').hide();
    }
    if(snackPrice>0){
        $('#snacks-col').show();
    }else{
        $('#snacks-col').hide();
    }
    if(giftPrice>0){
        $('#gifts-col').show();
    }else{
        $('#gifts-col').hide();
    }
    if(decorationPrice>0){
        $('#decorations-col').show();
    }else{
        $('#decorations-col').hide();
    }
    if(otherPrice>0){
        $('#others-col').show();
    }else{
        $('#others-col').hide();
    }
    $('#cake_total').html('₹' + cakePrice);
    $('#bouquet_total').html('₹' + bouquetPrice);
    $('#gift_total').html('₹' + giftPrice);
    $('#decoration_total').html('₹' + decorationPrice);
    $('#snack_total').html('₹' + snackPrice);
    $('#other_total').html('₹' + otherPrice);
    $('.grand-total').html('₹' + total);
    $('#selected_items').empty();

    let itemList = '';
    items.map(item => {
        itemList += `<tr>
                        <td>${item.type}</td>
                        <td>${item.title}</td>
                        <td>${item.price}</td>
                    </tr>`;
    });
    $('#selected_items').append(itemList);
    $('input[name="total_amount"]').val(total)
    allitems = items;
}
$('.nextButton').on('click', function() {
    var $activeTab = $('.nav-pills .nav-link.active');
    var $nextTab = $activeTab.parent().next().find('button');

    if ($nextTab.length > 0) {
        $nextTab.tab('show');
    } else {
        // If there's no next tab, go back to the first tab
        $('.nav-pills .nav-link').first().tab('show');
    }
});
$('#submit_btn').on('click', function() {
    let total = $('input[name="total_amount"]').val();
    let booking_id = $('input[name="booking_id"]').val();
    let nick_name = $('#nick_name').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "{{ route('booking.addons', $booking->id) }}",
        data: {
            booking_id: booking_id,
            total_amount: total,
            items: allitems,
            nick_name: nick_name,
        },
        success: function(response) {
            if (response.success) {
                let paymentUrl = window.location.origin + "/initiate-payment/" + booking_id;
                window.location.href = paymentUrl;
            } else {
                alert("something went wrong");
            }
        }
    });
});