@include('themes.head');

<body>
    @include('themes.header');
    @include('themes.sidemenu');

    <main id="main" class="main">
        <!-- Border wrapper for the content -->
        <div class="container p-4" style="border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
            
            <div class="pagetitle d-flex justify-content-between align-items-center">
                <h1>Payment List</h1>
                
                <div>
                    <button type="button" class="cssbuttons-io-button" data-bs-toggle="modal" data-bs-target="#addEventModal">
                        <svg height="24" width="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z" fill="currentColor"></path>
                        </svg>
                        <span>Add</span>
                    </button>
                </div>
                
            </div><!-- End Page Title -->
            <br>
            
          

            <!-- Table wrapper with border -->
            <div style="border-top: 2px solid #ccc; padding-top: 20px; overflow: auto;">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Semester</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>OR #</th>
                            <th>Paid Amount</th>           
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr>
                            <td style="white-space: nowrap;">
                                @if ($payment->semester)
                                    {{ $payment->semester->school_year }} | {{ $payment->semester->semester }}
                                @else
                                    No Semester Assigned
                                @endif  
                            </td>
                            <td style="white-space: nowrap;">{{ $payment->payment_date->format('F j, Y') }}</td>
                            <td>{{ ucfirst($payment->student->first_name) }} {{ ucfirst($payment->student->last_name) }}</td>
                            <td style="white-space: nowrap;">{{ $payment->or_number }}</td>
                            <td>₱{{ number_format($payment->amount_paid, 2) }}</td>
                            
                            <td class="d-flex justify-content-between align-items-center">

                                <button type="button" class="Btn me-2" data-bs-toggle="modal" data-bs-target="#editContributionModal" 
                                    data-id="{{ $payment->id }}" 
                                    data-or_number="{{ $payment->or_number }}" 
                                    data-amount_paid="{{ $payment->amount_paid }}">
                                    Edit 
                                    <svg class="svg" viewBox="0 0 512 512">
                                        <path d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"></path>
                                    </svg>
                                </button>

                                <form id="delete-form-{{ $payment->id }}" action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" class="btn btn-danger" style="padding: 4px 8px; font-size: 0.9rem;" onclick="confirmDelete({{ $payment->id }})">
                                    Delete
                                </button>
                                
                                <script>
                                    function confirmDelete(id) {
                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: "You won't be able to revert this!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Yes, delete it!'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.getElementById('delete-form-' + id).submit();
                                            }
                                        });
                                    }
                                </script>
                                @if(session('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: '{{ session('success') }}',
                                        timer: 3000, // Auto close after 3 seconds
                                        showConfirmButton: false
                                    });
                                </script>
                            @endif
                            
                            
                            
                            @if(session('error'))
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: '{{ session('error') }}',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                </script>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- End of Table wrapper -->

            <!-- Add Student Modal -->
            @include('payments.create')
            @include('payments.edit')

        </div> <!-- End of container wrapper -->
    </main><!-- End #main -->

    <script>
        $('#example').DataTable();
    </script>
    
</body>
</html>
@include('themes.footer');
