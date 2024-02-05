<style>

table{
    font-family: 'Quicksand Bold', sans-serif;
    font-size: 12px;
    text-align: center;
}


 /* Styling modal */
 .modal-window {
    position: fixed;
    background-color: rgba(255, 255, 255, 0.4);
    font-family: 'Zen Maru Gothic';
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
    width: 90%;
    height: 90%;
    border:#505050 1px solid;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 2em;
    overflow-y: scroll;
  scroll-behavior: smooth;
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

  li {
    display: inline;
  padding: 8px;
 
  }

  .grid-row {
    display: flex;
    flex-wrap: wrap;
    width: 90%;
    height: 600px;
  overflow-y: scroll;
  scrollbar-color: rebeccapurple green;
  scrollbar-width: thin;
    margin: 0 auto;
    padding-top: 30px;
    
  }
  
  .product {
    width: 25%;
    margin-bottom: 30px;
    padding-left: 15px;
    padding-right: 15px;
    display: flex;
   
  }

  .product--card {
    
    background: #fff;
    position: relative;
    overflow: hidden;
    width: 100%;
    font-family: 'Zen Maru Gothic';
    font-size: 12px;
    display: flex;
    flex-direction: column;
  
  }
  
  .product .product--image {
    padding-bottom: 67.88%;
    position: relative;
   
    -moz-box-sizing: content-box;
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
    display: block;
    overflow: hidden;
    height: 0;
  }
  
  .img-responsive {
    max-width: 100%;
    width: 100%;
    height: auto;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    transition: all 0.3s;
  }
  
  .product--title {
    display: block;
    color: #333;
    padding-bottom: 0 !important;
    text-decoration: none;
    padding: 5px;
  }
  
  .product--brand {
    color: #777;
    display: block;
    padding-top: 0 !important;
    padding: 5px;
    flex: 1 0 auto;
  }
  
  .product p {
    color: inherit;
    display: block;
    display: inline;
  }
  
  .product li {
    display:inline;
    padding-right: 6px;
  }
  
  
  .product .price--sell-price, 
  .product .price--discount-price {
    font-size: 1.5rem;
  }
  
  .price--sell-price {
    color: #28a528;
  }
  
  .product .product--price .was-price, 
  .product .product--price .price--rrp {
    font-size: 1rem;
  }
  
  .price--sell-price.was-price, 
  .price--rrp {
    color: #777;
    font-weight: 100;
    text-decoration: line-through;
  }
  
  .price--discount-price {
    color: #0074d9;
  }
  p {
      display: inline;
  }​
  .tags {
      display: block;
      position: absolute;
      z-index: 2;
      text-align: right;
      bottom: 6px;
      right: 12px;
  }
  .tags > .availability {
      text-transform: uppercase;
      color: #fff;
      line-height: 1;
      padding: 4px 5px;
      display: inline-block;
      margin-left: 6px;
      margin-bottom: 6px;    
    font-size: 0.75rem;
  }
  
  .tags > .availability.almost-gone {
      background-color: #ff9600;
  }
  
  .tags > .availability.discount {
      background-color: #0074d9;
  }
  
  .tags > .availability.sold-out {
      background-color: #ff0000;
  }
  
  #style:focus {     
    background-color:yellow;    
}

label {
  width: 100%;
}

.card-input-element {
  display: none;
}

.card-input {
  margin: 10px;
  padding: 00px;
}

.card-input:hover {
  cursor: pointer;
}

.card-input-element:checked + .card-input {
   box-shadow: 0 0 1px 3px #3b3e5e;
}

.container {
  width: 100%;
  height: 400px;
overflow-y: scroll;
scrollbar-color: 3b3e5e ;
scrollbar-width: thin;
}

.left select{
  border: #3b3e5e solid 1px;
  background-color: #3b3e5e;
  color: white;
  border-radius: 0;
  text-align: center;
  height: 30px;
  font-family: 'Quicksand Bold', sans-serif;
  width: 2px;
  
}
.middle {
  transition: .5s ease;
  opacity: 0;
  position: absolute;
  top: 20%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}
.product:hover .middle {
  opacity: 1;
}

.text {
  color: white;
  font-size: 16px;
  padding: 16px 32px;
}


.filter_list li{
  display: inline;
   padding: 2px ;
   font-size: 11px;
}

/* Dropdown Button */
.dropbtn {
  background-color: #3b3e5e;
  color: white;
  padding: 8px;
  font-size: 12px;
  border: none;
  width: 230px;
  height: 30px;
  font-family: 'zen maru gothic';
  cursor: pointer;
}

/* Dropdown button on hover & focus */
.dropbtn:hover, .dropbtn:focus {
  background-color: #3b3e5e;
}

/* The search field */
#myInput {
  box-sizing: border-box;
  background-image: url('searchicon.png');
  background-position: 14px 12px;
  background-repeat: no-repeat;
  font-size: 16px;
  padding: 14px 20px 12px 45px;
  border: none;
  border-bottom: 1px solid #ddd;
}

/* The search field when it gets focus/clicked on */
#myInput:focus {outline: 3px solid #ddd;}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f6f6f6;
width: 230px;
  border: 1px solid #ddd;
  z-index: 1;
  text-align: left;
  height: 400px;
  font-size: 12px;
overflow-y: scroll;
scrollbar-color: rebeccapurple green;
scrollbar-width: thin;
font-family: 'zen maru gothic';

}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu (use JS to add this class to the .dropdown-content container when the user clicks on the dropdown button) */
.show {display:block;}
.Suite {
  bottom: 50px;

  border-color: #ff9600;
  border-radius: 10px;
  background-color: #ff9600;
  height:50px;
  width: 170px;
  text-align:center;
  padding-top: 9px;

  font-size: 11px;
  font-family: 'Quicksand Bold', sans-serif;
}
   

      .action-sidebar .action-menu-item{
    padding: 12px 16px 12px 16px;
    width: 500px;
    text-align: center;
    line-height: 110%;
    font-size: 90%;}

   </style>




<div class="d-flex flex-column h-100" style="width:100%;text-align:center;float:right;">
    <h4 class="text-center font-weight-bolder action-title">
  
        DÉCOUPAGE TECHNIQUE 
    </h4>

    <br />
<div class="grid-row">

  

  @foreach ($decoupages as $decoupage)
  @if($decoupage->id < 197)
  <div class="product">
    <div class="product--card">
    
                 <ul>   <li> SCENE : {{ $decoupage->sequence_id }} </li> <li>  PLAN : {{ $decoupage->plan }} </li> <li>  DUREE : {{ $decoupage->durée }}</li>  <li STYLE="text-transform:uppercase">  LIEU : {{ $decoupage->lieu }}  </li> </ul>
           
   
      <a class="product--image" href="#" title="View">
        <img class="img-responsive" src="{{ $decoupage->story}}">
        <div class="middle">
        <div class="text">
        <a href="#update"><img src="/images/edit.png"style="width: 30px; height: 30px;"></a>
        <a href="#delete"><img src="/images/trash.png"style="width: 30px; height: 30px;"></a>
    </div>

  
  </div>
        <span class="tags"></span>
      </a>
      <a class="product--title" href="#" title="View">Description</a>
      <div class="product--brand">
 
      
                    <p style=" font-size:10px;">
                    @php $descriptions = json_decode($decoupage->description); @endphp
            @foreach($descriptions as $description)

   {{$description}}  
                                 
        
            @endforeach
                  </p>
      
      </div>
    </div>
  
  </div>
  @endif
  @endforeach



<!-- Add Story -->
<div id="add_story" class="modal-window">
                <div>
                    <a href="#" title="Close" class="modal-close">X</a>
                    <br>
                    <h4 class="text-center font-weight-bolder action-title">
  
 AJOUTER UN STORYBOARD <br><br>
</h4>
<form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-action">
    @csrf
    <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
    <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
    <input type="hidden" name="redirect_url"
        value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
<table >

        <tr>
            <td style="width:5%;">SÉQ N°</td>
            <td style="width:5%;">PLAN N°</td>
           
            <td style="width:10%;">LIEU</td>
            <td style="width:20%;">DESCRIPTION DE L’ACTION</td>
            <td style="width:10%;">ÉCHELLE et ANGLE</td>
            <td style="width:10%;">MOUVEMENT CAMÉRA</td>
            <td style="width:15%;">IMAGE 1</td>
            <td style="width:15%;">IMAGE 2</td>
        </tr>


@foreach ($decoupages as $decoupage)
<tr>
            <td>{{ $decoupage->sequence_id }}</td>
            <td> {{ $decoupage->plan }}</td> 
            <td> {{ $decoupage->lieu}}</td>
            <td>
            @php $descriptions = json_decode($decoupage->description); @endphp
            {{$descriptions[0]}}  
   
            </td>
            <td>{{ $decoupage->echelle}} </td>
            <td> {{ $decoupage->angle}}</td>
            @if($decoupage->id < 197)
            <td><img  src="{{$decoupage->story}}" style="width: 50px; height:50px;"> </td>
            @else
            <td><a href="#addStory2"><img  src="/images/plus.png" style="width: 50px; height:50px;"></a></td>
            @endif
            <td><a href="#addStory2"><img  src="/images/plus.png" style="width: 50px; height:50px;"></a></td>
  </tr>
  @endforeach
  </table>
      </form>                
                </div>
</div>
<!-- End The Modal -->


</div>

<br><br>
<!-- End List StoryBoard -->
</form>

    <!-- Delete The Modal -->
    <div id="delete" class="modal-window">
                <div>
                    <a href="#" title="Close" class="modal-close">X</a>
                    <br>
                    <h3 style="Text-align:center;">Suppression de vignette</h3>
                    
                    <hr>

                      <p> Es-tu sur de vouloir suprimer cette vignette  Plan  ?</p>
                  
                    <br>
                      <!-- The IMG -->

                      

                      <!-- End The IMG -->
                      <br>
                      <br>  <br>
                    <div style="float:right;"> 
                    <form action="" method="POST">
                          
                            <input type="hidden" id="vide" name="vide" value=" ">
                            <button type="submit"  class="btn btn-danger"></button>
                            </form>
             
                </div>
                </div>
                </div>
<!-- End The Modal -->

    <!-- Add The Modal -->
    <div id="update" class="modal-window">
                <div>
                    <a href="#" title="Close" class="modal-close">X</a>
                    <br>
                    <h3 style="Text-align:center;">Suppression de vignette</h3>
                    
                    <hr>

                      <p> Es-tu sur de vouloir suprimer cette vignette  Plan  ?</p>
                  
                    <br>
                      <!-- The IMG -->

                      

                      <!-- End The IMG -->
                      <br>
                      <br>  <br>
                    <div style="float:right;"> 
                    <form action="" method="POST">
                          
                            <input type="hidden" id="vide" name="vide" value=" ">
                            <button type="submit"  class="btn btn-danger"></button>
                            </form>
             
                </div>
                </div>
                </div>
<!-- End The Modal -->

     <!-- The Modal -->
     <div id="addStory2" class="modal-window">
                    <div>
                        <a href="#add_story" title="Close" class="modal-close">X</a>
                        <br>
                        <h3 style="Text-align:center;">Ajouter une vignette</h3>
                        <hr>
                       
                        <ul><li> SEQUENCE : 1</li> <li>  PLAN : 1 </li> <li>  DUREE : 00:00:00 </li>  <li STYLE="text-transform:uppercase">  LIEU : {{$decoupage->lieu}} </li> <li  STYLE="text-transform:uppercase">  DUREE : {{$decoupage->echelle}} / {{$decoupage->angle}}</li> <li  STYLE="text-transform:uppercase">  DUREE : {{$decoupage->mouvement}} </li> </ul>
                        <p>DESCRIPTION  : </p>
                        <br>
                     
                        <br>
                        <div class="dropdown"style="float:left;" >
  <button onclick="myFunction()" class="dropbtn">FILTER</button>
  <div id="myDropdown" class="dropdown-content">

                <h4>Plan</h4>
                    <ul class="cd-filter-content cd-filters list">
                        <li>
                            <input class="filter" data-filter=".check1" type="checkbox" id="checkbox1">
                            <p class="checkbox-label" for="checkbox1">Plan Américain</p>
                        </li>
                        <br>
                        <li>
                            <input class="filter" data-filter=".check2" type="checkbox" id="checkbox2">
                            <p class="checkbox-label" for="checkbox2">Plan Ensemble</p>
                        </li>
                        <br>
                        <li>
                            <input class="filter" data-filter=".check3" type="checkbox" id="checkbox3">
                            <p class="checkbox-label" for="checkbox3">Plan Italien</p>
                        </li>
                        <br>
                        <li>
                            <input class="filter" data-filter=".check4" type="checkbox" id="checkbox4">
                            <p class="checkbox-label" for="checkbox4">Plan Pied</p>
                        </li>
                        <br>
                        <li>
                            <input class="filter" data-filter=".check5" type="checkbox" id="checkbox5">
                            <p class="checkbox-label" for="checkbox5">Plan Rapproche Epaule</p>
                        </li>
                        <br>
                        <li>
                            <input class="filter" data-filter=".check6" type="checkbox" id="checkbox6">
                            <p class="checkbox-label" for="checkbox6">Plan</p>
                        </li>
                        <br>

                    </ul> <!-- cd-filter-content -->
        
             <h4>Couleur / Noir&Blanc</h4>
             
                            <select class="filter" name="selectThis" id="selectThis">
                                <option value="">Choose an option</option>
                                <option value=".option1">Couleur</option>
                                <option value=".option2">Noir&Blanc</option>
                            </select>
                         
                            <br>
                              <br>
                <h4>Interieur / Exterieur </h4>

                        <li>
                            <input class="filter" data-filter="" type="radio" name="radioButton" id="radio1" checked>
                            <p class="radio-label" for="radio1">All</p>
                        </li>
                        <br>
                        <li>
                            <input class="filter" data-filter=".radio2" type="radio" name="radioButton" id="radio2">
                            <p class="radio-label" for="radio2">Interieur</p>
                        </li>
                        <br>
                        <li>
                            <input class="filter" data-filter=".radio3" type="radio" name="radioButton" id="radio3">
                            <p class="radio-label" for="radio3">Exterieur</p>
                        </li>
                        <br>
                    </ul> <!-- cd-filter-content -->
  </div>
</div>
                        <br>
                        <br>
                    <!-- Form -->
                    
                        <div class="container">
                        
                            <div class="row">

                                    @foreach($images as $image)
                                        <div class="col-md-4 col-lg-4 col-sm-4">
                                            <label>
                                                <input type="radio" name="product" class="card-input-element" value="{{$image->liens}}" required/>

                                                <div class="panel panel-default card-input">
                                                    <div class="panel-heading"></div>
                                                    <div class="panel-body">
                                                    <img  class="img-responsive" src="{{$image->liens}}">
                                                    </div>
                                                </div>

                                            </label>
                                        </div>
                                    @endforeach
                            </div>
                        </div>
                        <br>
                        <br>
                        <div style="float:right;"> 
                        
                            <button type="submit" style="background-color:#464d80;border-color:#464d80;" class="btn btn-primary">Enregistrer</button>
                      
                        <!-- End Form -->
                        </div>
                    </div>
    </div>
    <!-- End The Modal -->

</div>
<script>

function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function filterFunction() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  div = document.getElementById("myDropdown");
  a = div.getElementsByTagName("a");
  for (i = 0; i < a.length; i++) {
    txtValue = a[i].textContent || a[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      a[i].style.display = "";
    } else {
      a[i].style.display = "none";
    }
  }
}
</script>
