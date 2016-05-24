<?php

namespace App\Http\Controllers;

use App\Utilisateur_uti;
use Illuminate\Http\Request;
use DB;
use App;
use Auth;

class ParamController extends Controller
{
    public function update(Request $request)
    {
    	$this->validate($request, [
    		'coulr' => 'required',
            'lang' => 'required|exists:langue_lan,lan_code',
    	]);
    	
    	$listLang = DB::table('langue_lan')->select('LAN_SEQNC')->where('LAN_CODE', '=', $request['lang'])->get();
    	$lang = "FR";
    	foreach ($listLang as $value){
    		$lang = $value->LAN_SEQNC;
    	}

    	Utilisateur_uti::where('UTI_SEQNC', '=',$request->seqnc)->update([
    			'uti_coulr' => $request['coulr'],
    			'uti_lan_seqnc' => $lang,
    	]);
    	
		App::setLocale(strtolower($lang));
        $_SESSION['lang'] = strtolower($lang);
        
    	return back()->with('status', 'general.success');
    }
}
