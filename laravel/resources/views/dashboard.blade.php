@include('themes.head')

<body>
@include('themes.header')
@include('themes.sidemenu')
<style>
    /* General Styling for Info Cards */
    .info-card {
        border-radius: 10px; /* Smooth border corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Shadow for depth */
        min-height: 200px; /* Adjust height if needed */
    }

    /* Specific Card Colors */
    .student-card {
        border: 2px solid #4caf50; /* Green border */
        background-color: #e8f5e9; /* Light green background */
    }

    .upcoming-events-card {
        border: 2px solid #2196f3; /* Blue border */
        background-color: #e3f2fd; /* Light blue background */
    }

    .ongoing-events-card {
        border: 2px solid #ff9800; /* Orange border */
        background-color: #fff3e0; /* Light orange background */
    }

    .recent-activity-card {
        border: 2px solid #9c27b0; /* Purple border */
        background-color: #f3e5f5; /* Light purple background */
    }

    /* General Container Styling */
    .container {
        border: 2px solid #9e9e9e; /* Neutral gray border */
        border-radius: 10px;
        background-color: #f9f9f9;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>

<main id="main" class="main">
    <div class="container p-4">

        <!-- Page Title -->
        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Dashboard</h1>
        </div>
        <br>

        <section class="section dashboard">
            <div class="row">

                <!-- Left Side Columns -->
                <div class="col-lg-8">
                    <div class="row">

                        <!-- Total Students Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card student-card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Students</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-circle"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $totalStudents }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upcoming Events Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card upcoming-events-card">
                                <div class="card-body">
                                    <h5 class="card-title">Upcoming Events <span>| Total</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-calendar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $totalUpcomingEvents }}</h6>
                                            <span class="text-success small pt-1 fw-bold">New</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ongoing Events Card -->
                        <div class="col-xxl-4 col-xl-12">
                            <div class="card info-card ongoing-events-card">
                                <div class="card-body">
                                    <h5 class="card-title">Ongoing Events <span>| Today</span></h5>
                                    <ul class="list-group">
                                        @if($ongoingEvents->isEmpty())
                                            <li class="list-group-item">No ongoing events found.</li>
                                        @else
                                            @foreach($ongoingEvents as $event)
                                                <li class="list-group-item">
                                                    <h6>{{ ucfirst($event->event_name) }}</h6>
                                                    <p>{{ $event->description }}</p>
                                                    <small>Date: {{ $event->start_date }}</small><br>
                                                    <small>Time: {{ $event->starttime_am ?? '' }} - {{ $event->endtime_am ?? '' }}</small><br>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Side Columns -->
                <div class="col-lg-4">

                    <!-- Recent Activity Card -->
                    <div class="card info-card recent-activity-card">
                        <div class="card-body">
                            <h5 class="card-title">Recent Activity <span>| Completed Events</span></h5>
                            <div class="activity">
                                @foreach($completedEvents as $event)
                                    @php
                                        $endtime = $event->endtime_pm ?? $event->endtime_am;
                                        $eventEndTime = \Carbon\Carbon::parse($endtime);
                                        $timeAgo = $eventEndTime->diffForHumans();
                                    @endphp

                                    <div class="activity-item d-flex">
                                        <div class="activite-label">{{ $timeAgo }}</div>
                                        <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                        <div class="activity-content">
                                            {{ $event->event_name }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
</body>

@include('themes.footer')
