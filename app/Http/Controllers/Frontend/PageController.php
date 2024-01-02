<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\Cake;
use App\Models\City;
use App\Models\Decoration;
use App\Models\Gift;
use App\Models\Location;
use App\Models\Package;
use App\Models\Screen;
use App\Models\User;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:dashboard', ['only' => ['dashboard']]);
    }
    public function index()
    {
        $client = new Client();
        $client->setApplicationName("Binge Club");
        $client->setClientId('1066054823323-5kma5k24tnuhit6khbgmvnpf2ohistod.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri('http://127.0.0.1:1023/googleCalendar');
        $client->addScope('https://www.googleapis.com/auth/calendar'); // Add necessary scopes

        if (!isset($_GET['code'])) {
            // Redirect to Google's OAuth 2.0 consent screen to get an authorization code
            $authUrl = $client->createAuthUrl();
            header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
            exit; // Ensure the script stops execution after redirection
        } else {
            // Exchange authorization code for an access token
            $client->authenticate($_GET['code']);
            $accessToken = $client->getAccessToken();

            // Create a Calendar service using the obtained access token
            $service = new Calendar($client);

            // Create a new calendar
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary('Dc Calendar'); // Replace with your calendar's name
            $calendar->setTimeZone('Asia/Kolkata'); // Replace with your timezone (e.g., 'Asia/Kolkata')

            // Insert the calendar into the user's account
            $createdCalendar = $service->calendars->insert($calendar);

            echo 'Calendar ID: ' . $createdCalendar->getId();
            // Optionally, store $accessToken securely for future use
        }
    }
    public function dashboard()
    {
        $cities = City::count();
        $locations = Location::count();
        $screens = Screen::count();
        $bookings = Booking::count();
        $currentMonth = Carbon::now()->startOfMonth();
        if (auth()->user()->hasRole('admin')) {
            $location = Location::where('user_id', auth()->user()->id)->first();
            $total_amount = Booking::where('created_at', '>=', $currentMonth)->where('location_id', $location->id)->where('status', 'success')
                ->sum('grand_total_amount');
        } else {
            $total_amount = Booking::where('created_at', '>=', $currentMonth)->where('status', 'success')
                ->sum('grand_total_amount');
        }
        $packages = Package::count();
        $cakes = Cake::count();
        $gifts = Gift::count();
        $decorations = Decoration::count();
        return view('admin.dashboard', compact('cities', 'locations', 'screens', 'bookings', 'packages', 'cakes', 'gifts', 'decorations', 'total_amount'));
    }
    public function screenList(Request $request)
    {
        $city = $request->city;
        $location = $request->location;
        if ($city) {
            $locations = Location::where('city_id', $city)->where('status', 1)->get();
            $screens = Screen::where('city_id', $city)->where('status', 1)->get();
        } else {
            $city = 1;
            $locations = Location::where('city_id', $city)->where('status', 1)->get();
            $screens = Screen::where('city_id', $city)->where('status', 1)->get();
        }
        if ($location) {
            $screens = Screen::where('location_id', $location)->where('status', 1)->get();
        } else {
            $location = Location::where('city_id', $city)->where('status', 1)->first()?->id;
            $screens = Screen::where('location_id', $location)->where('status', 1)->get();
        }
        return view('frontend.book.screenlist', compact('locations', 'screens'));
    }
    public function allCustomers()
    {
        $searchColumns = ['id', 'name', 'email', 'phone'];
        $search = request()->search;

        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'customer');
        });

        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;


        $users->whereHas('roles', function ($query) {
            $query->where('name', 'customer');
        });

        if ($search != '') {
            $users->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });
        }

        ($order == '') ? $users->orderByDesc('id') : $users->orderBy($order, $orderBy);
        $lists = $users->orderBy('id', 'desc')->paginate(10);
        return view('admin.customer.list', compact('lists'));
    }

    public function screenDetails($id)
    {
        $screen = Screen::find($id);
        return view('frontend.book.screenDetails', compact('screen'));
    }
    public function checkout()
    {
        return view('frontend.book.checkout');
    }
    public function userDataGet()
    {
        return view('frontend.book.userdata');
    }
    public function thankyouPage()
    {
        return view('frontend.book.thankyou');
    }

    public function userProfile()
    {
        return view('admin.profile');
    }
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                $this->uniqueExcept('users', 'email', $user->id),
            ],
            'phone' => [
                'required',
                $this->uniqueExcept('users', 'phone', $user->id),
            ],
            'confirm_password' => 'same:password',
        ]);
        if (!empty($request->password)) {
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
        }
        return redirect()->route('dashboard')->with('message', 'Profile updated successfully');
    }
    protected function uniqueExcept($table, $column, $id)
    {
        return Rule::unique($table, $column)->ignore($id);
    }

    public function blogs()
    {
        $blogs = Blog::all();
        return  view('frontend.blog', compact('blogs'));
    }
    public function blogDetails($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        return view('frontend.blogdetails', compact('blog'));
    }
}
