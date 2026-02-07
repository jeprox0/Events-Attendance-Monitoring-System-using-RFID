<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fine;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Semester;
use Illuminate\Support\Str;
use App\Models\Contribution;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
{
    $students = Student::all();
    $payments = Payment::with('student')->get();
    $semesters = Semester::all();
    foreach ($payments as $payment) {
        // Ensure payment_date is a Carbon instance
        $payment->payment_date = Carbon::parse($payment->payment_date);
    }

    return view('payments.index', compact('payments', 'students', 'semesters'));
}

    public function create()
    {
        // Pass students to the create view for selection
        $students = Student::all();
        return view('payments.create', compact('students'));
    }
    public function getBalance($studentId, $semesterId)
    {
        // Sum all fines for the specific student and semester (join fines with events to filter by semester)
        $totalFines = Fine::where('student_id', $studentId)
                          ->whereHas('event', function ($query) use ($semesterId) {
                              $query->where('semester_id', $semesterId);
                          })
                          ->sum('amount');
    
        // Sum contributions for the specific semester
        $totalContributions = Contribution::where('semester_id', $semesterId)->sum('amount');
    
        // Sum all payments already made by the student for the specific semester
        $totalPayments = Payment::where('student_id', $studentId)
                                ->where('semester_id', $semesterId) // Filter payments by semester
                                ->sum('amount_paid');
    
        // Total balance = (Fines + Contributions) - Payments
        $balance = ($totalFines + $totalContributions) - $totalPayments;
    
        return response()->json(['balance' => $balance]);
    }
    
    
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'student_id' => 'required|exists:students,id', // Validate that the student exists
            'amount_paid' => 'required|numeric',
            'semester_id' => 'required|exists:semesters,id', // Ensure semester_id is provided and exists
        ]);
    
        // Generate a unique OR number with the format "CSBO-random 6 numbers"
        $orNumber = 'CSBO-' . mt_rand(100000, 999999);
    
        // Get the currently logged-in user
        $loggedInUser = auth()->user();
    
        // Create the payment
        $payment = Payment::create([
            'student_id' => $request->student_id,
            'amount_paid' => $request->amount_paid,
            'or_number' => $orNumber,
            'semester_id' => $request->semester_id, // Include semester_id in the payment record
            'user_id' => $loggedInUser->id, // Associate the logged-in user with the payment
        ]);
    
        // Redirect to the receipt page with the payment details
        return redirect()->route('payments.receipt', ['payment' => $payment->id]);
    }
    

public function receipt(Payment $payment)
{
    // Calculate the balance for the student in the specific semester
    $totalFines = Fine::where('student_id', $payment->student_id)->sum('amount');
    $totalContributions = Contribution::where('semester_id', $payment->semester_id)->sum('amount');
    $totalPayments = Payment::where('student_id', $payment->student_id)
                            ->where('semester_id', $payment->semester_id)
                            ->sum('amount_paid');

    // Calculate the balance
    $balance = ($totalFines + $totalContributions) - $totalPayments;

    // Pass the payment and balance data to the receipt view
    return view('payments.receipt', compact('payment', 'balance'));
}



    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment successfully deleted.');
    }


    public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'or_number' => 'required|string|max:255',
        'amount_paid' => 'required|numeric|min:0',
    ]);

    // Find the payment by ID
    $payment = Payment::findOrFail($id);

    // Update the payment details
    $payment->or_number = $request->or_number; // If you want to change OR number, remove readonly
    $payment->amount_paid = $request->amount_paid;

    // Save the changes to the database
    $payment->save();

    // Redirect back with a success message
    return redirect()->route('payments.index')->with('success', 'Payment updated successfully!');
}

}
