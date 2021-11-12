<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Não Encontrada</title>
    <link rel="shortcut icon" href="../../Favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../source/root/root.css">
    <style>
        .image_row{
            width: 100%;
            height: auto;

            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
        }
        .page_not_found_gif > a{
            background-color: var(--button_color);
            color: var(--text-primary);
            width: 100px;
            height: 40px;
            padding: 2px;
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            transition: 0.2s;
        }

        .page_not_found_gif > a:hover{
            filter: brightness(80%);
        }
    </style>
</head>
<body>
    <div class="page_not_found_gif">
        <a href="/">
            Voltar
        </a>
        <div class="image_row">
            <img src="../../source/assets/udraw_images/page-not-found-error-404.gif" alt="">
        </div>
    </div>
</body>
</html>