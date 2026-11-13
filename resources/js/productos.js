// Función reutilizable para limpiar el formulario y restablecer campos
function limpiarForm() {
    $('.productosForm')[0].reset();
    $('#idproducto').val('');
}

$(function(){
    cargarProductos();
});

function cargarProductos(){
    $.ajax({
        url: '/productos/obtenerProductos',
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done((res)=>{
        let productos = res.productos;
        let html = '';
        productos.forEach(producto => {
            html += `<tr>
                <td>${producto.id_productos}</td>
                <td>${producto.producto}</td>
                <td>${producto.categoria}</td>
                <td>${producto.precio}</td>
                <td>${producto.stock}</td>
                <td>
                    <div class="data-cell-actions">
                        <button class="btn btn--ghost btn-sm editar"
                            data-id="${producto.id_productos}"
                            data-producto="${producto.producto}"
                            data-categoria="${producto.categoria}"
                            data-precio="${producto.precio}"
                            data-stock="${producto.stock}"
                            data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">Actualizar</button>
                        <button class="btn btn-danger btn-sm eliminar" data-id="${producto.id_productos}">Eliminar</button>
                    </div>
                </td>
            </tr>`;
        });
        $('.productosTable tbody').html(html);
    });
}

// Evento para Editar: Rellena el formulario con los datos seleccionados
$(document).on('click', '.editar', function() {
    let id = $(this).data('id');
    let producto = $(this).data('producto');
    let categoria = $(this).data('categoria');
    let precio = $(this).data('precio');
    let stock = $(this).data('stock');
    
    $('#staticBackdropLabel').text('ACTUALIZAR PRODUCTO');
    $('#idproducto').val(id);
    $('#producto').val(producto);
    $('#categoria').val(categoria);
    $('#precio').val(precio);
    $('#stock').val(stock);
});

// Evento para abrir el modal en modo "Añadir" (Reutiliza limpiarForm)
$(document).on('click', '[data-bs-target="#staticBackdrop"]', function() {
    if (!$(this).hasClass('editar')) {
        $('#staticBackdropLabel').text('AÑADIR NUEVO PRODUCTO');
        limpiarForm(); // Reutilización de función
    }
});

// Evento de envío del formulario (Crear o Actualizar por AJAX sin recargar)
$(document).on('submit', '.productosForm', function(e) {
    e.preventDefault();
    let form = $(this).serialize();
    let id = $('#idproducto').val();
    let url = id ? `/productos/${id}` : '/productos';
    let method = id ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        method: method,
        data: form,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
            cargarProductos();
            limpiarForm(); // Reutilización de función tras éxito
            let modalEl = document.getElementById('staticBackdrop');
            let modal = bootstrap.Modal.getInstance(modalEl);
            if(modal) modal.hide();
            
            // Opcional con SweetAlert si está disponible
            if(typeof Swal !== 'undefined') {
                Swal.fire({ position: "top-end", icon: "success", title: res.message || "Operación exitosa", showConfirmButton: false, timer: 1500 });
            }
        },
        error: function(xhr) {
            alert("Ocurrió un error. Revisa los campos.");
        }
    });
});

// Evento para Eliminar por AJAX sin recargar
$(document).on('click', '.eliminar', function(e){
    e.preventDefault();
    let id = $(this).data('id');
    
    if(confirm("¿Estás seguro de eliminar este producto?")) {
        $.ajax({
            url: `/productos/${id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done((res)=>{
            cargarProductos();
        });
    }
});