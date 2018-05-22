<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\fixerio;

class HomeController extends Controller {

    public function index() {
        return view('home');
    }

    public function calculate(Request $request) {

        $currency_from = $request->input('currency_from');
        $currency_to = $request->input('currency_to');
        $currency_amount = $request->input('currency_amount');

        $requestValidationRules = [
            'currency_from' => 'required',
            'currency_to' => 'required',
            'currency_amount' => 'required|numeric|min:1',
        ];
        $validator = Validator::make($request->all(), $requestValidationRules);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $fixer = new fixerio();
        $amound = $fixer->calculate($currency_amount, $currency_from, $currency_to);
        if (!is_numeric($amound) || $amound == 0) {
            return back()->withErrors(['invalude response' => ['Error calculating your currency']]);
        }
        $viewData = [
            'currency_from'=>$currency_from,
            'currency_to'=>$currency_to,
            'currency_amount'=>$currency_amount,
            'calculated_amount'=>$amound
        ];
        return view('calculate', $viewData);
    }

}
