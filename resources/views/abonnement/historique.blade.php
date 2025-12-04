@extends('layouts.app')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">Historique de mes abonnements</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            @if($abonnements->isEmpty())
                <div class="alert alert-info">Aucun abonnement trouvé.</div>
            @else
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Type</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($abonnements as $abonnement)
                            <tr>
                                <td>{{ \\Carbon\\Carbon::parse($abonnement->date_debut)->format('d/m/Y') }}</td>
                                <td>{{ \\Carbon\\Carbon::parse($abonnement->date_fin)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($abonnement->type) }}</td>
                                <td>
                                    @if($abonnement->estActif())
                                        <span class="badge bg-success">Actif</span>
                                    @else
                                        <span class="badge bg-secondary">Expiré</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection 