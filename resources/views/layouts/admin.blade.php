<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <!-- Aquí puedes incluir estilos y scripts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-vt5HzfSV+S5ZrL+LZ4QKWrP5O9exQDNv6D08Pf8oC64dX/xGEXMw1O0Ouvx+pmc1YUw9MB+PZ8RzFNV1AGd2Zg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>
    <nav>
        <!-- Tu menú de navegación aquí -->
    </nav>

    <main>
        {{ $slot }} <!-- Esto permite que el contenido de la vista se inserte aquí -->
    </main>

    <footer>
        <!-- Tu pie de página aquí -->
    </footer>
</body>


</html>
