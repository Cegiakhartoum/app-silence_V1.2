<?php
$introductions = json_decode($action->introduction);
?>
<h4 class="text-center font-weight-bolder action-title"> Introduction</h4>


            <form id="action-form" class="flex-grow-1" style="overflow-y: scroll;" method="POST" action="/save-action">
                @csrf
                <input type="hidden" name="chapter_id" value="{{$chapterKey}}" />
                <input type="hidden" name="projet_action_id" value="{{ $action->projet_action_id }}" />
                <input type="hidden" name="redirect_url"
                    value="/student/action?p={{ $action->projet_action_id }}&c={{$nextChapterKey }}" />
                <table>
                @if(!empty($introductions))
                    <tr>
                        <td>
                            <div>Phrase d'accroche</div>
                          
                        </td>
                        <td>
                            <textarea name="phrase" class="action-textarea w-100 h-100">{{$introductions->situation}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Nom et objectif</div>

                        </td>
                        <td>
                            <textarea name="nom" class="action-textarea w-100 h-100">{{$introductions->compétences}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Ton et ambiance </div>

                        </td>
                        <td>
                            <textarea name="ton" class="action-textarea w-100 h-100">{{$introductions->apporterais}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Public cible</div>

                        </td>
                        <td>
                            <textarea name="public" class="action-textarea w-100 h-100">{{$introductions->pourquoi}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Unicité</div>

                        </td>
                        <td>
                            <textarea name="unicité" class="action-textarea w-100 h-100">{{$introductions->pourquoi}}</textarea>
                        </td>
                    </tr>

    
                @else 
                <tr>
                        <td>
                            <div>Phrase d'accroche</div>
                          
                        </td>
                        <td>
                            <textarea name="phrase" class="action-textarea w-100 h-100"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Nom et objectif</div>

                        </td>
                        <td>
                            <textarea name="nom" class="action-textarea w-100 h-100"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Ton et ambiance </div>

                        </td>
                        <td>
                            <textarea name="ton" class="action-textarea w-100 h-100"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Public cible</div>

                        </td>
                        <td>
                            <textarea name="public" class="action-textarea w-100 h-100"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>Unicité</div>

                        </td>
                        <td>
                            <textarea name="unicité" class="action-textarea w-100 h-100"></textarea>
                        </td>
                    </tr>
                   @endif

                </table>
                
            </form>

