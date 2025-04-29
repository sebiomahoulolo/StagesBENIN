              @extends('layouts.admin.app')

              @section('title', 'StagesBENIN')

              @push('styles')
                  @section('content')
                      <div class="tab-content active" id="entreprises-content" role="tabpanel" aria-labelledby="entreprises-tab">
                          <div class="action-bar">
                              <div class="action-buttons">
                                  <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                      data-bs-target="#entrepriseModal">
                                      <i class="fas fa-plus-circle me-1"></i> Ajouter Entreprise
                                  </button>
                              </div>
                          </div>
                          <div class="content-area table-responsive">
                              <h4>Liste des Entreprises</h4>
                              @if (isset($entreprises) && !$entreprises->isEmpty())
                                  <table class="table table-hover table-bordered align-middle">
                                      <thead>
                                          <tr>
                                              <th>ID</th>
                                              <th>Nom</th>
                                              <th>Secteur</th>
                                              <th>Email</th>
                                              <th>Téléphone</th>
                                              <th>Logo</th>
                                              <th>Actions</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          @foreach ($entreprises as $entreprise)
                                              <tr>
                                                  <td>{{ $entreprise->id }}</td>
                                                  <td>{{ $entreprise->nom }}</td>
                                                  <td>{{ $entreprise->secteur ?? '-' }}</td>
                                                  <td>{{ $entreprise->email }}</td>
                                                  <td>{{ $entreprise->telephone ?? '-' }}</td>
                                                  <td>
                                                      @if ($entreprise->logo_path && Storage::exists($entreprise->logo_path))
                                                          <img src="{{ Storage::url($entreprise->logo_path) }}"
                                                              alt="Logo {{ $entreprise->nom }}"
                                                              style="width:40px;height:40px; object-fit:contain;">
                                                      @else
                                                          <span class="text-muted small">N/A</span>
                                                      @endif
                                                  </td>
                                                  <td>
                                                      <div class="d-flex gap-1 flex-wrap">
                                                          {{-- Ensure routes exist --}}
                                                          <a href="{{ route('entreprises.show', $entreprise->id) }}"
                                                              class="btn btn-info btn-sm" data-bs-toggle="tooltip"
                                                              title="Voir"><i class="fas fa-eye"></i></a>
                                                          <a href="{{ route('entreprises.contact', $entreprise->id) }}"
                                                              class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                                                              title="Contacter"><i class="fas fa-envelope"></i></a>
                                                          <a href="{{ route('entreprises.follow', $entreprise->id) }}"
                                                              class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                                              title="Suivre"><i class="fas fa-star"></i></a>
                                                          {{-- Assuming 'follow' means something like favorite/track --}}
                                                          <a href="{{ route('entreprises.edit', $entreprise->id) }}"
                                                              class="btn btn-warning btn-sm" data-bs-toggle="tooltip"
                                                              title="Modifier"><i class="fas fa-edit"></i></a>
                                                          <form action="{{ route('entreprises.destroy', $entreprise->id) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise?');"
                                                              style="display:inline;">
                                                              @csrf
                                                              @method('DELETE')
                                                              <button type="submit" class="btn btn-danger btn-sm"
                                                                  data-bs-toggle="tooltip" title="Supprimer"><i
                                                                      class="fas fa-trash"></i></button>
                                                          </form>
                                                      </div>
                                                  </td>
                                              </tr>
                                          @endforeach
                                      </tbody>
                                  </table>
                                  {{ $entreprises->links() }} {{-- Render pagination links --}}
                              @else
                                  <div class="alert alert-info">Aucune entreprise trouvée pour le moment.</div>
                              @endif
                          </div>
                      </div>
@endsection

@push('scripts')
    {{-- Scripts spécifiques si besoin --}}
@endpush