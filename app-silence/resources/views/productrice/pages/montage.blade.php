@extends('productrice.layouts.page', array('contentBackground' => '#33395e') )

@section('content')
<br>
  <!-- Afficher l'éditeur WeVideo dans un iframe -->
  <iframe src="https://eu.wevideo.com/hub" allow="microphone; camera; fullscreen" width="100%" height="100%"></iframe>
    
<script>
    var token = '{{$token}}';
   $.ajax({
    type: 'GET',
    url: 'https://eu.wevideo.com/api/3/sso/login/' + token,
    success: function() {
        /* L'utilisateur est maintenant connecté à WeVideo */
    },
    xhrFields: { withCredentials: true }
});
</script>
@endsection
