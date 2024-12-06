<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TimeSlotController;
use App\Mail\CancelMail;
use App\Mail\InvoiceMail;
use App\Models\Booking;
use App\Models\Location;
use App\Models\Package;
use App\Models\Screen;
use App\Models\ScreenImage;
use App\Models\Slot;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    protected $booking;
    protected $user;
    protected $location;
    public function __construct(
        Booking $booking,
        User $user,
        Location $location,
    ) {
        $this->booking = $booking;
        $this->user = $user;
    }
    public function booking(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'number_of_people' => 'required',
            'email' => 'sometimes|nullable|email',
            'phone' => 'sometimes|required|min:10|max:10',
        ]);
        // dd($request->all());
        $location_id = $request->location_id;
        $screen_id = $request->screen_id;
        $date = $request->date;
        $total_slot_amount = 0;
        $total_additional_amount = 0;
        $grand_total = 0;


        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $number_of_people = $request->number_of_people;
        $isNeedDecoration = $request->yesno;

        $location_details = Location::find($location_id);
        $screen_details = Screen::find($screen_id);

        $booking_slots = [];
        $capacity = $screen_details->capacity;
        $extra_people = $number_of_people - $capacity;

        foreach ($request->slot_id as $slot_id) {
            //check details are valid
            $slot_details = Slot::find($slot_id);
            $total_slot_amount += $slot_details->amount;
            // $grand_total += $slot_details->amount + ($slot_details->additional_amount * $number_of_people);
            $screen_slot_name = $slot_details->start_time . ' - ' . $slot_details->end_time;

            //validate slot name 
            $timeController = (new TimeSlotController);
            if (!in_array($screen_slot_name, $request->slot_name) || !$timeController->getSlotActive($date, $screen_id, $slot_details->start_time, $screen_slot_name)) {
                die('Sorry to inform ,This slot is booked already');
            }
            $startTime = \DateTime::createFromFormat('h:i A', $slot_details->start_time);
            $endTime = \DateTime::createFromFormat('h:i A', $slot_details->end_time);

            if ($startTime) {
                $startTime = $startTime->format('H:i:s');
            }
            if ($endTime) {
                $endTime = $endTime->format('H:i:s');
            }
            $booking_slots[] = [
                'slot_id' => $slot_id,
                'slot_name' => $screen_slot_name,
                'amount' => $slot_details->amount,
                'additional_amount' => $slot_details->additional_amount,
            ];
        }
        if ($extra_people > 0) {
            $total_additional_amount = $slot_details->additional_amount * $extra_people;
        }

        $grand_total = $total_slot_amount + $total_additional_amount;

        //check if user exists or not 
        $user = $this->addOrUpdateUser($request);

        $checkIfAlreadyAdded = $this->booking->where('user_id', $user->id)
            ->where('location_id', $location_id)
            ->where('screen_id', $screen_id)
            ->where('book_date', $date)
            ->where('status', 'success')
            ->first();
        if (is_null($checkIfAlreadyAdded)) {
            $booking = $this->booking->create([
                'user_id'               => $user->id,
                'city_id'               => $location_details->city_id,
                'city_name'             => $location_details->city?->name,

                'location_id'           => $location_id,
                'location_name'         => $location_details->name,

                'screen_id'             => $screen_id,
                'screen_name'           => $screen_details->screen_name,
                'screen_capacity'       => $screen_details->capacity,

                'book_date'             => $date,
                'name'                  => $name,
                'phone'                 => $phone,
                'email'                 => $email,
                // 'time_slot'             => $slot_name,
                'time_slot_amount'      => $total_slot_amount,
                'additional_amount'     => $total_additional_amount,
                'total_amount'          => $grand_total,
                'gst_amount'            => 0,
                'grand_total_amount'    => $grand_total,
                'with_decoration'       => $isNeedDecoration,
                'number_of_people'      =>  $number_of_people,
                'is_online_booking'     => true,
                'status'                => 'pending'
            ]);
            $booking->slots()->createMany($booking_slots);
        } else {
            $booking = $checkIfAlreadyAdded;

            //delete existing slots
            $booking->slots()->delete();

            //assign new selected slots
            $booking->slots()->createMany($booking_slots);
        }
        if ($isNeedDecoration == 1) {
            return redirect()->route('booking.addons', ['id' => $booking->id]);
        } else {
            return redirect()
                ->route('initiate-payment', $booking->id)
                ->withInput($request->all());
        }
    }
    public function addOrUpdateUser($request): User
    {
        $user = $this->user->where('phone', $request['phone'])->orWhere('email', $request['email'])->first();
        if (is_null($user)) {
            $useParams = [
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone']
            ];
            $user = $this->user->create($useParams);

            $user->assignRole('customer');

            return $user;
        }
        return $user;
    }
    public function selectAddons($booking_id)
    {
        $booking = Booking::find($booking_id);
        $location = Location::find($booking?->location_id);
        return view('frontend.book.checkout', compact('booking', 'location'));
    }

    public function addonStore(Request $request)
    {
        $booking_id = $request->booking_id;
        $booking = Booking::find($booking_id);

        $booking->update([
            'total_amount' => $request->total_amount,
            // 'gst_amount' => $request->gst,
            'grand_total_amount' => $request->total_amount,
            'nick_name' => $request->nick_name
        ]);

        //add occasions
        $this->addItems($booking, $request->items);
        return response()->json([
            'success' => true,
            'message' => 'Booking successfully completed',
        ]);
    }

    public function addItems($booking, $items): void
    {
        $booking->items()->delete();
        if ($items && count($items) > 0) {
            foreach ($items as $itm) {
                $data = [
                    'type' => $itm['type'],
                    'type_id' => $itm['id'],
                    'title' => $itm['title'],
                    'price' => $itm['price']
                ];

                $booking->items()->create($data);
            }
        }
    }

    public function sendInvoice($booking): void
    {
        $emails = [];
        if ($booking->email) {
            $emails = [...$emails, $booking->email];
        }

        //location admin emails
        $location =  $this->location->find($booking->location_id);

        if ($location) {
            $emails = [...$emails, $location->admin_email];
        }

        Mail::to($emails)
            ->send(new InvoiceMail($booking));
    }
    public function cancelMail($booking): void
    {
        $emails = [];
        if ($booking->email) {
            $emails = [...$emails, $booking->email];
        }

        //location admin emails
        $location =  $this->location->find($booking->location_id);

        if ($location) {
            $emails = [...$emails, $location->admin_email];
        }

        Mail::to($emails)
            ->send(new CancelMail($booking));
    }

    public function bookedWithPayment($id)
    {
        // // sending Email
        $relation = ['getCity', 'getLocation', 'getScreen'];
        $booking_details = Booking::with($relation)->whereId($id)->first();
        $location_admin_email = $booking_details->getLocation->admin_email;
        $screen_id = $booking_details->screen_id;
        $package_id = $booking_details->package_id;
        $userEmail =  $booking_details->email;
        // get Screen Image
        if ($screen_id) {
            $screenImage = ScreenImage::where('screen_id', $screen_id)->get();
            $imgScreen = $screenImage->first();
        } else {
            $imgScreen = 'Not found';
        }
        // get first image of package

        if ($package_id) {
            $package_details = Package::with('getPackageImage')->whereId($package_id)->first();
        } else {
            $package_details = '';
        }
        // this function will work if use have email
        if (!empty($userEmail)) {
            Mail::to([$userEmail, $location_admin_email])
                ->send(new InvoiceMail($booking_details));
        }

        // updating status in booking table
        if ($booking_details) {
            $booking_details->update(['status'    => 'success']);
        }
        return redirect('congratulations?booking_id=' . $id);
    }

    public function invoice_download($booking_id)
    {
        // dd($booking_id);
        $relation = ['getUser', 'getCity', 'getLocation', 'getScreen'];
        $booking = $this->booking->with($relation)->where('id', $booking_id)->first();

        $pdf = Pdf::loadView('frontend.book.invoicedownload', compact('booking'));
        return $pdf->stream('binge city invoice.pdf');
    }
}
