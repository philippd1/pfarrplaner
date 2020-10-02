@extends('layouts.app')

@section('title', 'Neue Zone anlegen')

@section('content')
    @component('components.container')
        <form method="post" action="{{ route('seatingSection.update', $seatingSection) }}">
            @csrf
            @method('PATCH')
            @component('components.ui.card')
                @slot('cardFooter')
                    <button type="submit" class="btn btn-primary">Speichern</button>
                @endslot
                @hidden(['name' => 'location_id', 'value' => $seatingSection->location_id])
                @input(['label' => 'Bezeichnung', 'name' => 'title', 'value' => $seatingSection->title])
                @select(['label' => 'Sitzplatzverteilung', 'name' => 'seating_model', 'items' => \App\Seating\SeatingModels::select(), 'value' => get_class($seatingSection->seating_model)])
            @endcomponent
        </form>
    @endcomponent
@endsection
