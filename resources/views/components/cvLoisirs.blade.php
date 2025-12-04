<div class="form-section">
 
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-repeater-item" style="border-top: 2px solid var(--primary-color); padding-top:1.5rem;">
        <h5 style="margin-bottom: 1rem; color: var(--primary-color);">Ajouter un nouveau centre d'intérêt</h5>
        <form method="POST" action="{{ route('loisirs.store') }}">
            @csrf
            <div class="form-group mb-0">
                <label for="new_interet_nom" class="form-label">Intérêt <span style="color:red">*</span></label>
                <input type="text" id="new_interet_nom" name="loisir" class="form-control" placeholder="Nom de l'intérêt..." required>
            </div>
            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Ajouter
                </button>
            </div>
        </form>
    </div>

     </div> 

<style>
    .form-section { margin-bottom: 2rem; }
    .form-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid #dee2e6; }
    .form-section-header h4 { margin: 0; color: #343a40; }

    .interet-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.75rem;
    }

    .interet-item {
        position: relative;
        text-align: center;
    }

    .interet-card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 60px;
        padding: 1.5rem 0.5rem 0.5rem;
    }

    .interet-nom-display {
        background-color: #e8f4fc;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.9em;
        color: var(--primary-color, #0d6efd);
        display: inline-block;
        word-wrap: break-word;
        margin-top: 0;
        line-height: 1.4;
    }

    .interet-item .item-actions {
        position: absolute;
        top: 0.2rem;
        right: 0.2rem;
        display: flex;
        gap: 0.5rem;
        z-index: 10;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .interet-item:hover .item-actions,
    .interet-item:focus-within .item-actions {
        opacity: 1;
    }

    .interet-item .item-actions button {
        background: rgba(255, 255, 255, 0.7);
        border: none;
        padding: 3px 5px;
        border-radius: 3px;
        cursor: pointer;
        line-height: 1;
    }

    .interet-item .item-actions .edit-item-btn i,
    .interet-item .item-actions .delete-item-btn i {
        font-size: 0.85rem;
    }

    .interet-item .item-actions .edit-item-btn { color: var(--bs-primary, #0d6efd); }
    .interet-item .item-actions .delete-item-btn { color: var(--bs-danger, #dc3545); }

    .interet-item .item-actions .edit-item-btn:hover { color: var(--bs-primary-dark, #0a58ca); background: rgba(255, 255, 255, 0.9); }
    .interet-item .item-actions .delete-item-btn:hover { color: var(--bs-danger-dark, #b02a37); background: rgba(255, 255, 255, 0.9); }

    .interet-item.editing-item {
        grid-column: 1 / -1;
        margin-bottom: 1.5rem;
        text-align: left;
        box-shadow: none;
        background-color: transparent;
        padding: 0;
    }

    .interet-item.editing-item .p-3 {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 4px;
    }

    @media (max-width: 575.98px) {
        .interet-grid {
            gap: 0.5rem;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
        .interet-card-body {
            min-height: 50px;
            padding: 1.2rem 0.3rem 0.3rem;
        }
        .interet-nom-display {
            font-size: 0.85em;
            padding: 4px 10px;
        }
        .interet-item .item-actions {
            top: 0.1rem;
            right: 0.1rem;
            gap: 0.3rem;
        }
        .interet-item .item-actions button {
            padding: 2px 4px;
        }
        .interet-item .item-actions i {
            font-size: 0.8rem;
        }
        .form-section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }

    :root {
        --primary-color: #0d6efd;
        --bs-danger: #dc3545;
        --bs-primary: #0d6efd;
    }
</style>
