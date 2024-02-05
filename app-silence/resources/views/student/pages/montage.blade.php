@extends('student.layouts.page-action')

@section('content')

                
  <!-- Afficher l'éditeur WeVideo dans un iframe -->
 <iframe src="https://eu.wevideo.com" allow="microphone; camera; fullscreen" security="restricted"
 width="100%" height="100%"></iframe>
    
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
