@component('mail::message')
# Melding datalek (AVG Art. 33)

Organisatie: **{{ config('app.name') }}**
Ontdekt op: **{{ $breach->discovered_at->format('d-m-Y H:i') }}**
Gemeld op: **{{ now()->format('d-m-Y H:i') }}**

## Beschrijving

{{ $breach->description }}

## Betrokken categorieën persoonsgegevens

@foreach ($breach->data_categories as $category)
- {{ $category }}
@endforeach

## Geschat aantal betrokkenen

{{ $breach->individuals_affected ?? 'Onbekend' }}

## Getroffen maatregelen

{{ $breach->measures_taken ?? 'Nog niet beschikbaar.' }}

---

*Dit bericht is automatisch gegenereerd door het systeem. Neem contact op met de organisatie voor aanvullende informatie.*
@endcomponent
