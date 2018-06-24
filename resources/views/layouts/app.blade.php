<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <title>{{ $title }} | {{ env('APP_NAME') }}</title>

        <script>
            window.laravel = {!! json_encode([ 'app_url' => url('/'), 'csrf_token' => csrf_token() ]) !!}
        </script>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
              <a class="navbar-brand" href="{{ url('/') }}">{{ env('APP_NAME') }}</a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item @if(Request::is("packages*")) active @endif">
                    <a class="nav-link" href="{{ url('packages') }}">Packages</a>
                  </li>
                  <li class="nav-item @if(Request::is("catalogs*")) active @endif">
                    <a class="nav-link" href="{{ url('catalogs') }}">Catalogs</a>
                  </li>
                  <li class="nav-item @if(Request::is("manifests*")) active @endif">
                    <a class="nav-link" href="{{ url('manifests') }}">Manifests</a>
                  </li>
                </ul>
              </div>
            </nav>

            <div class="container-fluid">
                <h2 class="page-title">{{ $title }}</h2>

                @yield('content')

                <footer>
                    <hr />
                    <h6>Munkiadmin-js</h6>
                    <h6>&copy;{{ date("Y") }} Benjamin Hansen. All Rights Reserved.</h6>
                </footer>
            </div>
        </div><!--#app-->

        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
