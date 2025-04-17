@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')

<style>
    .catalog-container {
        margin: 30px 0;
    }
    
    .catalog-title {
        text-align: center;
        font-weight: bold;
        margin-bottom: 30px;
        color: #0056b3;
    }
    
    .catalog-item {
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    
    .catalog-item:hover {
        transform: translateY(-5px);
    }
    
    .catalog-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    
    .catalog-content {
        padding: 15px;
    }
    
    .catalog-title {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 10px;
    }
    
    .catalog-desc {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .catalog-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background-color: #f8f9fa;
        border-top: 1px solid #eee;
    }
    
    .catalog-date {
        color: #777;
        font-size: 13px;
    }
    
    .btn-consult {
        background-color: #0056b3;
        color: white;
        padding: 6px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.2s;
    }
    
    .btn-consult:hover {
        background-color: #003d80;
        text-decoration: none;
        color: white;
    }
</style>

<div class="container catalog-container">

    
    <div class="row">
        @foreach($catalogues as $catalogue)
            <div class="col-md-4">
                <div class="catalog-item">
                    @if($catalogue->image)
                        <img src="{{ asset('assets/images/formations/' . $catalogue->image) }}" alt="{{ $catalogue->titre }}" class="catalog-image">
                    @endif
                    
                    <div class="catalog-content">
                        <h4 class="catalog-title">{{ $catalogue->titre }}</h4>
                        <p class="catalog-desc">{{ $catalogue->description }}</p>
                    </div>
                    
                    <div class="catalog-footer">
                        <span class="catalog-date">
                            {{ \Carbon\Carbon::parse($catalogue->created_at)->locale('fr')->format('d F Y') }}
                        </span>
                       <a href="{{ route('catalogueplus', ['id' => $catalogue->id]) }}" class="btn-consult">CONSULTER »</a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection