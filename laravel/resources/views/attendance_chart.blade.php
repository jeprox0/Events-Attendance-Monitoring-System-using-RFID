@include('themes.head')

<body>
@include('themes.header')
@include('themes.sidemenu')

<main id="main" class="main">
    <div class="container p-4" style="border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Attendance Summary - Pie Chart</h1>
        </div>
        <br>

        <!-- Filter by Event -->
        <form action="{{ route('attendance_chart') }}" method="GET" class="mb-3">
            <label for="eventFilter" class="form-label">Select Event:</label>
            <select name="event_id" id="eventFilter" class="form-select" onchange="this.form.submit()">
                <option value="">All Events</option>
                @foreach($events as $event)
                    <option value="{{ $event->id }}" {{ request('event_id') == $event->id ? 'selected' : '' }}>
                        {{ $event->event_name }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Chart Container -->
        <canvas id="attendancePieChart"></canvas>

    </div>
</main>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('attendancePieChart').getContext('2d');
        const chartData = {
            labels: @json($labels),
            datasets: [{
                label: 'Students Present',
                data: @json($data),
                backgroundColor: [
                    '#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#9966ff', '#ff9f40'
                ],
                hoverOffset: 4
            }]
        };

        new Chart(ctx, {
            type: 'pie',
            data: chartData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>

@include('themes.footer')
