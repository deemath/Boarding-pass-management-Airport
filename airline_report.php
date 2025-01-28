<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['FULLNAME'])) {
    // Display alert
    echo "<script>";
    echo "alert('Logging in is required to access  form.');";
    echo "window.location.href = './index.php';";
    echo "</script>";
    exit; // Ensure script stops execution after displaying alert and redirecting
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Report</title>
    <link rel="icon" type="image/x-icon" href="img/BP_Icon.png">
    <link rel="stylesheet" href="./global_styles.css">
    <link href="./bootstrap_icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./DataTables/datatables.min.css">

    <style>
        @font-face {
            font-family: 'Acumin Variable Concept';
            src: url('./assets/font/AcuminVariableConcept-WideExtraLight.ttf');
        }

        html,
        body {
            background: #ECF0F1;
            /* off white background color */
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Acumin Variable Concept', sans-serif;
            overflow-y: hidden;
            /* Prevent scrolling of the entire page */
        }

        .page {
            display: flex;
            flex-direction: column;
            height: 100vh;
            /* Full viewport height */
            position: relative;
            overflow-y: auto;
            /* Enable scrolling within .page if content exceeds viewport height */
        }

        .content {
            flex: 1;
            /* Adjust to occupy remaining space */
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Center content horizontally */
            justify-content: center;
            /* Center content vertically */
        }

        .img_dashbord {
            height: auto;
            /* Adjust image height */
            max-width: 80%;
            /* Ensure images don't exceed container width */
        }

        .para_text_ {
            font-size: 15px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* Center columns horizontally */
            align-items: center;
            /* Center columns vertically */
            height: 100%;
            /* Make the row take the full height of the container */
        }

        .col-3 {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Center content horizontally */
            justify-content: center;
            /* Center content vertically */
            margin-bottom: 20px;
            /* Add margin to separate the rows */
        }

        .col-3 p {
            margin-top: 10px;
            /* Space between image and text */
        }
    </style>
</head>

<body>

    <div class="page">
        <div class="header">
            <?php include './assets/navi.php'; ?>
        </div>

        <main class="content">
            <div class="container text-center">
                <div style="display: flex; justify-content: right">
                    <div>
                        <?php if ($_SESSION['USER_TYPE'] == 'Admin'): ?>
                            <a href="./airline_email.php" class="btn btn-primary my-3">Add Airline Email</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=SU">
                            <img src="airline img/Aeroflot-Logo.png" alt="Aeroflot" class="image-dashboatd-style">
                        </a>
                        <p>Aeroflot</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=G9">
                            <img src="airline img/Air Arabia - 3L.png" alt="Air Arabia - 3L"
                                class="image-dashboatd-style">
                        </a>
                        <p>Air Arabia - 3L</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=AK">
                            <img src="airline img/Air Asia Berhad - AK.png" alt="Air Asia Berhad - AK"
                                class="image-dashboatd-style">
                        </a>
                        <p>Air Asia Berhad - AK</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=KC">
                            <img src="airline img/Air Astana - KC.png" alt="Air Astana - KC"
                                class="image-dashboatd-style">
                        </a>
                        <p>Air Astana - KC</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=CA">
                            <img src="airline img/Air China - CA.png" alt="Air China - CA"
                                class="image-dashboatd-style">
                        </a>
                        <p>Air China - CA</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=AI">
                            <img src="airline img/Air India - AI.jpg" alt="Air India - AI"
                                class="image-dashboatd-style">
                        </a>
                        <p>Air India - AI</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=HM">
                            <img src="airline img/Air Seychelles - HM.png" alt="Air Seychelles - HM"
                                class="image-dashboatd-style">
                        </a>
                        <p>Air Seychelles - HM</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=AC">
                            <img src="airline img/Air_Canada_Logo.png" alt="Air Canada" class="image-dashboatd-style">
                        </a>
                        <p>Air Canada</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=AF">
                            <img src="airline img/Air_France_Logo_PNG_(10).png" alt="Air France"
                                class="image-dashboatd-style">
                        </a>
                        <p>Air France</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=OZ">
                            <img src="airline img/asiana-airlines-logo-alt.png" alt="Asiana Airlines"
                                class="image-dashboatd-style">
                        </a>
                        <p>Asiana Airlines</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=OS">
                            <img src="airline img/austria.png" alt="Austria" class="image-dashboatd-style">
                        </a>
                        <p>Austria</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=ZF">
                            <img src="airline img/Azur Air - ZF.png" alt="Azur Air - ZF" class="image-dashboatd-style">
                        </a>
                        <p>Azur Air - ZF</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=OD">
                            <img src="airline img/batik-air-logo-alt.png" alt="Batik Air" class="image-dashboatd-style">
                        </a>
                        <p>Batik Air</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=BA">
                            <img src="airline img/British-Airways-Logo.png" alt="British Airways"
                                class="image-dashboatd-style">
                        </a>
                        <p>British Airways</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=CX">
                            <img src="airline img/Cathay Pacific - CX.jpg" alt="Cathay Pacific - CX"
                                class="image-dashboatd-style">
                        </a>
                        <p>Cathay Pacific - CX</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=MU">
                            <img src="airline img/China Eastern - MU.jpg" alt="China Eastern - MU"
                                class="image-dashboatd-style">
                        </a>
                        <p>China Eastern - MU</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=CZ">
                            <img src="airline img/China_Southern_logo_PNG.png" alt="China Southern"
                                class="image-dashboatd-style">
                        </a>
                        <p>China Southern</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=OQ">
                            <img src="airline img/chongqing-airlines-logo-alt.png" alt="Chongqing Airlines"
                                class="image-dashboatd-style">
                        </a>
                        <p>Chongqing Airlines</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=WK">
                            <img src="airline img/Edelweiss Air - WK.png" alt="Edelweiss Air - WK"
                                class="image-dashboatd-style">
                        </a>
                        <p>Edelweiss Air - WK</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=EK">
                            <img src="airline img/Emirates - EK.png" alt="Emirates - EK" class="image-dashboatd-style">
                        </a>
                        <p>Emirates - EK</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=EN">
                            <img src="airline img/Enter Air - E4.png" alt="Enter Air - E4"
                                class="image-dashboatd-style">
                        </a>
                        <p>Enter Air - E4</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=ET">
                            <img src="airline img/Ethiopian-Airlines-Logo.png" alt="Ethiopian Airlines"
                                class="image-dashboatd-style">
                        </a>
                        <p>Ethiopian Airlines</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=EY">
                            <img src="airline img/Etihad Airways - EY.png" alt="Etihad Airways - EY"
                                class="image-dashboatd-style">
                        </a>
                        <p>Etihad Airways - EY</p>
                    </div>
                    <div class="image-style">
                        <a href="airline_passenger.php?airline=AY">
                            <img src="airline img/Finnair-Logo.webp" alt="Finnair" class="image-dashboatd-style">
                        </a>
                        <p>Finnair</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=AY"><img
                                src="airline img/Finnair-Logo.webp" alt="Finnair" class="image-dashboatd-style"></a>
                        <p>Finnair Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=8D"><img
                                src="airline img/fitsair-logo-alt.png" alt="Fitsair" class="image-dashboatd-style"></a>
                        <p>Fits Air</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=FZ"><img
                                src="airline img/FlyDubai.png" alt="FlyDubai" class="image-dashboatd-style"></a>
                        <p>FlyDubai</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=GF"><img
                                src="airline img/Gulf Air - GF.png" alt="Gulf Air - GF"
                                class="image-dashboatd-style"></a>
                        <p>Gulf Air</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=6E"><img
                                src="airline img/Indigo Airlines - 6E.png" alt="Indigo Airlines - 6E"
                                class="image-dashboatd-style"></a>
                        <p>Indigo Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=IR"><img
                                src="airline img/iran-airlines.png" alt="Iran Airlines"
                                class="image-dashboatd-style"></a>
                        <p>Iran Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=IZ"><img
                                src="airline img/israel airlines.png" alt="Israel Airlines"
                                class="image-dashboatd-style"></a>
                        <p>Israel Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=JL"><img
                                src="airline img/Japan_Airlines-Logo.wine.png" alt="Japan Airlines"
                                class="image-dashboatd-style"></a>
                        <p>Japan Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=J9"><img
                                src="airline img/Jazeera Airways - J9.png" alt="Jazeera Airways - J9"
                                class="image-dashboatd-style"></a>
                        <p>Jazeera Airways</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=9W"><img
                                src="airline img/Jet-Airways-Logo.png" alt="Jet Airways"
                                class="image-dashboatd-style"></a>
                        <p>Jet Airways</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=KE"><img
                                src="airline img/Korean_Air_logo_PNG.png" alt="Korean Air"
                                class="image-dashboatd-style"></a>
                        <p>Korean Air</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=KU"><img
                                src="airline img/Kuwait_Airways-Logo.wine.png" alt="Kuwait Airways"
                                class="image-dashboatd-style"></a>
                        <p>Kuwait Airways</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=SV"><img
                                src="airline img/Logo-saudi-arabian-airlines-transparent-PNG.png"
                                alt="Saudi Arabian Airlines" class="image-dashboatd-style"></a>
                        <p>Saudi Arabian Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=MH"><img
                                src="airline img/Malaysia Airlines - MH.jpg" alt="Malaysia Airlines - MH"
                                class="image-dashboatd-style"></a>
                        <p>Malaysia Airline</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=Q2"><img
                                src="airline img/maldivian-logo-alt.png" alt="Maldivian"
                                class="image-dashboatd-style"></a>
                        <p>Maldivian Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=NO"><img
                                src="airline img/Neos_(airline)-Logo.wine.png" alt="Neos Airlines"
                                class="image-dashboatd-style"></a>
                        <p>Neos Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=WY"><img
                                src="airline img/Oman Air - WY.png" alt="Oman Air" class="image-dashboatd-style"></a>
                        <p>Oman Air</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=LO"><img
                                src="airline img/polish.png" alt="Polish Airlines" class="image-dashboatd-style"></a>
                        <p>Polish Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=QF"><img
                                src="airline img/qantas-logo-alt.png" alt="Qantas Air"
                                class="image-dashboatd-style"></a>
                        <p>Qantas Air</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=QR"><img
                                src="airline img/Qatar Airways - QR.png" alt="Qatar Airlines"
                                class="image-dashboatd-style"></a>
                        <p>Qatar Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=FV"><img
                                src="airline img/rossiya.jpg" alt="Rossiya Airlines - SV"
                                class="image-dashboatd-style"></a>
                        <p>Rossiya Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=RL"><img
                                src="airline img/royal flight.png" alt="Royal Flight Airlines"
                                class="image-dashboatd-style"></a>
                        <p>Royal Flight Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=MI"><img
                                src="airline img/SilkAir-Logo.wine.png" alt="SilkAir" class="image-dashboatd-style"></a>
                        <p>SilkAir</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=SQ"><img
                                src="airline img/Singapore Airlines - SQ.png" alt="SilkAir"
                                class="image-dashboatd-style"></a>
                        <p>Singapore Airline</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=7O"><img
                                src="airline img/Smartwings-Logo.wine.png" alt="SilkAir"
                                class="image-dashboatd-style"></a>
                        <p>Smartwings Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=SJ"><img
                                src="airline img/sriwijaya-air-logo-alt.png" alt="SilkAir"
                                class="image-dashboatd-style"></a>
                        <p>Sriwijaya Air</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=OV"><img
                                src="airline img/salamair-logo-alt.png" alt="SalamAir"
                                class="image-dashboatd-style"></a>
                        <p>SalamAir</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=SG"><img
                                src="airline img/SpiceJet - SG.webp" alt="SpiceJet - SG"
                                class="image-dashboatd-style"></a>
                        <p>SpiceJet</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=UL"><img
                                src="airline img/Srilankan Airlines - UL.png" alt="Srilankan Airlines - UL"
                                class="image-dashboatd-style"></a>
                        <p>Srilankan Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=LX"><img src="airline img/swiss.png"
                                alt="Swiss Airlines - UL" class="image-dashboatd-style"></a>
                        <p>Swiss Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=TG"><img
                                src="airline img/Thai-Airways.jpg" alt="Thai Airways" class="image-dashboatd-style"></a>
                        <p>Thai Airways</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=TK"><img
                                src="airline img/Turkish Airlines - TK.png" alt="Turkish Airlines - TK"
                                class="image-dashboatd-style"></a>
                        <p>Turkish Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=SL"><img
                                src="airline img/thai-lion-air.png" alt="Thai Airways"
                                class="image-dashboatd-style"></a>
                        <p>Thai Lion Airways</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=WE"><img
                                src="airline img/thai-smile.png" alt="Thai Airways" class="image-dashboatd-style"></a>
                        <p>Thai Smile Airways</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=BY"><img
                                src="airline img/TUI_fly_logo_PNG.png" alt="Thai Airways"
                                class="image-dashboatd-style"></a>
                        <p>TUI Airways</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=PS"><img
                                src="airline img/Ukraine_International_Airlines.png" alt="Thai Airways"
                                class="image-dashboatd-style"></a>
                        <p>Ukraine Airlines</p>
                    </div>
                    <div class="image-style"><a href="airline_passenger.php?airline=UK"><img
                                src="airline img/Vistara Air - UK.webp" alt="Vistara Air - UK"
                                class="image-dashboatd-style"></a>
                        <p>Vistara Air</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="footer">
            <?php include './assets/footer.php'; ?>
        </footer>
    </div>

    <script src="./bootstrap/jquery-3.7.1.min.js"></script>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./DataTables/datatables.min.js"></script>
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>