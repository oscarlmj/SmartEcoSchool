<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- CSS Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

  <!-- Incluimos un fichero CSS personalizado creado por nosotros -->
  <!-- Usamos para ello el helper "asset", que genera la URL completa que apunta al fichero pasado por parámetro -->
  <!-- Usamos las llaves dobles para invocar un helper -->
  <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />

  <!-- Marcador donde incluiremos el título de la página. El primer parámetro (title) contiene el identificador y el segundo (Tienda online) contiene el valor por defecto que se usará en caso de que no se le asigne ningún valor al marcador-->
  <title>@yield('title', 'Smart Eco School')</title>   

</head>

<body>
  <!-- header -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-secondary py-4">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="{{ asset('/storage/logo.png') }}" alt=""></a>
    </div>
  </nav>

  <!--<header class="masthead bg-primary text-white text-center py-4">
    <div class="container d-flex align-items-center flex-column">
      <h2>@yield('subtitle', '')</h2>
    </div>
  </header>-->
  <!-- header -->

  <div class="container my-4">
    <div class="text-center">
      @yield('content')
    </div>
  </div>

  <!-- footer -->
  <div class="copyright py-4 text-center text-white">
    <div class="container">
      <small>
        Desarrollo web en entorno servidor - 2º DAW
      </small>
    </div>
  </div>
  <!-- footer -->

  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>