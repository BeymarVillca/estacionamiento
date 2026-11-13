<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Entradas y Salidas | Estacionamiento</title>
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
        
        .modal-content { background-color: #0f172a; border: 1px solid rgba(56, 189, 248, 0.3); color: #ffffff; }
        .modal-header, .modal-footer { border-color: rgba(56, 189, 248, 0.2); }
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
            <li class="active"><a href="{{ route('boletos.index') }}"><i class="fa-solid fa-ticket"></i> Entradas y Salidas</a></li>
            <li><a href="{{ route('caja.index') }}"><i class="fa-solid fa-cash-register"></i> Caja y Facturación</a></li>
            <li><a href="{{ route('reportes.index') }}"><i class="fa-solid fa-file-excel"></i> Reportes y Estadísticas</a></li>
        </ul>
    </nav>

    <div id="content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-white"><i class="fa-solid fa-ticket text-info me-2"></i> Control de Entradas y Salidas (Boletos)</h5>
            <div class="d-flex align-items-center">
                <span class="me-3 text-secondary">{{ Auth::user()->nombre ?? 'Administrador' }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-power-off"></i> Salir</button>
                </form>
            </div>
        </div>

        <div class="card card-futuristic p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-info m-0">Registro de Boletos Activos e Historial</h5>
                <button type="button" class="btn btn-futuristic px-4" data-bs-toggle="modal" data-bs-target="#entradaModal">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Registrar Entrada
                </button>
            </div>

            <div class="table-responsive">
                <table id="tablaBoletos" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Placa Vehículo</th>
                            <th>Celda Asignada</th>
                            <th>Ingreso</th>
                            <th>Salida</th>
                            <th>Total Pagado</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Entrada -->
    <div class="modal fade" id="entradaModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-info">Registrar Entrada de Vehículo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="entradaForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="id_vehículo" class="form-label">Seleccionar Vehículo *</label>
                            <select class="form-select" id="id_vehículo" name="id_vehículo" required>
                                <option value="">Seleccione placa...</option>
                                @foreach($vehiculos as $vehiculo)
                                    <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_espacio" class="form-label">Celda / Espacio Disponible *</label>
                            <select class="form-select" id="id_espacio" name="id_espacio" required>
                                <option value="">Seleccione celda libre...</option>
                                @foreach($espacios as $espacio)
                                    <option value="{{ $espacio->id }}">Celda {{ $espacio->código }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-futuristic btn-sm px-4">Generar Boleto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let tablaBoletos;

        $(document).ready(function() {
            tablaBoletos = $('#tablaBoletos').DataTable({
                ajax: {
                    url: "{{ route('boletos.obtener') }}",
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'vehiculo.placa', render: function(data) { return `<span class="badge bg-dark border border-info text-info fw-bold px-2 py-1">${data || 'N/A'}</span>`; } },
                    { data: 'espacio.código', render: function(data) { return `<span class="badge bg-secondary">Celda ${data || 'N/A'}</span>`; } },
                    { data: 'fecha_hora_ingreso' },
                    { data: 'fecha_hora_salida', defaultContent: '<span class="text-warning">En curso...</span>' },
                    { 
                        data: 'total_pagado', 
                        render: function(data) {
                            return data ? `<span class="text-success fw-bold">$ ${parseFloat(data).toFixed(2)}</span>` : '<span class="text-muted">-</span>';
                        }
                    },
                    { 
                        data: 'estado_boleto', 
                        render: function(data) {
                            return data == 0 
                                ? '<span class="badge bg-info text-dark">Activo (En Parqueo)</span>' 
                                : '<span class="badge bg-success">Finalizado / Pagado</span>';
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            if (data.estado_boleto == 0) {
                                return `<button class="btn btn-sm btn-outline-danger btn-salida" data-id="${data.id}" title="Registrar Salida y Cobro">
                                            <i class="fa-solid fa-right-from-bracket me-1"></i> Salida
                                        </button>`;
                            }
                            return `<span class="text-muted small"><i class="fa-solid fa-check"></i> Completado</span>`;
                        }
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });

            // Enviar formulario de Entrada
            $('#entradaForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('boletos.entrada') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        $('#entradaModal').modal('hide');
                        $('#entradaForm')[0].reset();
                        tablaBoletos.ajax.reload();
                        Swal.fire({ icon: 'success', title: '¡Entrada Exitosa!', text: res.message, timer: 1800, showConfirmButton: false, background: '#0f172a', color: '#ffffff' });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || "Error al registrar la entrada.";
                        Swal.fire({ icon: 'error', title: 'Atención', text: msg, background: '#0f172a', color: '#ffffff', confirmButtonColor: '#0284c7' });
                    }
                });
            });

            // Botón Registrar Salida
            $(document).on('click', '.btn-salida', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: '¿Registrar salida del vehículo?',
                    text: "Se calculará el tiempo transcurrido y se cobrará la tarifa correspondiente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0284c7',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sí, cobrar y dar salida',
                    cancelButtonText: 'Cancelar',
                    background: '#0f172a',
                    color: '#ffffff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/boletos/${id}/salida`,
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function(res) {
                                tablaBoletos.ajax.reload();
                                Swal.fire({ icon: 'success', title: '¡Cobro y Salida Exitosos!', text: res.message, background: '#0f172a', color: '#ffffff', confirmButtonColor: '#0284c7' });
                            },
                            error: function(xhr) {
                                let msg = xhr.responseJSON?.message || "Error al procesar la salida.";
                                Swal.fire({ icon: 'error', title: 'Error', text: msg, background: '#0f172a', color: '#ffffff' });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>