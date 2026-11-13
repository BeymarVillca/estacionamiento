<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clientes y Abonados | Estacionamiento</title>
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

    <!-- =======================================
         Sidebar de Navegación
         ======================================= -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fa-solid fa-square-parking"></i> Estacionamiento</h3>
        </div>
        <ul class="list-unstyled components">
            <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li><a href="{{ route('usuarios.index') }}"><i class="fa-solid fa-users-gear"></i> Seguridad / Usuarios</a></li>
            <li class="active"><a href="{{ route('clientes.index') }}"><i class="fa-solid fa-id-card"></i> Clientes / Abonados</a></li>
            <li><a href="{{ route('vehiculos.index') }}"><i class="fa-solid fa-car"></i> Gestión de Vehículos</a></li>
            <li><a href="{{ route('espacios.index') }}"><i class="fa-solid fa-warehouse"></i> Celdas / Espacios</a></li>
            <li><a href="{{ route('boletos.index') }}"><i class="fa-solid fa-ticket"></i> Entradas y Salidas</a></li>
            <li><a href="{{ route('caja.index') }}"><i class="fa-solid fa-cash-register"></i> Caja y Facturación</a></li>
            <li><a href="{{ route('reportes.index') }}"><i class="fa-solid fa-file-excel"></i> Reportes y Estadísticas</a></li>
        </ul>
    </nav>

    <!-- =======================================
         Contenedor Principal
         ======================================= -->
    <div id="content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-white"><i class="fa-solid fa-id-card text-info me-2"></i> Gestión de Clientes y Abonados</h5>
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
                <h5 class="text-info m-0">Directorio de Clientes</h5>
                <button type="button" class="btn btn-futuristic px-4" data-bs-toggle="modal" data-bs-target="#clienteModal" id="btnNuevoCliente">
                    <i class="fa-solid fa-user-plus me-2"></i> Nuevo Cliente
                </button>
            </div>

            <div class="table-responsive">
                <table id="tablaClientes" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Tipo</th>
                            <th>Vencimiento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- =======================================
         Modal Único (Crear / Editar) para Clientes
         ======================================= -->
    <div class="modal fade" id="clienteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-info" id="modalTitulo">Registrar Nuevo Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="clienteForm">
                    <input type="hidden" id="idcliente" name="idcliente">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej. Carlos Mendoza">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="teléfono" class="form-label">Teléfono / Celular</label>
                                <input type="text" class="form-control" id="teléfono" name="teléfono" placeholder="Ej. 71234567">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="correo_electrónico" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo_electrónico" name="correo_electrónico" placeholder="cliente@correo.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="es_suscriptor" class="form-label">Modalidad de Cliente *</label>
                            <select class="form-select" id="es_suscriptor" name="es_suscriptor" required>
                                <option value="0">Cliente Regular (Por hora/fracción)</option>
                                <option value="1">Abonado / Mensualidad</option>
                            </select>
                        </div>
                        <div class="mb-3 d-none" id="divVencimiento">
                            <label for="fecha_vencimiento" class="form-label text-info">Fecha de Vencimiento de Mensualidad *</label>
                            <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-futuristic btn-sm px-4">Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts (jQuery, Bootstrap, DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let tablaClientes;

        $(document).ready(function() {
            // =======================================
            // Mostrar / Ocultar campo fecha según modalidad
            // =======================================
            $('#es_suscriptor').on('change', function() {
                if ($(this).val() == '1') {
                    $('#divVencimiento').removeClass('d-none');
                    $('#fecha_vencimiento').attr('required', true);
                } else {
                    $('#divVencimiento').addClass('d-none');
                    $('#fecha_vencimiento').removeAttr('required').val('');
                }
            });

            // =======================================
            // Inicialización de DataTables
            // =======================================
            tablaClientes = $('#tablaClientes').DataTable({
                ajax: {
                    url: "{{ route('clientes.obtener') }}",
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'teléfono', defaultContent: '<span class="text-muted">N/A</span>' },
                    { data: 'correo_electrónico', defaultContent: '<span class="text-muted">N/A</span>' },
                    { 
                        data: 'es_suscriptor', 
                        render: function(data) {
                            return data == 1 
                                ? '<span class="badge bg-info text-dark"><i class="fa-solid fa-star me-1"></i> Abonado</span>' 
                                : '<span class="badge bg-secondary">Regular</span>';
                        }
                    },
                    { 
                        data: 'fecha_vencimiento', 
                        render: function(data, type, row) {
                            if (row.es_suscriptor == 1 && data) {
                                return `<span class="text-info fw-semibold">${data}</span>`;
                            }
                            return '<span class="text-muted">-</span>';
                        }
                    },
                    { 
                        data: 'estado', 
                        render: function(data) {
                            return data == 1 
                                ? '<span class="badge bg-success">Activo</span>' 
                                : '<span class="badge bg-danger">Inactivo</span>';
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            let btnEstadoTexto = data.estado == 1 ? 'Desactivar' : 'Activar';
                            let btnEstadoClase = data.estado == 1 ? 'btn-outline-warning' : 'btn-outline-success';
                            let btnEstadoIcon = data.estado == 1 ? 'fa-ban' : 'fa-check';

                            return `
                                <button class="btn btn-sm btn-outline-info btn-editar me-1" 
                                    data-id="${data.id}" 
                                    data-nombre="${data.nombre}" 
                                    data-telefono="${data.teléfono || ''}" 
                                    data-correo="${data.correo_electrónico || ''}" 
                                    data-suscriptor="${data.es_suscriptor}" 
                                    data-vencimiento="${data.fecha_vencimiento || ''}" 
                                    title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-sm ${btnEstadoClase} btn-estado" data-id="${data.id}" title="${btnEstadoTexto}">
                                    <i class="fa-solid ${btnEstadoIcon}"></i>
                                </button>
                            `;
                        }
                    }
                ],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                }
            });

            // =======================================
            // Limpiar modal para Nuevo Cliente
            // =======================================
            $('#btnNuevoCliente').on('click', function() {
                $('#clienteForm')[0].reset();
                $('#idcliente').val('');
                $('#divVencimiento').addClass('d-none');
                $('#fecha_vencimiento').removeAttr('required');
                $('#modalTitulo').text('Registrar Nuevo Cliente');
            });

            // =======================================
            // Guardar o Actualizar Cliente vía AJAX
            // =======================================
            $('#clienteForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#idcliente').val();
                let url = id ? `/clientes/${id}` : "{{ route('clientes.store') }}";
                let formData = $(this).serialize() + (id ? '&_method=PUT' : '');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        $('#clienteModal').modal('hide');
                        tablaClientes.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false,
                            background: '#0f172a',
                            color: '#ffffff'
                        });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || "Verifica los datos ingresados.";
                        Swal.fire({
                            icon: 'error',
                            title: 'Error de validación',
                            text: msg,
                            background: '#0f172a',
                            color: '#ffffff',
                            confirmButtonColor: '#0284c7'
                        });
                    }
                });
            });

            // =======================================
            // Cargar datos en el modal para Editar
            // =======================================
            $(document).on('click', '.btn-editar', function() {
                let id = $(this).data('id');
                let suscriptor = $(this).data('suscriptor');

                $('#idcliente').val(id);
                $('#nombre').val($(this).data('nombre'));
                $('#teléfono').val($(this).data('telefono'));
                $('#correo_electrónico').val($(this).data('correo'));
                $('#es_suscriptor').val(suscriptor).trigger('change');
                $('#fecha_vencimiento').val($(this).data('vencimiento'));
                $('#modalTitulo').text('Editar Cliente');

                new bootstrap.Modal(document.getElementById('clienteModal')).show();
            });

            // =======================================
            // Activar / Desactivar Cliente
            // =======================================
            $(document).on('click', '.btn-estado', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: '¿Cambiar estado del cliente?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0284c7',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sí, cambiar',
                    cancelButtonText: 'Cancelar',
                    background: '#0f172a',
                    color: '#ffffff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/clientes/${id}/estado`,
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function(res) {
                                tablaClientes.ajax.reload();
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Actualizado!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false,
                                    background: '#0f172a',
                                    color: '#ffffff'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>