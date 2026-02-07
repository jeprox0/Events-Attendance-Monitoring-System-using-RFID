@foreach($students as $student)
    <!-- Student Details Modal -->
    <div class="modal fade" id="studentDetailsModal{{ $student->id }}" tabindex="-1" aria-labelledby="studentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentDetailsModalLabel">Student Fees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($student->groupedContributions->isEmpty() && $student->fines->isEmpty())
                        <p>No contributions or fines found for this student.</p>
                    @else
                        <!-- Table Format -->
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>School Year/Semester</th>
                                    <th>Balance</th> <!-- New Balance Header -->
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
                                        <!-- Semester and School Year -->
                                        <td>
                                            {{ $student->groupedContributions[$semester_id]->first()->semester->school_year }} - {{ $student->groupedContributions[$semester_id]->first()->semester->semester }}
                                        </td>
                                        <td>
                                            @if($balance == 0)
                                                <span class="text-success fw-bold">Paid</span>
                                            @else
                                                <span class="fw-bold text-danger">₱{{ number_format($balance, 2) }}</span>
                                            @endif
                                        </td>
                                        <!-- Action with View/Close Button -->
                                        <td>
                                            <button class="btn btn-primary toggle-button" type="button" data-bs-toggle="collapse" data-bs-target="#semesterDetails{{ $student->id }}{{ $semester_id }}" aria-expanded="false" aria-controls="semesterDetails{{ $student->id }}{{ $semester_id }}">
                                                View
                                            </button>
                                        </td>

                                        <!-- Balance Column -->
                                      
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
    .toggle-button {
        transition: background-color 0.3s;
    }

    .toggle-button:hover {
        background-color: #0056b3; /* Darker shade on hover */
        color: white;
    }
</style>

<script>
    document.querySelectorAll('.toggle-button').forEach(button => {
        button.addEventListener('click', function() {
            const target = document.querySelector(this.getAttribute('data-bs-target'));
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            // Close all other collapses before opening the new one
            document.querySelectorAll('.collapse').forEach(collapse => {
                if (collapse !== target) {
                    bootstrap.Collapse.getInstance(collapse)?.hide();
                    // Reset button text to "View" for all others
                    document.querySelector(`button[data-bs-target="#${collapse.id}"]`).innerText = 'View';
                }
            });

            // Toggle the current button text based on the collapse state
            this.innerText = isExpanded ? 'View' : 'Close';

            // Toggle aria-expanded manually to ensure consistency
            this.setAttribute('aria-expanded', !isExpanded);

            // Manually handle Bootstrap collapse toggle if necessary
            if (isExpanded) {
                bootstrap.Collapse.getInstance(target)?.hide();
            } else {
                bootstrap.Collapse.getInstance(target)?.show();
            }
        });
    });
</script>
