<?php

namespace App\Http\Controllers;

use App\Models\Negocio;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Negocio::query();

        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($qBuilder) use ($q) {
                $qBuilder
                    ->where('nombre', 'like', "%$q%")
                    ->orWhere('rubro', 'like', "%$q%")
                    ->orWhere('direccion', 'like', "%$q%");
            });
        }

        $negocios = $query->orderBy('nombre')->get();

        return view('dashboard.index', compact('negocios'));
    }
}
