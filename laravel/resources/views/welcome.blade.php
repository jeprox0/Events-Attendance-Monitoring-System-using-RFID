<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
/* Hide the close button */
.modal-header .btn-close {
  display: none !important;
}

.modal-header {
  border-bottom: none; /* Removes bottom border */
  padding: 0; /* Removes padding */
}
/* Remove the default modal backdrop */
.modal-backdrop {
  display: none !important;
}

/* Adjust the modal itself */
.modal {
  background: none !important; /* Completely remove the modal background */
}

/* Style the modal content to look good without a background */
.modal-dialog {
  margin: 0; /* Remove extra spacing */
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh; /* Center vertically */
}

.modal-content {
  border: none; /* Remove border */
  box-shadow: none; /* Remove shadow */
  background: none; /* Ensure no background */
}

/* Form container styling */
.form-container {
  background-color: rgba(17, 24, 39, 1); /* Dark background for the form */
  padding: 2rem;
  border-radius: 0.75rem;
  color: rgba(243, 244, 246, 1); /* Light text */
  max-width: 400px;
  margin: auto; /* Center horizontally */
}


.title {
  text-align: center;
  font-size: 1.5rem;
  line-height: 2rem;
  font-weight: 700;
}

.form {
  margin-top: 1.5rem;
}

.input-group {
  margin-top: 0.25rem;
  font-size: 0.875rem;
  line-height: 1.25rem;
}

.input-group label {
  display: block;
  color: rgba(156, 163, 175, 1);
  margin-bottom: 4px;
}

.input-group input {
  width: 100%;
  border-radius: 0.375rem;
  border: 1px solid rgba(55, 65, 81, 1);
  outline: 0;
  background-color: rgba(17, 24, 39, 1);
  padding: 0.75rem 1rem;
  color: rgba(243, 244, 246, 1);
}

.input-group input:focus {
  border-color: rgba(167, 139, 250);
}



.sign {
  display: block;
  width: 100%;
  background-color: rgba(167, 139, 250, 1);
  padding: 0.75rem;
  text-align: center;
  color: rgba(17, 24, 39, 1);
  border: none;
  border-radius: 0.375rem;
  font-weight: 600;
}

.social-message {
  display: flex;
  align-items: center;
  padding-top: 1rem;
}

.line {
  height: 1px;
  flex: 1 1 0%;
  background-color: rgba(55, 65, 81, 1);
}

.social-message .message {
  padding-left: 0.75rem;
  padding-right: 0.75rem;
  font-size: 0.875rem;
  line-height: 1.25rem;
  color: rgba(156, 163, 175, 1);
}

.social-icons {
  display: flex;
  justify-content: center;
}

.social-icons .icon {
  border-radius: 0.125rem;
  padding: 0.75rem;
  border: none;
  background-color: transparent;
  margin-left: 8px;
}

.social-icons .icon svg {
  height: 1.25rem;
  width: 1.25rem;
  fill: #fff;
}

.signup {
  text-align: center;
  font-size: 0.75rem;
  line-height: 1rem;
  color: rgba(156, 163, 175, 1);
}


        body {
            background-image: url('{{ asset('assets/img/cap5.jpg')}}');
            background-size: cover;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header {
    background-image: url('{{ asset('assets/img/main-logo-1 (1).png') }}');
    width: calc(100% - 20px); /* Full width minus the right margin */
    height: 100px; /* Adjust height as needed */
    background-repeat: no-repeat;
 
    background-size: contain;
    position: fixed; /* Fixed at the top */
    top: 0; /* No gap at the top */
    left: 300px; /* No gap at the left */
     /* Right margin of 20px */
    z-index: 1000; /* Keep it on top of other elements */
}


.header-container {
    display: flex;
    justify-content: space-between; /* Space between the two images */
    align-items: center;
    height: 100%; /* Ensure the container fills the height of the header */
    padding: 0 20px; /* Optional, adds space around the content */
}


.right-image {
    background-image: url('{{ asset('assets/img/csbo2.png') }}');
    width: 30%; /* Adjust width as needed */
    height: 90px; /* Adjust height as needed */
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    margin-right: 400px; /* Adjust the margin as needed */
}



        .login-popup {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100%;
            text-align: center;
        }

     /* From Uiverse.io by MuhammadHasann */ 
.button {
  --black-700: hsla(0 0% 12% / 1);
  --border_radius: 9999px;
  --transtion: 0.3s ease-in-out;
  --offset: 2px;

  cursor: pointer;
  position: relative;

  display: flex;
  align-items: center;
  gap: 0.5rem;

  transform-origin: center;

  padding: 1rem 2rem;
  background-color: transparent;

  border: none;
  border-radius: var(--border_radius);
  transform: scale(calc(1 + (var(--active, 0) * 0.1)));

  transition: transform var(--transtion);
}

.button::before {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  width: 80%;
  height: 80%;
  background-color: var(--black-700);

  border-radius: var(--border_radius);
  box-shadow: inset 0 0.5px hsl(0, 0%, 100%), inset 0 -1px 2px 0 hsl(0, 0%, 0%),
    0px 4px 10px -4px hsla(0 0% 0% / calc(1 - var(--active, 0))),
    0 0 0 calc(var(--active, 0) * 0.375rem) hsl(260 97% 50% / 0.75);

  transition: all var(--transtion);
  z-index: 0;
}

.button::after {
  content: "";
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  width: 100%;
  height: 100%;
  background-color: hsla(260 97% 61% / 0.75);
  background-image: radial-gradient(
      at 51% 89%,
      hsla(266, 45%, 74%, 1) 0px,
      transparent 50%
    ),
    radial-gradient(at 100% 100%, hsla(266, 36%, 60%, 1) 0px, transparent 50%),
    radial-gradient(at 22% 91%, hsla(266, 36%, 60%, 1) 0px, transparent 50%);
  background-position: top;

  opacity: var(--active, 0);
  border-radius: var(--border_radius);
  transition: opacity var(--transtion);
  z-index: 2;
}

.button:is(:hover, :focus-visible) {
  --active: 1;
}
.button:active {
  transform: scale(1);
}

.button .dots_border {
  --size_border: calc(100% + 2px);

  overflow: hidden;

  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  width: var(--size_border);
  height: var(--size_border);
  background-color: transparent;

  border-radius: var(--border_radius);
  z-index: -10;
}

.button .dots_border::before {
  content: "";
  position: absolute;
  top: 30%;
  left: 50%;
  transform: translate(-50%, -50%);
  transform-origin: left;
  transform: rotate(0deg);

  width: 100%;
  height: 2rem;
  background-color: white;

  mask: linear-gradient(transparent 0%, white 120%);
  animation: rotate 2s linear infinite;
}

@keyframes rotate {
  to {
    transform: rotate(360deg);
  }
}

.button .sparkle {
  position: relative;
  z-index: 10;

  width: 1.75rem;
}

.button .sparkle .path {
  fill: currentColor;
  stroke: currentColor;

  transform-origin: center;

  color: hsl(0, 0%, 100%);
}

.button:is(:hover, :focus) .sparkle .path {
  animation: path 1.5s linear 0.5s infinite;
}

.button .sparkle .path:nth-child(1) {
  --scale_path_1: 1.2;
}
.button .sparkle .path:nth-child(2) {
  --scale_path_2: 1.2;
}
.button .sparkle .path:nth-child(3) {
  --scale_path_3: 1.2;
}

@keyframes path {
  0%,
  34%,
  71%,
  100% {
    transform: scale(1);
  }
  17% {
    transform: scale(var(--scale_path_1, 1));
  }
  49% {
    transform: scale(var(--scale_path_2, 1));
  }
  83% {
    transform: scale(var(--scale_path_3, 1));
  }
}

.button .text_button {
  position: relative;
  z-index: 10;

  background-image: linear-gradient(
    90deg,
    hsla(0 0% 100% / 1) 0%,
    hsla(0 0% 100% / var(--active, 0)) 120%
  );
  background-clip: text;

  font-size: 1rem;
  color: transparent;
}


       
    body, html {
    margin: 0; /* Remove default margins */
    padding: 0; /* Remove default padding */
    width: 100%;
    height: 100%;
}


* {
    margin: 0;
    padding: 0;
    box-sizing: border-box; /* Ensures padding and borders don't add to element size */
}
        
    </style>

</head>
<body>


    <!-- Header with background image -->

    <header class="header">
        <div class="header-container">
            <div class="main-logo"></div>
            <div class="right-image"></div>
        </div>
    </header>

    <!-- Login button to trigger the modal -->
    <nav class="login-popup">
   
        <nav class="login-popup">
            <button class="button" data-bs-toggle="modal" data-bs-target="#loginModal">
                <div class="dots_border"></div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="sparkle">
                    <path class="path" stroke-linejoin="round" stroke-linecap="round" stroke="black" fill="black" 
                          d="M14.187 8.096L15 5.25L15.813 8.096C16.0231 8.83114 16.4171 9.50062 16.9577 10.0413C17.4984 10.5819 18.1679 10.9759 18.903 11.186L21.75 12L18.904 12.813C18.1689 13.0231 17.4994 13.4171 16.9587 13.9577C16.4181 14.4984 16.0241 15.1679 15.814 15.903L15 18.75L14.187 15.904C13.9769 15.1689 13.5829 14.4994 13.0423 13.9587C12.5016 13.4181 11.8321 13.0241 11.097 12.814L8.25 12L11.096 11.187C11.8311 10.9769 12.5006 10.5829 13.0413 10.0423C13.5819 9.50162 13.9759 8.83214 14.186 8.097L14.187 8.096Z"></path>
                    <path class="path" stroke-linejoin="round" stroke-linecap="round" stroke="black" fill="black" 
                          d="M6 14.25L5.741 15.285C5.59267 15.8785 5.28579 16.4206 4.85319 16.8532C4.42059 17.2858 3.87853 17.5927 3.285 17.741L2.25 18L3.285 18.259C3.87853 18.4073 4.42059 18.7142 4.85319 19.1468C5.28579 19.5794 5.59267 20.1215 5.741 20.715L6 21.75L6.259 20.715C6.40725 20.1216 6.71398 19.5796 7.14639 19.147C7.5788 18.7144 8.12065 18.4075 8.714 18.259L9.75 18L8.714 17.741C8.12065 17.5925 7.5788 17.2856 7.14639 16.853C6.71398 16.4204 6.40725 15.8784 6.259 15.285L6 14.25Z"></path>
                    <path class="path" stroke-linejoin="round" stroke-linecap="round" stroke="black" fill="black" 
                          d="M6.5 4L6.303 4.5915C6.24777 4.75718 6.15472 4.90774 6.03123 5.03123C5.90774 5.15472 5.75718 5.24777 5.5915 5.303L5 5.5L5.5915 5.697C5.75718 5.75223 5.90774 5.84528 6.03123 5.96877C6.15472 6.09226 6.24777 6.24282 6.303 6.4085L6.5 7L6.697 6.4085C6.75223 6.24282 6.84528 6.09226 6.96877 5.96877C7.09226 5.84528 7.24282 5.75223 7.4085 5.697L8 5.5L7.4085 5.303C7.24282 5.24777 7.09226 5.15472 6.96877 5.03123C6.84528 4.90774 6.75223 4.75718 6.697 4.5915L6.5 4Z"></path>
                </svg>
                <span class="text_button">Log in</span>
            </button>
        </nav>
        
        
    </nav>
    
<center>
    <!-- Modal Structure for Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-container">
                        <h2 class="title">{{ __('Login') }}</h2>
                        <form method="POST" action="{{ route('login') }}" class="form">
                            @csrf
                            <div class="input-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input 
                                    id="email" 
                                    type="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    required 
                                    autofocus 
                                    autocomplete="username" 
                                />
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="input-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input 
                                    id="password" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    autocomplete="current-password" 
                                />
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="forgot">
                                <label for="remember_me">
                                    <input id="remember_me" type="checkbox" name="remember">
                                    {{ __('Remember me') }}
                                </label>
                            </div>
                            <button type="submit" class="sign">
                                {{ __('Log in') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</center>
    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
