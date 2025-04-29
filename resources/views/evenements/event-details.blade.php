@extends('layouts.admin.app')

@section('title', 'StagesBENIN')

@push('styles')
    @section('content')


    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .event-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .event-header img {
            width: 150px;
        }
        .event-details {
            border: 1px solid #ddd;
            padding: 10px;
        }
        .event-details h1 {
            font-size: 24px;
            color: #007BFF;
        }
    </style>

    <div class="event-header">
        <img src="{{ asset('images/events/' . $event->image) }}" alt="{{ $event->title }}">
        <h1>{{ $event->title }}</h1>
    </div>
    <div class="event-details">
        <p><strong>Date :</strong> {{ $event->start_date }}</p>
        <p><strong>Catégorie :</strong> {{ $event->categorie }}</p>
        <p><strong>Localisation :</strong> {{ $event->location }}</p>
        <p>{{ $event->description }}</p>
    </div>

      @endsection
    @push('scripts')
        {{-- Scripts spécifiques si besoin --}}
    @endpush
