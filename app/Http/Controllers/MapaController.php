<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapaController extends Controller
{
    public function index()
    {
        $ubicaciones = DB::table('ubicaciones')->get();
        return view('mapa', compact('ubicaciones'));
    }

    public function buscar(Request $request)
    {
        $query = $request->get('q', '');
        $ubicaciones = DB::table('ubicaciones')
            ->where('nombre', 'like', "%{$query}%")
            ->get();
        return response()->json($ubicaciones);
    }
}
