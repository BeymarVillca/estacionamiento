<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Vehículos | Estacionamiento</title>
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
            <li class="active"><a href="{{ route('vehiculos.index') }}"><i class="fa-solid fa-car"></i> Gestión de Vehículos</a></li>
            <li><a href="{{ route('espacios.index') }}"><i class="fa-solid fa-warehouse"></i> Celdas / Espacios</a></li>
            <li><a href="{{ route('boletos.index') }}"><i class="fa-solid fa-ticket"></i> Entradas y Salidas</a></li>
            <li><a href="{{ route('caja.index') }}"><i class="fa-solid fa-cash-register"></i> Caja y Facturación</a></li>
            <li><a href="{{ route('reportes.index') }}"><i class="fa-solid fa-file-excel"></i> Reportes y Estadísticas</a></li>
        </ul>
    </nav>

    <div id="content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-white"><i class="fa-solid fa-car text-info me-2"></i> Gestión de Vehículos</h5>
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
                <h5 class="text-info m-0">Parque Automotor Registrado</h5>
                <button type="button" class="btn btn-futuristic px-4" data-bs-toggle="modal" data-bs-target="#vehiculoModal" id="btnNuevoVehiculo">
                    <i class="fa-solid fa-car-side me-2"></i> Registrar Vehículo
                </button>
            </div>

            <div class="table-responsive">
                <table id="tablaVehiculos" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Placa</th>
                            <th>Propietario / Cliente</th>
                            <th>Tipo</th>
                            <th>Marca / Modelo</th>
                            <th>Color</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Vehículo -->
    <div class="modal fade" id="vehiculoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-info" id="modalTitulo">Registrar Nuevo Vehículo</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="vehiculoForm">
                    <input type="hidden" id="idvehiculo" name="idvehiculo">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="placa" class="form-label">Número de Placa *</label>
                            <input type="text" class="form-control text-uppercase fw-bold" id="placa" name="placa" required placeholder="Ej. 4501ABC">
                        </div>
                        <div class="mb-3">
                            <label for="id_cliente" class="form-label">Propietario / Cliente (Opcional)</label>
                            <select class="form-select" id="id_cliente" name="id_cliente">
                                <option value="">Sin cliente asociado (Vehículo ocasional)</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_tipo_vehículo" class="form-label">Tipo de Vehículo *</label>
                            <select class="form-select" id="id_tipo_vehículo" name="id_tipo_vehículo" required>
                                <option value="">Seleccione tipo...</option>
                                @foreach($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marca" class="form-label">Marca *</label>
                                <input type="text" class="form-control" id="marca" name="marca" required placeholder="Ej. Toyota">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modelo" class="form-label">Modelo *</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" required placeholder="Ej. Corolla">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="color" class="form-label">Color *</label>
                            <input type="text" class="form-control" id="color" name="color" required placeholder="Ej. Negro / Azul">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-futuristic btn-sm px-4">Guardar Vehículo</button>
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
        let tablaVehiculos;

        $(document).ready(function() {
            tablaVehiculos = $('#tablaVehiculos').DataTable({
                ajax: {
                    url: "{{ route('vehiculos.obtener') }}",
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'placa', render: function(data) { return `<span class="badge bg-dark border border-info text-info fw-bold px-2 py-1">${data}</span>`; } },
                    { data: 'cliente.nombre', defaultContent: '<span class="text-muted">Ocasional / Sin registrar</span>' },
                    { data: 'tipo_vehiculo.nombre', render: function(data) { return `<span class="badge bg-info text-dark">${data}</span>`; } },
                    { data: null, render: function(data) { return `${data.marca} ${data.modelo}`; } },
                    { data: 'color' },
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
                                    data-placa="${data.placa}" 
                                    data-cliente="${data.id_cliente || ''}" 
                                    data-tipo="${data.id_tipo_vehículo}" 
                                    data-marca="${data.marca}" 
                                    data-modelo="${data.modelo}" 
                                    data-color="${data.color}" 
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

            $('#btnNuevoVehiculo').on('click', function() {
                $('#vehiculoForm')[0].reset();
                $('#idvehiculo').val('');
                $('#modalTitulo').text('Registrar Nuevo Vehículo');
            });

            $('#vehiculoForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#idvehiculo').val();
                let url = id ? `/vehiculos/${id}` : "{{ route('vehiculos.store') }}";
                let formData = $(this).serialize() + (id ? '&_method=PUT' : '');

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        $('#vehiculoModal').modal('hide');
                        tablaVehiculos.ajax.reload();
                        Swal.fire({ icon: 'success', title: '¡Éxito!', text: res.message, timer: 1500, showConfirmButton: false, background: '#0f172a', color: '#ffffff' });
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message || "Verifica los datos.";
                        Swal.fire({ icon: 'error', title: 'Error', text: msg, background: '#0f172a', color: '#ffffff', confirmButtonColor: '#0284c7' });
                    }
                });
            });

            $(document).on('click', '.btn-editar', function() {
                $('#idvehiculo').val($(this).data('id'));
                $('#placa').val($(this).data('placa'));
                $('#id_cliente').val($(this).data('cliente'));
                $('#id_tipo_vehículo').val($(this).data('tipo'));
                $('#marca').val($(this).data('marca'));
                $('#modelo').val($(this).data('modelo'));
                $('#color').val($(this).data('color'));
                $('#modalTitulo').text('Editar Vehículo');

                new bootstrap.Modal(document.getElementById('vehiculoModal')).show();
            });

            $(document).on('click', '.btn-estado', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: '¿Cambiar estado del vehículo?',
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
                            url: `/vehiculos/${id}/estado`,
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function(res) {
                                tablaVehiculos.ajax.reload();
                                Swal.fire({ icon: 'success', title: '¡Actualizado!', text: res.message, timer: 1500, showConfirmButton: false, background: '#0f172a', color: '#ffffff' });
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>