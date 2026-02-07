@include('userlayouts.head')

<body>
@include('userlayouts.header')
@include('userlayouts.sidemenu')

<main id="main" class="main">
    <!-- Border wrapper for the content -->
    <div class="container p-4" style="border: 2px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 0 10px rgba(0,0,0,0.1);">

        <div class="pagetitle d-flex justify-content-between align-items-center">
            <h1>Dashboard</h1>
        </div><!-- End Page Title -->
        <br>
        <section class="section dashboard">
            <div class="row">
              
                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">

                    <!-- Upcoming Events Card -->
<div class="col-xxl-6 col-md-6">
    <div class="card info-card events-card">
        <div class="card-body">
            <h5 class="card-title">Upcoming Events <span>| Total: {{ $totalUpcomingEvents }}</span></h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
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
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card events-card">
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
                        </div><!-- End Ongoing Events Card -->

                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">

                   <!-- Recent Activity Card -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Recent Activity <span>| Completed Events</span></h5>
        <div class="activity">
            @foreach($completedEvents as $event)
                @php
                    $endtime = $event->endtime_pm ?? $event->endtime_am;
                @endphp

                <div class="activity-item d-flex" data-endtime="{{ $endtime }}">
                    <div class="activite-label time-ago">{{ \Carbon\Carbon::parse($endtime)->diffForHumans() }}</div>
                    <i class="bi bi-circle-fill activity-badge text-success align-self-start"></i>
                    <div class="activity-content">
                        {{ $event->event_name }}
                    </div>
                </div><!-- End activity item-->
            @endforeach
        </div>
    </div>
</div><!-- End Recent Activity -->

                </div><!-- End Right side columns -->

            </div>
        </section>
    </div><!-- End container -->
</main>
<script>
    function updateTimeAgo() {
        document.querySelectorAll('.activity-item').forEach(item => {
            const endtime = item.getAttribute('data-endtime');
            if (endtime) {
                // Parse the date using Moment.js
                const eventEndTime = moment(endtime);
                const now = moment();
                
                // Calculate the relative time using Moment.js
                const timeAgo = eventEndTime.from(now);

                // Update the display text
                item.querySelector('.time-ago').innerText = timeAgo;
            }
        });
    }

    // Update every minute
    setInterval(updateTimeAgo, 60000);
    // Initial update on load
    updateTimeAgo();
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js"></script>
</body>

@include('userlayouts.footer')
