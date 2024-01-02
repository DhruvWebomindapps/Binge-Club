<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Screen;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function initiatePayment($id)
    {
        if ($id) {
            $bookedData = Booking::find($id);
            $grand_total = $bookedData->grand_total_amount;
        }
        // $merchantId = 'M1GP2HG1YYEI';
        // $merchantTransactionId = (string) uniqid();
        // $merchantUserId = (string) uniqid();
        // $saltKey = 'b0859315-3dcf-4ed1-ab5c-f724eff3ab28';
        // $saltIndex = 1;


        // $amount = $grand_total;
        // // $amount = 1;

        // $data = [
        //     "merchantId" => $merchantId,
        //     "merchantTransactionId" => $merchantTransactionId,
        //     "merchantUserId" => $merchantUserId,
        //     "amount" => (float) $amount * 100,
        //     "redirectUrl" => route('phonepe-response', ['id' => $bookedData->id, 'transactionId' => $merchantTransactionId]),
        //     "redirectMode" => "GET",
        //     "callbackUrl" => '',
        //     "mobileNumber" => "9902224246",
        //     "paymentInstrument" => [
        //         "type" => "PAY_PAGE"
        //     ]
        // ];

        // $encode = base64_encode(json_encode($data));
        // $string = $encode . '/pg/v1/pay' . $saltKey;
        // $sha256 = hash('sha256', $string);
        // $finalXHeader = $sha256 . '###' . $saltIndex;

        // $vars = json_encode(['request' => $encode]);

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://api.phonepe.com/apis/hermes/pg/v1/pay");
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);  //Post Fields
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // $headers = [
        //     'Content-Type:application/json',
        //     'X-VERIFY:' . $finalXHeader,
        // ];

        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // $server_output = curl_exec($ch);

        // curl_close($ch);

        // $response = json_decode($server_output);

        // $redirect_url = $response?->data?->instrumentResponse?->redirectInfo?->url;

        return redirect()->route('phonepe-response', $id);
    }

    public function PhonePeResponse(Request $request, $id)
    {
        $relation = ['getCity', 'getLocation', 'getScreen', 'slots'];
        $booking = Booking::with($relation)->whereId($id)->first();
        $screen = Screen::find($booking->screen_id);
        if (is_null($screen)) {
            config(['google-calendar.calendar_id' => 'primary']);
        } else {
            config(['google-calendar.calendar_id' => $screen->calendar_id]);
        }
        foreach ($booking->slots as $slot) {
            $timeArray = explode(" - ", $slot->slot_name);
            if (count($timeArray) === 2) {
                $startTime = trim($timeArray[0]);
                $endTime = trim($timeArray[1]);
            }
            $startTime = \DateTime::createFromFormat('h:i A', $startTime);
            $endTime = \DateTime::createFromFormat('h:i A', $endTime);
            if ($startTime) {
                $startTime = $startTime->format('H:i:s');
            }
            if ($endTime) {
                $endTime = $endTime->format('H:i:s');
            }
            $startDtTime = Carbon::parse($booking->book_date . ' ' . $startTime, 'Asia/Kolkata');
            $endDtTime = Carbon::parse($booking->book_date . ' ' . $endTime, 'Asia/Kolkata');
            $event = new Event;
            $event->name = '[' . $booking->location_name . '] [' . $booking->screen_name . ']' . $booking->name;
            $event->description = $request->notes;
            $event->startDateTime = $startDtTime;
            $event->endDateTime = $endDtTime;
            $event_id=$event->save();
            $slot->update(['event_id', $event_id->id]);
        }
        return redirect()->route('bookedWithPayment', $id);
        // if ($response->code == 'PAYMENT_SUCCESS') {
        //     die();
        // } else {
        //     $messages['message'] = $response->code;
        //     return view('frontend.pages.thank-you', $messages);
        // }
    }
}
