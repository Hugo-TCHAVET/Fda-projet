<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use App\Mail\ContactMail;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;


class ClientController extends Controller
{
    //


    public function index()
    {
        return view('Client.service');
    }

    public function Formulaire()
    {
        return view('Client.formulaire');
    }

    public function SuivreDemande()
    {
       
        return view('Client.suivredemande');
    }



    public function RechercheDemande(Request $request)
    {
       $code = $request->input('code');
       $service = $request->input('service');
       //dd($demande);
      // $stage = Demande1::where($demande,'code');
      //$stage1 = DB::table('demande1s')->where('code','=',$demande)->first();
       $demande = Demande::where('code',$code)
                        ->where('service',$service)
                        ->first();
      
        
      // $accept = DB::table('accepters')->where('code','=',$demande)->first();
         // dd($stage);
        if($demande)
        {
           return view('Client.recherchedemande',compact('demande'));
        }else{
            Alert::toast('Le Code de suivie que vous avez insérer est incorrecte', 'error')->position('top-end')->timerProgressBar();
            return back();
         }
        
       
    }

    public function About()
    {
        return view('Client.about');
    }
    
    public function Contact()
    {
      return view('Client.contact');
    }

    public function nousContacter(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        ];

        Mail::to('huguesrichardmongadji@gmail.com')->send(new ContactMail($data));

        Alert::toast('Votre message a été envoyé avec succès!', 'success')->position('top-end')->timerProgressBar();
        return redirect()->route('client.contact');
    }
    
    
    public function statistiqueDepartement()
    {
        $totalDemandes = Demande::count();

        $data = Departement::leftJoin('demandes', 'departements.id', '=', 'demandes.departement')
            ->groupBy('departements.id', 'departements.nom') // Inclure departements.nom dans GROUP BY
            ->selectRaw('departements.id, departements.nom as nom_departement, count(demandes.id) as count')
            ->get();

        $data = $data->map(function ($item) use ($totalDemandes) {
            $item['percentage'] = $totalDemandes > 0 ? ($item['count'] / $totalDemandes) * 100 : 0;
            return $item;
        });

        return view('Statistique.departement', ['data' => $data]);
    }


    public function statistiqueSexe()
    {
        $data = Demande::groupBy('sexe')
            ->selectRaw('sexe, count(*) as count')
            ->get();

        return view('Statistique.sexe', ['data' => $data]);
    }

    public function statistiqueService()
    {
        $data = Demande::groupBy('service')
            ->selectRaw('service, count(*) as count')
            ->get();

        return view('Statistique.service', ['data' => $data]);
    }

    public function statistiqueDemandeur()
    {
        $totalDemandes = Demande::count();
    
        $data = Demande::groupBy('type_demande')
            ->selectRaw('type_demande, count(*) as count')
            ->get();
    
        $data = $data->map(function ($item) use ($totalDemandes) {
            $item['percentage'] = $totalDemandes > 0 ? ($item['count'] / $totalDemandes) * 100 : 0;
            return $item;
        });
    
        return view('Statistique.demandeur', ['data' => $data]);
    }
}