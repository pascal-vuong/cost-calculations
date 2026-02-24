@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Reservering Overzicht</h1>

    <hr>

    <p><strong>Totaal spelers:</strong> {{ $result->count($result) }}</p>
    <p><strong>Totaal prijs:</strong> €{{ number_format($total, 2) }}</p>
    <p><strong>Prijs per speler:</strong> €{{ number_format($pricePerPlayer, 2) }}</p>

    <hr>

    <h3>Details per speler</h3>

    @foreach($result as $player)
        <div style="margin-bottom:10px; padding:10px; border:1px solid #ccc;">
            <p><strong>Speler {{ $player['speler'] }}</strong></p>
            <p>Type: {{ $player['type'] }}</p>
            <p>Prijs: €{{ number_format($player['price'], 2) }}</p>
        </div>
    @endforeach

</div>

@endsection