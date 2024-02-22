<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- CSS Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />

  <!-- Incluimos un fichero CSS personalizado creado por nosotros -->
  <!-- Usamos para ello el helper "asset", que genera la URL completa que apunta al fichero pasado por parámetro -->
  <!-- Usamos las llaves dobles para invocal un helper -->
  <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />

  <!-- Marcador donde incluiremos el título de la página. El primer parámetro (title) contiene el identificador y el segundo (Tienda online) contiene el valor por defecto que se usará en caso de que no se le asigne ningún valor al marcador-->
  <title class="text-center">@yield('title', 'Tienda online')</title>   

</head>

<body>
  <!-- header -->

  <header class="px-3 py-2 bg-dark text-white">
    <div class="container d-flex align-items-center flex-column">
      <h2>@yield('subtitle', 'Smart Eco School')</h2>
    </div>
  </header>
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