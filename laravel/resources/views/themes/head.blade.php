<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">


  <meta content="" name="description">
  <meta content="" name="keywords">
  
  <!-- Favicons 


<body onload="hideLoading()">
    <div id="loading-screen" class="active">
        <div class="spinner"></div>
    </div>
    -->
  <!-- Google Fonts -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <!--
  <script>
    function hideLoading() {
        document.getElementById('loading-screen').classList.remove('active');
    }

    window.onload = function() {
        hideLoading();
    };
    -->
</script>
 {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
        <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
        
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"> --}}
       

    
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.bootstrap.min.css"> =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

 

  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.bootstrap5.css">
<style>
  
   /* Loading Screen Styles 
    #loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        visibility: hidden; /* Initially hidden */
     /*}

    #loading-screen.active {
        visibility: visible; /* Show when active */
     /*}

    .spinner {
        border: 6px solid #f3f3f3; /* Light grey */
        /* border-top: 6px solid #3498db; /* Blue 
        /* border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

*/


.cssbuttons-io-button {
  display: flex;
  align-items: center;
  font-family: inherit;
  cursor: pointer;
  font-weight: 300;
  font-size: 12px;
  padding: 0.3em 2em 0.3em 2em; /* Reduced top and bottom padding */
  min-width: 150px; /* Set a minimum width */
  color: white;
  background: #ad5389;
  background: linear-gradient(
    0deg,
    rgba(20, 167, 62, 1) 0%,
    rgba(102, 247, 113, 1) 100%
  );
  border: none;
  box-shadow: 0 0.7em 1.5em -0.5em #14a73e98;
  letter-spacing: 0.05em;
  border-radius: 20em;
}

.cssbuttons-io-button svg {
  margin-right: 6px;
}

.cssbuttons-io-button:hover {
  box-shadow: 0 0.5em 1.5em -0.5em #14a73e98;
}

.cssbuttons-io-button:active {
  box-shadow: 0 0.3em 1em -0.5em #14a73e98;
}

.btn-info {
  --fs: 13px;
  --col1: honeydew;
  --col2: rgba(240, 128, 128, 0.603);
  --col3: rgb(79, 149, 255);
  --col4: rgb(0, 72, 117);
  --pd: .5em .65em;
  display: grid;
  align-content: baseline;
  appearance: none;
  border: 0;
  grid-template-columns: min-content 1fr;
  padding: var(--pd);
  font-size: var(--fs);
  color: var(--col1);
  background-color: var(--col3);
  border-radius: 6px;
  text-shadow: 1px 1px var(--col4);
  box-shadow: inset -2px 1px 1px var(--col2),
    inset 2px 1px 1px var(--col2);
  position: relative;
  transition: all .75s ease-out;
  transform-origin: center;
}

.btn-info:hover {
  color: var(--col4);
  box-shadow: inset -2px 1px 1px var(--col2),
    inset 2px 1px 1px var(--col2),
    inset 0px -2px 20px var(--col4),
    0px 20px 30px var(--col3),
    0px -20px 30px var(--col2),
    1px 2px 20px var(--col4);
  text-shadow: 1px 1px var(--col2);
}

.btn-info:active {
  animation: offset 1s ease-in-out infinite;
  outline: 2px solid var(--col2);
  outline-offset: 0;
}

.btn-info::after,
.btn-info::before {
  content: '';
  align-self: center;
  justify-self: center;
  height: .5em;
  margin: 0 .5em;
  grid-column: 1;
  grid-row: 1;
  opacity: 1;
}

.btn-info::after {
  position: relative;
  border: 2px solid var(--col4);
  border-radius: 50%;
  transition: all .5s ease-out;
  height: .1em;
  width: .1em;
}

.btn-info:hover::after {
  border: 2px solid var(--col3);
  transform: rotate(-120deg) translate(10%, 140%);
}

.btn-info::before {
  border-radius: 50% 0%;
  border: 4px solid var(--col4);
  box-shadow: inset 1px 1px var(--col2);
  transition: all 1s ease-out;
  transform: rotate(45deg);
  height: .45em;
  width: .45em;
}

.btn-info:hover::before {
  border-radius: 50%;
  border: 4px solid var(--col1);
  transform: scale(1.25) rotate(0deg);
  animation: blink 1.5s ease-out 1s infinite alternate;
}

.btn-info:hover > span {
  filter: contrast(150%);
}

@keyframes blink {
  0% {
    transform: scale(1, 1) skewX(0deg);
    opacity: 1;
  }

  5% {
    transform: scale(1.5, .1) skewX(10deg);
    opacity: .5;
  }

  10%, 35% {
    transform: scale(1, 1) skewX(0deg);
    opacity: 1;
  }

  40% {
    transform: scale(1.5, .1) skewX(10deg);
    opacity: .25;
  }

  45%, 100% {
    transform: scale(1, 1) skewX(0deg);
    opacity: 1;
  }
}

@keyframes offset {
  50% {
    outline-offset: .15em;
    outline-color: var(--col1);
  }

  55% {
    outline-offset: .1em;
    transform: translateY(1px);
  }

  80%, 100% {
    outline-offset: 0;
  }
}
/* From Uiverse.io by vinodjangid07 */ 
.Btn {
  font-size: 12px;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 70px;
  height: 32px;
  border: none;
  padding: 0px 20px;
  background-color: rgb(168, 38, 255);
  color: white;
  font-weight: 500;
  cursor: pointer;
  border-radius: 5px;

  transition-duration: .10s;
}

.svg {
  width: 13px;
  position: absolute;
  right: 0;
  margin-right: 20px;
  fill: white;
  transition-duration: .3s;
}

.Btn:hover {
  color: transparent;
}

.Btn:hover svg {
  right: 43%;
  margin: 0;
  padding: 0;
  border: none;
  transition-duration: .3s;
}

.Btn:active {
  transform: translate(3px , 3px);
  transition-duration: .3s;
  box-shadow: 2px 2px 0px rgb(140, 32, 212);
} 
</style>
</head>