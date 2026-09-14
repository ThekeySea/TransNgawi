<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisaController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->input('period', '7days');
        $days = $period === '30days' ? 30 : 7;
        $startDate = now()->subDays($days);

        // Revenue from CONFIRMED bookings grouped by date
        $revenueByDay = Booking::where('bookings.status', 'CONFIRMED')
            ->where('bookings.created_at', '>=', $startDate)
            ->select(
                DB::raw('DATE(bookings.created_at) as date'),
                DB::raw('SUM(bookings.total) as revenue'),
                DB::raw('COUNT(*) as ticket_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        // Fill missing dates with zeros
        $dailyRevenue = [];
        $dailyTicketCount = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dailyRevenue[$date] = $revenueByDay->has($date) ? (int) $revenueByDay[$date]->revenue : 0;
            $dailyTicketCount[$date] = $revenueByDay->has($date) ? (int) $revenueByDay[$date]->ticket_count : 0;
        }

        // Total revenue and ticket sales
        $totalRevenue = Booking::where('bookings.status', 'CONFIRMED')
            ->where('bookings.created_at', '>=', $startDate)
            ->sum('bookings.total');
        $totalTickets = Booking::where('bookings.status', 'CONFIRMED')
            ->where('bookings.created_at', '>=', $startDate)
            ->count();

        // Average per ticket
        $avgTicket = $totalTickets > 0 ? $totalRevenue / $totalTickets : 0;

        // Revenue by service category
        $revenueByService = Booking::where('bookings.status', 'CONFIRMED')
            ->where('bookings.created_at', '>=', $startDate)
            ->join('trips', 'bookings.trip_id', '=', 'trips.id')
            ->join('routes', 'trips.route_id', '=', 'routes.id')
            ->select('routes.service_category', DB::raw('SUM(bookings.total) as revenue'), DB::raw('COUNT(*) as ticket_count'))
            ->groupBy('routes.service_category')
            ->get();

        // Revenue by class
        $revenueByClass = Booking::where('bookings.status', 'CONFIRMED')
            ->where('bookings.created_at', '>=', $startDate)
            ->join('booking_seats', 'bookings.id', '=', 'booking_seats.booking_id')
            ->select('booking_seats.class_name', DB::raw('SUM(booking_seats.fare_amount) as revenue'), DB::raw('COUNT(*) as ticket_count'))
            ->groupBy('booking_seats.class_name')
            ->get();

        // Top routes by revenue
        $topRoutes = Booking::where('bookings.status', 'CONFIRMED')
            ->where('bookings.created_at', '>=', $startDate)
            ->join('trips', 'bookings.trip_id', '=', 'trips.id')
            ->join('routes', 'trips.route_id', '=', 'routes.id')
            ->join('locations as origin', 'routes.origin_id', '=', 'origin.id')
            ->join('locations as destination', 'routes.destination_id', '=', 'destination.id')
            ->select('routes.origin_id', 'routes.destination_id', 'origin.name as origin_name', 'destination.name as destination_name', DB::raw('SUM(bookings.total) as revenue'), DB::raw('COUNT(*) as ticket_count'))
            ->groupBy('routes.origin_id', 'routes.destination_id', 'origin.name', 'destination.name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get();

        return view('admin.analisa.index', [
            'period' => $period,
            'days' => $days,
            'dailyRevenue' => $dailyRevenue,
            'dailyTicketCount' => $dailyTicketCount,
            'totalRevenue' => $totalRevenue,
            'totalTickets' => $totalTickets,
            'avgTicket' => $avgTicket,
            'revenueByService' => $revenueByService,
            'revenueByClass' => $revenueByClass,
            'topRoutes' => $topRoutes,
        ]);
    }
}
