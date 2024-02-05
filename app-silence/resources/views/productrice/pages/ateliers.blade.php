@extends('student.layouts.page', array('contentBackground' => '#161c30') )

@section('content')

    <div class="container-fluid">

        <div style="text-align: center; padding: 64px 0 32px; color: #FFF; font-size: 32px;">
            Votre espace d'apprentissage, <span style="color: #eb5887">{{ Auth::user()->name }}</span>
        </div>
        <div class="row" style="margin-left:5%;">

<div class="col-md-6 text-end" style="margin-bottom: 16px;">
    <button type="button" class="btn btn-orange btn-lg" data-bs-toggle="modal"
        data-bs-target="#createProjetModal">
        <i class="fas fa-plus-circle"></i>
        Ajouter un Atelier
    </button>
</div>

</div>
<style>

/* Styling modal */
.modal-window {
 position: fixed;
 background-color: rgba(255, 255, 255, 0.4);
 top: 0;
 right: 0;
 bottom: 0;
 left: 0;
 z-index: 999;
 visibility: hidden;
 opacity: 0;
 pointer-events: none;
 transition: all 0.3s;
}
.modal-window:target {
 visibility: visible;
 opacity: 1;
 pointer-events: auto;
}
.modal-window > div {
 width:50%;
 border:#505050 1px solid;
 position: absolute;
 top: 50%;
 left: 50%;
 transform: translate(-50%, -50%);
 padding: 2em;
 text-align: center;
 background: white;
}
.modal-window header {
 font-weight: bold;
}
.modal-window h1 {
 font-size: 150%;
 margin: 0 0 15px;
}
.modal-close {
 color: #de813b;
 line-height: 50px;
 font-size: 16px;
 position: absolute;
 right: 0;
 text-align: center;
 top: 0;
 width: 70px;
 text-decoration: none;
}

.modal-close:hover {
 color: black;
}
/* Demo Styles */


.modal-window > div {
 border-radius: 1rem;
}
.modal-window div:not(:last-of-type) {
 margin-bottom: 15px;
}
.logo {
 max-width: 150px;
 display: block;
}
small {
 color: lightgray;
}
/* Styling modal */
   
   .small-help-button {
       color: #d5972b;
       font-size: 1.2rem;
       cursor: pointer;
       position: relative;
       bottom: 6px;
       right: 4px;
       margin-right: -8px;

   }
  


.dropbtn {
  background-color: transparent;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
}

.dropup {
  position: relative;
  display: inline-block;
}

.dropup-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 160px;
  bottom: 50px;
  z-index: 1;
}

.dropup-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

.dropup-content a:hover {background-color: #ccc}

.dropup:hover .dropup-content {
  display: block;
}

.dropup:hover .dropbtn {
  background-color: #2980B9;
}

    .col-md-4  {
        padding: 20px;
        margin-bottom:20px;
    }
    .online-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }
</style>

<div class="container-fluid custom-container" style="color: #FFF; padding-top: 32px;">
    <div style="font-weight: lighter; font-size: 34px; margin: 16px 0 32px; color: #FFF;"> Les Ateliers En Ligne! </div>

    <div class="online-container"  style="margin-bottom: 50px;">
    @foreach($ateliers as $atelier)
    @if($atelier['enligne'] == 1)
            <div class="col-md-4 col-sm-6">
                    <a href="/productrice/parcours-film-fiction/{{$atelier['id']}}" class="tuile-ateliers">
                        <div class="titre">{{$atelier['phrase_accroche']}}</div>
                        <img src="{{$atelier['image']}}" />
                    </a>
                    <div style="margin-top: 10px; width:100%">
                        <a href="" class="btn btn-primary" data-bs-toggle="modal"
        data-bs-target="#update{{$atelier['id']}}">Modifier</a>
        @if($atelier['enligne'] == 1)
        <a href="#enligne{{$atelier['id']}}" class="btn btn-success" > En ligne</a>
        @else
        <a href="#enligne{{$atelier['id']}}" class="btn btn-primary" style="background-color:grey; border-color:grey;" > Brouillon</a>
        @endif

                        <a href="#delete{{$atelier['id']}}" class="btn btn-danger">Delete</a>
                    </div>
                </div>

 <!-- Creer projet modal -->
 <div class="modal fade" id="update{{$atelier['id']}}" tabindex="-1" role="dialog" aria-hidden="true">

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
                Modifier Atelier
            </h3>
            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">

        <form method="POST" action="ateliers/update/{{$atelier['id']}}">
               
        @csrf
            @method('PUT')
                    <div class="form-group">
                        <label class="text-white" for="nameInput">Nom du format</label>
                        <input type="text" class="form-control text-orange" id="formatInput" name="format"
                            value="{{$atelier['format']}}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-white" for="nameInput">Phrase d'accroche</label>
                        <input type="text" class="form-control text-orange" id="phrase_accrocheInput" name="phrase_accroche"
                            value="{{$atelier['phrase_accroche']}}">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-white" for="nameInput">Url image couverture</label>
                        <input type="text" class="form-control text-orange" id="imageInput" name="image"
                            value="{{$atelier['image']}}">
                    </div>
                    
                
    <br>
    <div class="form-group">
 <label class="text-white" for="nameInput">Disponnible pour : {{$atelier['public_cible']}} ?</label>
           <select class="form-control" id="cible" name="cible">
            <option value="Tous public">Tous public</option>
            <option value="Gar">Gar</option>
            <option value="Hors Gar">Hors Gar</option>

    </select>
    </div>
            <br>


                <div class="text-end">
                    <button type="submit"  class="btn btn-orange rounded-pill">
                        Créer
                    </button>
                </div>
            </div>

</form>
        </div>
    </div>
</div>

</div>


 <!-- Modal ajouter decoupage  -->
 <div id="public{{$atelier['id']}}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>

        <form method="POST" action="ateliers/cible/{{$atelier['id']}}">
           
           @csrf
           @method('PUT')

           <p style="color:black;"> Disponnible pour : {{$atelier['public_cible']}} ? </p>
                    <br>
            <select class="form-control" id="cible" name="cible">
                          <option value="Tous public">Tous public</option>
            <option value="Gar">Gar</option>
            <option value="Hors Gar">Hors Gar</option>

            </select>

           <br>
              <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Enregistrer</button>
            <br>
       </form>
     </div>
</div>
<!-- End The Modal -->

 <!-- Modal ajouter decoupage  -->
 <div id="enligne{{$atelier['id']}}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                  

                    <form method="POST" action="ateliers/active/{{$atelier['id']}}">
               
               @csrf
                   @method('PUT')
                   <input type="hidden"  name="enligne" value="1">
                  <p style="color:black;">  Etes vous sur de vouloir mettre en ligne le cours : {{$atelier['format']}} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Oui</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Nom<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
                         

 <!-- Modal ajouter decoupage  -->
 <div id="delete{{$atelier['id']}}" class="modal-window" >
     <div>

            <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
            <br>
                    <br>
                    <br>
                    <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
                  
                   <br>
                    <br>

                    <form action="ateliers/delete/{{$atelier['id']}}" method="POST" >
            @csrf
            @method('DELETE')
                  <p style="color:black;">  Etes vous sur de vouloir suprimer le cours : {{$atelier['format']}} ? </p>
                    <br>
                           
                                <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Suprimer</button>
                                <br>
                                <br>
                               <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

            </form>
     </div>
</div>
<!-- End The Modal -->
            @endif
            @endforeach
            </div>
            </div>
<br>
            <div style="font-weight: lighter; font-size: 34px; margin: 16px 0 32px; color: #FFF;"> Les Ateliers Hors Ligne ! </div>

<div class="online-container"  style="margin-bottom: 50px;">
@foreach($ateliers as $atelier)
@if($atelier['enligne'] == 0 )
        <div class="col-md-4 col-sm-6">
                <a href="/productrice/parcours-film-fiction/{{$atelier['id']}}" class="tuile-ateliers">
                    <div class="titre">{{$atelier['phrase_accroche']}}</div>
                    <img src="{{$atelier['image']}}" />
                </a>
                <div style="margin-top: 10px; width:100%">
                    <a href="" class="btn btn-primary" data-bs-toggle="modal"
    data-bs-target="#update{{$atelier['id']}}">Modifier</a>
    @if($atelier['enligne']  == 1)
    <a href="#enligne{{$atelier['id']}}" class="btn btn-primary" > En ligne</a>
    @else
    <a href="#enligne{{$atelier['id']}}" class="btn btn-primary" style="background-color:grey; border-color:grey;" > Brouillon</a>
    @endif

                    <a href="#delete{{$atelier['id']}}" class="btn btn-danger">Delete</a>

                </div>
            </div>

<!-- Creer projet modal -->
<div class="modal fade" id="update{{$atelier['id']}}" tabindex="-1" role="dialog" aria-hidden="true">

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
            Modifier Atelier
        </h3>
        <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">

    <form method="POST" action="ateliers/update/{{$atelier['id']}}">
           
    @csrf
        @method('PUT')
                <div class="form-group">
                    <label class="text-white" for="nameInput">Nom du format</label>
                    <input type="text" class="form-control text-orange" id="formatInput" name="format"
                        value="{{$atelier['format']}}">
                </div>
                <br>
                <div class="form-group">
                    <label class="text-white" for="nameInput">Phrase d'accroche</label>
                    <input type="text" class="form-control text-orange" id="phrase_accrocheInput" name="phrase_accroche"
                        value="{{$atelier['phrase_accroche']}}">
                </div>
                <br>
                <div class="form-group">
                    <label class="text-white" for="nameInput">Url image couverture</label>
                    <input type="text" class="form-control text-orange" id="imageInput" name="image"
                        value="{{$atelier['image']}}">
                </div>
            
<br>

<div class="form-group">
 <label class="text-white" for="nameInput">Disponnible pour : {{$atelier['public_cible']}} ?</label>
           <select class="form-control" id="cible" name="cible">
            <option value="Gar">Gar</option>
            <option value="Hors Gar">Hors Gar</option>
            <option value="Tous public">Tous public</option>
    </select>
    </div>
            <br>

            <div class="text-end">
                <button type="submit"  class="btn btn-orange rounded-pill">
                    Créer
                </button>
            </div>
        </div>

</form>
    </div>
</div>
</div>

</div>


<!-- Modal ajouter decoupage  -->
<div id="public{{$atelier['id']}}" class="modal-window" >
 <div>

        <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
        <br>
                <br>
                <br>
                <form method="POST" action="ateliers/cible/{{$atelier['id']}}">
           @csrf
           @method('PUT')

           <p style="color:black;">  Disponnible pour : {{$atelier['public_cible']}} ? </p>
                    <br>
           <select class="form-control" id="cible" name="cible">
                         <option value="Tous public">Tous public</option>
            <option value="Gar">Gar</option>
            <option value="Hors Gar">Hors Gar</option>
            
            </select>

            <br>
               <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Enregistrer</button>
             <br>
        </form>
 </div>
</div>
<!-- End The Modal -->

<!-- Modal ajouter decoupage  -->
<div id="enligne{{$atelier['id']}}" class="modal-window" >
 <div>

        <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
        <br>
                <br>
                <br>
              

         <form method="POST" action="ateliers/active/{{$atelier['id']}}">
           @csrf
           @method('PUT')
               <input type="hidden"  name="enligne" value="1">
              <p style="color:black;">  Etes vous sur de vouloir mettre en ligne le cours : {{$atelier['format']}} ? </p>
                <br>
                       
                            <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Oui</button>
                            <br>
                            <br>
                           <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Nom<a> 

        </form>
 </div>
</div>
<!-- End The Modal -->
                     

<!-- Modal ajouter decoupage  -->
<div id="delete{{$atelier['id']}}" class="modal-window" >
 <div>

        <a href="#" title="Close" class="modal-close" style="border-color:black;">X</a>
        <br>
                <br>
                <br>
                <i style="color: red;font-size: 120px; " class="fas fa-trash"></i>
              
               <br>
                <br>

                <form action="ateliers/delete/{{$atelier['id']}}" method="POST" >
                @csrf
                @method('DELETE')
              <p style="color:black;">  Etes vous sur de vouloir suprimer le cours : {{$atelier['format']}} ? </p>
                <br>
                       
                            <button type="submit" class="btn btn-danger btn-addsequence" style="width:40%; border-radius:30px;">Suprimer</button>
                            <br>
                            <br>
                           <a href="#" class="btn btn-primary btn-addsequence" style="width:40%; background-color:grey;border-color:grey; border-radius:30px;"> Annuler<a> 

        </form>
 </div>
</div>
<!-- End The Modal -->
@endif
        @endforeach

 <!-- Creer projet modal -->
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
                Nouveaux Atelier
            </h3>
            <div class="d-flex flex-column overflow-scroll" style="height: calc(100vh - 400px);">

        <form method="POST" action="ateliers/create">
               
        @csrf
 
                    <div class="form-group">
                        <label class="text-white" for="nameInput">Nom du format</label>
                        <input type="text" class="form-control text-orange" id="formatInput" name="format"
                            value="">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-white" for="nameInput">Phrase d'accroche</label>
                        <input type="text" class="form-control text-orange" id="phrase_accrocheInput" name="phrase_accroche"
                            value="">
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="text-white" for="nameInput">Url image couverture</label>
                        <input type="text" class="form-control text-orange" id="imageInput" name="image"
                            value="">
                    </div>
                
<br>


                <div class="text-end">
                    <button type="submit"  class="btn btn-orange rounded-pill">
                        Créer
                    </button>
                </div>
            </div>

</form>
        </div>
    </div>
</div>

</div>


        </div>


    </div>
@endsection
