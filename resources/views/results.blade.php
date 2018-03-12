<!DOCTYPE html>
<html>
<head>
    <title>Skidag Resultater</title>

    <script src="js/app.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/app.css" type="text/css"/>
</head>
<body id="top" class="results-page">
    <div class="results-wrapper">
        @foreach($results as $result)
            <div>
                <h1>{{ $result['title'] }}</h1>
                <ol>
                    @foreach($result['standings'] as $i => $name)
                        <li>{{ $name }}</li>
                    @endforeach
                </ol>
            </div>
        @endforeach
    </div>
</body>
</html>
