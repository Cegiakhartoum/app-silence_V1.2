    <style>
        .action-textarea {
            font-size: 16px; /* Définir la taille de police par défaut */
            padding-left: 20px; /* Marge à gauche pour les bullet points */
        }
    </style>

    <div class="d-flex flex-column h-100">
        <h4 class="text-center font-weight-bolder action-title">Titre de l'action</h4>
        <div class="action-subtitle">Écrivez ici :</div>
        <form id="action-form" class="flex-grow-1" method="POST" action="/save-action">
            @csrf
            <input type="hidden" name="chapter_id" value="{{ $chapterKey }}" />
            <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
            <input type="hidden" name="redirect_url"
                value="/student/action?p={{ $action->projet_action_id }}&c={{ $nextChapterKey }}" />
            <textarea name="idées" class="action-textarea w-100 h-100" cols="50" oninput="handleTextAreaInput(event)">{{ $action->idées ?? '' }}</textarea>
        </form>
    </div>

    <script>
        function handleTextAreaInput(event) {
            const textarea = event.target;
            const inputValue = textarea.value;
            const lastCharacter = inputValue.charAt(inputValue.length - 1);

            if (lastCharacter === '\n') {
                textarea.value += '• ';
            }
        }
    </script>

