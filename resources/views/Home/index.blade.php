<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agnes Template</title>
    <link href="https://fonts.googleapis.com/css?family=Hind+Vadodara:400,700|Mukta:500,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('Home/dist/css/style.css') }}">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
</head>

<body class="is-boxed has-animations">
    <div class="body-wrap boxed-container">
        <header class="site-header">
            <div class="container">
                <div class="site-header-inner">
                    <div class="brand header-brand">
                        <h1 class="m-0">
                            <a href="#">
                                <img src="{{ asset('assets/images/Payal Dealers.png') }}" alt="" width="150px">
                            </a>
                        </h1>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="container">
                    <div class="hero-inner">
                        <div class="hero-copy">
                            <h1 class="hero-title h2-mobile mt-0 is-revealing">Quality Cashews For Your Loved Ones</h1>
                            <p class="hero-paragraph is-revealing">Our premium cashew products are available for all
                                seasons, so you can order easily and enjoy the best cashews forever..</p>
                            <p class="hero-cta is-revealing"><a class="button button-primary button-shadow"
                                    href="{{ route('login') }}">Login</a></p>
                        </div>
                        <div class="hero-illustration is-revealing">
                            <img src="{{ asset('Home/dist/kaju.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </section>

            <section class="features section text-center">
                <div class="section-square"></div>
                <div class="container">
                    <div class="features-inner section-inner">
                        <div class="features-wrap">
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient x1="50%" y1="100%" x2="50%"
                                                    y2="0%" id="feature-1-a">
                                                    <stop stop-color="#007CFE" stop-opacity="0" offset="0%" />
                                                    <stop stop-color="#007DFF" offset="100%" />
                                                </linearGradient>
                                                <linearGradient x1="50%" y1="0%" x2="50%"
                                                    y2="100%" id="feature-1-b">
                                                    <stop stop-color="#FF4F7A" stop-opacity="0" offset="0%" />
                                                    <stop stop-color="#FF4F7A" offset="100%" />
                                                </linearGradient>
                                            </defs>
                                            <g fill="none" fill-rule="evenodd">
                                                <path d="M8 0h24v24a8 8 0 0 1-8 8H0V8a8 8 0 0 1 8-8z"
                                                    fill="url(#feature-1-a)" />
                                                <path d="M48 16v24a8 8 0 0 1-8 8H16c0-17.673 14.327-32 32-32z"
                                                    fill="url(#feature-1-b)" />
                                            </g>
                                        </svg>
                                    </div>
                                    <h4 class="feature-title h3-mobile">Quality</h4>
                                    <p class="text-sm">We source the highest quality cashews directly from trusted
                                        farms, ensuring freshness and taste.</p>
                                </div>
                            </div>
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient x1="50%" y1="100%" x2="50%"
                                                    y2="0%" id="feature-2-a">
                                                    <stop stop-color="#007CFE" stop-opacity="0" offset="0%" />
                                                    <stop stop-color="#007DFF" offset="100%" />
                                                </linearGradient>
                                                <linearGradient x1="50%" y1="0%" x2="50%"
                                                    y2="100%" id="feature-2-b">
                                                    <stop stop-color="#FF4F7A" stop-opacity="0" offset="0%" />
                                                    <stop stop-color="#FF4F7A" offset="100%" />
                                                </linearGradient>
                                            </defs>
                                            <g fill="none" fill-rule="evenodd">
                                                <path d="M0 0h32v7c0 13.807-11.193 25-25 25H0V0z"
                                                    fill="url(#feature-2-a)" />
                                                <path d="M48 16v7c0 13.807-11.193 25-25 25h-7c0-17.673 14.327-32 32-32z"
                                                    fill="url(#feature-2-b)" transform="matrix(1 0 0 -1 0 64)" />
                                            </g>
                                        </svg>

                                    </div>
                                    <h4 class="feature-title h3-mobile">Processing</h4>
                                    <p class="text-sm">Our state-of-the-art processing facilities guarantee that every
                                        cashew is perfectly roasted and packed.</p>
                                </div>
                            </div>
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient x1="50%" y1="100%" x2="50%"
                                                    y2="0%" id="feature-3-a">
                                                    <stop stop-color="#007CFE" stop-opacity="0" offset="0%" />
                                                    <stop stop-color="#007DFF" offset="100%" />
                                                </linearGradient>
                                                <linearGradient x1="50%" y1="0%" x2="50%"
                                                    y2="100%" id="feature-3-b">
                                                    <stop stop-color="#FF4F7A" stop-opacity="0" offset="0%" />
                                                    <stop stop-color="#FF4F7A" offset="100%" />
                                                </linearGradient>
                                            </defs>
                                            <g fill="none" fill-rule="evenodd">
                                                <circle fill="url(#feature-3-a)" cx="16" cy="16"
                                                    r="16" />
                                                <path d="M16 16c17.673 0 32 14.327 32 32H16V16z"
                                                    fill="url(#feature-3-b)" />
                                            </g>
                                        </svg>

                                    </div>
                                    <h4 class="feature-title h3-mobile">Packaging</h4>
                                    <p class="text-sm">We use eco-friendly packaging to ensure our products are safe
                                        for the environment.</p>
                                </div>
                            </div>
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <div class="feature-icon">
                                        <svg width="48" height="48" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <linearGradient x1="50%" y1="0%" x2="50%"
                                                    y2="100%" id="feature-4-a">
                                                    <stop stop-color="#FF4F7A" stop-opacity="0" offset="0%" />
                                                    <stop stop-color="#FF4F7A" offset="100%" />
                                                </linearGradient>
                                                <linearGradient x1="50%" y1="100%" x2="50%"
                                                    y2="0%" id="feature-4-b">
                                                    <stop stop-color="#007CFE" stop-opacity="0" offset="0%" />
                                                    <stop stop-color="#007DFF" offset="100%" />
                                                </linearGradient>
                                            </defs>
                                            <g fill="none" fill-rule="evenodd">
                                                <path
                                                    d="M32 16h16v16c0 8.837-7.163 16-16 16H16V32c0-8.837 7.163-16 16-16z"
                                                    fill="url(#feature-4-a)" />
                                                <path d="M16 0h16v16c0 8.837-7.163 16-16 16H0V16C0 7.163 7.163 0 16 0z"
                                                    fill="url(#feature-4-b)" />
                                            </g>
                                        </svg>

                                    </div>
                                    <h4 class="feature-title h3-mobile">Order</h4>
                                    <p class="text-sm">Enjoy quick and efficient delivery services with every order,
                                        ensuring your cashews arrive fresh.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="site-footer text-light">
                <div class="container">
                    <div class="site-footer-inner has-top-divider">
                        <div class="brand footer-brand">
                            <a href="#">
                                <img src="{{ asset('assets/images/Payal Dealers.png') }}" alt=""
                                    width="150px">
                            </a>
                        </div>
                        <ul class="footer-links list-reset">
                            <li>
                                <a href="#">Contact</a>
                            </li>
                            <li>
                                <a href="#">About us</a>
                            </li>
                            <li>
                                <a href="#">FAQ's</a>
                            </li>
                            <li>
                                <a href="#">Support</a>
                            </li>
                        </ul>
                        <ul class="footer-social-links list-reset">
                            <li>
                                <a href="#">
                                    <span class="screen-reader-text">Facebook</span>
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.023 16L6 9H3V6h3V4c0-2.7 1.672-4 4.08-4 1.153 0 2.144.086 2.433.124v2.821h-1.67c-1.31 0-1.563.623-1.563 1.536V6H13l-1 3H9.28v7H6.023z"
                                            fill="#FFFFFF" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="screen-reader-text">Twitter</span>
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 3c-.6.3-1.2.4-1.9.5.7-.4 1.2-1 1.4-1.8-.6.4-1.3.6-2.1.8-.6-.6-1.5-1-2.4-1-1.7 0-3.2 1.5-3.2 3.3 0 .3 0 .5.1.7-2.7-.1-5.2-1.4-6.8-3.4-.3.5-.4 1-.4 1.7 0 1.1.6 2.1 1.5 2.7-.5 0-1-.2-1.5-.4C.7 7.7 1.8 9 3.3 9.3c-.3.1-.6.1-.9.1-.2 0-.4 0-.6-.1.4 1.3 1.6 2.3 3.1 2.3-1.1.9-2.5 1.4-4.1 1.4H0c1.5.9 3.2 1.5 5 1.5 6 0 9.3-5 9.3-9.3v-.4C15 4.3 15.6 3.7 16 3z"
                                            fill="#FFFFFF" />
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="screen-reader-text">Google</span>
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.9 7v2.4H12c-.2 1-1.2 3-4 3-2.4 0-4.3-2-4.3-4.4 0-2.4 2-4.4 4.3-4.4 1.4 0 2.3.6 2.8 1.1l1.9-1.8C11.5 1.7 9.9 1 8 1 4.1 1 1 4.1 1 8s3.1 7 7 7c4 0 6.7-2.8 6.7-6.8 0-.5 0-.8-.1-1.2H7.9z"
                                            fill="#FFFFFF" />
                                    </svg>
                                </a>
                            </li>
                        </ul>
                        <div class="footer-copyright">&copy; 2024 Payal Dealers, all rights reserved</div>
                    </div>
                </div>
            </footer>
    </div>

    <script src="{{ asset('Home/dist/js/main.min.js') }}"></script>
</body>

</html>
