<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated Lines</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>{{ config('chatify.name') }}</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css' />

    <style>
        :root {
            --primary-color: {
                    {
                    $messengerColor
                }
            }

            ;
        }
    </style>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 50px;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-container {
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .logo {
            width: 30vh;
        }

        .line-container {
            position: relative;
            height: 100px;
            overflow: hidden;
            margin-top: 10px;
            padding-top: 4cm;
            padding-bottom: 7cm;
        }

        .line {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.5s ease, transform 2s ease;
            position: absolute;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            text-align: center;
        }

        .line.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    @if(auth()->check())
        <script>
            window.addEventListener("beforeunload", function () {
                navigator.sendBeacon("/user-leaving");
            });
        </script>
    @endif

    <div class="logo-container">
        <img src="logo.png" alt="Logo" class="logo">
    </div>

    <div class="container">
        <div class="line-container">
            <h1 class="line">Welcome To The <span style="color:#4bb750"><b>WELC.PK</b></span></h1>
            <h1 class="line">Send Us Your Query</h1>
            <h1 class="line">And Get a Solution for it</h1>
            <div class="card-body line" style="top: 0%">

                <!-- Nested accordion -->
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card mt-4">
                                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                    <h5 class="card-title">Please Select a query for a quick solution of your problem
                                    </h5>
                                    <!-- Nested accordion -->
                                    <div class="accordion" id="accordionRightIcon">
                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link collapsed" style="color:#4bb750;"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#accordion-item-icon-right-1"
                                                        aria-expanded="false">
                                                        Alibaba Sales:
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="accordion-item-icon-right-1" class="collapse"
                                                data-bs-parent="#accordionRightIcon">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="What is Alibaba packages?"><label
                                                            for="">What is Alibaba packages?</label></div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2"
                                                            value="What are the Alibaba document requirements of Alibaba membership?"><label
                                                            for="">What are the Alibaba document requirements of Alibaba
                                                            membership?</label></div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="How to register Alibaba account?"><label
                                                            for="">How to register Alibaba account?</label></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link collapsed" style="color:#4bb750;"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#accordion-item-icon-right-2">
                                                        Alibaba Service:
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="accordion-item-icon-right-2" class="collapse"
                                                data-bs-parent="#accordionRightIcon">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="How to post product?"><label for="">How
                                                            to post product?</label></div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="How to fill Profile?"><label for="">How
                                                            to fill Profile?</label></div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="How to increase Star rating?"><label
                                                            for="">How to increase Star rating?</label></div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="How to recover Alibaba account?"><label
                                                            for="">How to recover Alibaba account?</label></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link collapsed" style="color:#4bb750;"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#accordion-item-icon-right-3">
                                                        Web Development:
                                                    </button>
                                                    </h3>
                                            </div>
                                            <div id="accordion-item-icon-right-3" class="collapse"
                                                data-bs-parent="#accordionRightIcon">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="What is website package?"><label
                                                            for="">What is website package?</label></div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="What is SEO Packages?"><label
                                                            for="">What is SEO Packages?</label></div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="What is Alibaba Minisite price?"><label
                                                            for="">What is Alibaba Minisite price?</label></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link collapsed" style="color:#4bb750;"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#accordion-item-icon-right-4">
                                                        Domain Hosting:
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="accordion-item-icon-right-4" class="collapse"
                                                data-bs-parent="#accordionRightIcon">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2"
                                                            value="What is domain registration prices?"><label
                                                            for="">What is domain registration prices?</label></div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="What is Hosting Packages prices?"><label
                                                            for="">What is Hosting Packages prices?</label></div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2"
                                                            value="What is Unlimited hosting packages prices?"><label
                                                            for="">What is Unlimited hosting packages prices?</label>
                                                    </div>
                                                    <br>
                                                    <div class="d-flex justify-content-start"><input type="checkbox"
                                                            class="mb-3 mr-2" value="What is Server price?"><label
                                                            for="">What is Server price?</label></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Nested accordion -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Nested accordion -->
            </div>
        </div>
    </div>
    <button class="btn btn-success mt-5">Next>></button>
    <!-- Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Activate lines with a delay
        document.addEventListener("DOMContentLoaded", function () {
            const lines = document.querySelectorAll('.line');

            lines.forEach((line, index) => {
                setTimeout(() => {
                    if (index > 0) {
                        lines[index - 1].classList.remove('active');
                    }
                    line.classList.add('active');
                }, index * 4000); // Adjust the delay as needed
            });
        });
    </script>

</body>

</html>
