<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio - Universidad de Córdoba</title>
    <meta name="description" content="Proyecto mapa interactivo - Universidad de Córdoba">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
</head>

<body class="antialiased bg-gray-50 text-gray-800">

    <!-- ====== HEADER ====== -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="h-12 w-auto">
                <h1 class="text-xl font-semibold text-gray-900">
                    Acerca de MapUc
                </h1>
            </div>
            <nav class="flex items-center gap-3">
                <a href="/" class="text-sm font-medium hover:underline">Inicio</a>
                <a href="/login"
                    class="inline-block px-4 py-2 rounded-md bg-green-600 text-white text-sm shadow hover:bg-green-700">
                    Iniciar sesión
                </a>
                <a href="/register"
                    class="inline-block px-4 py-2 rounded-md bg-green-600 text-white text-sm shadow hover:bg-green-700">
                    Regístrate
                </a>
            </nav>
        </div>
    </header>

    <!-- ====== CONTENIDO PRINCIPAL ====== -->
    <main class="max-w-6xl mx-auto px-4 py-12">
        <section class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <h2 class="text-3xl font-extrabold mb-4">MapUc</h2>
                <h1 class="text-3xl font-extrabold mb-4">Mapa Interactivo Unicórdoba</h1>
                <p class="mb-6 text-gray-600">
                    Visualiza los edificios y puntos de interés de la Universidad de Córdoba.
                    Desde aquí puedes acceder al mapa interactivo, administrar puntos y más.
                </p>
                <p class="text-gray-600">
                    Este proyecto busca mejorar la orientación dentro del campus, permitiendo a los estudiantes,
                    docentes y visitantes encontrar fácilmente los diferentes bloques, servicios y zonas comunes.
                </p>
                <div class="mt-8 text-sm text-gray-500">
                    <strong>Entorno:</strong> Laravel — Proyecto académico de la Universidad de Córdoba
                </div>
            </div>

            <div class="rounded-lg overflow-hidden shadow relative group cursor-pointer" id="preview-container">
                <img src="{{ asset('img/mapa-preview.jpg') }}" alt="Vista previa del mapa"
                    class="h-72 w-full object-cover transition-transform duration-300 group-hover:scale-105">
                <div
                    class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                    <span class="text-white font-semibold text-lg">Haz clic para ampliar</span>
                </div>
            </div>

            <!-- Modal (imagen ampliada) -->
            <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50">
                <div class="relative max-w-4xl w-full p-4">
                    <button id="close-modal"
                        class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300">&times;</button>
                    <img src="{{ asset('img/mapa-preview.jpg') }}" alt="Vista ampliada del mapa"
                        class="w-full h-auto rounded-lg shadow-lg">
                </div>
            </div>
        </section>

        <script>
            // Elementos del DOM
            const preview = document.getElementById('preview-container');
            const modal = document.getElementById('image-modal');
            const closeBtn = document.getElementById('close-modal');

            // Abrir modal al hacer clic
            preview.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            // Cerrar modal al hacer clic en la X
            closeBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            // Cerrar modal al hacer clic fuera de la imagen
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        </script>

        <!-- ====== SECCIÓN DE FUNCIONALIDADES ====== -->
        <section class="mt-12 grid gap-6 md:grid-cols-3">
            <div class="p-4 bg-white rounded shadow">
                <h3 class="font-semibold">Guardar puntos</h3>
                <p class="text-sm text-gray-600 mt-2">
                    Permite registrar edificios y zonas importantes con su nombre y coordenadas en la base de datos.
                </p>
            </div>
            <div class="p-4 bg-white rounded shadow">
                <h3 class="font-semibold">Carga dinámica</h3>
                <p class="text-sm text-gray-600 mt-2">
                    Los puntos se muestran automáticamente en el mapa desde la base de datos mediante Leaflet.
                </p>
            </div>
            <div class="p-4 bg-white rounded shadow">
                <h3 class="font-semibold">Filtros</h3>
                <p class="text-sm text-gray-600 mt-2">
                    Filtra ubicaciones por categorías como aulas, servicios, oficinas o espacios recreativos.
                </p>
            </div>
        </section>

        <!-- ====== NUEVA SECCIÓN: INFORMACIÓN ADICIONAL ====== -->
        <section class="mt-16 space-y-8">
            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3"> Propósito del proyecto</h3>
                <p class="text-gray-600 leading-relaxed">
                    <strong>MapUc</strong> es una iniciativa académica que busca aplicar tecnologías
                    web modernas para la creación de herramientas de apoyo al bienestar universitario.
                    Su objetivo principal es optimizar la orientación dentro del campus y mejorar la accesibilidad a los
                    espacios institucionales.
                </p>
            </div>

            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3"> Utilidades</h3>
                <ul class="list-disc ml-6 text-gray-600 space-y-2">
                    <li>Facilita la ubicación de bloques, bibliotecas, cafeterías y oficinas administrativas.</li>
                    <li>Permite planificar rutas peatonales desde la ubicación del usuario hasta el destino.</li>
                    <li>Ayuda a estudiantes y visitantes nuevos a familiarizarse con el campus.</li>
                    <li>Apoya el desarrollo de habilidades tecnológicas en proyectos universitarios.</li>
                </ul>
            </div>

            <div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Cómo acceder</h3>
                <p class="text-gray-600 leading-relaxed">
                    Puedes ingresar al mapa iniciando secion desde el boton con el mismo nombre.
                    Una vez dentro, podrás buscar ubicaciones específicas, generar rutas personalizadas y explorar las
                    diferentes zonas del campus.
                </p>
            </div>
        </section>
    </main>

    <!-- ====== FOOTER ====== -->
    <footer class="bg-white border-t py-4 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-sm text-gray-500 text-center">
            &copy; {{ date('Y') }} Universidad de Córdoba — Proyecto de mapa interactivo.
        </div>
    </footer>
</body>

</html>