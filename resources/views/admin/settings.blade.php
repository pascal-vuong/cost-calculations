@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Reservering Instellingen</h1>

    <hr>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <div>
            <label>Basistarief (€)</label>
            <input type="number" step="0.01" name="base_price"
                   value="{{ $settings->base_price ?? '' }}" required>
        </div>

        <div>
            <label>Extra toeslag (€)</label>
            <input type="number" step="0.01" name="extra_fee"
                   value="{{ $settings->extra_fee ?? '' }}" required>
        </div>

        <div>
            <label>Max aantal spelers</label>
            <input type="number" name="player_limit"
                   value="{{ $settings->player_limit ?? '' }}" required>
        </div>

        <div>
            <label>GreenFee (%)</label>
            <input type = 'number'
                   step = '1'
                   min = '0'
                   max = '100'
                   name = 'greenfee'
                   value = '{{ old('greenfee', $settings->greenfee * 100) }}'>
        </div>

        <div>
            <label>Member korting (%)</label>
            <input type = 'number'
                   step = '1'
                   min = '0'
                   max = '100'
                   name = 'member_discount'
                   value = '{{ old('member_discount', $settings->member_discount * 100) }}'>
        </div>

        <div>
            <label>Super Member korting (%)</label>
            <input type = 'number'
                   step = '1'
                   min = '0'
                   max = '100'
                   name = 'super_member_discount'
                   value = {{ old('super_member_discount', $settings->super_member_discount * 100) }}>
        </div>

        <hr>

        <button type="submit">Opslaan</button>
    </form>
</div>

@endsection