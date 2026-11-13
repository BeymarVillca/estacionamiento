<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Acceso al Sistema | Estacionamiento</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* =======================================
           Estilos futuristas con degradados en movimiento
           ======================================= */
        body {
            background-color: #0b0f19;
            color: #ffffff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Fondo animado con degradados dinámicos en azul celeste y negro */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, #0b0f19, #0f172a, #0284c7, #0b0f19);
            background-size: 400% 400%;
            z-index: -1;
            animation: gradientMove 15s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* =======================================
           Contenedor de la Tarjeta de Login (Efecto Glassmorphism)
           ======================================= */
        .login-card {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 1rem;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 0 30px rgba(2, 132, 199, 0.15);
        }

        .login-title {
            font-weight: 700;
            letter-spacing: 1px;
            color: #38bdf8;
            text-transform: uppercase;
            font-size: 1.5rem;
        }

        /* =======================================
           Campos de Entrada (Inputs)
           ======================================= */
        .form-control {
            background-color: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #ffffff;
            border-radius: 0.50rem;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            background-color: rgba(30, 41, 59, 0.9);
            border-color: #38bdf8;
            color: #ffffff;
            box-shadow: 0 0 10px rgba(56, 189, 248, 0.4);
        }

        .form-label {
            color: #94a3b8;
            font-weight: 500;
        }

        /* =======================================
           Botón con Degradado Dinámico "con vida"
           ======================================= */
        .btn-futuristic {
            background: linear-gradient(135deg, #0284c7, #38bdf8, #0284c7);
            background-size: 200% auto;
            color: #ffffff;
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: 0.5s;
            animation: btnGlow 4s ease infinite;
        }

        .btn-futuristic:hover {
            background-position: right center;
            box-shadow: 0 0 20px rgba(56, 189, 248, 0.6);
            color: #ffffff;
        }

        @keyframes btnGlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body>

    <!-- =======================================
         Estructura Principal del Login
         ======================================= -->
    <div class="login-card">
        <div class="text-center mb-4">
            <h3 class="login-title">Estacionamiento</h3>
            <p class="text-secondary small">Panel de Control & Accesos</p>
        </div>

        <form id="loginForm">
            <!-- Campo de Correo Electrónico -->
            <div class="mb-3">
                <label for="correo_electrónico" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo_electrónico" name="correo_electrónico" required placeholder="admin@estacionamiento.com">
            </div>

            <!-- Campo de Contraseña -->
            <div class="mb-4">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contraseña" name="contraseña" required placeholder="••••••••">
            </div>

            <!-- Botón de Acceso -->
            <button type="submit" class="btn btn-futuristic w-100">INGRESAR AL SISTEMA</button>
        </form>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // =======================================
        // Petición AJAX para procesar el Login sin recargar
        // =======================================
        $('#loginForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('login.post') }}",
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    if(res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Acceso Concedido!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false,
                            background: '#0f172a',
                            color: '#ffffff'
                        }).then(() => {
                            window.location.href = res.redirect;
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = "Credenciales incorrectas.";
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Acceso Denegado',
                        text: errorMessage,
                        background: '#0f172a',
                        color: '#ffffff',
                        confirmButtonColor: '#0284c7'
                    });
                }
            });
        });
    </script>
</body>
</html>