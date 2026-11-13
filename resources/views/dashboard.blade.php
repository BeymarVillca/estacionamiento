<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Control | Estacionamiento</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* =======================================
           Estilos Generales y Tema Futurista (Negro, Azul Celeste, Blanco)
           ======================================= */
        body {
            background-color: #0b0f19;
            color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* =======================================
           Sidebar de Navegación Lateral
           ======================================= */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            background: rgba(15, 23, 42, 0.95);
            border-right: 1px solid rgba(56, 189, 248, 0.2);
            min-height: 100vh;
            transition: all 0.3s;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #0b0f19;
            border-bottom: 1px solid rgba(56, 189, 248, 0.2);
        }

        #sidebar .sidebar-header h3 {
            color: #38bdf8;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li a {
            padding: 12px 20px;
            font-size: 0.95rem;
            display: block;
            color: #94a3b8;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: 0.3s;
        }

        #sidebar ul li a:hover, #sidebar ul li.active a {
            color: #ffffff;
            background: rgba(56, 189, 248, 0.1);
            border-left: 3px solid #38bdf8;
        }

        #sidebar ul li a i {
            margin-right: 10px;
            color: #38bdf8;
        }

        /* =======================================
           Contenido Principal
           ======================================= */
        #content {
            margin-left: 260px;
            width: calc(100% - 260px);
            padding: 30px;
        }

        /* =======================================
           Tarjetas de Estadísticas / Resumen
           ======================================= */
        .card-futuristic {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 0.75rem;
            color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .card-futuristic .card-title {
            color: #94a3b8;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* =======================================
           Barra Superior (Navbar)
           ======================================= */
        .top-navbar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(56, 189, 248, 0.2);
            padding: 15px 30px;
            border-radius: 0.5rem;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <!-- =======================================
         Este es el Sidebar y sirve para navegar de forma ordenada entre los módulos del sistema sin mezclar pantallas.
         ======================================= -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fa-solid fa-square-parking"></i> Estacionamiento</h3>
        </div>

        <ul class="list-unstyled components">
            <li class="active">
                <a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a>
            </li>
            <li>
                <a href="{{ route('usuarios.index') }}"><i class="fa-solid fa-users-gear"></i> Seguridad / Usuarios</a>
            </li>
            <li>
                <a href="{{ route('clientes.index') }}"><i class="fa-solid fa-id-card"></i> Clientes / Abonados</a>
            </li>
            <li>
                <a href="{{ route('vehiculos.index') }}"><i class="fa-solid fa-car"></i> Gestión de Vehículos</a>
            </li>
            <li>
                <a href="{{ route('espacios.index') }}"><i class="fa-solid fa-warehouse"></i> Celdas / Espacios</a>
            </li>
            <li>
                <a href="{{ route('boletos.index') }}"><i class="fa-solid fa-ticket"></i> Entradas y Salidas</a>
            </li>
            <li>
                <a href="{{ route('caja.index') }}"><i class="fa-solid fa-cash-register"></i> Caja y Facturación</a>
            </li>
            <li>
                <a href="{{ route('reportes.index') }}"><i class="fa-solid fa-file-excel"></i> Reportes y Estadísticas</a>
            </li>
        </ul>
    </nav>

    <!-- =======================================
         Contenedor principal donde se despliega la información del módulo activo
         ======================================= -->
    <div id="content">
        <!-- Barra superior con usuario autenticado y botón de salir -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-white"><i class="fa-solid fa-gauge-high text-info me-2"></i> Panel Principal</h5>
            <div class="d-flex align-items-center">
                <span class="me-3 text-secondary">{{ Auth::user()->nombre ?? 'Administrador' }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <!-- Este es el botón para cerrar sesión de forma segura del sistema -->
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-power-off"></i> Salir</button>
                </form>
            </div>
        </div>

        <!-- Tarjetas de Resumen Rápido -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card card-futuristic p-4">
                    <div class="card-title">Espacios Ocupados</div>
                    <h3 class="text-info mt-2 mb-0">0 / 0</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-futuristic p-4">
                    <div class="card-title">Vehículos Ingresados Hoy</div>
                    <h3 class="text-info mt-2 mb-0">0</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-futuristic p-4">
                    <div class="card-title">Ingresos del Día</div>
                    <h3 class="text-info mt-2 mb-0">$ 0.00</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>