<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WKM @yield('name')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logoWKM.png') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/siema@latest/dist/siema.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans text-gray-900 bg-white">
    <div class="min-h-screen flex flex-col">
        @if (request()->is('admin*'))
            @include('layout.admin_nav')
        @else
            @include('layout.navigation')
        @endif

        <main class="flex-grow">
            @yield('content')
        </main>

        @if (request()->is('admin*'))
            @include('layout.admin_footer')
        @else
            @include('layout.footer')
        @endif
    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
</body>

<script>
    // (function() {
    //     emailjs.init({
    //         publicKey: "YOUR_PUBLIC_KEY_HERE",
    //     });
    // })();

    // $("#contactForm").on("submit", function (e) {
    //     e.preventDefault();

    //     emailjs.sendForm('wkmukti', 'template_6uyoxto', this)
    //         .then(function () {
    //             alert("Message sent successfully!");
    //             $("#contactForm")[0].reset();
    //         }, function (error) {
    //             alert("Failed to send message. Please try again.");
    //             console.error(error);
    //         });
    // });

    // document.addEventListener('DOMContentLoaded', function () {
    //     const showMoreButtons = document.querySelectorAll('.show-more-btn');

    //     showMoreButtons.forEach(button => {
    //         button.addEventListener('click', function () {
    //             const brand = this.getAttribute('data-brand');
    //             const hiddenProducts = document.querySelectorAll(`.product-item.hidden[data-brand="${brand}"]`);
    //             const itemsToShow = Array.from(hiddenProducts).slice(0, 10);

    //             itemsToShow.forEach(item => {
    //                 item.classList.remove('hidden');
    //             });

    //             const remainingHidden = document.querySelectorAll(`.product-item.hidden[data-brand="${brand}"]`);
    //             if (remainingHidden.length === 0) {
    //                 this.style.display = 'none';
    //             }
    //         });
    //     });
    // });
</script>
</html>