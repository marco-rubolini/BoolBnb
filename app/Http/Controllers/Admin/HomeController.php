<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Apartment;
use App\Message;

class HomeController extends Controller
{
    public function index(){
        return view('admin.home');
    }

    public function readmessage(){
        // recupero l'id dell'utente loggato
        $id = Auth::id();
        // recupero i messaggi legati a questo utente
        $messages = DB::table('apartments')
            ->join('messages', 'apartments.id', '=', 'messages.apartment_id')
            ->where('user_id', $id)
            ->get();
        return view('admin.message', compact('messages'));
    }
}
