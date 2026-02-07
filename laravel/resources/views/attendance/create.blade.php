<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Record Attendance</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        .header-logos {
    position: absolute;
    width: 100%;
    top: 10px;
    left: 0;
    display: flex;
    justify-content: space-between;
    padding: 0 20px; /* Add padding to keep logos from touching screen edges */
}

.left-logo, .right-logo {
    max-width: 150px; /* Adjust logo size */
    height: auto; /* Maintain aspect ratio */
}

        body {
            font-family: Arial, sans-serif;
            background-color: #4a81bb
        }

        .container {
            margin-top: 300px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 74vh;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.21);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 400px;
            
        }

        

        .card-header h5, h3 {
            margin: 0;
            color: rgb(0, 0, 0);
            font-size: 2em;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .card-header .time {
            position: absolute;
            left: 15px;
            margin-top: 100px;
            transform: translateY(-50%);
            font-size: 23px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background-color: rgba(0, 0, 0, 0);
            padding: 5px 10px;
            border-radius: 5px;
        }

        

        .form input, .form select {
            height: 45px;
            outline: none;
            border: 2px solid rgb(0, 0, 0);
            background: transparent;
            padding: 10px;
            border-radius: 5px;
            transition: .5s;
            color: rgb(0, 0, 0);
            font-size: 16px;
        }

        .form input:focus, .form select:focus {
            background: rgba(255, 255, 255, 0.311);
        }



        .alert {
            margin-top: 20px;
            border-radius: 4px;
        }

        .heading {
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            text-align: center;
        }

        .back-button a {
            text-decoration: none;
            color: #007bff;
            font-size: 16px;
            transition: color 0.3s;
        }

        .back-button a:hover {
            color: #0056b3;
        }
      /* Background Image */
.background-overlay {
    position: fixed;
    top: 0;
    left: 35px;
    width: 100%;
    height: 100vh; /* Full screen height */
    background-image: url('{{ asset('assets/img/cardbg-unscreen.gif') }}'); /* Add your new background */
    background-position: center center; /* Center the background */
    background-repeat: no-repeat; /* No repeating */

}

/* Center Image */
.center-logo {
    max-width: 500px; /* Adjust as needed */
    height: auto;
    position: absolute;
    left: 50%;
    transform: translateX(-50%); /* Centers it perfectly */
}
    </style>
</head>
<body>
    <div class="card-header"></div>
    <div class="background-overlay"></div> <!-- Background Image -->
    <div class="header-logos">
        <img src="{{ asset('assets/img/fccic.png') }}" alt="Left Logo" class="left-logo">
        <img src="{{ asset('assets/img/fcicname.png') }}" alt="Center Logo" class="center-logo">
        <img src="{{ asset('assets/img/csbo2.png') }}" alt="Right Logo" class="right-logo">
    </div>
    
    <div class="container">
        <div class="card mb-4 shadow-sm">
            <form class="form" id="attendance_form" action="{{ route('attendance.store') }}" method="POST">
                @csrf
                <!-- Hidden RFID input -->
                <input type="hidden" id="rfid" name="student_rfid">
    
                <!-- Input for event ID -->
                <input type="number" id="event_id" name="event_id" class="form-control" placeholder="Input Event ID" required>
    
                <!-- Read-only input to display event name -->
                <input type="text" id="event_name" class="form-control mt-2" placeholder="Event Name" readonly>
            </form>
        </div>
    </div>

        <!-- Success/Error Alerts -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>

    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.getElementById('event_id').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission

            let eventId = this.value;

            if (eventId) {
                axios.get('/get-events', { params: { id: eventId } })
                .then(function (response) {
                    if (response.data.success) {
                        document.getElementById('event_name').value = response.data.event_name;
                    } else {
                        document.getElementById('event_name').value = "Event not found";
                    }
                })
                .catch(function (error) {
                    console.error('Error fetching event name:', error);
                    document.getElementById('event_name').value = "Error fetching event";
                });
            }
        }
    });
        // Fetch the RFID and submit attendance
        function fetchRFID() {
            axios.get('http://localhost:5000/card')
                .then(function (response) {
                    if (response.data && response.data.uid) {
                        console.log('RFID detected:', response.data.uid);
                        document.getElementById('rfid').value = response.data.uid;

                        axios.post("{{ route('attendance.record') }}", {
                            rfid: response.data.uid,
                            event_id: document.getElementById('event_id').value
                        })
                        .then(function (response) {
                            if (response.data.success) {
                                Swal.fire({
                                    html: `
                                        <div class="text-center">
                                            <img src="{{ asset('assets/img/fcic2.png') }}" alt="School Logo" class="school-logo mb-3">
                                            <h5 style="font-weight: bold;">Franciscan College of The Immaculate Conception</h5>
                                            <img src="{{ asset('storage') }}/${response.data.student.picture}" alt="Student Picture" class="img-fluid student-picture mb-3" style="display: block; margin-left: auto; margin-right: auto;">
                                            
                                            <div class="student-info-box mb-3">
                                                <span class="label" style="font-weight: bold;">Name:</span>
                                                <span class="value" style="margin-left: 10px; font-weight: bold;">${response.data.student.first_name.toUpperCase()} ${response.data.student.last_name.toUpperCase()}</span>
                                            </div>

                                            <div class="student-info-box">
                                                <span class="label" style="font-weight: bold;">Course & Year:</span>
                                                <span class="value" style="margin-left: 10px; font-weight: bold;">${response.data.student.course_year.course_name} - ${response.data.student.course_year.year_level}</span>
                                            </div>
                                        </div>
                                    `,
                                    confirmButtonText: 'OK',
                                    timer: 10000,
                                    timerProgressBar: true,
                                    background: '#87CEEB',
                                    customClass: { popup: 'swal-custom-popup' },
                                    didClose: () => { refreshAttendanceList(); }
                                });
                            }
                        })
                        .catch(function (error) {
                            console.error('Error saving attendance:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: error.response.data.error || 'Failed to save attendance.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                timer: 10000,
                                timerProgressBar: true
                            });
                        });
                    }
                })
                .catch(function (error) {
                    console.error('Error fetching RFID:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error fetching RFID. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        timer: 10000,
                        timerProgressBar: true
                    });
                });
        }

        // Check for RFID every 2 seconds
        setInterval(fetchRFID, 2000);

        // Refresh attendance list
        function refreshAttendanceList() {
            var eventId = document.getElementById('event_id').value;

            axios.get("{{ route('attendance.index') }}", {
                params: { event_id: eventId }
            })
            .then(function (response) {
                document.querySelector('#example tbody').innerHTML = response.data;
            })
            .catch(function (error) {
                console.error('Error refreshing attendance list:', error);
            });
        }
    </script>


    <style>
    
    /* Ensure the student's picture is a square */
    .student-picture {
        width: 180px;
        height: 180px;
        object-fit: cover;  /* This makes sure the image fills the square without distortion */
        border-radius: 5px;  /* Slight rounding of corners */
    }
    
    /* Style for individual bordered boxes */
    .student-info-box {
        background-color: white;
        padding: 10px;
        border: 2px solid lightgray;  /* Separate borders for each section */
        border-radius: 5px;
        font-weight: bold;  /* Make the text bold */
    }
    
    /* Add spacing between sections */
    .mb-3 {
        margin-bottom: 15px;  /* Adjust the margin for better spacing */
    }
    
    /* Add some additional styling if necessary */
    .swal-custom-popup {
        border-radius: 15px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    
    
    .swal-content {
    text-align: center; /* Center content */
    }
    
    .swal-content img {
    width: 180px; /* Adjust image size */
    height: auto; /* Maintain aspect ratio */
    display: block;
    margin-left: auto;
    margin-right: auto;
    }
    .school-logo {
        max-width: 120px; /* Adjust the size of the logo */
        height: auto;    /* Maintain aspect ratio */
    }
    
    </style>        
</body>
</html>