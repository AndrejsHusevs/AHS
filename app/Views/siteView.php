<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>
<body>
    <h1><?= $title ?></h1>
    <ul>
        <?php if (!empty($dataSiteView)): ?>
            <?php foreach ($dataSiteView as $item): ?>
                <li>ID: <?= htmlspecialchars($item['id']) ?>, Name: <?= htmlspecialchars($item['name']) ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No data available.</li>
        <?php endif; ?>
    </ul>


</body>
</html>