<div class="post-list-container">
    @can('create-post')
        <div class="mb-4">
            <a href="{{ route('messagerie-sociale.create-post') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer un post
            </a>
        </div>
    @endcan
    
    @if($posts->count() > 0)
        <div class="post-list">
            @foreach($posts as $post)
                <div class="mb-4">
                    @livewire('nouvelle-messagerie.post-card', ['post' => $post], key('post-'.$post->id))
                </div>
            @endforeach
        </div>
        
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <h4 class="text-muted mb-3">Aucun post disponible</h4>
                @can('create-post')
                    <p>Soyez le premier à créer un post dans ce canal!</p>
                @else
                    <p>Aucun contenu n'a encore été publié dans ce canal.</p>
                @endcan
            </div>
        </div>
    @endif
</div> 