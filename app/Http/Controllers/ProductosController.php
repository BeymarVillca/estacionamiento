<?php
namespace App\Http\Controllers;
use App\Models\productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index()
    {
        $productos = productos::all();
        return view('productos.productos', compact('productos'));
    }

    public function create()
    {
        return view('productos.crear');
    }

   public function store(Request $request)
    {
        $request->validate([
            'producto' => 'required',
            'categoria' => 'required',
            'precio' => 'required',
            'stock' => 'required'
        ]);

        productos::create($request->all());

        return redirect()->route('productos.index')->with('success', '¡Tu producto a sido guardado con exito!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto' => 'required',
            'categoria' => 'required',
            'precio' => 'required',
            'stock' => 'required'
        ]);

        $producto = productos::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', '¡Actualizado con éxito!');
    }

    public function destroy($id)
    {
        $producto = productos::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index');
    }
}