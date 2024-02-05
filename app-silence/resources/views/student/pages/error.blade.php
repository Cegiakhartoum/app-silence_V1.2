<!-- resources/views/error.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'erreur</title>
    <style>
        /* Ajoutez du style CSS pour la mise en page de votre page d'erreur */
        body {
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Erreur</h1>
        <p>{{ isset($error) ? $error : 'Une erreur s\'est produite. Veuillez réessayer plus tard.' }}</p>
    </div>
</body>
</html>
