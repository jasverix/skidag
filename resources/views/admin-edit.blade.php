<!DOCTYPE html>
<html>
<head>
    <title>Rediger oppføring</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <script src="/js/app.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/css/app.css" type="text/css"/>
</head>

<body id="top" class="admin-page">
    <div class="container">
        <div class="row">
            <h1>Rediger oppføring</h1>
        </div>
        <div class="row">
            <form method="post">
                {!! csrf_field() !!}

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        Fiks alle feil
                    </div>
                @endif

                <div class="form-group">
                    <label>Type</label>
                    <span class="form-control">{{ $result->type }}</span>
                </div>

                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Navn</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Navn" value="{{ old('name', $result->name) }}"/>
                    @if ($errors->has('name'))
                        <span class="help-block">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('seconds') ? 'has-error' : '' }}">
                    <label for="name">{{ $scoreTitle }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="seconds" name="seconds" placeholder="{{ $scoreTitle }}" value="{{ old('seconds', $result->seconds) }}"/>
                        <span class="input-group-append">{{ $scoreSuffix }}</span>
                    </div>
                    @if ($errors->has('seconds'))
                        <span class="help-block">{{ $errors->first('seconds') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                    <label for="gender">Kjønn</label>
                    <select class="form-control" name="gender" id="gender">
                        <option value="-1" {{ (int)old('gender', $result->gender) === -1 ? 'selected' : '' }}>Velg...</option>
                        <option value="0" {{ (int)old('gender', $result->gender) === 0 ? 'selected' : '' }}>Gutt</option>
                        <option value="1" {{ (int)old('gender', $result->gender) === 1 ? 'selected' : '' }}>Jente</option>
                    </select>
                    @if ($errors->has('gender'))
                        <span class="help-block">{{ $errors->first('seconds') }}</span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('age') ? 'has-error' : '' }}">
                    <label for="age">Alder</label>
                    <input type="number" min="0" max="100" step="1" value="{{ old('age', $result->age) }}" name="age" id="age" class="form-control"/>
                    @if ($errors->has('age'))
                        <span class="help-block">{{ $errors->first('seconds') }}</span>
                    @endif
                </div>

                <input type="submit" value="Lagre og godkjenn" name="save" class="btn btn-primary"/>
                <!-- input type="submit" value="Avvis" name="reject" class="btn btn-danger"/ -->
            </form>
        </div>
    </div>
</body>
</html>
