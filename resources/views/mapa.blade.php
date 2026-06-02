<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MapUc - Mapa Interactivo Unicórdoba</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css"/>

    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Segoe UI', sans-serif;
        display: flex;
        height: 100vh;
        overflow: hidden;
    }

    /* ===== SIDEBAR ===== */
    #sidebar {
        width: 370px;
        min-width: 370px;
        height: 100vh;
        background: #fff;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 8px rgba(0,0,0,0.15);
        z-index: 1000;
        transition: transform 0.3s ease;
    }

    #sidebar-header {
        padding: 14px 16px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: #fff;
    }

    #logo-link {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    #logo-link img {
        height: 52px;
        width: auto;
    }

    #search-input {
        width: 100%;
        padding: 9px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }

    #search-input:focus { border-color: #16a34a; }

    #ubicaciones-list {
        flex: 1;
        overflow-y: auto;
        padding: 8px 0;
    }

    #ubicaciones-list::-webkit-scrollbar { width: 5px; }
    #ubicaciones-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

    .ubicacion-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        cursor: pointer;
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.15s;
    }

    .ubicacion-card:hover { background: #f9fafb; }
    .ubicacion-card.active { background: #f0fdf4; border-left: 4px solid #16a34a; }

    .ubicacion-card img {
        width: 72px;
        height: 56px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
        background: #e5e7eb;
    }

    .ubicacion-info { flex: 1; min-width: 0; }

    .ubicacion-info h3 {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ubicacion-info p {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 7px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-ruta {
        display: inline-block;
        padding: 5px 14px;
        background: #16a34a;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-ruta:hover { background: #15803d; }

    #no-results {
        display: none;
        padding: 20px 16px;
        text-align: center;
        color: #9ca3af;
        font-size: 14px;
    }

    /* ===== LOGOUT ===== */
    #logout-section {
        padding: 12px 16px;
        border-top: 1px solid #e5e7eb;
    }

    #logout-form button {
        width: 100%;
        padding: 11px;
        background: #dc2626;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background 0.2s;
    }

    #logout-form button:hover { background: #b91c1c; }

    /* ===== MAPA ===== */
    #map {
        flex: 1;
        height: 100vh;
        z-index: 1;
    }

    .leaflet-routing-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        max-height: 300px;
        overflow-y: auto;
        font-size: 13px;
    }

    .custom-popup h4 {
        font-weight: 700;
        font-size: 14px;
        margin-bottom: 4px;
        color: #111827;
    }

    .custom-popup p {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .custom-popup img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 6px;
        margin-bottom: 8px;
    }

    .popup-btn-ruta {
        display: block;
        width: 100%;
        padding: 6px;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
    }

    .popup-btn-ruta:hover { background: #15803d; }

    /* ===== BOTÓN FLOTANTE MÓVIL ===== */
    #btn-toggle-panel {
        display: none;
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 2000;
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 50px;
        padding: 14px 28px;
        font-size: 15px;
        font-weight: 700;
        box-shadow: 0 4px 16px rgba(0,0,0,0.3);
        cursor: pointer;
        gap: 8px;
        align-items: center;
    }

    /* ===== OVERLAY MÓVIL ===== */
    #overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 999;
    }

    /* ===== RESPONSIVE MÓVIL ===== */
    @media (max-width: 768px) {
        body { flex-direction: column; }

        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 85vh;
            transform: translateY(100%);
            z-index: 1500;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -4px 24px rgba(0,0,0,0.2);
        }

        #sidebar.open {
            transform: translateY(15%);
        }

        #map {
            width: 100vw;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
        }

        #btn-toggle-panel {
            display: flex;
        }

        #overlay.active {
            display: block;
        }
    }
</style>
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<div id="sidebar">
    <div id="sidebar-header">
        <a id="logo-link" href="/" title="Ir al inicio">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Unicórdoba">
        </a>
        <input
            type="text"
            id="search-input"
            placeholder="Buscar bloque..."
            autocomplete="off"
        >
    </div>

    <div id="ubicaciones-list">
        <div id="no-results">No se encontraron resultados.</div>

        @foreach($ubicaciones as $u)
        <div
            class="ubicacion-card"
            data-id="{{ $u->id }}"
            data-lat="{{ $u->latitud }}"
            data-lng="{{ $u->longitud }}"
            data-nombre="{{ $u->nombre }}"
            data-descripcion="{{ $u->descripcion }}"
            data-imagen="{{ asset($u->imagen ?? 'img/logo.jpeg') }}"
        >
            <img
                src="{{ asset($u->imagen ?? 'img/logo.jpeg') }}"
                alt="{{ $u->nombre }}"
                onerror="this.src='{{ asset('img/logo.jpeg') }}'"
            >
            <div class="ubicacion-info">
                <h3>{{ $u->nombre }}</h3>
                <p>{{ $u->descripcion }}</p>
                <button class="btn-ruta" onclick="iniciarRuta({{ $u->latitud }}, {{ $u->longitud }}, '{{ addslashes($u->nombre) }}', event)">
                    Iniciar ruta
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <div id="logout-section">
        <form id="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                </svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</div>

<!-- ===== MAPA ===== -->
<div id="map"></div>

<!-- Botón flotante móvil -->
<button id="btn-toggle-panel" onclick="togglePanel()">
    ☰ &nbsp; Ver bloques
</button>

<!-- Overlay -->
<div id="overlay" onclick="togglePanel()"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Leaflet Routing Machine -->
<script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>

<script>
    // ===== INICIALIZAR MAPA =====
    const bounds = L.latLngBounds(
    [8.7839753, -75.8561432],  // esquina suroeste
    [8.7964442, -75.8682132]   // esquina noreste
);

const map = L.map('map', {
    minZoom: 15,
    maxZoom: 19,
    maxBounds: bounds,
    maxBoundsViscosity: 1.0
}).setView([8.7504, -75.8795], 16);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

// Muestra coordenadas al hacer clic en el mapa
map.on('click', function(e) {
    const lat = e.latlng.lat.toFixed(7);
    const lng = e.latlng.lng.toFixed(7);
    
    L.popup()
        .setLatLng(e.latlng)
        .setContent(`<b>Coordenadas:</b><br>Lat: ${lat}<br>Lng: ${lng}`)
        .openOn(map);
        
    console.log(`${lat}, ${lng}`);
});

    // ===== DATOS DE UBICACIONES =====
    const ubicaciones = @json($ubicaciones);

    // ===== MARCADORES =====
    const markers = {};
    let routingControl = null;
    let userLocationMarker = null;

    const iconoAzul = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    ubicaciones.forEach(function(u) {
        const marker = L.marker([u.latitud, u.longitud], { icon: iconoAzul })
            .addTo(map);

        const imagenSrc = u.imagen ? '/{{ "" }}' + u.imagen : '{{ asset("img/logo.jpeg") }}';

        marker.bindPopup(`
            <div class="custom-popup" style="min-width:200px">
                <img src="${u.imagen ? '/' + u.imagen : '{{ asset("img/logo.jpeg") }}'}"
                     onerror="this.src='{{ asset('img/logo.jpeg') }}'"
                     alt="${u.nombre}">
                <h4>${u.nombre}</h4>
                <p>${u.descripcion || ''}</p>
                <button class="popup-btn-ruta" onclick="iniciarRuta(${u.latitud}, ${u.longitud}, '${u.nombre.replace(/'/g,"\\'")}')">
                    Iniciar ruta
                </button>
            </div>
        `);

        marker.on('click', function() {
            resaltarCard(u.id);
        });

        markers[u.id] = marker;
    });

    // ===== FUNCIÓN INICIAR RUTA =====
    function iniciarRuta(lat, lng, nombre, event) {
        if (event) event.stopPropagation();

        // Eliminar ruta anterior
        if (routingControl) {
            map.removeControl(routingControl);
            routingControl = null;
        }

        // Obtener ubicación del usuario
        if (!navigator.geolocation) {
            alert('Tu navegador no soporta geolocalización. Se usará la entrada principal del campus.');
            trazarRuta(8.7504, -75.8795, lat, lng, nombre);
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                trazarRuta(pos.coords.latitude, pos.coords.longitude, lat, lng, nombre);
            },
            function() {
                // Si el usuario rechaza la geolocalización, usar entrada principal
                trazarRuta(8.7504, -75.8795, lat, lng, nombre);
            }
        );
    }

    function trazarRuta(origenLat, origenLng, destLat, destLng, nombre) {
        // Marcador de usuario
        if (userLocationMarker) map.removeLayer(userLocationMarker);

        const iconoUsuario = L.divIcon({
            html: '<div style="background:#2563eb;width:14px;height:14px;border-radius:50%;border:3px solid white;box-shadow:0 0 6px rgba(0,0,0,0.4)"></div>',
            iconSize: [14, 14],
            iconAnchor: [7, 7],
            className: ''
        });

        userLocationMarker = L.marker([origenLat, origenLng], { icon: iconoUsuario })
            .addTo(map)
            .bindPopup('Tu ubicación')
            .openPopup();

        routingControl = L.Routing.control({
    router: L.Routing.osrmv1({
        serviceUrl: 'https://routing.openstreetmap.de/routed-foot/route/v1'
    }),
    waypoints: [
        L.latLng(origenLat, origenLng),
        L.latLng(destLat, destLng)
    ],
            routeWhileDragging: false,
            lineOptions: {
                styles: [{ color: '#16a34a', weight: 5, opacity: 0.8 }]
            },
            createMarker: function() { return null; },
            show: true,
            addWaypoints: false,
            language: 'es'
        }).addTo(map);

        map.setView([destLat, destLng], 17);
    }

    // ===== CLICK EN CARD LATERAL =====
    document.querySelectorAll('.ubicacion-card').forEach(function(card) {
        card.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-ruta')) return;

            const id   = parseInt(card.dataset.id);
            const lat  = parseFloat(card.dataset.lat);
            const lng  = parseFloat(card.dataset.lng);

            map.setView([lat, lng], 18);

            if (markers[id]) {
                markers[id].openPopup();
            }

            resaltarCard(id);
        });
    });

    function resaltarCard(id) {
        document.querySelectorAll('.ubicacion-card').forEach(c => c.classList.remove('active'));
        const card = document.querySelector(`.ubicacion-card[data-id="${id}"]`);
        if (card) {
            card.classList.add('active');
            card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    // ===== BUSCADOR =====
    document.getElementById('search-input').addEventListener('input', function() {
        const q = this.value.toLowerCase().trim();
        let visibles = 0;

        document.querySelectorAll('.ubicacion-card').forEach(function(card) {
            const nombre = card.dataset.nombre.toLowerCase();
            if (nombre.includes(q)) {
                card.style.display = 'flex';
                visibles++;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('no-results').style.display = visibles === 0 ? 'block' : 'none';
    });
// ===== TOGGLE PANEL MÓVIL =====
function togglePanel() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const btn = document.getElementById('btn-toggle-panel');

    sidebar.classList.toggle('open');
    overlay.classList.toggle('active');
    btn.textContent = sidebar.classList.contains('open') ? '✕  Cerrar' : '☰  Ver bloques';
}

</script>
</body>
</html>
