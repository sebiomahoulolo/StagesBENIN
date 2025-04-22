<form action="{{ route('events.store') }}" method="POST">
    @csrf
    <label for="title">Titre :</label>
    <input type="text" name="title" required>

    <label for="description">Description :</label>
    <textarea name="description" required></textarea>

    <label for="start_date">Date de début :</label>
    <input type="datetime-local" name="start_date" required>

    <label for="end_date">Date de fin :</label>
    <input type="datetime-local" name="end_date">

    <button type="submit">Ajouter l’événement</button>
</form>
