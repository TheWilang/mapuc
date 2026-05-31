<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Mapa Interactivo - Universidad de Córdoba</title>
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">


  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <!-- Routing Machine -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
  <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

  <!-- FontAwesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

  <style>
    #map { height: 100vh; }
    .slidebar { transition: transform 0.3s ease; }
    .slidebar.hidden { transform: translateX(-100%); }
    /* Botón hamburguesa externo siempre visible y destacado */
    #menu-btn-externo {
      position: fixed;
      top: 0;
      right: 0;
      margin: 0;
      background: rgba(255,255,255,0.95);
      border: 2px solid #38a169;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      color: #256029;
      display: block;
      z-index: 9999;
      border-radius: 0 0 0 12px;
    }
    @media (min-width: 1024px) {
      #menu-btn-externo { display: none; }
    }

    #modal-imagen img {
  transition: transform 0.2s ease;
}
#modal-imagen img:hover {
  transform: scale(1.02);
}
#imagen-ampliada {
  transform-origin: center center;
}

  </style>
</head>

<body class="bg-gray-100 flex">
  <!-- Modal de información de lugar -->
  <div id="modal-lugar" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-[99999] hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
      <button id="cerrar-modal-lugar" class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-2xl font-bold">&times;</button>
      <img id="modal-lugar-img" src="" alt="Imagen del lugar" class="w-full h-40 object-cover rounded mb-4 bg-gray-100">
      <h3 id="modal-lugar-nombre" class="text-xl font-bold mb-2 text-green-700"></h3>
      <p id="modal-lugar-desc" class="text-gray-700"></p>
    </div>

    <!-- Modal de imagen ampliada -->
<div id="modal-imagen" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-[999999] hidden">
  <div class="relative">
    <img id="imagen-ampliada" src="" alt="Vista ampliada" class="max-w-4xl max-h-[90vh] rounded-lg shadow-lg cursor-zoom-in transition-transform duration-300 ease-in-out">
  </div>
</div>


  </div>

  <!-- Logo Universidad de Córdoba como botón hamburguesa -->
  <button id="menu-btn-logo" class="fixed top-4 right-4 z-50 bg-white p-1 rounded-full shadow-lg border-2 border-green-600 hover:scale-105 transition-transform lg:hidden" style="width:56px;height:56px;display:flex;align-items:center;justify-content:center;">
    <img src="{{ asset('img/ico.png') }}" alt="Logo Universidad de Córdoba" class="h-12 w-auto rounded-full">
  </button>

  <!-- Barra lateral -->
  <aside id="slidebar" class="slidebar bg-white w-80 h-screen shadow-lg p-5 fixed z-40 flex flex-col justify-between">
    
    <div>
  <div class="flex justify-between items-center mb-5">
    <div class="flex items-center gap-2">
      <a href="/"> <!-- Enlace al inicio -->
        <img src="{{ asset('img/logo.jpeg') }}" 
             alt="Logo Universidad de Córdoba" 
             class="h-12 w-auto rounded shadow">
      </a>
    </div>
  </div>
</div>


      <!-- Buscador -->
      <div class="mb-4">
        <input id="search-input" type="text" placeholder="Buscar bloque..." class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
      </div>

      <!-- Lista de bloques -->
      <div id="bloques-list" class="space-y-4 overflow-y-auto max-h-[70vh]"></div>
    </div>

    <!-- Botones -->
    <div class="flex flex-col gap-3">
      <!-- Botón cancelar ruta -->
      <button id="cancel-route-btn" class="hidden w-full bg-yellow-500 hover:bg-yellow-600 text-white py-2 rounded-lg font-semibold flex items-center justify-center gap-2">
        <i class="fa fa-times-circle"></i> Cancelar ruta
      </button>

      <!-- Botón de cerrar sesión -->
      <button id="logout-btn" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-semibold flex items-center justify-center gap-2">
        <i class="fa fa-sign-out-alt"></i> Cerrar sesión
      </button>
    </div>
  </aside>

  <!-- Mapa -->
  <div id="map" class="flex-1 z-10"></div>

  <script>
    // ======= MAPA PRINCIPAL =======
    const ubicacionUnicordoba = [8.791676, -75.862504];
    const map = L.map('map').setView(ubicacionUnicordoba, 17);

    // ======= MAPA SIN LÍMITES =======
    map.setMinZoom(17);

    // ======= CAPA BASE =======
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

  // ======= DATOS DE LOS BLOQUES =======
const bloques = [
  { nombre: "Universidad de Córdoba", lat: 8.791676, lng: -75.862504, descripcion: "Campus principal en Montería, Colombia.", imagen: "img/ico.png" },
  { nombre: "Bloque A - Rectoría", lat: 8.79185, lng: -75.86280, descripcion: "Oficinas administrativas y rectoría.", imagen: "img/Rectoria.jpg" },
  { nombre: "Biblioteca Central", lat: 8.79150, lng: -75.86220, descripcion: "Centro de recursos académicos y salas de estudio.", imagen: "img/Biblioteca.jpg" },
  { nombre: "Cafetería Auditorio", lat: 8.79130, lng: -75.86190, descripcion: "Zona de alimentación y descanso para estudiantes.", imagen: "img/Cafeteria Auditorio.jpg" },
  { nombre: "Bloque 11 Bioclimático", lat: 8.78968091273895, lng: -75.85936154749987, descripcion: "Edificio con diseño sostenible y ecológico.", imagen: "img/Bioclimatico.jpg" },
  { nombre: "Edificio de Postgrado", lat: 8.788655450501842,  lng: -75.85802280524611, descripcion: "Oficinas y aulas para programas de postgrado.", imagen: "img/Postgrado.jpg" },
  { nombre: "Estadio de Fútbol", lat: 8.787799, lng: -75.859501, descripcion: "Estadio universitario para actividades deportivas.", imagen: "img/Estadio.jpg" },
  { nombre: "Zona de Estudio Informática", lat: 8.788922, lng: -75.859029, descripcion: "Área de estudio y laboratorios para estudiantes de informática.", imagen: "img/zona informatica.jpg" },
  { nombre: "Piscina De La Universidad De Cordoba", lat: 8.789138235631484, lng: -75.85771734636926, descripcion: "Laboratorio para investigación molecular.", imagen: "img/piscina.jpg" },
  { nombre: "Bloque 4 - Salud", lat: 8.78934402578916, lng: -75.85792461571228, descripcion: "Bloque 4 - áreas de salud y docencia.", imagen: "img/bloque 4.jpg" },
  { nombre: "Cancha De Micro-Futbol", lat: 8.787656599770294, lng:  -75.86001478002512, descripcion: "Bloque 8 dedicado a Salud Pública.", imagen: "img/microfut.jpg" },
  { nombre: "Enfermeria", lat: 8.78941938480094, lng:  -75.85869326977293, descripcion: "Facultad y consultorios de Enfermería.", imagen: "img/Enfermeria.jpg" },
  { nombre: "Bloque 14 - Informática", lat: 8.78888550235526, lng: -75.85917411943119, descripcion: "Bloque 14 - aulas y laboratorios de informática.", imagen: "img/informatica.jpg" },
  { nombre: "Centro de Convenciones", lat: 8.79001454751785, lng: -75.85753669627043, descripcion: "Centro de Convenciones - espacio para eventos académicos y culturales.", imagen: "img/convenciones.jpg" },
  { nombre: "Cafeteria Salud", lat: 8.789514435266693,  lng: -75.85835222924841, descripcion: "Biblioteca central con recursos y salas de estudio.", imagen: "img/saludcafe.jpg" },
  { nombre: "Auditorio Cultural", lat: 8.790792305371227, lng: -75.86369668617539, descripcion: "Auditorio para eventos culturales y conferencias.", imagen: "img/auditorio.jpg" },
  { nombre: "Bienestar Universitario", lat: 8.791144239621776, lng: -75.86326702658098, descripcion: "Bienestar universitario - servicios y apoyo al estudiante.", imagen: "img/Bienestar.jpg" },
  { nombre: "Centro De Ciencias Del Deporte Y La Cultura Física", lat: 8.78846290154185,  lng: -75.86031007296867, descripcion: "Colección y espacio de conservación de plantas.", imagen: "img/fisicacul.jpg" },
  { nombre: "Bloque 21 - Lab Ciencias Básicas", lat: 8.792551890684262, lng: -75.86117258381022, descripcion: "Laboratorios de ciencias básicas.", imagen: "img/lab1.jpg" },
  { nombre: "Bloque 33 - Ciencias Básicas", lat: 8.792445632939502, lng: -75.86193935760708, descripcion: "Aulas y laboratorios para ciencias básicas.", imagen: "img/b33.jpg" },
  { nombre: "Bloque 23 - Laboratorio integrado de Ingeniería Industrial", lat: 8.79257277550118, lng: -75.86241926369385, descripcion: "Laboratorio de materiales de ingeniería mecánica.", imagen: "img/b23.jpg" },
  { nombre: "Bloque 26 ", lat: 8.791785725112916, lng: -75.86216234600576, descripcion: "Servicios de atención al egresado.", imagen: "img/b26.jpg" },
  { nombre: "Zonas de Estudio Educacion", lat: 8.789114456067594, lng:  -75.86024790314846, descripcion: "Bloque 26 - aulas.", imagen: "img/zona educacion.jpg" },
  { nombre: "Zonas de Estudios Tamarindo", lat: 8.790825940675566, lng: -75.86347956615774, descripcion: "Zonas de estudio al aire libre (Tamarindo).", imagen: "img/zona tamarindo.jpg" },
  { nombre: "Zonas de Estudios Agronomia", lat: 8.790825940675566, lng: -75.86347956615774, descripcion: "Zonas de estudio al aire libre (Tamarindo).", imagen: "img/zona agronomia.jpg" },
  { nombre: "Corresponsal Bancolombia Unicor", lat: 8.79098988810083, lng: -75.86298044774581, descripcion: "Punto de atención bancaria en el campus.", imagen: "img/corresponsal.png" },
  { nombre: "Cafetería Central", lat: 8.791470447308514,  lng: -75.86249834586667, descripcion: "Cafetería principal del campus.", imagen: "img/central.jpg" },
  { nombre: "Bloque 44", lat: 8.791490530785532, lng: -75.8636165898739, descripcion: "Bloque 44 - aulas y oficinas.", imagen: "img/b44.jpg" },
  { nombre: "Bloque 43", lat: 8.791843579981547, lng: -75.86343637170344, descripcion: "Bloque 43 - aulas y laboratorios.", imagen: "img/b43.jpg" },
  { nombre: "Piscícola CINPIC", lat: 8.79203631713771, lng: -75.86408432062719, descripcion: "Instalaciones piscícolas del CINPIC.", imagen: "img/cinpic.jpg" },
  { nombre: "Bloque 42 - Agronomía", lat: 8.79188040890364, lng: -75.86065611345624, descripcion: "Bloque 42 - Facultad de Agronomía.", imagen: "img/b42.jpg" },
  { nombre: "Estadio Unicor El Tamarindo", lat: 8.790217434147882, lng: -75.86336005475576, descripcion: "Estadio El Tamarindo para eventos deportivos.", imagen: "img/cancha tamarindo.jpg" },
  { nombre: "Estadio Futsal", lat: 8.788145180583161, lng: -75.85984546512825, descripcion: "Espacio deportivo para futsal dentro del campus.", imagen: "img/EstadioFutsal.jpg" }
];


    // ======= MARCADORES =======
    bloques.forEach(b => {
      const marker = L.marker([b.lat, b.lng]).addTo(map)
        .bindPopup(`<b>${b.nombre}</b><br>${b.descripcion}`);
      marker.on('click', () => {
        document.getElementById('modal-lugar-img').src = b.imagen;
        document.getElementById('modal-lugar-nombre').textContent = b.nombre;
        document.getElementById('modal-lugar-desc').textContent = b.descripcion;
        document.getElementById('modal-lugar').classList.remove('hidden');
      });
    // Cerrar modal de información de lugar
    document.addEventListener('DOMContentLoaded', function() {
      const modal = document.getElementById('modal-lugar');
      const cerrarBtn = document.getElementById('cerrar-modal-lugar');
      cerrarBtn.addEventListener('click', () => {
        modal.classList.add('hidden');
      });
      modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.classList.add('hidden');
      });
    });
    });

    // ======= LISTA DE BLOQUES =======
    const bloquesList = document.getElementById("bloques-list");
    function renderBloques(filtro = "") {
      bloquesList.innerHTML = "";
      bloques
        .filter(b => b.nombre.toLowerCase().includes(filtro.toLowerCase()))
        .forEach(b => {
          const div = document.createElement("div");
          div.className = "border border-gray-200 p-3 rounded-lg hover:bg-gray-50 transition flex gap-3";
          div.innerHTML = `
            <img src="${b.imagen}" alt="${b.nombre}" class="w-16 h-16 object-cover rounded shadow mr-2">
            <div class="flex-1">
              <h3 class="font-semibold text-gray-800">${b.nombre}</h3>
              <p class="text-sm text-gray-600 mb-2">${b.descripcion}</p>
              <button onclick="iniciarRuta(${b.lat}, ${b.lng})" class="bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-1 rounded">
                Iniciar ruta
              </button>
            </div>
          `;
          bloquesList.appendChild(div);
        });
    }
    renderBloques();

    // ======= BUSCADOR =======
    document.getElementById("search-input").addEventListener("input", (e) => {
      renderBloques(e.target.value);
    });

    // ======= BOTÓN LOGO HAMBURGUESA =======
    const slidebar = document.getElementById("slidebar");
    const menuBtnLogo = document.getElementById("menu-btn-logo");
    if (menuBtnLogo) {
      menuBtnLogo.addEventListener("click", () => {
        slidebar.classList.toggle("hidden");
      });
    }

    // ======= CERRAR SESIÓN =======
    document.getElementById("logout-btn").addEventListener("click", () => {
      if (confirm("¿Deseas cerrar sesión?")) {
        window.location.href = "https://ds2-rcci.onrender.com/";
      }
    });

    // ======= VARIABLES DE RUTAS =======
    let rutaActiva = null;
    let marcadorUsuario = null;
    let seguimientoActivo = false;
    let watchId = null;
    const cancelRouteBtn = document.getElementById("cancel-route-btn");

    // ======= FUNCIONES =======
    function iniciarRuta(destLat, destLng) {
      limpiarRutaActiva();

      if (!navigator.geolocation) {
        alert("Tu navegador no soporta geolocalización.");
        return;
      }

      navigator.geolocation.getCurrentPosition(pos => {
        const { latitude, longitude } = pos.coords;

        rutaActiva = L.Routing.control({
          waypoints: [
            L.latLng(latitude, longitude),
            L.latLng(destLat, destLng)
          ],
          router: L.Routing.osrmv1({
            serviceUrl: 'https://router.project-osrm.org/route/v1',
            profile: 'foot'
          }),
          lineOptions: {
            styles: [{ color: 'blue', opacity: 0.7, weight: 5 }]
          },
          routeWhileDragging: false,
          createMarker: function(i, wp) {
            return L.marker(wp.latLng, {
              icon: L.icon({
                iconUrl: i === 0 
                  ? 'https://cdn-icons-png.flaticon.com/512/64/64113.png' 
                  : 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                iconSize: [32, 32]
              })
            });
          }
        }).addTo(map);

        iniciarSeguimiento();
        cancelRouteBtn.classList.remove("hidden");

      }, () => alert("No se pudo obtener tu ubicación actual."));
    }

    function iniciarSeguimiento() {
      if (seguimientoActivo || !navigator.geolocation) return;
      seguimientoActivo = true;

      watchId = navigator.geolocation.watchPosition(pos => {
        const { latitude, longitude } = pos.coords;
        if (marcadorUsuario) {
          marcadorUsuario.setLatLng([latitude, longitude]);
        } else {
          marcadorUsuario = L.marker([latitude, longitude], {
            icon: L.icon({
              iconUrl: 'https://cdn-icons-png.flaticon.com/512/64/64113.png',
              iconSize: [30, 30]
            })
          }).addTo(map).bindPopup("Tu ubicación actual");
        }
      });
    }

    function limpiarRutaActiva() {
      if (rutaActiva) {
        try { map.removeControl(rutaActiva); } catch(e) {}
        rutaActiva = null;
      }

      if (marcadorUsuario) {
        try { map.removeLayer(marcadorUsuario); } catch(e) {}
        marcadorUsuario = null;
      }

      if (watchId !== null && navigator.geolocation) {
        navigator.geolocation.clearWatch(watchId);
        watchId = null;
      }

      seguimientoActivo = false;
      cancelRouteBtn.classList.add("hidden");
    }

    // ======= CANCELAR RUTA =======
    cancelRouteBtn.addEventListener("click", () => {
      if (!confirm("¿Deseas cancelar la ruta actual?")) return;
      limpiarRutaActiva();
      map.setView(ubicacionUnicordoba, 17);
    });

    // ======= AMPLIAR IMAGEN DEL BLOQUE =======
const modalImagen = document.getElementById('modal-imagen');
const imagenAmpliada = document.getElementById('imagen-ampliada');
const modalLugarImg = document.getElementById('modal-lugar-img');

// Mostrar imagen ampliada al hacer clic
modalLugarImg.addEventListener('click', () => {
  imagenAmpliada.src = modalLugarImg.src;
  modalImagen.classList.remove('hidden');
});

// Cerrar modal de imagen al hacer clic fuera
modalImagen.addEventListener('click', (e) => {
  if (e.target === modalImagen) {
    modalImagen.classList.add('hidden');
  }
});

// ======= ZOOM INTERACTIVO EN IMAGEN AMPLIADA =======
let zoomActivo = false;
let escalaZoom = 1.5;

imagenAmpliada.addEventListener('click', (e) => {
  zoomActivo = !zoomActivo;

  if (zoomActivo) {
    imagenAmpliada.classList.remove('cursor-zoom-in');
    imagenAmpliada.classList.add('cursor-zoom-out');
    imagenAmpliada.style.transform = `scale(${escalaZoom})`;
    imagenAmpliada.style.cursor = "zoom-out";
  } else {
    imagenAmpliada.classList.remove('cursor-zoom-out');
    imagenAmpliada.classList.add('cursor-zoom-in');
    imagenAmpliada.style.transform = 'scale(1)';
  }
});

// Cerrar modal al hacer clic fuera o en el botón ×
modalImagen.addEventListener('click', (e) => {
  if (e.target === modalImagen) {
    modalImagen.classList.add('hidden');
    imagenAmpliada.style.transform = 'scale(1)';
    zoomActivo = false;
  }
});

document.getElementById('cerrar-imagen').addEventListener('click', () => {
  modalImagen.classList.add('hidden');
  imagenAmpliada.style.transform = 'scale(1)';
  zoomActivo = false;
});
  </script>
</body>
</html>


