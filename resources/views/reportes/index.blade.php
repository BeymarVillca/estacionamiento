<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reportes y Estadísticas | Estacionamiento</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #0b0f19; color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        #sidebar { min-width: 260px; max-width: 260px; background: rgba(15, 23, 42, 0.95); border-right: 1px solid rgba(56, 189, 248, 0.2); min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; }
        #sidebar .sidebar-header { padding: 20px; background: #0b0f19; border-bottom: 1px solid rgba(56, 189, 248, 0.2); }
        #sidebar .sidebar-header h3 { color: #38bdf8; font-size: 1.25rem; font-weight: 700; margin: 0; text-transform: uppercase; }
        #sidebar ul.components { padding: 20px 0; }
        #sidebar ul li a { padding: 12px 20px; font-size: 0.95rem; display: block; color: #94a3b8; text-decoration: none; border-left: 3px solid transparent; transition: 0.3s; }
        #sidebar ul li a:hover, #sidebar ul li.active a { color: #ffffff; background: rgba(56, 189, 248, 0.1); border-left: 3px solid #38bdf8; }
        #sidebar ul li a i { margin-right: 10px; color: #38bdf8; }
        #content { margin-left: 260px; width: calc(100% - 260px); padding: 30px; }
        .card-futuristic { background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(12px); border: 1px solid rgba(56, 189, 248, 0.2); border-radius: 0.75rem; color: #ffffff; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4); }
        .top-navbar { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(56, 189, 248, 0.2); padding: 15px 30px; border-radius: 0.5rem; margin-bottom: 30px; }
        
        .btn-futuristic {
            background: linear-gradient(135deg, #0284c7, #38bdf8, #0284c7);
            background-size: 200% auto;
            color: #ffffff;
            border: none;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: 0.5s;
            animation: btnGlow 4s ease infinite;
        }
        .btn-futuristic:hover { background-position: right center; box-shadow: 0 0 15px rgba(56, 189, 248, 0.6); color: #ffffff; }
        @keyframes btnGlow { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

        .dataTables_wrapper .dataTables_length select, .dataTables_wrapper .dataTables_filter input {
            background-color: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(56, 189, 248, 0.3);
            color: #ffffff;
            border-radius: 0.35rem;
            padding: 5px 10px;
        }
        .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_paginate { color: #94a3b8 !important; }
        table.table { color: #ffffff; border-color: rgba(56, 189, 248, 0.1); }
        table.table th { color: #38bdf8; border-bottom: 2px solid rgba(56, 189, 248, 0.3); }
        table.table td { background-color: transparent !important; color: #f8fafc !important; vertical-align: middle; }
        .form-control, .form-select { background-color: rgba(30, 41, 59, 0.6); border: 1px solid rgba(56, 189, 248, 0.3); color: #ffffff; }
        .form-control:focus, .form-select:focus { background-color: rgba(30, 41, 59, 0.9); border-color: #38bdf8; color: #ffffff; box-shadow: 0 0 10px rgba(56, 189, 248, 0.4); }
        .form-label { color: #94a3b8; }
    </style>
</head>
<body>

    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fa-solid fa-square-parking"></i> Estacionamiento</h3>
        </div>
        <ul class="list-unstyled components">
            <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="{{ route('usuarios.index') }}"><i class="fa-solid fa-users-gear"></i> Seguridad / Usuarios</a></li>
            <li><a href="{{ route('clientes.index') }}"><i class="fa-solid fa-id-card"></i> Clientes / Abonados</a></li>
            <li><a href="{{ route('vehiculos.index') }}"><i class="fa-solid fa-car"></i> Gestión de Vehículos</a></li>
            <li><a href="{{ route('espacios.index') }}"><i class="fa-solid fa-warehouse"></i> Celdas / Espacios</a></li>
            <li><a href="{{ route('boletos.index') }}"><i class="fa-solid fa-ticket"></i> Entradas y Salidas</a></li>
            <li><a href="{{ route('caja.index') }}"><i class="fa-solid fa-cash-register"></i> Caja y Facturación</a></li>
            <li class="active"><a href="{{ route('reportes.index') }}"><i class="fa-solid fa-file-excel"></i> Reportes y Estadísticas</a></li>
        </ul>
    </nav>

    <div id="content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-white"><i class="fa-solid fa-file-excel text-info me-2"></i> Reportes y Estadísticas</h5>
            <div class="d-flex align-items-center">
                <span class="me-3 text-secondary">{{ Auth::user()->nombre ?? 'Administrador' }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-power-off"></i> Salir</button>
                </form>
            </div>
        </div>

        <div class="card card-futuristic p-4 mb-4">
            <h5 class="text-info mb-3">Filtros de Reporte</h5>
            <form id="filtroReporteForm" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label">Fecha Desde</label>
                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ date('Y-m-01') }}">
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label">Fecha Hasta</label>
                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-futuristic w-100">
                        <i class="fa-solid fa-filter me-2"></i> Generar Reporte
                    </button>
                </div>
            </form>
        </div>

        <div class="card card-futuristic p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-info m-0">Resultados del Reporte</h5>
                <button type="button" class="btn btn-outline-success btn-sm" onclick="window.print()">
                    <i class="fa-solid fa-print me-1"></i> Imprimir / Exportar
                </button>
            </div>

            <div class="table-responsive">
                <table id="tablaReportes" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Placa</th>
                            <th>Celda</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Total Pagado</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let tablaReportes;

        $(document).ready(function() {
            tablaReportes = $('#tablaReportes').DataTable({
                ajax: {
                    url: "{{ route('reportes.generar') }}",
                    data: function(d) {
                        d.fecha_inicio = $('#fecha_inicio').val();
                        d.fecha_fin = $('#fecha_fin').val();
                    },
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'vehiculo.placa', render: function(data) { return `<span class="badge bg-dark border border-info text-info fw-bold px-2 py-1">${data || 'N/A'}</span>`; } },
                    { data: 'espacio.código', render: function(data) { return `<span class="badge bg-secondary">Celda ${data || 'N/A'}</span>`; } },
                    { data: 'fecha_hora_ingreso' },
                    { data: 'fecha_hora_salida', defaultContent: '<span class="text-warning">En curso...</span>' },
                    { data: 'total_pagado', render: function(data) { return data ? `<span class="text-success fw-bold">$ ${parseFloat(data).toFixed(2)}</span>` : '<span class="text-muted">-</span>'; } },
                    { 
                        data: 'estado_boleto', 
                        render: function(data) {
                            return data == 0 
                                ? '<span class="badge bg-info text-dark">Activo</span>' 
                                : '<span class="badge bg-success">Completado</span>';
                        }
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });

            $('#filtroReporteForm').on('submit', function(e) {
                e.preventDefault();
                tablaReportes.ajax.reload();
            });
        });
    </script>
</body>
</html>