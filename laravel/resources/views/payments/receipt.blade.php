<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .receipt {
            border: 1px solid #000;
            padding: 20px;
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        .receipt h1 {
            margin-bottom: 20px;
        }

        .receipt p {
            margin: 10px 0;
        }

        .receipt-footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="receipt">
    <h1>Payment Receipt</h1>
   
    <p><strong>Student Name:</strong> {{ ucfirst($payment->student->first_name) }} {{ ucfirst($payment->student->last_name) }}</p>
    <p><strong>Amount Paid:</strong> ₱{{ number_format($payment->amount_paid, 2) }}</p>
    <p><strong>Remaining Balance:</strong> ₱{{ number_format($balance, 2) }}</p> <!-- Balance Display -->
    <p><strong>Payment Date:</strong> {{ date('F d, Y', strtotime($payment->payment_date)) }}</p>
   
    <p><strong>OR Number:</strong> {{ $payment->or_number }}</p>
    <div class="receipt-footer">
        <p>Thank you for your payment!</p>
    </div>
</div>

<!-- Auto-trigger print dialog and redirect after print/cancel -->
<script>
    window.onload = function() {
        window.print();

        // After print dialog is closed, redirect to the payments index
        window.onafterprint = function() {
            window.location.href = "{{ route('payments.index') }}";
        };
    };
</script>

</body>
</html>
