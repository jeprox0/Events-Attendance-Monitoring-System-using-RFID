@include('layouts.head')



    @include('layouts.header')
    @include('layouts.sidemenu')

    <main id="main" class="main">
        <!-- Student Details Section -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $student->name }}</h5>
            </div>
            <div class="collapse show" id="studentDetails{{ $student->id }}">
                <div class="card-body">
                    @if($student->groupedContributions->isEmpty() && $student->fines->isEmpty())
                        <p>No contributions or fines found for this student.</p>
                    @else
                        <!-- Table Format -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>School Year/Semester</th>
                                    <th>Balance</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($student->groupedContributions as $semester_id => $semesterContributions)
                                    @php
                                        // Calculate Total Contributions, Fines, and Balance for the semester
                                        $totalContributions = $semesterContributions->sum('amount');
                                        $totalFines = $student->fines->where('event.semester_id', $semester_id)->sum('total_fine');
                                        $totalFees = $totalContributions + $totalFines;

                                        $totalPaid = $student->payments->where('semester_id', $semester_id)->sum('amount_paid');
                                        $balance = $totalFees - $totalPaid;
                                    @endphp

                                    <tr>
                                        <td>
                                            {{ $student->groupedContributions[$semester_id]->first()->semester->school_year }} | {{ $student->groupedContributions[$semester_id]->first()->semester->semester }}
                                        </td>
                                        <td>
                                            @if($balance == 0)
                                                <span class="text-success fw-bold">Paid</span>
                                            @else
                                                <span class="fw-bold text-danger">₱{{ number_format($balance, 2) }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-primary toggle-button" type="button" data-bs-toggle="collapse" data-bs-target="#semesterDetails{{ $student->id }}{{ $semester_id }}" aria-expanded="false" aria-controls="semesterDetails{{ $student->id }}{{ $semester_id }}">
                                                View
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Collapsible Section for Contributions and Fines -->
                                    <tr>
                                        <td colspan="3">
                                            <div class="collapse border p-3 mb-4" id="semesterDetails{{ $student->id }}{{ $semester_id }}">
                                                <!-- Contributions for the semester -->
                                                <div class="mb-3">
                                                    @if($semesterContributions->isEmpty())
                                                        <p>No contributions found for this semester.</p>
                                                    @else
                                                        <div class="mb-2 d-flex justify-content-between">
                                                            <strong>Contributions:</strong>
                                                            <span class="fw-bold">Amount</span>
                                                        </div>
                                                        <ul>
                                                            @foreach($semesterContributions as $contribution)
                                                                <li class="d-flex justify-content-between">
                                                                    <span>{{ ucfirst($contribution->type) }}</span>
                                                                    <span>₱{{ number_format((float)$contribution->amount, 2) }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>

                                                <!-- Fines for the semester -->
                                                <div class="mb-3">
                                                    <strong>Fines:</strong>
                                                    @if($student->fines->isEmpty())
                                                        <p>No fines found for this semester.</p>
                                                    @else
                                                        <ul>
                                                            @foreach($student->fines->where('event.semester_id', $semester_id) as $fine)
                                                                <li class="d-flex justify-content-between">
                                                                    <span>{{ $fine->event->event_name }}</span>
                                                                    <span>₱{{ number_format((float)$fine->total_fine, 2) }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>

                                                <!-- Total Fees, Paid, and Balance Calculation -->
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-bold text-primary">Total Fees:</span>
                                                        <span class="fw-bold text-primary">₱{{ number_format($totalFees, 2) }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-bold text-success">Total Paid:</span>
                                                        <span class="fw-bold text-success">₱{{ number_format($totalPaid, 2) }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-bold text-danger">Balance:</span>
                                                        @if($balance == 0)
                                                            <span class="text-success fw-bold">Paid</span>
                                                        @else
                                                            <span class="fw-bold text-danger">₱{{ number_format($balance, 2) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
        <!-- Remaining script and styles unchanged -->

    </main><!-- End #main -->

    @include('layouts.footer')

    
</body>
</html>
