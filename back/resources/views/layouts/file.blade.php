{{-- Base template for PDF files --}}

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  <link type="text/css" rel="stylesheet" href="{{ base_path('resources/assets/css/file.css') }}" />
  <link type="text/css" rel="stylesheet" href="{{ base_path('resources/assets/css/semantic.min.css') }}" />
</head>
<body>

  <div class="ui container">
    <div class="ui two columns grid">
      <div class="column">
        <h2 class="header">Numéris ISEP</h2>
        <div class="sub header">@yield('type')</div>
        <div>@yield('summary')</div>
      </div>
      <div class="column">
        <img class="ui small right floated image" src="{{ public_path('logos/numeris-blue.png') }}">
      </div>
    </div>

    @yield('header')

    @yield('content')

    @yield('footer')
  </div>
</body>
</html>
