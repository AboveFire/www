<?php

namespace App\Http\Controllers;

use App\Utilisateur_uti;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App;
use JWTAuth;
use Auth;

class PoolController extends Controller
{
    public function sinscrire (Request $request)
    {
    	DB::table('utilisateur_pool_utp')->insert(['UTP_UTI_SEQNC' => Auth::user()->UTI_SEQNC,'UTP_POO_SEQNC' => $request['poolCourant']]);
    }
}
