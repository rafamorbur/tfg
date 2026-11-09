<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function aviso() {
        return view('legal.aviso');
    }

    public function privacidad() {
        return view('legal.privacidad');
    }

    public function cookies() {
        return view('legal.cookies');
    }

    public function terminos() {
        return view('legal.terminos');
    }

    public function reembolsos() {
        return view('legal.reembolsos');
    }
}