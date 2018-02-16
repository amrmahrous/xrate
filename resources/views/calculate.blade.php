@extends('layouts.master')
@section('title')
result
@endsection
@section('content')

<div class = "container">
    <div class="wrapper">
        <div action="{{route('calculate')}}" method="post" name="currency_Form" class="form-xrate">       
            <h3 class="form-signin-heading">currency result</h3>
              <hr class="colorgraph"><br>
              
             <h5 class='text-center'>{{$currency_amount}} {{$currency_from}} = {{$calculated_amount}} {{$currency_to}}</h5>
              
             
              <a href="{{route('home')}}" class="btn btn-lg btn-primary btn-block"  >calculate again</a>            
        </div>         
    </div>
</div>
@endsection