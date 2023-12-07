@extends('pages.template')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pzjw1Esk5L6F8aJOTAj+CldBknwSW9/1SdFeDvOrvDFFMlI5SksmWO5fa/zIbbVJ" crossorigin="anonymous">
    </script>

    <div class="pagetitle">
        <h1>Création et Modification des Projets</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projets</a></li>
                <li class="breadcrumb-item active">{{ isset($project) ? 'Modification' : 'Création' }}</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ isset($project) ? 'Modifier le Projet' : 'Formulaire de Création des Projets' }}</h5>
                        <form method="POST" action="{{ isset($project) ? route('projects.update', $project->id) : route('projects.store') }}">
                            @csrf
                            @if(isset($project))
                                @method('PUT')
                            @endif

                            <div class="row mb-3">
                                <label for="status_id" class="col-sm-4 col-form-label">Statut :</label>
                                <div class="col-sm-8">
                                    <select name="status_id" id="status_id" class="form-select">
                                        @if(isset($project))
                                            <option value="{{ $project->status?->id }}">{{ $project->status?->label }}</option>
                                        @endif
                                        @foreach($status as $item)
                                            @if(isset($project) && $project->status?->id == $item->id)
                                                @php continue @endphp
                                            @else
                                                <option value="{{ $item->id }}">{{ $item->label }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="label" class="col-sm-4 col-form-label">Label :</label>
                                <div class="col-sm-8">
                                    <input type="text" name="label" id="label" class="form-control" value="{{ isset($project) ? $project->label : old('label') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="description" class="col-sm-4 col-form-label">Description :</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="description" name="description" rows="3">{{ isset($project) ? $project->description : old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="budget" class="col-sm-4 col-form-label">Budget :</label>
                                <div class="col-sm-8">
                                    <input type="number" name="budget" id="budget" class="form-control" value="{{ isset($project) ? $project->budget : old('budget') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="start_date" class="col-sm-4 col-form-label">Date de début :</label>
                                <div class="col-sm-8">
                                    <input type="date" name="start_date"  id="start_date" class="form-control" value="{{ \Carbon\Carbon::parse(isset($project) ? $project->start_date : old('start_date'))->format('d/m/y') }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="end_date" class="col-sm-4 col-form-label">Date de fin :</label>
                                <div class="col-sm-8">
                                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ isset($project) ? $project->end_date : old('end_date') }}">
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="row mb-3">
                                <div class="col-sm-12 text-end">
                                    <button type="submit" class="btn btn-primary">{{ isset($project) ? 'Enregistrer les modifications' : 'Enregistrer' }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @if(isset($projects))
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Liste des Projets</h5>
                            @if ($projects->isEmpty())
                                <p>Aucun administrateur trouvé.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Porteur de projet</th>
                                        <th>Label</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Debut</th>
                                        <th>Fin</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $project->id }}</td>
                                            <td>{{ $project->user->email }}</td>
                                            <td>{{ $project->label }}</td>
                                            <td>{{ $project->description }}</td>
                                            <td>{{ $project->status->label }}</td>
                                            <td>{{ $project->start_date }}</td>
                                            <td>{{ $project->end_date }}</td>
                                            <td>
                                                {{--                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"--}}
                                                {{--                                                    data-bs-target="#editModal{{ $project->id }}">--}}
                                                {{--                                                    Edit--}}
                                                {{--                                                </button>--}}
                                                <a class="btn btn-sm btn-primary" href="{{ route('projects.edit', $project->id) }}">Edit</a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $project->id }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal{{ $project->id }}" tabindex="-1"
                                             aria-labelledby="editModalLabel{{ $project->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $project->id }}">
                                                            Modifier l'administrateur</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Contenu du formulaire d'édition -->
                                                        <form
                                                            action="{{ route('projects.update', $project->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <!-- Ajoutez ici les champs que vous souhaitez éditer -->
                                                            <div class="mb-3">
                                                                <label for="firstname" class="form-label">Prénom :</label>
                                                                <input type="text" class="form-control" id="firstname"
                                                                       name="firstname"
                                                                       value="{{ $project->user->firstname }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="lastname" class="form-label">Nom :</label>
                                                                <input type="text" class="form-control" id="lastname"
                                                                       name="lastname"
                                                                       value="{{ $project->user->lastname }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="contact" class="form-label">Contact :</label>
                                                                <input type="text" class="form-control" id="contact"
                                                                       name="contact"
                                                                       value="{{ $project->user->contact }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="photo" class="form-label">Photo :</label>
                                                                <input type="file" class="form-control" id="photo"
                                                                       name="photo">
                                                                <!-- Affichez l'image actuelle -->
                                                                @if ($project->user->photo)
                                                                    <img src="{{ asset('path/to/your/photos/' . $project->user->photo) }}"
                                                                         alt="Current Photo" class="mt-2"
                                                                         style="max-width: 100px;">
                                                                @endif
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email :</label>
                                                                <input type="email" class="form-control" id="email"
                                                                       name="email"
                                                                       value="{{ $project->user->email }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label">Mot de passe
                                                                    :</label>
                                                                <input type="password" class="form-control"
                                                                       id="password" name="password">
                                                                <!-- Ajoutez une option pour modifier le mot de passe si nécessaire -->
                                                            </div>

                                                            <!-- ... (ajoutez d'autres champs) ... -->

                                                            <button type="submit" class="btn btn-primary">Enregistrer les
                                                                modifications</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $project->id }}" tabindex="-1"
                                             aria-labelledby="deleteModalLabel{{ $project->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteModalLabel{{ $project->id }}">Supprimer
                                                            l'administrateur</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Êtes-vous sûr de vouloir supprimer l'administrateur
                                                        "{{ $project->user->lastname }}" ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form
                                                            action="{{ route('projects.destroy', $project->id) }}"
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
                                {{ $projects->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
