@extends('pages.template')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw1Esk5L6F8aJOTAj+CldBknwSW9/1SdFeDvOrvDFFMlI5SksmWO5fa/zIbbVJ" crossorigin="anonymous">
    </script>

    <div class="pagetitle">
        <h1>Création et Modification des Employés</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employés</a></li>
                <li class="breadcrumb-item active">Création</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Formulaire de Création des Employés</h5>
                        <form method="POST" action="{{ route('employees.store') }}">
                            @csrf
                            <!-- Champs pour le formulaire de création -->
                            <div class="row mb-3">
                                <label for="firstname" class="col-sm-4 col-form-label">Prénom :</label>
                                <div class="col-sm-8">
                                    <input type="text" name="firstname" id="firstname" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="lastname" class="col-sm-4 col-form-label">Nom :</label>
                                <div class="col-sm-8">
                                    <input type="text" name="lastname" id="lastname" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="contact" class="col-sm-4 col-form-label">Contact :</label>
                                <div class="col-sm-8">
                                    <input type="text" name="contact" id="contact" class="form-control">
                                </div>
                            </div>
{{--                            <div class="row mb-3">--}}
{{--                                <label for="photo" class="col-sm-4 col-form-label">Photo :</label>--}}
{{--                                <div class="col-sm-8">--}}
{{--                                    <input type="file" name="photo" id="photo" class="form-control">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="row mb-3">
                                <label for="email" class="col-sm-4 col-form-label">Email :</label>
                                <div class="col-sm-8">
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-sm-4 col-form-label">Mot de passe :</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password_confirmation" class="col-sm-4 col-form-label">Confirmer votre mot de passe :</label>
                                <div class="col-sm-8">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <!-- Bouton de soumission -->
                            <div class="row mb-3">
                                <div class="col-sm-12 text-end">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Liste des Employés</h5>
                        @if ($employees->isEmpty())
                            <p>Aucun administrateur trouvé.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{ $employee->id }}</td>
                                            <td>{{ $employee->user->lastname }}</td>
                                            <td>{{ $employee->user->email }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $employee->id }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $employee->id }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $employee->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $employee->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $employee->id }}">
                                                            Modifier l'administrateur</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Contenu du formulaire d'édition -->
                                                        <form
                                                            action="{{ route('employees.update', $employee->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <!-- Ajoutez ici les champs que vous souhaitez éditer -->
                                                            <div class="mb-3">
                                                                <label for="firstname" class="form-label">Prénom :</label>
                                                                <input type="text" class="form-control" id="firstname"
                                                                    name="firstname"
                                                                    value="{{ $employee->user->firstname }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="lastname" class="form-label">Nom :</label>
                                                                <input type="text" class="form-control" id="lastname"
                                                                    name="lastname"
                                                                    value="{{ $employee->user->lastname }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="contact" class="form-label">Contact :</label>
                                                                <input type="text" class="form-control" id="contact"
                                                                    name="contact"
                                                                    value="{{ $employee->user->contact }}">
                                                            </div>
{{--                                                            <div class="mb-3">--}}
{{--                                                                <label for="photo" class="form-label">Photo :</label>--}}
{{--                                                                <input type="file" class="form-control" id="photo"--}}
{{--                                                                    name="photo">--}}
{{--                                                                <!-- Affichez l'image actuelle -->--}}
{{--                                                                @if ($employee->user->photo)--}}
{{--                                                                    <img src="{{ asset('path/to/your/photos/' . $employee->user->photo) }}"--}}
{{--                                                                        alt="Current Photo" class="mt-2"--}}
{{--                                                                        style="max-width: 100px;">--}}
{{--                                                                @endif--}}
{{--                                                            </div>--}}
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email :</label>
                                                                <input type="email" class="form-control" id="email"
                                                                    name="email"
                                                                    value="{{ $employee->user->email }}">
                                                            </div>
{{--                                                            <div class="mb-3">--}}
{{--                                                                <label for="password" class="form-label">Mot de passe--}}
{{--                                                                    :</label>--}}
{{--                                                                <input type="password" class="form-control"--}}
{{--                                                                    id="password" name="password">--}}
{{--                                                                <!-- Ajoutez une option pour modifier le mot de passe si nécessaire -->--}}
{{--                                                            </div>--}}

                                                            <!-- ... (ajoutez d'autres champs) ... -->

                                                            <button type="submit" class="btn btn-primary">Enregistrer les
                                                                modifications</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $employee->id }}" tabindex="-1"
                                            aria-labelledby="deleteModalLabel{{ $employee->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteModalLabel{{ $employee->id }}">Supprimer
                                                            l'administrateur</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Êtes-vous sûr de vouloir supprimer l'administrateur
                                                        "{{ $employee->user->lastname }}" ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form
                                                            action="{{ route('employees.destroy', $employee->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit"
                                                                class="btn btn-danger">Supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Affichage de la pagination -->
                            {{ $employees->links() }}
                        @endif
                    </div>
                </div>
            </div>
    </section>
@endsection
