{{-- Base template for PDF files --}}

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>@yield('title')</title>
  <link type="text/css" rel="stylesheet" href="{{ base_path('resources/assets/css/file.css') }}" />
  @yield('style')
</head>
<body>

  <div class="ui container">
    <div class="column">
      <img class="logo" src="{{ public_path('logos/numeris-blue.png') }}">
    </div>
    <div class="ui two columns grid">
      <div class="column">
        <h1>Numéris ISEP</h1>
        <div class="sub header">@yield('type')</div>
        <div>@yield('summary')</div>
      </div>
    </div>

    @yield('header')

    @yield('content')

    @yield('footer')
  </div>
</body>
</html>
