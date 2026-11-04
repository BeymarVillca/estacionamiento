@extends('layouts.principal')
@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">USUARIOS</span>
        <h1 class="hero-title">PRODUCTOS</h1>
        <p class="hero-sub"></p>
    </div>
    <div class="hero-actions">
        <button type="button" class="btn btn--primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" fill="none"><path d="M12 5v14M5 12h14" /></svg> Añadir producto
        </button>
    </div>
</section>

<div class="grid">
    <section class="col-12 card">
        <div style="overflow-x:auto;margin:0 -22px">
            <table class="data-table" style="margin:0 22px;min-width:900px">
                <thead>
                    <tr>
                        <th>N</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Categoria</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody> 
                    @foreach ($productos as $prod)
                        <tr class="data-row"> 
                            <td>{{$prod->id_productos}}</td>
                            <td>{{$prod->producto}}</td>
                            <td>{{$prod->precio}}</td>
                            <td>{{$prod->categoria}}</td>
                            <td>{{$prod->stock}}</td>
                            <td>
                                <div class="data-cell-actions">
                                    <button type="button" class="btn btn--ghost btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditar{{$prod->id_productos}}">
                                        Actualizar
                                    </button>

                                    <form id="form-eliminar-{{$prod->id_productos}}" action="{{ route('productos.destroy', $prod->id_productos) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-id="{{$prod->id_productos}}">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
</div>


@foreach ($productos as $prod)
<!-- MODAL ACTUALIZAR -->
<div class="modal fade" id="modalEditar{{$prod->id_productos}}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--card-bg, #fff); color: inherit;">
            <div class="modal-header">
                <h5 class="modal-title">ACTUALIZAR PRODUCTO: {{$prod->producto}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-editar-{{ $prod->id_productos}}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Producto</label>
                        <input type="text" name="producto" class="form-control" value="{{$prod->producto}}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <input type="text" name="categoria" class="form-control" value="{{$prod->categoria}}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control" value="{{$prod->precio}}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" value="{{$prod->stock}}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- MODAL CREAR -->
<div class="modal fade" id="modalCrear" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--card-bg, #fff); color: inherit;">
            <div class="modal-header">
                <h5 class="modal-title">AÑADIR NUEVO PRODUCTO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form id="form-crear">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Producto</label>
                        <input type="text" name="producto" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoria</label>
                        <input type="text" name="categoria" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stock</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    
    @if(session('success'))
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    const botonesEliminar = document.querySelectorAll('.btn-eliminar');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esta acción!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-eliminar-' + id).submit();
                }
            });
        });
    });
});
</script>
@endsection