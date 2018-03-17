<!DOCTYPE html>
<html>
<head>
    <title>Skidag Resultater</title>

    <script src="js/app.js" type="text/javascript"></script>
    <link rel="stylesheet" href="css/app.css" type="text/css"/>
</head>
<body id="top" class="results-page">
    <div class="container">
        <div class="row">
            <h1>Resultater skidag</h1>
        </div>
        <div class="row">
            <div class="results-wrapper">
                @foreach($results as $result)
                    <div>
                        <h2>{{ $result['title'] }}</h2>
                        <ol>
                            @foreach($result['standings'] as $i => $standing)
                                <li><span class="name">{{ $standing['name'] }}</span> -
                                    <span class="score">{{ $standing['score'] }}</span></li>
                            @endforeach
                        </ol>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
