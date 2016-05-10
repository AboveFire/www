<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LangueController extends Controller
{
    public function switchLangue (Request $request)
	{
		if (!isset($_SESSION['lang']) || $_SESSION['lang'] == 'en')
		{
			$_SESSION['lang'] = 'fr';
		}
		else 
		{
			$_SESSION['lang'] = 'en';
		}
		
		return back();
	}
}
