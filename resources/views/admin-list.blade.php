<!DOCTYPE html>
<html>
<head>
    <title>Administrasjon</title>

    <script src="/js/app.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/css/app.css" type="text/css"/>
</head>
<body>
    <table>
        <tr>
            <td></td>
            <th>Navn</th>
            <th>Alder</th>
            <th>Aktivitet</th>
            <th>Resultat</th>
            <th>Kjønn</th>
        </tr>
        @foreach ($results as /** @var $result \App\Result */$result)
            <tr>
                <td>
                    <a href="/admin/edit/{{ $result->id }}">Rediger</a>
                </td>
                <td>{{ $result->name }}</td>
                <td>{{ $result->age }}</td>
                <td>{{ $result->type }}</td>
                <td>{{ $result->seconds }}</td>
                <td>{{ ['Gutt', 'Jente'][$result->gender] ?? 'Ikke definert ennå' }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
