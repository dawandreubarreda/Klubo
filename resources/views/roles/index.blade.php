<!DOCTYPE html>
<html>
<head>
    <title>Roles - Klubo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Roles disponibles en Klubo</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre técnico</th>
                <th>Nombre visible</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->display_name }}</td>
                <td>{{ $role->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>