<?php

namespace App\Http\Controllers\Entreprises;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PackController extends Controller
{
    public function index()
    {
        return view('entreprises.packs.index');
    }
}