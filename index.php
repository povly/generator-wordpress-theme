

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator</title>
</head>
<body>
    <form action="generator.php" method="post">
    Название темы: <input type="text" name="theme_name"><br>
    Ссылка темы: <input type="text" name="theme_uri"><br>
    Автор: <input type="text" name="author"><br>
    Ссылка автора: <input type="text" name="author_uri"><br>
    Text Domain(text-domain): <textarea name="text_domain"></textarea><br>
    Описание: <textarea name="description"></textarea><br>
    <button type="submit">Генерировать тему</button>
</form>
</body>
</html>