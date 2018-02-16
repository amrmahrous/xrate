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

        $validator = Validator::make($request->all(), [
                    'currency_from' => 'required',
                    'currency_to' => 'required',
                    'currency_amount' => 'required|numeric|min:1',
        ]);

        $validator->after(
                function ($validator) use ($request) {
            if (!in_array($request->input('currency_from'), config('currencies'))) {
                $validator->errors()->add('currency_from', 'Something is wrong with currency_from!');
            }
            if (!in_array($request->input('currency_to'), config('currencies'))) {
                $validator->errors()->add('currency_to', 'Something is wrong with currency_to');
            }
        }
        );
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $currency_from = $viewData['currency_from'] = $request->input('currency_from');
        $currency_to = $viewData['currency_to'] = $request->input('currency_to');
        $currency_amount = $viewData['currency_amount'] = $request->input('currency_amount');

        try {
            $fixer = new fixerio();
            $amound = $fixer->calculate($currency_amount, $currency_from, $currency_to);
            if (!is_numeric($amound) || $amound == 0) {
                return back()->withErrors(['invalude response' => ['Error calculating your currency']]);
            }

            $viewData['calculated_amount'] = $amound;
            return view('calculate', $viewData);
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return back()->withErrors(['invalude response' => ['Error handling our converter , please come back later']]);
        }
    }

}
