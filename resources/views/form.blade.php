<!DOCTYPE html>
<html>
<head>
    <title>Skidag {{ $type }} - Legg til oppføring</title>

    <script src="/js/app.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/css/app.css" type="text/css"/>
</head>

<body id="top" class="{{ strtolower($type) }}-page">
    <div class="container">
        <div class="row">
            <h1>Registrer tid for {{ strtolower($type) }}</h1>
        </div>
        <div class="row">
            <form method="post">
                {!! csrf_field() !!}

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Fiks alle feil
                    </div>
                @endif

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Navn</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Navn" value="{{ old('name') }}"/>
                    @if ($errors->has('name'))
                        <span class="help-block">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('seconds') ? 'has-error' : '' }}">
                    <label for="name">{{ $scoreTitle }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="seconds" name="seconds" placeholder="{{ $scoreTitle }}" value="{{ old('seconds') }}"/>
                        <span class="input-group-append">{{ $scoreSuffix }}</span>
                    </div>
                    @if ($errors->has('seconds'))
                        <span class="help-block">{{ $errors->first('seconds') }}</span>
                    @endif
                </div>
            </form>
        </div>
    </div>
</body>
</html>
