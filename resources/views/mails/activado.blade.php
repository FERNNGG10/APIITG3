<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <title>LifePlants - Cuenta Activada</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #28a745;
        }
        .navbar-brand {
            color: #fff;
        }
        .content {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container d-flex justify-content-center">
            <h3 class="navbar-brand" href="#">LifePlants</h3>
        </div>
    </nav>
    <div class="container content">
        <img src="{{ asset('images/plant.png') }}" alt="Logo" class="img-fluid">
        <h1 class="mt-5">Tu cuenta ha sido activada</h1>
    </div>
</body>
</html>