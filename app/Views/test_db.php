<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Users</h3>
    <table border ="1">
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>pass</th>
                <th>c</th>
                <th>u</th>
                <th>d</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= $user->username ?></td>
                    <td><?= $user->passwrd ?></td>
                    <td><?= $user->created_at ?></td>
                    <td><?= $user->updated_at ?></td>
                    <td><?= $user->deleted_at ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>