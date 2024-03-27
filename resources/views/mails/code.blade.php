<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activa tu cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            align-items: center;
            align-content: center
        }

        .container {
            width: 50%;
            margin: 0 auto;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 20px;
            border-radius: 10px;
        }

        .button {
            display: inline-block;
            margin: 20px auto;
            background-color: #5cb85c;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            text-decoration: none;
        }

        .button:hover {
            background-color: #4cae4c;
        }

        table{
            background-image: url('https://i.ibb.co/5M0zRH3/portadaplants.jpg'); 
            background-size: cover; 
            background-repeat: no-repeat;
            width: 70%;
            height: 900%;
            align-content: center;
            align-items: center

        }

        /* Estilos para pantallas de menos de 600px de ancho */
        @media (max-width: 600px) {
            .container {
                width: 90%;
            }
            table{
                width: 100%;
                height: 100%;
            }
        }

        
        
    </style>
</head>
<body>
    <table>
        <tr>
            <td align="center">
                <div class="container">
                    <h1>Tu codigo de Life Plants</h1>
                    <a class="button">{{$code}}</a>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>