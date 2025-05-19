@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @guest
                    <div>déconnecté</div>
                @else
                    <div>connecté</div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Créé par</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($dishes as $dish)
                            <tr>
                                <td>{{ $dish->name }}</td>
                                <td>{{ $dish->owner->name }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" onclick="showRecipeCard('{{ $dish->id }}')">
                                        Voir la recette
                                    </button>
                                </td>
                            </tr>
                            <tr id="recipe-card-{{ $dish->id }}" style="display: none;">
                                <td colspan="3">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title">Recette de {{ $dish->name }}</h5>
                                            <p class="card-subtitle text-muted">Créé par {{ $dish->owner->name }}</p>
                                            <img height="200" width="300" src="{{ "storage/" . $dish->image }}">
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('dishes.update', $dish) }}" name="dish-update-{{ $dish->id }}" method="POST" class="mt-3" >
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label for="dish-name-{{ $dish->id }}">Titre</label>
                                                    @can('edit dish')
                                                        <input type="text" required class="form-control" id="dish-name-{{ $dish->id }}" name="name" value="{{ $dish->name }}">
                                                    @else
                                                        <input readonly type="text" required class="form-control" id="dish-name-{{ $dish->id }}" name="name" value="{{ $dish->name }}">
                                                    @endcan
                                                </div>
                                                <div class="form-group">
                                                    <label for="dish-recipe-{{ $dish->id }}">Recette</label>
                                                    @can('edit dish')
                                                        <textarea maxlength="2048" class="form-control" id="dish-recipe-{{ $dish->id }}" name="recipe">{{ $dish->recipe }}</textarea>
                                                    @else
                                                        <textarea readonly maxlength="2048" class="form-control" id="dish-recipe-{{ $dish->id }}" name="recipe">{{ $dish->recipe }}</textarea>
                                                    @endcan
                                                </div>
                                                @can('edit dish')
                                                    <button type="submit" class="btn btn-warning">Mettre à jour</button>
                                                @endcan
                                            </form>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <div>
                                                    <form action="{{ route('likes.storeOrDelete') }}" method="POST" class="d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="dish_id" value="{{ $dish->id }}">
                                                        <button type="submit" class="btn {{ $dish->likedBy()->where('user_id', Auth::id())->exists() ? 'btn-outline-danger' : 'btn-danger' }}">
                                                            ♥ {{ $dish->likesCount() }}
                                                        </button>
                                                    </form>
                                                </div>
                                                @can('delete dish')
                                                <form action="{{ route('dishes.destroy', $dish->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');" class="d-inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Supprimer</button>
                                                </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">{{ $dishes->onEachSide(1)->links('pagination::bootstrap-5') }}</div>
                    @can('publish dish')
                        <div class="card mb-4" id="createForm" >
                            <div class="card-header">
                                <h5 class="card-title">Ajouter un nouveau plat</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dishes.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="dish-image">Image</label>
                                        <input required type="file" class="form-control-file" id="image" name="image">
                                    </div>
                                    <div class="form-group">
                                        <label for="dish-name">Titre</label>
                                        <input required type="text" class="form-control" id="dish-name" name="name" value="">
                                    </div>
                                    <div class="form-group">
                                        <label for="dish-recipe">Recette</label>
                                        <textarea maxlength="2048" class="form-control" id="dish-recipe" name="recipe"></textarea>
                                    </div>
                                    <input style="display: none" type="text" name="owner_id" class="form-control" readonly placeholder="Auteur" value="{{Auth::user()->id}}">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </form>
                            </div>
                        </div>
                    @endcan
                @endguest
            </div>
        </div>
    </div>

    <script>
        function showRecipeCard(dishId) {
            const recipeCard = document.getElementById(`recipe-card-${dishId}`);
            if (recipeCard.style.display === 'none') {
                recipeCard.style.display = 'table-row';
            } else {
                recipeCard.style.display = 'none';
            }
        }
    </script>
@endsection
