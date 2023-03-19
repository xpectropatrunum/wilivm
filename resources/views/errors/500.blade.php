<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Wilivm</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <style>
        #error {
            background-color: #ebf3ff;
            min-height: 100vh;
            padding: 2rem 0
        }

        #error .img-error {
            height: 435px;
            -o-object-fit: contain;
            object-fit: contain;
            padding: 3rem 0
        }

        #error .error-title {
            font-size: 3rem;
            margin-top: 1rem
        }

        html[data-bs-theme=dark] #error {
            background-color: #151521
        }
    </style>
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.svg') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/images/logo/favicon.png') }}" type="image/png">
</head>

<body>
    <script src="{{ asset('assets/js/initTheme.js') }}"></script>
    <div id="error">
       
<div class="error-page container">
    <div class="col-md-8 col-12 offset-md-2">
        <div class="text-center">
            <img class="img-error" src="assets/images/samples/error-500.svg" alt="Not Found">
            <h1 class="error-title">System Error</h1>
            <p class="fs-5 text-gray-600">The website is currently unavailable. Try again later or contact the
                support.</p>
            <a href="/" class="btn btn-lg btn-outline-primary mt-3">Go Home</a>
        </div>
    </div>
</div>
    </div>
</body>

</html>
