<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Apartment;
use App\Message;

class ApartmentController extends Controller
{

     //salva il messaggio
    public function sendmessage(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'lastname' => 'required|max:2000',
            'email' => 'required|email',
            'text' => 'required',
        ]);
        $dati = $request->all();
        $dati['apartment_id'] = $id;
        $message = new Message();
        $message->fill($dati);
        $message->save();
        return redirect()->back()->with('message', 'Messaggio inviato con successo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $apartment = Apartment::find($id);

//se l'$utente loggato non è il proprietario dell'appartamento non conto la view
        $utente = Auth::id();
        if (!$apartment->user_id == $utente) {
            DB::table('apartments')->where('id', $id)->increment('views', 1);
        }

        if($apartment){
            if (Auth::check()) {
                $user = Auth::user();
                $data = [
                    'apartment' => $apartment,
                    'user' => $user
                ];
            }else{
                $data = [
                    'apartment' => $apartment
                ];
            }
            return view('show', $data);
        }else{
             return abort('404');
        }
    }

}
