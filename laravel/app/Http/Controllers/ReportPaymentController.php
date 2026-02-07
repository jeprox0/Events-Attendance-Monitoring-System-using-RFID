<?php

namespace App\Http\Controllers;

use App\Models\Fine;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportPaymentController extends Controller
{
    public function showFinancialReport()
    {
        $studentCount = Student::count();
    
        // Get the total contributions grouped by semester and multiplied by the student count
        $totalContributionsBySemester = Contribution::selectRaw('semester_id, SUM(amount) as total_contribution')
            ->groupBy('semester_id')
            ->get()
            ->map(function ($contribution) use ($studentCount) {
                $contribution->total_contribution_for_all_students = $contribution->total_contribution * $studentCount;
                return $contribution;
            });
    
        // Get the total fines grouped by semester
        $totalFinesBySemester = Fine::join('events', 'fines.event_id', '=', 'events.id')
            ->selectRaw('events.semester_id, SUM(fines.amount) as total_fine')
            ->groupBy('events.semester_id')
            ->get();
    
        // Get the total payments grouped by semester
        $totalPaymentsBySemester = Payment::selectRaw('semester_id, SUM(amount_paid) as total_paid')
            ->groupBy('semester_id')
            ->get();
    
        // Combine contributions, fines, and payments by semester
        $combinedTotals = $totalContributionsBySemester->map(function ($contribution) use ($totalFinesBySemester, $totalPaymentsBySemester) {
            $semesterId = $contribution->semester_id;
    
            // Match the corresponding fines and payments for the semester
            $matchingFine = $totalFinesBySemester->firstWhere('semester_id', $semesterId);
            $totalFine = $matchingFine ? $matchingFine->total_fine : 0;
    
            $matchingPayment = $totalPaymentsBySemester->firstWhere('semester_id', $semesterId);
            $totalPaid = $matchingPayment ? $matchingPayment->total_paid : 0;
    
            // Calculate total amount with fines and net balance
            $contribution->total_fine = $totalFine;
            $contribution->total_paid = $totalPaid;
            $contribution->total_amount_with_fines = $contribution->total_contribution_for_all_students + $totalFine;
            $contribution->net_balance = $contribution->total_amount_with_fines - $totalPaid;
    
            return $contribution;
        });
    
        // Pass the combined totals to the view
        return view('contributionsAndPayments', compact('combinedTotals'));
    }
}    