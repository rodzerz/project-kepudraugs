<?php



namespace App\Http\Controllers;



use App\Models\Booking;



use App\Models\Message;



use App\Models\Pet;



use App\Models\SitterProfile;



use App\Models\User;



use Carbon\Carbon;



use Illuminate\Http\Request;



use Illuminate\Support\Facades\Auth;



use Illuminate\Support\Facades\DB;



use Illuminate\Validation\ValidationException;



class BookingController extends Controller



{



    public function create($sitter)



    {



        if (Auth::user()->role !== 'owner') {



            abort(403);



        }



        $sitterProfile = SitterProfile::with('user')



            ->whereHas('user', function ($query) {



                $query->where('role', 'sitter')



                    ->where('is_blocked', false);



            })



            ->findOrFail($sitter);



        $pets = Pet::where('user_id', Auth::id())



            ->orderBy('name')



            ->get();



        return view('bookings.create', compact('sitterProfile', 'pets'));



    }



    public function index()



    {



        if (Auth::user()->role !== 'owner') {



            abort(403);



        }



        $bookings = Auth::user()->ownerBookings()



            ->with('sitter')



            ->latest()



            ->paginate(10);



        return view('bookings.index', compact('bookings'));



    }



    public function sitterBookings()



    {



        if (Auth::user()->role !== 'sitter') {



            abort(403);



        }



        $bookings = Auth::user()->sitterBookings()



            ->with('owner')



            ->latest()



            ->paginate(10);



        return view('bookings.sitter', compact('bookings'));



    }



    public function store(Request $request)



    {



        if (Auth::user()->role !== 'owner') {



            abort(403);



        }



        $validated = $request->validate([



            'sitter_id' => 'required|integer|exists:users,id',



            'pet_id' => 'required|integer|exists:pets,id',



            'booking_date' => 'required|date_format:Y-m-d|after_or_equal:today',



            'start_time' => 'required|date_format:H:i',



            'end_time' => 'required|date_format:H:i|after:start_time',



            'message' => 'nullable|string|max:5000',



        ]);



        $bookingStart = Carbon::parse(



            $validated['booking_date'] . ' ' . $validated['start_time']



        );



        if ($bookingStart->lessThanOrEqualTo(now())) {



            throw ValidationException::withMessages([



                'start_time' => 'Rezervācijas sākuma laikam jābūt nākotnē.',



            ]);



        }



        DB::transaction(function () use ($validated) {



            /*



            |--------------------------------------------------------------------------



            | Bloķē pieskatītāja lietotāja ierakstu transakcijas laikā



            |--------------------------------------------------------------------------



            |



            | Visi vienlaicīgie rezervāciju izveides pieprasījumi vienam



            | pieskatītājam tiek apstrādāti secīgi.



            |



            */



            // Pārbauda, ka izvēlētais mājdzīvnieks pieder pieslēgtajam īpašniekam.



            $pet = Pet::whereKey($validated['pet_id'])



                ->where('user_id', Auth::id())



                ->first();



            if (!$pet) {



                throw ValidationException::withMessages([



                    'pet_id' => 'Izvēlētais mājdzīvnieks nav pieejams tavā profilā.',



                ]);



            }



            $sitter = User::whereKey($validated['sitter_id'])



                ->lockForUpdate()



                ->firstOrFail();



            if ($sitter->role !== 'sitter' || $sitter->is_blocked) {



                throw ValidationException::withMessages([



                    'sitter_id' => 'Izvēlētais pieskatītājs nav pieejams.',



                ]);



            }



            // Iegūst stundas likmi no datubāzes, nevis no lietotāja formas.



            $sitterProfile = SitterProfile::where('user_id', $sitter->id)



                ->first();







            if (!$sitterProfile) {



                throw ValidationException::withMessages([



                    'sitter_id' => 'Izvēlētajam pieskatītājam nav profila.',



                ]);



            }



            /*



            |--------------------------------------------------------------------------



            | Pārbauda laika pārklāšanos



            |--------------------------------------------------------------------------



            */



            $hasConflict = Booking::where('sitter_id', $sitter->id)



                ->where('booking_date', $validated['booking_date'])



                ->whereIn('status', ['pending', 'accepted'])



                ->where('start_time', '<', $validated['end_time'])



                ->where('end_time', '>', $validated['start_time'])



                ->exists();



            if ($hasConflict) {



                throw ValidationException::withMessages([



                    'booking_date' =>



                        'Šajā datumā un laikā pieskatītājs jau ir aizņemts.',



                ]);



            }



            /*



            |--------------------------------------------------------------------------



            | Izveido rezervāciju



            |--------------------------------------------------------------------------



            */



            // Aprēķina rezervācijas ilgumu minūtēs.



            $start = Carbon::parse(



                $validated['booking_date'] . ' ' . $validated['start_time']



            );



            $end = Carbon::parse(



                $validated['booking_date'] . ' ' . $validated['end_time']



            );



            $minutes = (int) round($start->diffInMinutes($end));







            // Naudas aprēķins centos, lai izvairītos no float neprecizitātes.



            $rate = number_format((float) $sitterProfile->price, 2, '.', '');



            [$euros, $cents] = explode('.', $rate);



            $hourlyCents = ((int) $euros * 100) + (int) $cents;







            if ($hourlyCents <= 0) {



                throw ValidationException::withMessages([



                    'sitter_id' => 'Pieskatītājam nav norādīta derīga stundas likme.',



                ]);



            }







            // Noapaļo gala cenu līdz tuvākajam centam.



            $totalCents = intdiv($hourlyCents * $minutes + 30, 60);



            $totalPrice = sprintf('%d.%02d', intdiv($totalCents, 100), $totalCents % 100);







            $booking = Booking::create([



                'owner_id' => Auth::id(),



                'sitter_id' => $sitter->id,



                'pet_id' => $pet->id,



                'pet_type' => $pet->species,



                'booking_date' => $validated['booking_date'],



                'start_time' => $validated['start_time'],



                'end_time' => $validated['end_time'],



                'message' => $validated['message'] ?? null,



                'status' => 'pending',



            ]);







            // Saglabā cenu rezervācijas brīdī. Nav atkarīgs no $fillable.



            $booking->total_price = $totalPrice;



            $booking->save();







            /*



            |--------------------------------------------------------------------------



            | Sākotnējā ziņa tajā pašā transakcijā



            |--------------------------------------------------------------------------



            */



            if (!empty($validated['message'])) {



                Message::create([



                    'booking_id' => $booking->id,



                    'sender_id' => Auth::id(),



                    'receiver_id' => $sitter->id,



                    'message' => $validated['message'],



                ]);



            }



        }, 3);



        return redirect('/dashboard')



            ->with(



                'success',



                'Rezervācijas pieprasījums veiksmīgi nosūtīts!'



            );



    }



    public function accept($booking)



    {



        if (Auth::user()->role !== 'sitter') {



            abort(403);



        }



        DB::transaction(function () use ($booking) {



            $reservation = Booking::findOrFail($booking);



            if ($reservation->sitter_id !== Auth::id()) {



                abort(403);



            }



            // Izmanto to pašu pieskatītāja bloķēšanas kārtību



            // kā rezervācijas izveidē.



            User::whereKey(Auth::id())



                ->lockForUpdate()



                ->firstOrFail();



            $reservation = Booking::whereKey($booking)



                ->lockForUpdate()



                ->firstOrFail();



            if ($reservation->status !== 'pending') {



                throw ValidationException::withMessages([



                    'booking' => 'Šo rezervāciju vairs nevar pieņemt.',



                ]);



            }



            $reservationStart = Carbon::parse(



                $reservation->booking_date . ' ' . $reservation->start_time



            );



            if ($reservationStart->lessThanOrEqualTo(now())) {



                throw ValidationException::withMessages([



                    'booking' => 'Rezervāciju ar pagājušu sākuma laiku nevar pieņemt.',



                ]);



            }



            $hasConflict = Booking::where(



                'sitter_id',



                $reservation->sitter_id



            )



                ->whereKeyNot($reservation->id)



                ->where('booking_date', $reservation->booking_date)



                ->where('status', 'accepted')



                ->where('start_time', '<', $reservation->end_time)



                ->where('end_time', '>', $reservation->start_time)



                ->exists();



            if ($hasConflict) {



                throw ValidationException::withMessages([



                    'booking' =>



                        'Šajā laikā jau ir cita apstiprināta rezervācija.',



                ]);



            }



            $reservation->update([



                'status' => 'accepted',



            ]);



        }, 3);



        return redirect('/bookings/sitter')



            ->with('success', 'Rezervācija ir pieņemta!');



    }



    public function reject($booking)



    {



        if (Auth::user()->role !== 'sitter') {



            abort(403);



        }



        $reservation = Booking::findOrFail($booking);



        if ($reservation->sitter_id !== Auth::id()) {



            abort(403);



        }



        if ($reservation->status !== 'pending') {



            return redirect('/bookings/sitter')



                ->with('error', 'Šo rezervāciju vairs nevar noraidīt!');



        }



        $reservation->update([



            'status' => 'rejected',



        ]);



        return redirect('/bookings/sitter')



            ->with('success', 'Rezervācija ir noraidīta!');



    }



    public function complete($booking)



    {



        if (Auth::user()->role !== 'sitter') {



            abort(403);



        }



        $reservation = Booking::findOrFail($booking);



        if ($reservation->sitter_id !== Auth::id()) {



            abort(403);



        }



        if ($reservation->status !== 'accepted') {



            return redirect('/bookings/sitter')



                ->with('error', 'Šo rezervāciju nevar atzīmēt kā pabeigtu!');



        }



        $reservationEnd = Carbon::parse(



            $reservation->booking_date . ' ' . $reservation->end_time



        );



        if ($reservationEnd->isFuture()) {



            return redirect('/bookings/sitter')



                ->with(



                    'error',



                    'Rezervāciju var pabeigt tikai pēc tās beigu laika!'



                );



        }



        $reservation->update([



            'status' => 'completed',



        ]);



        return redirect('/bookings/sitter')



            ->with(



                'success',



                'Rezervācija ir atzīmēta kā pabeigta!'



            );



    }



    public function cancel($booking)



    {



        if (Auth::user()->role !== 'owner') {



            abort(403);



        }



        $reservation = Booking::findOrFail($booking);



        if ($reservation->owner_id !== Auth::id()) {



            abort(403);



        }



        if (!in_array($reservation->status, ['pending', 'accepted'])) {



            return redirect('/bookings')



                ->with('error', 'Šo rezervāciju vairs nevar atcelt!');



        }



        $reservationStart = Carbon::parse(



            $reservation->booking_date . ' ' . $reservation->start_time



        );



        if ($reservationStart->lessThanOrEqualTo(now())) {



            return redirect('/bookings')



                ->with(



                    'error',



                    'Rezervāciju nevar atcelt pēc tās sākuma laika!'



                );



        }



        $reservation->update([



            'status' => 'cancelled',



        ]);



        return redirect('/bookings')



            ->with('success', 'Rezervācija ir atcelta!');



    }




    public function sitterCancel($booking)
    {
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        DB::transaction(function () use ($booking) {
            // Pārbauda, ka rezervācija pieder pieslēgtajam pieskatītājam.
            $reservation = Booking::findOrFail($booking);

            if ($reservation->sitter_id !== Auth::id()) {
                abort(403);
            }

            // Vienota bloķēšanas secība ar rezervāciju izveidi un pieņemšanu.
            User::whereKey(Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            $reservation = Booking::whereKey($booking)
                ->lockForUpdate()
                ->firstOrFail();

            if ($reservation->status !== 'accepted') {
                throw ValidationException::withMessages([
                    'booking' => 'Atcelt var tikai pieņemtu rezervāciju.',
                ]);
            }

            $reservationStart = Carbon::parse(
                $reservation->booking_date . ' ' . $reservation->start_time
            );

            if ($reservationStart->lessThanOrEqualTo(now())) {
                throw ValidationException::withMessages([
                    'booking' => 'Rezervāciju nevar atcelt pēc tās sākuma laika.',
                ]);
            }

            $reservation->update(['status' => 'cancelled']);
        }, 3);

        return redirect('/bookings/sitter')
            ->with('success', 'Rezervācija veiksmīgi atcelta!');
    }

}