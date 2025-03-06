<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <style>
        :root {
            --primary-color: #1e40af;
            --secondary-color: #3b82f6;
            --accent-color: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(120deg, var(--primary-color), var(--secondary-color));
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-container {
            max-width: 1200px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .content-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 900px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-radius: 24px;
            overflow: hidden;
            background: #fff;
            padding: 2rem;
            backdrop-filter: blur(12px);
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .animation-container {
            width: 100%;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            margin-top: 1rem;
        }

        .form-control {
            padding: 1rem;
            border-radius: 12px;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.25);
        }

        /* Hide animation container on mobile */
        @media (max-width: 767.98px) {
            .animation-container {
                display: none;
            }
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .content-wrapper {
                flex-direction: column;
            }

            .animation-container {
                height: 250px;
            }

            .login-container {
                max-width: 100%;
            }
        }

        /* Position the back button at the top-left corner */
        .back-icon {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 30px;
            color: #007bff;
            /* You can change the color */
            text-decoration: none;
        }

        .back-icon:hover {
            color: #0056b3;
            /* Change color on hover */
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="content-wrapper">
            <!-- Back Button Icon -->
            <a href="{{ url('/') }}" class="back-icon" id="backButton">
                <i class="bi bi-arrow-left-circle-fill"></i> <!-- Arrow Back Icon -->
            </a>

            <div class="login-container">
                @if ($errors->any())
                    <div class="alert alert-danger mb-4" role="alert">
                        <strong>Oops!</strong>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="id" class="form-label fw-semibold">ID:</label>
                        <input type="text" class="form-control" name="id" id="id" required
                            placeholder="Enter your ID">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" required
                            placeholder="Enter your password">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Sign In
                    </button>
                </form>
            </div>

            <div class="animation-container" id="lottie"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>

    <script>
        // Initialize Lottie animation only on larger screens
        if (window.innerWidth >= 768) {
            const anim = lottie.loadAnimation({
                container: document.getElementById('lottie'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '{{ asset('animations/Animation-1739151970151.json') }}' // Fixed the animation path
            });
        }

        // Handle animation visibility on resize
        window.addEventListener('resize', function() {
            const animContainer = document.querySelector('.animation-container');

            if (window.innerWidth >= 768) {
                animContainer.style.display = 'block';
            } else {
                animContainer.style.display = 'none';
            }
        });

        // Back button functionality
        document.getElementById('backButton').addEventListener('click', function() {
            window.history.back(); // Go back to previous page
        });
    </script>

</body>

</html>
