<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use FPDF;

class AdminController extends Controller
{
    public function dashboard()
    {
        $bookings = Booking::with(['user', 'room', 'slot'])
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('booking_date')
            ->get();

        $rooms = Room::orderBy('room_name')->get();

        return view('admin.dashboard', compact('bookings', 'rooms'));
    }

    public function exportBookingsPdf()
    {
        $bookings = Booking::with(['user', 'room', 'slot'])
            ->orderBy('booking_date')
            ->get();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,'Reserve-Lab Booking Report',0,1,'C');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,10,'Generated on '.now()->format('F j, Y g:i A'),0,1,'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(30,10,'User',1);
        $pdf->Cell(30,10,'Room',1);
        $pdf->Cell(30,10,'Date',1);
        $pdf->Cell(30,10,'Slot',1);
        $pdf->Cell(30,10,'Status',1);
        $pdf->Ln();

        $pdf->SetFont('Arial','',10);
        foreach($bookings as $booking) {
            $pdf->Cell(30,10,substr($booking->user->name, 0, 15),1);
            $pdf->Cell(30,10,substr($booking->room->room_name, 0, 15),1);
            $pdf->Cell(30,10,$booking->booking_date->format('M j, Y'),1);
            $pdf->Cell(30,10,substr($booking->slot->label, 0, 15),1);
            $pdf->Cell(30,10,ucfirst($booking->status),1);
            $pdf->Ln();
        }

        return response($pdf->Output('S'), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reserve-lab-bookings-'.now()->format('Ymd').'.pdf"',
        ]);
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
        ]);

        if (! in_array($booking->status, ['pending', 'approved'])) {
            return back()->with('error', 'Status cannot be changed.');
        }

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated successfully.');
    }
}
