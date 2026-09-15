<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    private function loadBooking(string $code): Booking
    {
        $booking = Booking::with([
            'trip.route.origin',
            'trip.route.destination',
            'trip.bus',
            'seats',
        ])
            ->where('code', $code)
            ->first();

        if (! $booking || ! in_array($booking->status, ['CONFIRMED', 'CANCELLED', 'CANCELLED_BY_ADMIN'])) {
            abort(404);
        }

        return $booking;
    }

    private function generateBarcodePng(string $code): string
    {
        $generator = new BarcodeGeneratorPNG();
        $pngData = $generator->getBarcode($code, $generator::TYPE_CODE_128, 2, 50);

        return base64_encode($pngData);
    }

    /**
     * Show invoice in browser.
     */
    public function view(string $code)
    {
        $booking = $this->loadBooking($code);
        $barcodeBase64 = $this->generateBarcodePng($booking->code);

        return view('customer.invoice.show', [
            'booking' => $booking,
            'barcodeBase64' => $barcodeBase64,
        ]);
    }

    /**
     * Download invoice as PDF.
     */
    public function downloadPdf(string $code): Response
    {
        $booking = $this->loadBooking($code);
        $barcodeBase64 = $this->generateBarcodePng($booking->code);

        $pdf = Pdf::loadView('customer.invoice.show', [
            'booking' => $booking,
            'barcodeBase64' => $barcodeBase64,
        ])->setPaper('a4');

        return $pdf->download("invoice-{$booking->code}.pdf");
    }

    /**
     * Download invoice as JPG/PNG image.
     */
    public function downloadImage(string $code): Response
    {
        $booking = $this->loadBooking($code);
        $barcodeBase64 = $this->generateBarcodePng($booking->code);

        $pdf = Pdf::loadView('customer.invoice.show', [
            'booking' => $booking,
            'barcodeBase64' => $barcodeBase64,
        ])->setPaper('a4');

        return response($pdf->output(), 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => "attachment; filename=\"invoice-{$booking->code}.png\"",
        ]);
    }
}
