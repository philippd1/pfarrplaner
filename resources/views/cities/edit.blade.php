@extends('layouts.app')

@section('title', 'Kirchengemeinde bearbeiten')

@section('content')
    <form method="post" action="{{ route('cities.update', $city->id) }}" id="frm" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        @component('components.ui.card')
            @slot('cardFooter')
                <button id="btnSubmit" type="submit" class="btn btn-primary">Speichern</button>
            @endslot
            @tabheaders
                @tabheader(['id' => 'home', 'title' => 'Allgemeines', 'active' => true]) @endtabheader
                @tabheader(['id' => 'offerings', 'title' => 'Opfer']) @endtabheader
                @tabheader(['id' => 'calendars', 'title' => 'Externe Kalender']) @endtabheader
                @tabheader(['id' => 'podcast', 'title' => 'Podcast']) @endtabheader
            @endtabheaders
            @tabs
                @tab(['id' => 'home', 'active' => true])
                    @input(['name' => 'name', 'label' => 'Ort', 'value' => $city->name, 'enabled' => Auth::user()->can('ort-bearbeiten')])
                @endtab
                @tab(['id' => 'offerings'])
                    @input(['name' => 'default_offering_goal', 'label' => 'Opferzweck, wenn nicht angegeben', 'value' => $city->default_offering_goal])
                    @input(['name' => 'default_offering_description', 'label' => 'Opferbeschreibung bei leerem Opferzweck', 'value' => $city->default_offering_description])
                    @input(['name' => 'default_funeral_offering_goal', 'label' => 'Opferzweck für Beerdigungen', 'value' => $city->default_funeral_offering_goal])
                    @input(['name' => 'default_funeral_offering_description', 'label' => 'Opferbeschreibung für Beerdigungen', 'value' => $city->default_funeral_offering_description])
                    @input(['name' => 'default_wedding_offering_goal', 'label' => 'Opferzweck für Trauungen', 'value' => $city->default_wedding_offering_goal])
                    @input(['name' => 'default_wedding_offering_description', 'label' => 'Opferbeschreibung für Trauungen', 'value' => $city->default_wedding_offering_description])
                @endtab
                @tab(['id' => 'calendars'])
                    @input(['name' => 'public_events_calendar_url', 'label' => 'URL für einen öffentlichen Kalender auf elkw.de', 'value' => $city->public_events_calendar_url, 'enabled' => Auth::user()->can('ort-bearbeiten')])
                    @input(['name' => 'op_domain', 'label' => 'Domain für den Online-Planer', 'value' => $city->op_domain, 'enabled' => Auth::user()->can('ort-bearbeiten')])
                    @input(['name' => 'op_customer_key', 'label' => 'Kundenschlüssel (customer key) für den Online-Planer', 'value' => $city->op_customer_key, 'enabled' => Auth::user()->can('ort-bearbeiten')])
                    @input(['name' => 'op_customer_token', 'label' => 'Token (customer token) für den Online-Planer', 'value' => $city->op_customer_token, 'enabled' => Auth::user()->can('ort-bearbeiten')])
                @endtab
                @tab(['id' => 'podcast'])
                    @input(['name' => 'podcast_title', 'label' => 'Titel des Podcasts', 'value' => $city->podcast_title, 'enabled' => Auth::user()->can('ort-bearbeiten')])
                    @upload(['name' => 'podcast_logo', 'label' => 'Logo für den Podcast', 'value' => $city->podcast_logo, 'prettyName' => $city->name.'-Podcast-Logo', 'accept' => '.jpg,.jpeg'])
                    @upload(['name' => 'sermon_default_image', 'label' => 'Standard-Titelbild zur Predigt', 'value' => $city->sermon_default_image, 'prettyName' => $city->name.'-Standard-Predigtbild', 'accept' => '.jpg,.jpeg'])
                    @input(['name' => 'podcast_owner_name', 'label' => 'Herausgeber des Podcasts', 'value' => $city->podcast_owner_name, 'enabled' => Auth::user()->can('ort-bearbeiten')])
                    @input(['name' => 'podcast_owner_email', 'label' => 'E-Mailadresse für den Herausgeber des Podcasts', 'value' => $city->podcast_owner_email, 'enabled' => Auth::user()->can('ort-bearbeiten')])
                    @input(['name' => 'homepage', 'label' => 'Homepage der Kirchengemeinde', 'value' => $city->homepage, 'enabled' => Auth::user()->can('ort-bearbeiten')])
                @endtab
            @endtabs
    </form>
    @endcomponent
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#btnSubmit').click(function (e) {
                $('input').removeAttr('disabled');
            });
        });
    </script>
@endsection
