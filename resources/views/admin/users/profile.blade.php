@extends('layouts.dashboard')

@section('content')
    
<h1>Dati Utente</h1>
<div class="card" style="width: 18rem;">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">{{Auth::user()->name}}</li>
        <li class="list-group-item">{{Auth::user()->email}}</li>

        {{-- verifico se c'è api_token in tabella per stampare o generare --}}
        @if (Auth::user()->api_token)
            <li class="list-group-item">{{Auth::user()->api_token}}</li>
        @else
            <form action="{{route('admin_generate_token')}}" method="post">
                @csrf
                @method('POST')
                <button class="btn btn-info" type="submit">Genera API token</button>
            
            </form>
        @endif
    </ul>
  </div>

@endsection