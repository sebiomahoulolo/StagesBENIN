@extends('layouts.layout')

@section('title', 'StagesBENIN')

@section('content')
<style>
body {
        font-family: 'Times New Roman', Times, serif;
    }
    </style>
<section class="contact-section py-5">
    <div class="container">
        <h1 class="text-center mb-4 text-primary">CONTACTEZ-NOUS</h1>
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="{{ asset('assets/images/contacts.jpg') }}" alt="Contact Image" class="img-fluid rounded shadow">
            </div>
            <div class="col-md-6">
               
                    <form action="{{ route('contact.send') }}" method="POST" class="border p-4 rounded shadow">
    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Objet</label>
                        <input type="text" id="subject" name="subject" class="form-control" placeholder="Objet" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea id="message" name="message" class="form-control" rows="5" placeholder="Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
