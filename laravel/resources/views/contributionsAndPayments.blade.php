@include('themes.head')

<body>
@include('themes.header')
@include('themes.sidemenu')

<main id="main" class="main">
    <!-- Border wrapper for the content -->
    <div class="container p-4" style="border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Contributions and fines Total Summary</h1>

            <!-- Button wrapper for aligning the button to the right -->
           
        </div><!-- End Page Title -->
        <br>

      

        <!-- Table wrapper with border -->
        <div style="border-top: 2px solid #ccc; padding-top: 20px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Semester ID</th>
                        <th>Total Contributions for All Students (₱)</th>
                        <th>Total Fines for All Students(₱)</th>
                       
                       
                        <th>Total Amount Collected (₱)</th>
                        <th>Net Balance (₱)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($combinedTotals as $total)
                        <tr>
                            <td>{{ $total->semester->semester }}</td>
                            <td>₱{{ number_format($total->total_contribution_for_all_students, 2) }}</td>
                            <td>₱{{ number_format($total->total_fine, 2) }}</td>
                          
                           
                            <td>₱{{ number_format($total->total_paid, 2) }}</td>
                            <td>₱{{ number_format($total->net_balance, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

    </div> <!-- End of container wrapper -->
</main><!-- End #main -->

<!-- Include necessary JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>

@include('themes.footer')
