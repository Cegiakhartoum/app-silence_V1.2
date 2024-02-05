
@extends('student.layouts.page-cours', ['contentBackground' => '#161c30'])

@php

// $parts = config('z-courses');
$cours = config('z-courses');

$parts = array();

foreach ($cours as $key => $item) {
   $parts[$item['partie']][$key] = $item;
}
@endphp
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12 text-center">
                <div>
                    <span class="orange-text" style="font-size: 1.3rem;"> Parcours {{$atelier['format']}} </span>
                </div>
                <div style="font-size: 3rem; color: #FFF;">
                {{$atelier['phrase_accroche']}}
                </div>
            </div>
        </div>

        <div class="col-md-6 text-end" style="margin-bottom: 16px;">
    <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
        data-bs-target="#createProjetModal">
        <i class="fas fa-plus-circle"></i>
        Ajouter un Atelier
    </button>

    
</div>

@php
    use App\Http\Controllers\Productrice\AtelierController;
    $AtelierCtrl = new AtelierController();

@endphp
@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif
<div class="col-md-12">
    @foreach ($atelier_partis as $p)
        <div style="margin-top: 24px;">
            <span class="orange-text"> Partie </span>
            <span class="orange-text"> {{$p['public_cible']}}  </span>
        </div>
        <div style="font-size: 2rem; color: #FFF; margin: 8px 0;">
      {{$p['name']}} 
  <!-- Modify button -->
  <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
        data-bs-target="#editPartie{{$p['id']}}">
        <i class="fas fa-edit"></i>

    </button>
    <!-- Popup HTML -->
    <!-- Creer projet modal -->
 <div class="modal fade" id="editPartie{{$p['id']}}" tabindex="-1" role="dialog" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: #4a4d77;">
        <div class="modal-body">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                </button>
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                </button>
            </div>

    <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">

    <form method="POST" action="/productrice/ateliers/update-partie/{{$p['id']}}">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label class="text-white" for="nameInput">Partie</label>
        <input type="text" class="form-control text-orange" id="name" name="name" value="{{$p['name']}}">
    </div>

    <div class="form-group">
        <label class="text-white" for="nameInput">Apés</label>
        <select class="form-control" id="ordre" name="ordre">
            @foreach ($atelier_partis as $g)
                <option value="{{$g['id']}}">{{$g['name']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="text-white" for="nameInput">Disponnible pour : {{$p['public_cible']}} ?</label>
        <select class="form-control" id="cible_partie" name="cible_partie">
                      <option value="Tous public">Tous public</option>
            <option value="Gar">Gar</option>
            <option value="Hors Gar">Hors Gar</option>
   
        </select>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-orange rounded-pill">
            Mettre à jour
        </button>
    </div>
</form>
</div>
        </div>
    </div>
</div>

</div>

          <!-- Delete button -->
          <button type="button" class="btn btn-danger" data-bs-toggle="modal"
        data-bs-target="#deleteParti{{$p['id'] }}">
        <i class="fas fa-trash">

        </i></button>

</div>


                    

                       

 <!-- Modal delete chapitre  -->

    
<div class="modal fade" id="deleteParti{{$p['id'] }}" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #4a4d77;">
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="close btn btn-link" style="text-decoration: none;"
                        data-bs-dismiss="modal" aria-label="Close">
                        <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                    </button>
                    <button type="button" class="close btn btn-link" style="text-decoration: none;"
                        data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                    </button>
                </div>


                <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">

                        <form action="/productrice/delete-parti/{{$p['id'] }}" method="POST" >
                            @csrf
                            @method('DELETE')

                                <p style="color:black;">  Etes vous sur de vouloir suprimer le cours : {{$p['name'] }} ? </p>
                                    <br>
                                        
                                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Suprimer</button>
                                                <br>
                                                <br>
                                            <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

                
                        </form>
                        </div>
        </div>
    </div>
</div>

</div>

          <!-- Delete button -->

@php
    $chapters = $AtelierCtrl->findChapitre($p['id']);
@endphp
        @foreach ($chapters as $chapter)
          
                <div class="chapitre-cours">
                    <div>
                        <div>
                            <span style="margin-left: 2px; margin-right: 32px; background: rgba(255,255,255,0.3); border-radius:4px; padding:1px 8px;">
                                Chapitre
                            </span>
                            <span class="orange-text"> Durée : {{ $chapter['duration'] }} </span>
                          <span class="orange-text"> Public : {{ $p['public_cible'] }}  </span>
                        </div>
                        <div style="font-size: 1.2rem; color: #FFF; margin-top: 8px;">
                            <div contenteditable="true" style="outline: none;">
                                {{ $chapter['name'] }}
                            </div>
                        </div>
                        <div style="color: #aaa; margin-top: 8px;">
                            <div contenteditable="true" style="outline: none;">
                                {{ $chapter['description'] }}
                            </div>
                        </div>
                    </div>
                   
                </div>

            <div>

                        <!-- Modify button -->
                        <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
        data-bs-target="#editChapitre{{$chapter['id']}}">
        <i class="fas fa-edit"></i>

    </button>

    <!-- Popup HTML -->
<div class="modal fade" id="editChapitre{{$chapter['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: #4a4d77;">
        <div class="modal-body">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                </button>
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                </button>
            </div>

            <h3 class="text-center text-white">
                Modifier chapitre
            </h3>
            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">
            <form method="POST" action="/productrice/ateliers/update-chapitre/{{$chapter['id']}}">
            @csrf
            @method('PUT')

                    <input type="hidden" name="redirect_url" value="/productrice/parcours-film-fiction/{{$atelier['id']}}"/>
                    <input type="hidden" name="idchapitre" value="{{$chapter['id']}}"/>

                    <div class="form-group">
                        <label class="text-white" for="nameInput">Chapitre</label>
                        <input type="text" class="form-control text-orange" id="name" name="name"
                            value="  {{ $chapter['name'] }}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-white" for="nameInput">Description</label>
                        <input type="text" class="form-control text-orange" id="description" name="description"
                        value="  {{ $chapter['description'] }}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-white" for="nameInput">Duration</label>
                        <input type="text" class="form-control text-orange" id="duration" name="duration"
                        value="  {{ $chapter['duration']  }}">
                    </div>
                    <br>
                    <div class="form-group">
                    <label class="text-white" for="nameInput">Cible</label>
                    <select class="form-control" id="cible" name="cible">
                                <option value="Tous public">Tous public</option>
                    <option value="Gar">Gar</option>
                    <option value="Hors Gar">Hors Gar</option>
          
                    </select>
                    </div>
                   
                    <br>

                <div class="text-end">
                    <button type="submit" 
                        class="btn btn-orange rounded-pill">Créer</button>
                </div>
            </div>

        </form>
        </div>
            </div>
    
        </div>
    </div>
<!-- End The Modal -->


            
                        <!-- Delete button -->
                        <a href="/productrice/cours?c={{$chapter['cours_id']}}" class="btn btn-primary" ><i class="fa fa-eye"></i> </a>
                                                <!-- Delete button -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
        data-bs-target="#deletechapitre{{$chapter['id']}}">
        <i class="fas fa-trash"></i></button>
                       

 <!-- Modal delete chapitre  -->

    
     <div class="modal fade" id="deletechapitre{{$chapter['id']}}" tabindex="-1" role="dialog" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: #4a4d77;">
        <div class="modal-body">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                </button>
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                </button>
            </div>


            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">

                    <form action="/productrice/delete-chapitre/{{$chapter['id']}}" method="POST" >
            @csrf
            @method('DELETE')

                  <p style="color:black;">  Etes vous sur de vouloir suprimer le cours : {{$chapter['name']}} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Suprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            
                               </form>
                </div>
            </div>
        </div>
      
    </div>
<!-- End The Modal -->
                    </div>
                    <br>
        @endforeach
    @endforeach
</div>



            </div>
        </div>

    </div>


    <!-- Ajouter un cour dans un parti -->
    <div class="modal fade" id="createProjetModal" tabindex="-1" role="dialog" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="background-color: #4a4d77;">
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="close btn btn-link" style="text-decoration: none;"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                        </button>
                        <button type="button" class="close btn btn-link" style="text-decoration: none;"
                            data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                        </button>
                    </div>

                    <h3 class="text-center text-white">
                        Ajouter  Un chapitre
                    </h3>
                    <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">
                    <form method="POST" action="/productrice/create-chapitre"> 
    @csrf
    <div class="form-group">
        <label class="text-white" for="nameInput">Partie </label>
        <select name="partie_id" id="partie_id">
            @foreach ($atelier_partis as $p)
                <option value="{{ $p['id'] }}">{{ $p['name'] }}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
        data-bs-target="#createPartie">
        <i class="fas fa-plus-circle"></i>
    </button>

    </div>
    <div class="form-group">
        <label class="text-white" for="nameInput">Chapitre</label>
        <input type="text" class="form-control text-orange" id="name" name="name" placeholder="Nom du chapitre">
    </div>
    <br>
    <div class="form-group">
        <label class="text-white" for="nameInput">Description</label>
        <input type="text" class="form-control text-orange" id="description" name="description" placeholder="Description du chapitre">
    </div>
    <br>
    <div class="form-group">
        <label class="text-white" for="nameInput">Duration</label>
        <input type="text" class="form-control text-orange" id="duration" name="duration" placeholder="Durée du chapitre">
    </div>
    <br>
    <div class="form-group">
        <label class="text-white" for="nameInput">Après le chapitre </label>
        <select name="ordre_1" id="ordre_1">

        </select>
    </div>
    <br>
    <div class="form-group">
        <label class="text-white" for="nameInput">Cible</label>
        <select class="form-control" id="cible" name="cible">
                    <option value="Tous public">Tous public</option>
            <option value="Gar">Gar</option>
            <option value="Hors Gar">Hors Gar</option>
     
        </select>
    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function() {
        $('#partie_id').change(function() {
            var selectedPartieId = $(this).val();

            $.ajax({
                url: '/productrice/get-partie-data/' + selectedPartieId, // Endpoint pour récupérer les données des parties
                method: 'get', // Utilisez la méthode HTTP POST pour cette requête
                success: function(response) {
                    // Mettre à jour les données du formulaire en fonction de la réponse AJAX
                    // Par exemple, mettre à jour les options du select "ordre"
                    var ordreSelect = $('#ordre_1');
                    ordreSelect.empty();

                    if (response && response.length > 0) {
                        $.each(response, function(index, chapitre) {
                            ordreSelect.append($('<option></option>').val(chapitre.id).text(chapitre.name));
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    });
</script>

<div class="text-end">
        <button type="submit" class="btn btn-orange rounded-pill">Créer</button>
    </div>
</form>
                </div>
            </div>
        </div>
        </div>

    </div>
 <!-- Popup HTML -->
<div class="modal fade" id="createPartie" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color: #4a4d77;">
        <div class="modal-body">
            <div class="d-flex justify-content-between align-items-center">
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i style="color: #d5972b; font-size: 1.5em;" class="fas fa-arrow-alt-circle-left"></i>
                </button>
                <button type="button" class="close btn btn-link" style="text-decoration: none;"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: #d5972b; font-size: 2rem;">&times;</span>
                </button>
            </div>

            <h3 class="text-center text-white">
            Ajouter  Une Parti
            </h3>
            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">
            <form method="POST" action="/productrice/create-partie">
                        <input type="hidden" name="redirect_url" value="/productrice/parcours-film-fiction/{{$atelier['id'] }}"/>
                        <input type="hidden" name="atelier_id" value="{{$atelier['id'] }}" />
                            @csrf
                            <div class="form-group">
                                <label class="text-white" for="nameInput">Partie</label>
                                <input type="text" class="form-control text-orange" id="name" name="name"
                                    placeholder="Nom du projet">
                            </div>
                            <br>
                            <div class="form-group">
                                <label class="text-white" for="nameInput">Aprés parti </label>

                                <select name="ordre" id="ordre">
                                @foreach ($atelier_partis as $p) 
                                    <option value=" {{ $p['ordre'] }}"> {{$p['name'] }}</option>
                                @endforeach
                                </select>

                                
                                <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#createPartie">
                                    <i class="fas fa-plus-circle"></i>
                                </button>

                                <div class="form-group">
                    <label class="text-white" for="nameInput">Cible</label>
                    <select class="form-control" id="cible" name="cible">
                                <option value="Tous public">Tous public</option>
           <option value="Gar">Gar</option>
           <option value="Hors Gar">Hors Gar</option>

           </select>
           </div>
                            </div>
                            <br>

                        <div class="text-end">
                            <button type="submit" 
                                class="btn btn-orange rounded-pill">Créer</button>
                        </div>
                    </div>

                    </form>
        </div>
    </div>
</div>

</div>

<!-- JavaScript code -->

   


@endsection
