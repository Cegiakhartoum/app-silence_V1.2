<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('/auth/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/mentions-legales', function () {
    return view('mentions-legales');
});

Route::get('/politiques-confidentialites', function () {
    return view('politiques-confidentialites');
});

Route::post("/cree-abonnememte", [App\Http\Controllers\AbonnementController::class, 'create']);

Route::post("/save-action-teacher", [App\Http\Controllers\ActionController::class, 'saveActionTeacher']);
Route::post("/save-action", [App\Http\Controllers\ActionController::class, 'saveAction']);

Route::post("/save-actionDecoupage", [App\Http\Controllers\ActionController::class, 'saveActionDecoupage']);
Route::post("/AddDecoupage", [App\Http\Controllers\ActionController::class, 'AddDecoupage']);
Route::post("/DeleteDec", [App\Http\Controllers\ActionController::class, 'DeleteDec']);

Route::post("/DeletePersonnage", [App\Http\Controllers\ActionController::class, 'DeletePersonnage']);
Route::post("/DeleteDescription", [App\Http\Controllers\ActionController::class, 'DeleteDescription']);

Route::post("/AddDescription", [App\Http\Controllers\ActionController::class, 'AddDescription']);
Route::post("/AddPersonnage", [App\Http\Controllers\ActionController::class, 'AddPersonnage']);

Route::post("/UpdtadePAT", [App\Http\Controllers\ActionController::class, 'UpdtadePAT']);
Route::post("/UpdtadeDéjeuner", [App\Http\Controllers\ActionController::class, 'UpdtadeDéjeuner']);
Route::post("/UpdtadeOrdre", [App\Http\Controllers\ActionController::class, 'UpdtadeOrdre']);
Route::post("/UpdtadeTrajet", [App\Http\Controllers\ActionController::class, 'UpdtadeTrajet']);

Route::get('/GetSubCatAgainstMainCatEdit/{action_id}/{id}', [\App\Http\Controllers\ActionController::class, 'GetSubCatAgainstMainCatEdit']);
Route::get("/archive/{number}/{id}", [App\Http\Controllers\ProjetActionController::class, 'archive']);
Route::get("/delete/{id}", [App\Http\Controllers\ProjetActionController::class, 'delete']);





// Projet Action Routes productrice
Route::prefix('distributeur')->middleware(['auth'])->name("distributeur.")->group(function () {

    Route::get('/profile', [App\Http\Controllers\Distributeur\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Distributeur\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\Distributeur\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('profile/update', [App\Http\Controllers\Distributeur\ProfileController::class, 'update']);
    Route::patch('/profile', [App\Http\Controllers\Distributeur\ProfileController::class, 'update'])->name('profile.update');

    Route::post('compte/update/{id}', [App\Http\Controllers\Distributeur\CompteController::class, 'update']);

    Route::get('action-dls', [App\Http\Controllers\Distributeur\ActionController::class, 'downloadScenarioPdf']);
    Route::get('action', [App\Http\Controllers\Distributeur\ActionController::class, 'index']);
    Route::get('action-dashboard', [App\Http\Controllers\Distributeur\ActionController::class, 'dashboard']);
    Route::post('action-join-project', [App\Http\Controllers\Distributeur\ProjetActionController::class, 'joinProject'])->name("action-join-project");
    Route::post('/DeleteProjet/{id}', [App\Http\Controllers\Distributeur\ProjetActionController::class, 'delete']);
    Route::get('ateliers', [App\Http\Controllers\Distributeur\AtelierController::class, 'index']);
    Route::get('parcours-film-fiction/{format}', [App\Http\Controllers\Distributeur\AtelierController::class, 'show']);
    Route::post('ateliers/create', [App\Http\Controllers\Distributeur\AtelierController::class, 'create']);
    Route::post('productrice/get-chapters', [App\Http\Controllers\Distributeur\AtelierController::class, 'getChapters']);
    Route::put('ateliers/update/{id}', [App\Http\Controllers\Distributeur\AtelierController::class, 'update'])->name('ateliers.update');
    Route::put('ateliers/active/{id}', [App\Http\Controllers\Distributeur\AtelierController::class, 'active'])->name('ateliers.enligne');
    Route::put('ateliers/cible/{id}', [App\Http\Controllers\Distributeur\AtelierController::class, 'cible'])->name('ateliers.cible');

    Route::post('/create-partie', [App\Http\Controllers\Distributeur\AtelierController::class, 'createParti']);
    Route::put('ateliers/update-partie/{id}', [App\Http\Controllers\Distributeur\AtelierController::class, 'updateParti']);

    Route::post('/create-chapitre', [App\Http\Controllers\Distributeur\AtelierController::class, 'createChapitre']);
    Route::post('/update-chapitre', [App\Http\Controllers\Distributeur\AtelierController::class, 'updateChapitre']);

    Route::post('/update-cour', [App\Http\Controllers\Distributeur\AtelierController::class, 'updateCour']);
        // Créer
    Route::post("/creer", [App\Http\Controllers\Distributeur\ProjetActionController::class, 'creer']);


    Route::post('/create-compte', [App\Http\Controllers\Auth\RegisteredUserController::class, 'storeCompte']);
        Route::post("/student-create", [App\Http\Controllers\Distributeur\ProjetActionController::class, 'studentCreateProject']);

    Route::get('{page}', function () {
        return view('distributeur.pages.en-construction');
    })->where('name', ('informations|actions|support|videos'));

    Route::get('{page}', function ($page) {
        return view('productrice.pages.' . $page);
    });

});




// Projet Action Routes productrice
Route::prefix('productrice')->middleware(['auth'])->name("productrice.")->group(function () {

    Route::get('/profile', [App\Http\Controllers\Productrice\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Productrice\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\Productrice\ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('profile/update', [App\Http\Controllers\Productrice\ProfileController::class, 'update']);
    Route::patch('/profile', [App\Http\Controllers\Productrice\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/get-partie-data/{id}', [\App\Http\Controllers\Productrice\AtelierController::class, 'getPartieData']);

    Route::delete('compte/delete/{id}', [App\Http\Controllers\CompteController::class, 'destroy']);
    Route::post('compte/update/{id}', [App\Http\Controllers\CompteController::class, 'update']);

    Route::get('action-dls', [App\Http\Controllers\Productrice\ActionController::class, 'downloadScenarioPdf']);
    Route::get('action', [App\Http\Controllers\Productrice\ActionController::class, 'index']);
    Route::get('action-dashboard', [App\Http\Controllers\Productrice\ActionController::class, 'dashboard']);
    Route::post('action-join-project', [App\Http\Controllers\Productrice\ProjetActionController::class, 'joinProject'])->name("action-join-project");
    Route::post('/DeleteProjet/{id}', [App\Http\Controllers\Productrice\ProjetActionController::class, 'delete']);
    Route::get('ateliers', [App\Http\Controllers\Productrice\AtelierController::class, 'index']);
    Route::get('parcours-film-fiction/{format}', [App\Http\Controllers\Productrice\AtelierController::class, 'show']);
    Route::post('ateliers/create', [App\Http\Controllers\Productrice\AtelierController::class, 'create']);
    Route::post('productrice/get-chapters', [App\Http\Controllers\Productrice\AtelierController::class, 'getChapters']);
    Route::put('ateliers/update/{id}', [App\Http\Controllers\Productrice\AtelierController::class, 'update'])->name('ateliers.update');
    Route::put('ateliers/active/{id}', [App\Http\Controllers\Productrice\AtelierController::class, 'active'])->name('ateliers.enligne');
    Route::put('ateliers/cible/{id}', [App\Http\Controllers\Productrice\AtelierController::class, 'cible'])->name('ateliers.cible');
    Route::delete('ateliers/delete/{id}', [App\Http\Controllers\Productrice\AtelierController::class, 'delete'])->name('ateliers.delete');

    Route::post('/create-partie', [App\Http\Controllers\Productrice\AtelierController::class, 'createParti']);
    Route::put('ateliers/update-partie/{id}', [App\Http\Controllers\Productrice\AtelierController::class, 'updateParti']);
    Route::delete('/delete-parti/{id}', [App\Http\Controllers\Productrice\AtelierController::class, 'deleteParti']);

    Route::post('/create-chapitre', [App\Http\Controllers\Productrice\AtelierController::class, 'createChapitre']);
    Route::put('ateliers/update-chapitre/{id}', [App\Http\Controllers\Productrice\AtelierController::class, 'updateChapitre']);
    Route::delete('/delete-chapitre/{id}', [App\Http\Controllers\Productrice\AtelierController::class, 'deleteChapitre']);

    Route::post('/update-cour', [App\Http\Controllers\Productrice\AtelierController::class, 'updateCour']);
        // Créer
        Route::post("/creer", [App\Http\Controllers\Productrice\ProjetActionController::class, 'creer']);
        Route::post('/create-compte', [App\Http\Controllers\Auth\RegisteredUserController::class, 'storeCompte']);
        Route::post("/student-create", [App\Http\Controllers\Productrice\ProjetActionController::class, 'studentCreateProject']);

        Route::get('{page}', function () {
            return view('distributeur.pages.en-construction');
        })->where('name', ('informations|actions|support|videos'));

        Route::get('{page}', function ($page) {
            return view('productrice.pages.' . $page);
        });

});



// Projet Action Routes
Route::prefix('student')->middleware(['auth'])->name("student.")->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('action-dls', [App\Http\Controllers\ActionController::class, 'downloadScenarioPdf']);
    Route::get('action', [App\Http\Controllers\ActionController::class, 'index']);
        Route::get('montage', [App\Http\Controllers\MontageController::class, 'index']);
    Route::get('action-dashboard', [App\Http\Controllers\ActionController::class, 'dashboard']);
    Route::post('action-join-project', [App\Http\Controllers\ProjetActionController::class, 'joinProject'])->name("action-join-project");
    Route::post('/DeleteProjet/{id}', [App\Http\Controllers\ProjetActionController::class, 'delete']);

    Route::get('ateliers', [App\Http\Controllers\AtelierController::class, 'index']);
    Route::get('parcours-film-fiction/{format}', [App\Http\Controllers\AtelierController::class, 'show']);
    
        // Créer
            Route::post('/create-abonnememt', [App\Http\Controllers\AbonnementController::class, 'sendAbonnementData']);
                        Route::post('/delete-abonnememt', [App\Http\Controllers\AbonnementController::class, 'deleteAbonnementData']);
        Route::post("/creer", [App\Http\Controllers\ProjetActionController::class, 'creer']);
        Route::post("/student-create", [App\Http\Controllers\ProjetActionController::class, 'studentCreateProject']);

    Route::get('{page}', function () {
        return view('student.pages.en-construction');
    })->where('name', ('informations|actions|support|videos'));

    Route::get('{page}', function ($page) {
        return view('student.pages.' . $page);
    });

});

Route::prefix('pdf')->middleware(['auth'])->name("pdf.")->group(function () {
    Route::get('{page}', function ($page) {
        return view('pdf.' . $page);
    });
});

Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('silence', [App\Http\Controllers\ReportController::class, 'silencePdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('cv', [App\Http\Controllers\ReportController::class, 'cvPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('La thématique', [App\Http\Controllers\ReportController::class, 'thématiquePdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Le pitch', [App\Http\Controllers\ReportController::class, 'pitchPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Le schéma narratif', [App\Http\Controllers\ReportController::class, 'shémaPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Le synopsis', [App\Http\Controllers\ReportController::class, 'synopsisPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Le traitement', [App\Http\Controllers\ReportController::class, 'traitementPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Scénario', [App\Http\Controllers\ReportController::class, 'scénarioPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Découpage technique', [App\Http\Controllers\ReportController::class, 'découpagePdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Lieux de tournage', [App\Http\Controllers\ReportController::class, 'lieux_tPdf']);
});

Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Liste des acteurs/actrices', [App\Http\Controllers\ReportController::class, 'liste_acteurPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Dépouillement personnage', [App\Http\Controllers\ReportController::class, 'dépouillementPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Planning de tournage', [App\Http\Controllers\ReportController::class, 'planningPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Feuille de script', [App\Http\Controllers\ReportController::class, 'feuille_scriptPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Mes idées', [App\Http\Controllers\ReportController::class, 'ideePdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('J organise mon discours', [App\Http\Controllers\ReportController::class, 'discoursPdf']);
});
Route::prefix('report')->middleware(['auth'])->name("report.")->group(function () {
    Route::get('Mes idées', [App\Http\Controllers\ReportController::class, 'ideePdf']);
});
require __DIR__.'/auth.php';



