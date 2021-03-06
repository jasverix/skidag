<!DOCTYPE html>
<html>
<head>
    <title>Skidag {{ $type }} - Legg til oppføring</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <script src="/js/app.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/css/app.css" type="text/css"/>
</head>

<body id="top" class="{{ strtolower($type) }}-page" style="padding:15px;">
    <div class="container">
        <div class="row">
            <h1>Registrer {{ strtolower($type) }}</h1>
        </div>
        <div class="row">
            <form method="post" style="width:100%">
                {!! csrf_field() !!}

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Fiks alle feil
                    </div>
                @endif

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Navn</label>
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Navn" value="{{ old('name') }}"/>
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('seconds') ? 'has-error' : '' }}">
                    <label for="name">{{ $scoreTitle }}</label>
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" id="seconds" name="seconds" placeholder="{{ $scoreTitle }}" value="{{ old('seconds') }}"/>
                        <span class="input-group-append">{{ $scoreSuffix }}</span>
                    </div>
                    @if ($errors->has('seconds'))
                        <span class="help-block">{{ $errors->first('seconds') }}</span>
                    @endif
                </div>

                <input type="submit" class="btn btn-primary" value="Send inn"/>
            </form>
        </div>
    </div>
</body>
</html>
