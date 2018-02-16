<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\fixerio;

class HomeController extends Controller
{
    public function index(){

    	return view('home');
    }

    public function calculate(Request $request){

    	$request->validate([
		    'currency_from' => 'required',
		    'currency_to' => 'required',
		    'currency_amount' => 'required|numeric',
		]);

    	
    	$currency_from = $viewData['currency_from'] = $request->input('currency_from');
    	$currency_to = $viewData['currency_to'] = $request->input('currency_to');
    	$currency_amount = $viewData['currency_amount']  =$request->input('currency_amount');
    	try {
    		$fixer = new fixerio();
	    	$amound = $fixer->calculate($currency_amount,$currency_from,$currency_to);
	    	if(!is_numeric($amound) || $amound==0){
	    		return back()->withErrors(['invalude response' => ['Error calculating your currency']]);
	    	}

	    	$viewData['calculated_amount'] = $amound;
	    	return view('calculate',$viewData);

    	} catch (Exception $e) {
    		return back()->withErrors(['invalude response' => [$e->getMessage]]);
    	}
    	
    }
}
