@extends('layouts.master')

@section('title')
result
@endsection

@section('content')

<div class = "container">
    <div class="wrapper">
        <form action="{{route('calculate')}}" method="post" name="currency_Form" class="form-xrate">       
            <h3 class="form-signin-heading">Welcome! please select your choise</h3>
            <hr class="colorgraph"><br>
            {{ csrf_field() }}
            <select name="currency_from" class="form-control" required="">
                <option>convert from</option>>
                @foreach(config('currencies') AS $ckey)
                <option value="{{$ckey}}">{{$ckey}} - {{ __('currency.'.$ckey) }}</option>
                @endforeach
            </select>

            <select name="currency_to" class="form-control" required="">
                <option>convert to</option>>
                @foreach(config('currencies') AS $ckey)
                <option value="{{$ckey}}">{{$ckey}} - {{ __('currency.'.$ckey) }}</option>
                @endforeach
            </select>

            <input type="number" class="form-control" name="currency_amount" placeholder="amount" required=""/>            

            <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="calculate" type="Submit">convert</button>            
        </form>         
    </div>
</div>
@endsection