<?php

namespace App\Http\Livewire\NouvelleMessagerie;

use Livewire\Component;
use App\Models\MessagePost;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    
    protected $listeners = [
        'postCreated' => '$refresh',
        'postDeleted' => '$refresh',
        'commentAdded' => '$refresh'
    ];
    
    public function render()
    {
        $posts = MessagePost::with(['user', 'comments.user', 'attachments'])
            ->where('is_published', true)
            ->latest()
            ->paginate(10);
            
        return view('livewire.nouvelle-messagerie.post-list', [
            'posts' => $posts
        ]);
    }
} 