<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - UMKM Makanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-purple: #8B5CF6;
            --secondary-purple: #A78BFA;
            --accent-purple: #7C3AED;
            --light-purple: #EDE9FE;
            --dark-purple: #5B21B6;
            --text-dark: #1F2937;
            --text-light: #6B7280;
        }

        .auth-container {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--accent-purple) 100%);
            display: flex;
            align-items: center;
            padding: 20px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(139, 92, 246, 0.2);
            overflow: hidden;
            min-height: 600px;
        }

        .login-left {
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            height: 100%;
        }

        .login-right {
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--accent-purple) 100%);
            padding: 0;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .login-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(139, 92, 246, 0.9), rgba(124, 58, 237, 0.9)),
                    url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            color: white;
            text-align: center;
            padding: 3rem;
        }

        .stats-container {
            background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 2rem;
    margin-top: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    width: 100%;
    max-width: 400px;
        }

        .stat-percentage {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #fff, #EDE9FE);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-title {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .stat-item {
            display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-number {
            font-size: 1.1rem;
    font-weight: 600;
    text-align: right;
    flex: 0 0 auto;
    margin-left: 1rem;
        }

        .stat-label {
            font-size: 0.95rem;
    opacity: 0.8;
    font-weight: 400;
    text-align: left;
    flex: 1;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .auth-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
            font-weight: 400;
        }

        .form-control {
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            padding: 14px 16px;
            font-size: 1rem;
            transition: all 0.3s;
            background: #F9FAFB;
        }

        .form-control:focus {
            border-color: var(--primary-purple);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
            background: white;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .btn-auth {
            background: linear-gradient(135deg, var(--primary-purple) 0%, var(--accent-purple) 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            transition: all 0.3s;
            width: 100%;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 92, 246, 0.6);
            color: white;
        }

        .form-check-input:checked {
            background-color: var(--primary-purple);
            border-color: var(--primary-purple);
        }

        .form-check-label {
            color: var(--text-light);
        }

        .auth-link {
            color: var(--primary-purple);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .auth-link:hover {
            color: var(--accent-purple);
            text-decoration: underline;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .forgot-password {
            color: var(--primary-purple);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .forgot-password:hover {
            color: var(--accent-purple);
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #E5E7EB;
        }

        .register-link p {
            color: var(--text-light);
            margin-bottom: 0;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
            color: #065F46;
            border-left: 4px solid #10B981;
        }

        .alert-danger {
            background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
            color: #7F1D1D;
            border-left: 4px solid #EF4444;
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            font-size: 2.5rem;
            color: var(--primary-purple);
            margin-bottom: 1rem;
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-purple);
            margin-bottom: 0.25rem;
        }

        .logo-tagline {
            color: var(--text-light);
            font-size: 0.95rem;
            font-weight: 400;
        }

        .rating {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1.5rem 0;
            gap: 0.5rem;
        }

        .stars {
            color: #FBBF24;
            font-size: 1.2rem;
        }

.rating-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
        .rating-text {
            font-size: 1rem;
    opacity: 0.9;
    font-weight: 500;
    text-align: left;
    flex: 1;
        }

        .rating-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    flex: 0 0 auto;
}

        .side-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
        }

        .back-home {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            text-decoration: none;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 15px;
            border-radius: 8px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .back-home:hover {
            color: white;
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-5px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-right {
                display: none;
            }

            .login-container {
                border-radius: 15px;
                margin: 1rem;
                min-height: auto;
            }

            .login-left {
                padding: 2rem 1.5rem;
            }

            .auth-title {
                font-size: 1.8rem;
            }

            .logo-text {
                font-size: 1.5rem;
            }

            .back-home {
                top: 10px;
                left: 10px;
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .login-left {
                padding: 2rem;
            }

            .stats-container {
                padding: 2rem;
            }

            .login-image {
                padding: 2rem;
            }
        }

        @media (min-width: 993px) {
            .login-container {
                display: flex;
            }

            .login-left {
                width: 50%;
            }

            .login-right {
                width: 50%;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <a href="{{ url('/') }}" class="back-home">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Home
    </a>

    <div class="auth-container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus effects to form inputs
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    if (this.value === '') {
                        this.parentElement.classList.remove('focused');
                    }
                });
            });

            // Add loading state to auth buttons
            const authForms = document.querySelectorAll('form');
            authForms.forEach(form => {
                const authBtn = form.querySelector('.btn-auth');
                if (authBtn) {
                    form.addEventListener('submit', function() {
                        authBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                        authBtn.disabled = true;
                    });
                }
            });

            // Animate stats counter
            function animateCounter(element, target, duration) {
                let start = 0;
                const increment = target / (duration / 16);
                const timer = setInterval(() => {
                    start += increment;
                    if (start >= target) {
                        element.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(start).toLocaleString();
                    }
                }, 16);
            }

            // Animate percentage
            function animatePercentage(element, target, duration) {
                let start = 0;
                const increment = target / (duration / 16);
                const timer = setInterval(() => {
                    start += increment;
                    if (start >= target) {
                        element.textContent = Math.floor(target) + '%';
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(start) + '%';
                    }
                }, 16);
            }

            // Start animations when page loads
            setTimeout(() => {
                const percentageElement = document.querySelector('.stat-percentage');
                if (percentageElement) {
                    animatePercentage(percentageElement, 89, 2000);
                }
            }, 1000);
        });
    </script>
    @yield('scripts')
</body>
</html>
