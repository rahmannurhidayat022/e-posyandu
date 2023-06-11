<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 Forbidden - Posyandu Kebon Jayanti</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/posyandu.png') }}" />

    <style>
        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            padding: 0;
            margin: 0;
        }

        #forbidden {
            position: relative;
            height: 100vh;
        }

        #forbidden .forbidden {
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .forbidden {
            max-width: 560px;
            width: 100%;
            padding-left: 160px;
            line-height: 1.1;
        }

        .forbidden .forbidden-403 {
            position: absolute;
            left: 0;
            top: 0;
            display: inline-block;
            width: 140px;
            height: 140px;
            background-size: cover;
        }

        .forbidden .forbidden-403:before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-transform: scale(2.4);
            -ms-transform: scale(2.4);
            transform: scale(2.4);
            border-radius: 50%;
            background-color: #f2f5f8;
            z-index: -1;
        }

        .forbidden h1 {
            font-family: 'Nunito', sans-serif;
            font-size: 65px;
            font-weight: 700;
            margin-top: 0px;
            margin-bottom: 10px;
            color: #151723;
            text-transform: uppercase;
        }

        .forbidden h2 {
            font-family: 'Nunito', sans-serif;
            font-size: 21px;
            font-weight: 400;
            margin: 0;
            text-transform: uppercase;
            color: #151723;
        }

        .forbidden p {
            font-family: 'Nunito', sans-serif;
            color: #999fa5;
            font-weight: 400;
        }

        .forbidden a {
            font-family: 'Nunito', sans-serif;
            display: inline-block;
            font-weight: 700;
            border-radius: 40px;
            text-decoration: none;
            color: #388dbc;
        }

        @media only screen and (max-width: 767px) {
            .forbidden .forbidden-403 {
                width: 110px;
                height: 110px;
            }

            .forbidden {
                padding-left: 15px;
                padding-right: 15px;
                padding-top: 110px;
            }
        }
    </style>
</head>

<body>
    <div id="forbidden">
        <div class="forbidden">
            <img class="forbidden-403" src="{{ mix('assets/images/403.png' )}}" alt="forbidden icon">
            <h1>403</h1>
            <h2>Oops! Akses Dilarang</h2>
            <p>Maaf, halaman yang Anda cari memerlukan hak akses tertentu</p>
            <a href="{{ route('dashboard.index') }}">Kembali ke halaman utama</a>
        </div>
    </div>
</body>

</html>
