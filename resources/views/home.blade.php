@extends('layouts.app')

@section('content')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @guest
                    <div>déconnecté</div>
                @else
                    <div>connecté</div>
                    <table>
                        <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Créateur</th>
                            <th>Likes</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($dishes as $dish)
                            <tr>
                                <td>{{ $dish->titre }}</td>
                                <td>{{ $dish->createur }}</td>
                                <td>{{ $dish->likes }}</td>
                                <td>
                                    <form action="{{ route('articles.like', $dish->id) }}" method="POST">
                                        @csrf
                                        <button type="submit">♥</button>
                                    </form>
                                    <a href="{{ route('articles.show', $dish->id) }}" class="btn btn-primary">👁</a>
                                    <a href="{{ route('articles.edit', $dish->id) }}" class="btn btn-warning">🖋</a>
                                    <form action="{{ route('articles.destroy', $dish->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">🗑</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!-- Modal pour afficher les détails d'un article -->
                    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel">Détails de l'article</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p id="viewTitre"></p>
                                    <p id="viewCreateur"></p>
                                    <p id="viewLikes"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal pour éditer un article -->
{{--                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">--}}
{{--                        <div class="modal-dialog" role="document">--}}
{{--                            <div class="modal-content">--}}
{{--                                <div class="modal-header">--}}
{{--                                    <h5 class="modal-title" id="editModalLabel">Éditer l'article</h5>--}}
{{--                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                        <span aria-hidden="true">&times;</span>--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                                <div class="modal-body">--}}
{{--                                    <form action="{{ route('dishes.update', $SelectedDish->id) }}" method="POST">--}}
{{--                                        @csrf--}}
{{--                                        @method('PUT')--}}
{{--                                        <input type="text" name="titre" class="form-control" placeholder="Titre" value="{{ $SelectedDish->titre }}">--}}
{{--                                        <input type="text" name="createur" class="form-control" placeholder="Créateur" value="{{ $SelectedDish->createur }}">--}}
{{--                                        <input type="number" name="likes" class="form-control" placeholder="Likes" value="{{ $SelectedDish->likes }}">--}}
{{--                                        <button type="submit" class="btn btn-primary">Enregistrer</button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                @endguest
            </div>
        </div>
    </div>
@endsection
