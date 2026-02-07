@include('layouts.head')

<body>
    @include('layouts.header')
    @include('layouts.sidemenu')

    <main id="main" class="main">
        <!-- Border wrapper for the content -->
        <div class="container p-4" style="border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

            <!-- Page Title -->
            <div class="pagetitle d-flex justify-content-between align-items-center">
                <h1>Dashboard</h1>
            </div>
            <!-- End Page Title -->

            <br>

            <section class="section dashboard">
                <div class="row">

                    <!-- Upcoming and Ongoing Events Section -->
                    <div class="col-lg-12">
                        <div class="row">

                            <!-- Upcoming Events Card -->
                            <div class="col-xxl-4 col-md-4 mb-4">
                                <div class="card info-card events-card" style="border: 1px solid #4CAF50;">
                                    <div class="card-body">
                                        <h5 class="card-title text-success">Upcoming Events <span>| Total: {{ $totalUpcomingEvents }}</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success text-white">
                                                <i class="bi bi-calendar"></i>
                                            </div>
                                            <div class="ps-3">
                                                <span class="text-success small pt-1 fw-bold">New</span>
                                            </div>
                                        </div>

                                        <!-- Display list of upcoming events -->
                                        <ul class="mt-3">
                                            @foreach($upcomingEvents as $event)
                                                <li>
                                                    <strong>{{ $event->event_name }}</strong>
                                                    <span class="text-muted"> - {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Upcoming Events Card -->

                            <!-- Ongoing Events Card -->
                            <div class="col-xxl-4 col-md-4 mb-4">
                                <div class="card info-card events-card" style="border: 1px solid #FFC107;">
                                    <div class="card-body">
                                        <h5 class="card-title text-warning">Ongoing Events <span>| Today</span></h5>
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
                            <!-- End Ongoing Events Card -->

                            <!-- Missed Events Card -->
                            <div class="col-xxl-4 col-md-4 mb-4">
                                <div class="card info-card events-card" style="border: 1px solid #FF5722;">
                                    <div class="card-body">
                                        <h5 class="card-title text-danger">Missed Events <span>| Total: {{ $finedEventIds->count() }}</span></h5>
                                        <div class="d-flex align-items-center">
                                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-danger text-white">
                                                <i class="bi bi-x-circle"></i>
                                            </div>
                                            <div class="ps-3">
                                                <span class="text-danger small pt-1 fw-bold">Fined</span>
                                            </div>
                                        </div>

                                        <!-- Display list of missed events -->
                                        <ul class="mt-3">
                                            @foreach($finedEventIds as $eventId)
                                                @php
                                                    $event = \App\Models\Event::find($eventId);
                                                @endphp
                                                @if($event)
                                                    <li>
                                                        <strong>{{ $event->event_name }}</strong>
                                                        <span class="text-muted"> - {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}</span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Missed Events Card -->

                        </div>
                    </div>
                    <!-- End Upcoming and Ongoing Events Section -->

                    <!-- Right side columns -->
                    <div class="col-lg-4">
                        <!-- Recent Activity Card -->
                        <!-- Add content here -->
                    </div>
                    <!-- End Right side columns -->

                </div>
            </section>
        </div>
        <!-- End container -->
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
</body>

@include('layouts.footer')
