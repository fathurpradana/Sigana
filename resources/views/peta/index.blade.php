<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Kejadian | SIGANA</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="{{ asset('css/sigana-theme.css') }}?v=7">
    <script src="{{ asset('js/sigana-theme.js') }}?v=4" defer></script>
    <style>
        * { box-sizing: border-box; }
        :root { --teal:#105361; --page:var(--sigana-page,#f4f5f2); --text:var(--sigana-text,#19373d); --muted:var(--sigana-muted,#788889); --line:var(--sigana-line,#e1e8e5); --surface:var(--sigana-surface,#fff); }
        body { min-height:100vh; margin:0; background:var(--page); color:var(--text); font-family:Arial,Helvetica,sans-serif; }
        .app { min-height:100vh; display:grid; grid-template-columns:260px minmax(0,1fr); }
        .sidebar { min-height:100vh; display:flex; flex-direction:column; padding:24px 16px 16px; background:#105361; color:#fff; }
        .brand { display:flex; align-items:center; gap:10px; padding:0 8px 26px; }
        .brand-icon { width:42px; height:42px; flex:0 0 42px; display:grid; place-items:center; border-radius:12px; background:#fff; }
        .brand-icon img { width:28px; height:28px; }
        .brand-name { margin:0; font-size:18px; letter-spacing:.03em; }
        .brand-caption { margin:3px 0 0; color:#c6dfe2; font-size:10px; }
        .nav { display:grid; gap:7px; }
        .nav a { min-height:44px; display:flex; align-items:center; gap:12px; padding:0 12px; border-radius:10px; color:#e2eff0; font-size:13px; text-decoration:none; }
        .nav a:hover,.nav a.active { background:rgba(255,255,255,.17); color:#fff; }
        .nav a span { width:18px; text-align:center; }
        .sidebar-bottom { margin-top:auto; }
        .emergency-card { padding:14px; border-radius:12px; background:rgba(255,255,255,.13); }
        .emergency-card span { display:block; margin-bottom:5px; color:#d0e3e5; font-size:11px; }
        .emergency-card strong { font-size:20px; }
        .logout-button { display:block; width:100%; margin-top:12px; padding:12px 14px; box-sizing:border-box; border:1px solid rgba(255,255,255,.3); border-radius:9px; background:transparent; color:#e2eff0; font:inherit; font-size:13px; text-align:center; text-decoration:none; cursor:pointer; }
        .main { min-width:0; padding:clamp(22px,3vw,42px); }
        .page-heading { display:flex; align-items:flex-end; justify-content:space-between; gap:20px; margin-bottom:22px; }
        .page-heading h1 { margin:0; font-size:clamp(25px,3vw,34px); letter-spacing:-.03em; }
        .page-heading p { margin:7px 0 0; color:var(--muted); font-size:14px; }
        .map-card { overflow:hidden; border:1px solid var(--line); border-radius:20px; background:var(--surface); box-shadow:0 10px 32px rgb(26 57 62 / 6%); }
        .map-toolbar { display:flex; align-items:center; justify-content:space-between; gap:18px; padding:20px 22px; border-bottom:1px solid var(--line); }
        .map-toolbar h2 { margin:0; font-size:17px; }
        .map-toolbar p { margin:5px 0 0; color:var(--muted); font-size:12px; }
        .map-tools { display:flex; align-items:center; gap:10px; }
        .filter-list { display:flex; flex-wrap:wrap; gap:7px; }
        .map-filter,.locate-button { min-height:36px; padding:0 14px; border:1px solid var(--line); border-radius:999px; background:var(--surface); color:var(--text); font:inherit; font-size:12px; cursor:pointer; }
        .map-filter[aria-pressed="true"] { border-color:var(--teal); background:var(--teal); color:white; }
        .locate-button { display:flex; align-items:center; gap:7px; color:var(--teal); font-weight:700; }
        .locate-button:disabled { opacity:.65; cursor:wait; }
        .map-wrap { position:relative; padding:16px; }
        #sigana-map { width:100%; height:min(68vh,700px); min-height:460px; overflow:hidden; border-radius:14px; background:#b3d9e3; }
        .map-legend { position:absolute; z-index:500; left:28px; bottom:28px; display:flex; align-items:center; gap:14px; padding:11px 14px; border:1px solid #e0e8e6; border-radius:12px; background:rgba(255,255,255,.96); box-shadow:0 5px 16px rgb(20 45 50 / 15%); color:#44595c; font-size:12px; }
        .legend-item { display:inline-flex; align-items:center; gap:7px; white-space:nowrap; }
        .legend-dot { width:11px; height:11px; flex:0 0 11px; border-radius:50%; background:#09879a; box-shadow:0 0 0 2px #fff,0 0 0 3px #09879a; }
        .legend-dot.quake { background:#d58a24; box-shadow:0 0 0 2px #fff,0 0 0 3px #d58a24; }
        .legend-count { padding-left:12px; border-left:1px solid #dce5e3; color:#105361; font-weight:700; }
        .map-note { min-height:46px; display:flex; align-items:center; padding:10px 22px; border-top:1px solid var(--line); color:var(--muted); font-size:12px; }
        .leaflet-container { font-family:Arial,Helvetica,sans-serif; }
        .leaflet-control-zoom { overflow:hidden; border:1px solid #dce5e3!important; border-radius:10px; box-shadow:0 4px 14px rgb(25 55 61 / 14%)!important; }
        .leaflet-control-zoom a { color:#105361!important; }
        .sigana-marker { display:grid; width:34px; height:34px; place-items:center; border:2px solid #fff; border-radius:50%; box-shadow:0 3px 10px rgb(24 48 54 / 35%); color:white; font-size:16px; line-height:1; }
        .sigana-marker.flood { background:#07889d; }
        .sigana-marker.quake { background:#d58a24; }
        .popup-card { width:230px; }
        .popup-card img { width:100%; height:112px; display:block; margin-bottom:9px; border-radius:8px; object-fit:cover; }
        .popup-card strong { display:block; margin-bottom:5px; font-size:13px; }
        .popup-card p { margin:3px 0; color:#607174; font-size:11px; line-height:1.4; }
        .popup-card a { display:inline-block; margin-top:8px; color:#105361; font-size:12px; font-weight:700; text-decoration:none; }
        @media(max-width:900px) { .app { grid-template-columns:220px minmax(0,1fr); } .map-toolbar { align-items:flex-start; flex-direction:column; } .map-tools { width:100%; justify-content:space-between; } }
        @media(max-width:680px) { .app { display:block; } .sidebar { min-height:0; padding:12px; } .brand { padding:0 6px 12px; } .nav { display:flex; gap:6px; overflow-x:auto; padding-bottom:4px; } .nav a { min-width:max-content; min-height:38px; padding:0 10px; font-size:12px; } .sidebar-bottom { display:none; } .main { padding:22px 14px; } .page-heading { align-items:flex-start; } .map-toolbar { padding:16px; } .map-tools { align-items:flex-start; flex-direction:column; } #sigana-map { min-height:420px; height:65vh; } .map-wrap { padding:10px; } .map-legend { left:18px; bottom:20px; gap:10px; padding:9px 11px; font-size:11px; } }
    </style>
</head>
<body>
<div class="app">
    @include('partials.sidebar')
    <main class="main">
        <header class="page-heading">
            <div>
                <h1>Peta kejadian bencana</h1>
                <p>Pantau lokasi kejadian Banjir dan Gempa Bumi yang telah diverifikasi.</p>
            </div>
        </header>

        <section class="map-card" aria-labelledby="mapTitle">
            <div class="map-toolbar">
                <div>
                    <h2 id="mapTitle">Peta Indonesia</h2>
                    <p>Penanda aktif ditampilkan selama 7 hari sejak verifikasi.</p>
                </div>
                <div class="map-tools">
                    <div class="filter-list" role="group" aria-label="Filter jenis bencana">
                        <button class="map-filter" type="button" data-filter="all" aria-pressed="true">Semua</button>
                        <button class="map-filter" type="button" data-filter="banjir" aria-pressed="false">Banjir</button>
                        <button class="map-filter" type="button" data-filter="gempa" aria-pressed="false">Gempa Bumi</button>
                    </div>
                    <button class="locate-button" id="locateMe" type="button">◎ <span>Lokasi saya</span></button>
                </div>
            </div>
            <div class="map-wrap">
                <div id="sigana-map" aria-label="Peta interaktif lokasi kejadian bencana"></div>
                <div class="map-legend" aria-label="Legenda peta">
                    <span class="legend-item"><span class="legend-dot"></span>Banjir</span>
                    <span class="legend-item"><span class="legend-dot quake"></span>Gempa</span>
                    <span class="legend-count" id="mapCount">0 kejadian</span>
                </div>
            </div>
            <div class="map-note" id="mapNote" aria-live="polite">Memuat lokasi kejadian…</div>
        </section>
    </main>
</div>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const disasters = @json($disasters);
    const map = L.map('sigana-map', { scrollWheelZoom: true }).setView([-2.5, 118], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const markers = [];
    let activeFilter = 'all';
    const mapCount = document.getElementById('mapCount');
    const mapNote = document.getElementById('mapNote');

    function isQuake(item) { return String(item.category || '').toLocaleLowerCase('id').includes('gempa'); }
    function safeText(value) { return String(value ?? ''); }
    function createPopup(item) {
        const wrapper = document.createElement('div');
        wrapper.className = 'popup-card';
        if (item.photo_url) {
            const image = document.createElement('img');
            image.src = item.photo_url;
            image.alt = 'Foto kejadian';
            image.loading = 'lazy';
            wrapper.append(image);
        }
        const title = document.createElement('strong');
        title.textContent = safeText(item.title);
        wrapper.append(title);
        const category = document.createElement('p');
        category.textContent = `${safeText(item.category)} · ${safeText(item.status)}`;
        wrapper.append(category);
        const location = document.createElement('p');
        location.textContent = safeText(item.location);
        wrapper.append(location);
        if (item.occurred_at) {
            const occurred = document.createElement('p');
            occurred.textContent = `Waktu kejadian: ${safeText(item.occurred_at)}`;
            wrapper.append(occurred);
        }
        if (item.uploaded_at) {
            const uploaded = document.createElement('p');
            uploaded.textContent = `Diunggah: ${safeText(item.uploaded_at)}`;
            wrapper.append(uploaded);
        }
        const link = document.createElement('a');
        link.href = item.url;
        link.textContent = 'Lihat detail →';
        wrapper.append(link);
        return wrapper;
    }

    disasters.forEach(item => {
        const quake = isQuake(item);
        const icon = L.divIcon({
            className: '',
            html: `<span class="sigana-marker ${quake ? 'quake' : 'flood'}" aria-hidden="true">${quake ? '⌁' : '💧'}</span>`,
            iconSize: [34, 34],
            iconAnchor: [17, 17],
            popupAnchor: [0, -17]
        });
        const marker = L.marker([item.latitude, item.longitude], { icon }).bindPopup(createPopup(item));
        marker.siganaCategory = quake ? 'gempa' : 'banjir';
        markers.push(marker);
    });

    function applyFilter(filter) {
        activeFilter = filter;
        let visible = 0;
        markers.forEach(marker => {
            const show = filter === 'all' || marker.siganaCategory === filter;
            if (show) { marker.addTo(map); visible++; } else { map.removeLayer(marker); }
        });
        mapCount.textContent = `${visible} kejadian`;
        mapNote.textContent = visible
            ? `${visible} kejadian terverifikasi dengan koordinat ditampilkan pada peta.`
            : 'Belum ada kejadian terverifikasi dengan koordinat untuk filter ini.';
        document.querySelectorAll('.map-filter').forEach(button => {
            button.setAttribute('aria-pressed', String(button.dataset.filter === filter));
        });
    }
    document.querySelectorAll('.map-filter').forEach(button => button.addEventListener('click', () => applyFilter(button.dataset.filter)));
    applyFilter(activeFilter);

    let userMarker = null;
    function locateUser(button = null) {
        if (!navigator.geolocation) {
            mapNote.textContent = 'Browser ini tidak mendukung fitur lokasi.';
            return;
        }
        if (button) button.disabled = true;
        mapNote.textContent = 'Meminta izin lokasi perangkat…';
        navigator.geolocation.getCurrentPosition(position => {
            const point = [position.coords.latitude, position.coords.longitude];
            if (userMarker) {
                userMarker.setLatLng(point);
            } else {
                userMarker = L.circleMarker(point, { radius: 8, color: '#fff', weight: 3, fillColor: '#126b7c', fillOpacity: 1 }).addTo(map);
                userMarker.bindPopup('Lokasi Anda');
            }
            userMarker.openPopup();
            map.flyTo(point, 10);
            mapNote.textContent = 'Peta dipusatkan pada lokasi perangkat Anda.';
            if (button) button.disabled = false;
        }, () => {
            mapNote.textContent = 'Lokasi tidak tersedia. Izinkan akses lokasi pada browser lalu coba lagi.';
            if (button) button.disabled = false;
        }, { enableHighAccuracy: true, timeout: 10000 });
    }

    document.getElementById('locateMe').addEventListener('click', function () { locateUser(this); });
    locateUser();
</script>
</body>
</html>
