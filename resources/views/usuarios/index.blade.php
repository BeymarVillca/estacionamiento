<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Usuarios | Estacionamiento</title>
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
        
        /* Botón con degradado vivo */
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

        /* Estilos de la tabla DataTables en modo oscuro */
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
        
        /* Modales oscuros */
        .modal-content { background-color: #0f172a; border: 1px solid rgba(56, 189, 248, 0.3); color: #ffffff; }
        .modal-header, .modal-footer { border-color: rgba(56, 189, 248, 0.2); }
        .form-control { background-color: rgba(30, 41, 59, 0.6); border: 1px solid rgba(56, 189, 248, 0.3); color: #ffffff; }
        .form-control:focus { background-color: rgba(30, 41, 59, 0.9); border-color: #38bdf8; color: #ffffff; box-shadow: 0 0 10px rgba(56, 189, 248, 0.4); }
        .form-label { color: #94a3b8; }
    </style>
</head>
<body>

    <!-- =======================================
         Este es el Sidebar y sirve para navegar entre los módulos del sistema
         ======================================= -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3><i class="fa-solid fa-square-parking"></i> Estacionamiento</h3>
        </div>
        <ul class="list-unstyled components">
            <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
            <li class="active"><a href="{{ route('usuarios.index') }}"><i class="fa-solid fa-users-gear"></i> Seguridad / Usuarios</a></li>
            <li><a href="{{ route('clientes.index') }}"><i class="fa-solid fa-id-card"></i> Clientes / Abonados</a></li>
            <li><a href="{{ route('vehiculos.index') }}"><i class="fa-solid fa-car"></i> Gestión de Vehículos</a></li>
            <li><a href="{{ route('espacios.index') }}"><i class="fa-solid fa-warehouse"></i> Celdas / Espacios</a></li>
            <li><a href="{{ route('boletos.index') }}"><i class="fa-solid fa-ticket"></i> Entradas y Salidas</a></li>
            <li><a href="{{ route('caja.index') }}"><i class="fa-solid fa-cash-register"></i> Caja y Facturación</a></li>
            <li><a href="{{ route('reportes.index') }}"><i class="fa-solid fa-file-excel"></i> Reportes y Estadísticas</a></li>
        </ul>
    </nav>

    <!-- =======================================
         Este es el contenedor principal del módulo de usuarios
         ======================================= -->
    <div id="content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-white"><i class="fa-solid fa-users-gear text-info me-2"></i> Gestión de Usuarios y Accesos</h5>
            <div class="d-flex align-items-center">
                <span class="me-3 text-secondary">{{ Auth::user()->nombre ?? 'Administrador' }}</span>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-power-off"></i> Salir</button>
                </form>
            </div>
        </div>

        <!-- Tarjeta contenedora de la tabla -->
        <div class="card card-futuristic p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="text-info m-0">Lista de Usuarios Registrados</h5>
                <!-- Este es el botón para abrir el modal de registro de un nuevo usuario -->
                <button type="button" class="btn btn-futuristic px-4" data-bs-toggle="modal" data-bs-target="#usuarioModal" id="btnNuevoUsuario">
                    <i class="fa-solid fa-user-plus me-2"></i> Nuevo Usuario
                </button>
            </div>

            <!-- Tabla DataTables -->
            <div class="table-responsive">
                <table id="tablaUsuarios" class="table table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Los datos se cargan dinámicamente mediante AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- =======================================
         Este es el Modal único (Crear / Editar) para Usuarios
         ======================================= -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-info" id="modalTitulo">Registrar Nuevo Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="usuarioForm">
                    <input type="hidden" id="idusuario" name="idusuario">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej. Juan Pérez">
                        </div>
                        <div class="mb-3">
                            <label for="correo_electrónico" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo_electrónico" name="correo_electrónico" required placeholder="correo@estacionamiento.com">
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña <small class="text-muted" id="passHelp">(Obligatorio)</small></label>
                            <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="••••••••">
                        </div>
                        <div class="mb-3">
                            <label for="id_rol" class="form-label">Rol del Sistema</label>
                            <select class="form-control" id="id_rol" name="id_rol" required>
                                <option value="">Seleccione un rol...</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <!-- Este es el botón para guardar o actualizar el usuario -->
                        <button type="submit" class="btn btn-futuristic btn-sm px-4">Guardar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios (jQuery, Bootstrap, DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        let tablaUsuarios;

        $(document).ready(function() {
            // =======================================
            // Inicialización de la tabla con DataTables por AJAX
            // =======================================
            tablaUsuarios = $('#tablaUsuarios').DataTable({
                ajax: {
                    url: "{{ route('usuarios.obtener') }}",
                    dataSrc: 'data'
                },
                columns: [
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'correo_electrónico' },
                    { data: 'rol.nombre', render: function(data) { return `<span class="badge bg-info text-dark">${data}</span>`; } },
                    { 
                        data: 'estado', 
                        render: function(data) {
                            return data == 1 
                                ? '<span class="badge bg-success">Activo</span>' 
                                : '<span class="badge bg-secondary">Inactivo</span>';
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            let btnEstadoTexto = data.estado == 1 ? 'Desactivar' : 'Activar';
                            let btnEstadoClase = data.estado == 1 ? 'btn-outline-warning' : 'btn-outline-success';
                            let btnEstadoIcon = data.estado == 1 ? 'fa-ban' : 'fa-check';

                            return `
                                <button class="btn btn-sm btn-outline-info btn-editar me-1" data-id="${data.id}" data-nombre="${data.nombre}" data-correo="${data.correo_electrónico}" data-rol="${data.id_rol}" title="Editar">
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
            // Este evento sirve para limpiar el formulario al hacer clic en Nuevo Usuario
            // =======================================
            $('#btnNuevoUsuario').on('click', function() {
                $('#usuarioForm')[0].reset();
                $('#idusuario').val('');
                $('#modalTitulo').text('Registrar Nuevo Usuario');
                $('#contraseña').attr('required', true);
                $('#passHelp').text('(Obligatorio)');
            });

            // =======================================
            // Este evento sirve para enviar el formulario de crear o actualizar vía AJAX
            // =======================================
            $('#usuarioForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#idusuario').val();
                let url = id ? `/usuarios/${id}` : "{{ route('usuarios.store') }}";
                let method = id ? 'PUT' : 'POST';

                // Preparamos los datos simulando PUT con _method si es necesario o enviando normal por POST/PUT
                let formData = $(this).serialize() + (id ? '&_method=PUT' : '');

                $.ajax({
                    url: url,
                    method: 'POST', // Usamos POST con _method para compatibilidad perfecta con AJAX en Laravel
                    data: formData,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        $('#usuarioModal').modal('hide');
                        tablaUsuarios.ajax.reload();
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
                        let msg = "Ocurrió un error al procesar los datos.";
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: msg,
                            background: '#0f172a',
                            color: '#ffffff',
                            confirmButtonColor: '#0284c7'
                        });
                    }
                });
            });

            // =======================================
            // Este evento sirve para cargar los datos en el modal al hacer clic en Editar
            // =======================================
            $(document).on('click', '.btn-editar', function() {
                let id = $(this).data('id');
                let nombre = $(this).data('nombre');
                let correo = $(this).data('correo');
                let rol = $(this).data('rol');

                $('#idusuario').val(id);
                $('#nombre').val(nombre);
                $('#correo_electrónico').val(correo);
                $('#contraseña').val('');
                $('#contraseña').removeAttr('required');
                $('#passHelp').text('(Opcional: Dejar en blanco si no desea cambiarla)');
                $('#modalTitulo').text('Editar Usuario');

                let modal = new bootstrap.Modal(document.getElementById('usuarioModal'));
                modal.show();
            });

            // =======================================
            // Este evento sirve para activar o desactivar un usuario sin eliminarlo físicamente
            // =======================================
            $(document).on('click', '.btn-estado', function() {
                let id = $(this).data('id');

                Swal.fire({
                    title: '¿Cambiar estado del usuario?',
                    text: "El usuario cambiará su acceso al sistema.",
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
                            url: `/usuarios/${id}/estado`,
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function(res) {
                                tablaUsuarios.ajax.reload();
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