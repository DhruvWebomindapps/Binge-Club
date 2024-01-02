<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CancelMail;
use App\Models\Gift;
use Illuminate\Http\Request;


#use models
use App\Models\User;
use App\Models\City;
use App\Models\Screen;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Location;
use App\Models\Timeslot;
use App\Models\Cake;
use App\Models\Decoration;
use App\Models\PackageImage;
use App\Models\ScreenImage;

#use other classes
use App\Mail\InvoiceMail;
use App\Models\BookingSlot;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\GoogleCalendar\Event;


class BookingController extends Controller
{
    #Bind the model
    protected $user;
    protected $city;
    protected $addOn;
    protected $booking;
    protected $screen;
    protected $package;
    protected $location;
    protected $timeSlot;
    protected $packageImage;
    protected $decoration;
    protected $cake;
    protected $gift;
    protected $screenImage;
    protected $email;
    protected $name;
    protected $admin_email;
    protected $location_admin_email;

    function __construct(
        User        $user,
        City        $city,
        Booking     $booking,
        Screen      $screen,
        Package     $package,
        Location    $location,
        Timeslot    $timeSlot,
        PackageImage $packageImage,
        Decoration $decoration,
        Cake $cake,
        Gift $gift,
        ScreenImage $screenImage
    ) {
        $this->user             = $user;
        $this->city             = $city;
        $this->screen           = $screen;
        $this->package          = $package;
        $this->booking          = $booking;
        $this->location         = $location;
        $this->timeSlot         = $timeSlot;
        $this->packageImage     = $packageImage;
        $this->decoration     = $decoration;
        $this->cake     = $cake;
        $this->gift     = $gift;
        $this->screenImage      = $screenImage;
    }

    public function index(Request $request)
    {
        try {
            $locations = $this->location->where('status', 1)->get();
            $screens = $this->screen->where('status', 1)->get();
            $searchColumns = ['id', 'total_amount', 'name', 'email', 'phone', 'screen_name', 'status'];
            $search = request()->search;
            $relation = ['getCity', 'getUser', 'getLocation', 'getScreen'];
            $bookings = $this->booking->with($relation);
            $order = request()->orderedColumn;
            $orderBy = request()->orderBy;
            $bookingType = request()->bookingType;
            $location = request()->location;
            $screen = request()->screen;

            if ($search != '') {
                $bookings->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
                $bookings->orWhereHas('getLocation', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
            }
            if ($location != '') {
                $bookings->where('location_id', $location);
            }
            if ($screen != '') {
                $bookings->where('screen_id', $screen);
            }
            // if ($bookingType != '') {
            //     $today = Carbon::today();
            //     switch ($bookingType) {
            //         case 'today':
            //             $bookings->where('book_date', $today);
            //             break;
            //         case 'upcoming':
            //             $bookings->where('book_date', '>', $today);
            //             break;
            //         case 'cancelled':
            //             $bookings->where('status', 'cancel');
            //             break;
            //         default:
            //             # code...
            //             break;
            //     }
            // }
            if ($order == 'timeslot') {
                if ($orderBy == 'desc') {
                    $bookings->orderByDesc(
                        BookingSlot::select('start_time')
                            ->whereColumn('booking_slots.booking_id', 'bookings.id')
                            ->orderBy('start_time', 'desc')
                            ->take(1)
                    );
                } else {
                    $bookings->orderBy(
                        BookingSlot::select('start_time')
                            ->whereColumn('booking_slots.booking_id', 'bookings.id')
                            ->orderBy('start_time', 'asc')
                            ->take(1)
                    );
                }
            } else {
                ($order == '') ? $bookings->orderByDesc('id') : $bookings->orderBy($order, $orderBy);
            }
            if (auth()->user()->hasRole('admin')) {
                $location = Location::where('user_id', auth()->user()->id)->first();
                $bookings = $bookings->where('location_id', $location->id)->orderBy('id', 'desc')->paginate(30);
            } else {
                $bookings = $bookings->orderBy('id', 'desc')->paginate(30);
            }
            $success['booking_list'] = $bookings;
            $success['locations'] = $locations;
            $success['screens'] = $screens;
            return view('admin.booking.list', $success);
        } catch (Exception $ex) {
            dd($ex);
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    // upcoming bookings
    public function upcomingBooking(Request $request)
    {
        try {
            $locations = $this->location->where('status', 1)->get();
            $searchColumns = ['id', 'total_amount', 'name', 'email', 'phone', 'screen_name', 'status'];
            $search = request()->search;
            $relation = ['getCity', 'getUser', 'getLocation', 'getScreen'];
            $bookings = $this->booking->with($relation);
            $order = request()->orderedColumn;
            $orderBy = request()->orderBy;
            $location = request()->location;

            if ($search != '') {
                $bookings->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
                $bookings->orWhereHas('getLocation', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
            }
            if ($location != '') {
                $bookings->where('location_id', $location);
            }
            if ($order == 'timeslot') {
                if ($orderBy == 'desc') {
                    $bookings->orderByDesc(
                        BookingSlot::select('start_time')
                            ->whereColumn('booking_slots.booking_id', 'bookings.id')
                            ->orderBy('start_time', 'desc')
                            ->take(1)
                    );
                } else {
                    $bookings->orderBy(
                        BookingSlot::select('start_time')
                            ->whereColumn('booking_slots.booking_id', 'bookings.id')
                            ->orderBy('start_time', 'asc')
                            ->take(1)
                    );
                }
            } else {
                ($order == '') ? $bookings->orderByDesc('id') : $bookings->orderBy($order, $orderBy);
            }
            $today = Carbon::today();
            // ->where('book_date','>',$today)
            $bookings = $bookings->where('book_date', '>', $today)->orderBy('id', 'desc')->paginate(10);
            return view('admin.booking.upcomingbooking', compact('bookings', 'locations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    // today's bookings
    public function todayBooking(Request $request)
    {
        try {
            $locations = $this->location->where('status', 1)->get();
            $searchColumns = ['id', 'total_amount', 'name', 'email', 'phone', 'screen_name', 'status'];
            $search = request()->search;
            $relation = ['getCity', 'getUser', 'getLocation', 'getScreen'];
            $bookings = $this->booking->with($relation);
            $order = request()->orderedColumn;
            $orderBy = request()->orderBy;
            $location = request()->location;

            if ($search != '') {
                $bookings->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
                $bookings->orWhereHas('getLocation', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
            }
            if ($location != '') {
                $bookings->where('location_id', $location);
            }
            if ($order == 'timeslot') {
                if ($orderBy == 'desc') {
                    $bookings->orderByDesc(
                        BookingSlot::select('start_time')
                            ->whereColumn('booking_slots.booking_id', 'bookings.id')
                            ->orderBy('start_time', 'desc')
                            ->take(1)
                    );
                } else {
                    $bookings->orderBy(
                        BookingSlot::select('start_time')
                            ->whereColumn('booking_slots.booking_id', 'bookings.id')
                            ->orderBy('start_time', 'asc')
                            ->take(1)
                    );
                }
            } else {
                ($order == '') ? $bookings->orderByDesc('id') : $bookings->orderBy($order, $orderBy);
            }
            $today = Carbon::today();
            // ->where('book_date','>',$today)
            $bookings = $bookings->where('book_date', $today)->orderBy('id', 'desc')->paginate(10);
            return view('admin.booking.todaybooking', compact('bookings', 'locations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    public function cancelledBooking(Request $request)
    {
        try {
            $locations = $this->location->where('status', 1)->get();
            $searchColumns = ['id', 'total_amount', 'name', 'email', 'phone', 'screen_name', 'status'];
            $search = request()->search;
            $relation = ['getCity', 'getUser', 'getLocation', 'getScreen'];
            $bookings = $this->booking->with($relation);
            $order = request()->orderedColumn;
            $orderBy = request()->orderBy;
            $location = request()->location;

            if ($search != '') {
                $bookings->where(function ($q) use ($search, $searchColumns) {
                    foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
                });
                $bookings->orWhereHas('getLocation', function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%');
                });
            }
            if ($location != '') {
                $bookings->where('location_id', $location);
            }
            if ($order == 'timeslot') {
                if ($orderBy == 'desc') {
                    $bookings->orderByDesc(
                        BookingSlot::select('start_time')
                            ->whereColumn('booking_slots.booking_id', 'bookings.id')
                            ->orderBy('start_time', 'desc')
                            ->take(1)
                    );
                } else {
                    $bookings->orderBy(
                        BookingSlot::select('start_time')
                            ->whereColumn('booking_slots.booking_id', 'bookings.id')
                            ->orderBy('start_time', 'asc')
                            ->take(1)
                    );
                }
            } else {
                ($order == '') ? $bookings->orderByDesc('id') : $bookings->orderBy($order, $orderBy);
            }
            $today = Carbon::today();
            // ->where('book_date','>',$today)
            $bookings = $bookings->where('status', 'cancel')->orderBy('id', 'desc')->paginate(10);
            return view('admin.booking.cancelledbooking', compact('bookings', 'locations'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $cities = $this->city->where('status', true)->get();
            return view('admin.booking.create', compact('cities'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $booking_id = $request->booking_id;

        $timeSlotDetails  = $request->items['timeSlot'];
        $basicDetails = $request->items['basicDetails'];
        $occasions = $request->items['occasions'] ?? null;
        $cakes = $request->items['cakes'] ?? null;
        $decorations = $request->items['decorations'] ?? null;
        $gifts = $request->items['gifts'] ?? null;
        $snacks = $request->items['snacks'] ?? null;
        $bouquets = $request->items['bouquets'] ?? null;
        $others = $request->items['others'] ?? null;

        DB::beginTransaction();
        try {
            $user = $this->addOrUpdateUser($basicDetails);
            $data = [
                'user_id'               => $user->id,
                'city_id'               => $timeSlotDetails['city_id'],
                'city_name'             => $timeSlotDetails['city_name'],

                'location_id'           => $timeSlotDetails['location_id'],
                'location_name'         => $timeSlotDetails['location_name'],

                'screen_id'             => $timeSlotDetails['screen_id'],
                'screen_name'           => $timeSlotDetails['screen_name'],
                'screen_capacity'       => $timeSlotDetails['screen_capacity'],

                'book_date'             => $timeSlotDetails['date'],
                'name'                  => $basicDetails['name'],
                'phone'                 => $basicDetails['phone'],
                'email'                 => $basicDetails['email'],
                'time_slot_amount'      => $request->total_slot_amount,
                'additional_amount'     => $request->total_additional_amount,
                'total_amount'          => $request->total,
                'gst_amount'            => $request->gst,
                'grand_total_amount'    => $request->grandTotal,
                'with_decoration'       => $request->decoration,
                'number_of_people'      => $basicDetails['no_of_people'],
                'status'                => $request->payment_status,
                'payment_type'          => $request->payment_type,
                'advance'               => $request->advance,
                'balance'               => $request->balance,
                'notes'                 => $request->notes,
            ];

            if ($booking_id) {
                $booking = $this->booking->find($booking_id);
                $booking->update($data);

                //delete all existing slots and items
                $booking->slots()->delete();
                $booking->items()->delete();
            } else {
                $booking = $this->booking->create($data);
            }
            $screen = Screen::find($timeSlotDetails['screen_id']);
            if (is_null($screen)) {
                config(['google-calendar.calendar_id' => 'primary']);
            } else {
                config(['google-calendar.calendar_id' => $screen->calendar_id]);
            }
            //add slots
            foreach ($timeSlotDetails['selectedSlots'] as $slot) {
                $timeArray = explode(" - ", $slot['slot']);
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
                $event_id = '';
                if ($request->payment_status == 'success') {
                    $startDtTime = Carbon::parse($timeSlotDetails['date'] . ' ' . $startTime, 'Asia/Kolkata');
                    $endDtTime = Carbon::parse($timeSlotDetails['date'] . ' ' . $endTime, 'Asia/Kolkata');
                    // dd($startDtTime, $endDtTime);
                    // dd("all okay");
                    $event = new Event;
                    $event->name = '[' . $timeSlotDetails['location_name'] . '] [' . $timeSlotDetails['screen_name'] . ']' . $basicDetails['name'];
                    $event->description = $request->notes;
                    $event->startDateTime = $startDtTime;
                    $event->endDateTime = $endDtTime;
                    $event_id=$event->save();
                    $event_id = $event_id->id;
                }
                $slot_data = [
                    'slot_id' => $slot['id'],
                    'slot_name' => $slot['slot'],
                    'amount' => $slot['amount'],
                    'additional_amount' => $slot['additional_amount'],
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'event_id' => $event_id,
                ];

                $booking->slots()->create($slot_data);
            }

            //add occasions
            $this->addItems($booking, 'Occasions', $occasions);

            //add cakes
            $this->addItems($booking, 'Cakes', $cakes);

            //add decorations
            $this->addItems($booking, 'Decorations', $decorations);

            //add gifts
            $this->addItems($booking, 'Gifts', $gifts);

            //add snacks
            $this->addItems($booking, 'Snacks', $snacks);

            //add bouquets
            $this->addItems($booking, 'Bouquets', $bouquets);

            //add others
            $this->addItems($booking, 'Others', $others);

            DB::commit();

            // send invoice emails
            if ($request->payment_status == 'success') {
                $this->sendInvoice($booking);
            }
            if ($request->payment_status == 'cancel') {
                $this->cancelMail($booking);
            }
            return response()->json([
                'success' => true,
                'message' => 'Booking successfully completed',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'response' => $e->getMessage()
            ]);
        }
    }


    public function addOrUpdateUser($basicDetails): User
    {
        $user = $this->user->where('phone', $basicDetails['phone'])->first();
        if (is_null($user)) {
            $useParams = [
                'name' => $basicDetails['name'],
                'email' => $basicDetails['email'],
                'phone' => $basicDetails['phone']
            ];
            $user = $this->user->create($useParams);
            $user->assignRole('customer');
            return $user;
        }
        return $user;
    }


    public function addItems($booking, $type, $items): void
    {
        if ($items && count($items) > 0) {
            foreach ($items['selectedItems'] as $itm) {
                $data = [
                    'type' => $type,
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

    // view details 
    public function show($id)
    {
        try {
            $booking = Booking::find($id);
            return view('admin.booking.show', compact('booking'));
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }

    // edit view
    public function edit($id)
    {

        $cities = $this->city->get();
        $booking = Booking::with('getScreen')->find($id);
        $booking_details = [
            'info' => $booking,
            'occasions' => $booking->items()->where('type', 'Occasions')->get(),
            'cakes' => $booking->items()->where('type', 'Cakes')->get(),
            'decorations' => $booking->items()->where('type', 'Decorations')->get(),
            'gifts' => $booking->items()->where('type', 'Gifts')->get(),
            'snacks' => $booking->items()->where('type', 'Snacks')->get(),
            'bouquets' => $booking->items()->where('type', 'Bouquets')->get(),
            'others' => $booking->items()->where('type', 'Others')->get(),
        ];
        return view('admin.booking.edit', compact('cities', 'booking_details'));
    }

    // delete booking
    public function destroy($id)
    {
        try {
            $deleted = $this->booking->whereId($id)->delete();
            if ($deleted) {
                return redirect()->back()->with('message', 'Successfully Deleted');
            } else {
                return redirect()->back()->with('error', '!!Sorry!! Internal server error');
            }
        } catch (Exception $ex) {
            return redirect()->back()->with('error', $ex->getMessage());
        }
    }
}
