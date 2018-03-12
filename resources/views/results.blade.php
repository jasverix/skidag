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
                    @foreach($result['standings'] as $i => $standing)
                        <li><span class="name">{{ $standing['name'] }}</span> -
                            <span class="score">{{ $standing['score'] }}</span></li>
                    @endforeach
                </ol>
            </div>
        @endforeach
    </div>
</body>
</html>
