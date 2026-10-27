<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | SIGANA</title>

    <link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        * { box-sizing: border-box; }

        :root {
            --teal: #105361;
            --teal-dark: #0d4652;
            --page: #f4f5f2;
            --text: #19373d;
            --muted: #788889;
            --line: #e6eae7;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--page);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .app {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 240px minmax(0, 1fr);
        }

        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 24px 16px 16px;
            background: var(--teal);
            color: white;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 8px 26px;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: white;
            color: var(--teal);
        }

        .brand-icon svg { width: 25px; height: 25px; }

        .brand-name {
            margin: 0;
            font-size: 17px;
            letter-spacing: .03em;
        }

        .brand-caption {
            margin: 3px 0 0;
            color: #c6dfe2;
            font-size: 10px;
        }

        .nav {
            display: grid;
            gap: 7px;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 42px;
            padding: 0 12px;
            border-radius: 9px;
            color: #e2eff0;
            font-size: 13px;
            text-decoration: none;
        }

        .nav a:hover,
        .nav a.active {
            background: rgba(255, 255, 255, .17);
            color: white;
        }

        .nav svg {
            width: 17px;
            height: 17px;
            flex: 0 0 auto;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .emergency-card {
            padding: 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .13);
        }

        .emergency-card span {
            display: block;
            margin-bottom: 5px;
            color: #d0e3e5;
            font-size: 11px;
        }

        .emergency-card strong { font-size: 20px; }

        /* Konten utama */
        .main {
            min-width: 0;
            padding: 28px clamp(20px, 4vw, 58px);
        }

        .topbar {
            position: relative;
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 24px;
        }

        .welcome h1 {
            margin: 0;
            font-size: clamp(22px, 2.4vw, 30px);
        }

        .welcome p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search {
            width: min(270px, 32vw);
            height: 42px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 13px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: white;
        }

        .search svg {
            width: 16px;
            height: 16px;
            color: #728182;
        }

        .search input {
            width: 100%;
            border: 0;
            outline: 0;
            color: var(--text);
            font-size: 12px;
        }

        .search input::placeholder { color: #8a9695; }

        .icon-button {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border: 1px solid var(--line);
            border-radius: 50%;
            background: white;
            color: var(--teal);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: #dcebed;
            color: var(--teal);
            font-weight: bold;
        }
        .search-wrap { position: relative; z-index: 1105; }
        .search-wrap .search { width: min(270px, 32vw); }
        .search-suggestions {
            position: absolute; z-index: 1106; top: calc(100% + 8px); right: 0;
            width: min(390px, calc(100vw - 32px)); max-height: min(420px, calc(100vh - 120px));
            overflow-y: auto; border: 1px solid var(--line); border-radius: 14px;
            background: white; box-shadow: 0 14px 34px rgb(20 45 50 / 16%);
        }
        .search-suggestions[hidden] { display: none; }
        .search-suggestion { display: flex; align-items: center; gap: 12px; min-width: 0; padding: 12px; border-bottom: 1px solid #edf0ed; color: var(--text); text-decoration: none; }
        .search-suggestion:last-child { border-bottom: 0; }
        .search-suggestion:hover, .search-suggestion:focus { outline: 0; background: #f2f8f8; }
        .search-suggestion-copy { display: grid; flex: 1; min-width: 0; gap: 4px; }
        .search-suggestion strong { display: block; overflow: hidden; font-size: 12px; line-height: 1.4; text-overflow: ellipsis; }
        .search-suggestion .search-suggestion-meta { margin: 0; overflow: hidden; color: var(--muted); font-size: 10px; text-overflow: ellipsis; white-space: nowrap; }
        .search-suggestion-dates { display: grid; gap: 2px; margin-top: 2px; }
        .search-suggestion .search-suggestion-dates span { margin: 0; color: #899493; font-size: 9px; line-height: 1.4; }
        .search-empty { margin: 0; padding: 16px; color: var(--muted); font-size: 12px; }
        .user-menu-wrap { position: relative; z-index: 1103; }
        .user-avatar { cursor: pointer; font: inherit; font-weight: bold; overflow: hidden; }
        .user-avatar img, .profile-menu-avatar img { width: 100%; height: 100%; display: block; border-radius: 50%; object-fit: cover; }
        .user-avatar:hover, .user-avatar[aria-expanded="true"] { background: #c9e1e4; }
        .profile-menu {
            position: absolute; z-index: 1104; top: calc(100% + 12px); right: 0;
            width: min(300px, calc(100vw - 32px)); overflow: hidden;
            border: 1px solid var(--line); border-radius: 14px; background: white;
            box-shadow: 0 12px 35px rgb(20 45 50 / 16%);
        }
        .profile-menu[hidden] { display: none; }
        .profile-menu-heading { display: flex; align-items: center; gap: 12px; padding: 17px; border-bottom: 1px solid var(--line); }
        .profile-menu-avatar {
            width: 44px; height: 44px; flex: 0 0 44px; display: grid; place-items: center;
            border-radius: 50%; background: #dcebed; color: var(--teal); font-size: 17px; font-weight: bold;
        }
        .profile-menu-identity { min-width: 0; }
        .profile-menu-identity strong, .profile-menu-identity span { display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .profile-menu-identity strong { font-size: 13px; }
        .profile-menu-identity span { margin-top: 4px; color: var(--muted); font-size: 11px; }
        .profile-menu-links { padding: 7px; }
        .profile-menu-links a, .profile-menu-links button {
            width: 100%; display: block; padding: 11px 10px; border: 0; border-radius: 8px;
            background: transparent; color: var(--text); font: inherit; font-size: 12px;
            text-align: left; text-decoration: none; cursor: pointer;
        }
        .profile-menu-links a:hover, .profile-menu-links button:hover { background: #f2f7f6; }
        .profile-menu-links .profile-logout { color: #c84b37; }
        .profile-menu-links .profile-login {
            background: var(--teal);
            color: white;
            text-align: center;
            font-weight: bold;
        }
        .profile-menu-links .profile-login:hover { background: var(--teal-dark); }
        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }

        .stat-card {
            min-height: 76px;
            padding: 15px 16px;
            border: 1px solid var(--line);
            border-radius: 13px;
            background: white;
        }

        .stat-card span {
            display: block;
            margin-bottom: 7px;
            color: #778585;
            font-size: 11px;
        }

        .stat-card strong {
            font-size: 19px;
            letter-spacing: .02em;
        }

        .stat-card.red strong { color: #df482e; }
        .stat-card.orange strong { color: #b36b1c; }
        .stat-card.blue strong { color: var(--teal); }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(260px, .75fr) minmax(0, 1.65fr);
            gap: 16px;
        }

        .panel {
            min-width: 0;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: white;
        }

        .panel-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 18px 18px 12px;
        }

        .panel-heading h2 {
            margin: 0;
            font-size: 15px;
        }

        .panel-heading a {
            color: var(--teal);
            font-size: 11px;
            font-weight: bold;
            text-decoration: none;
        }

        .updates {
            padding: 0 18px 16px;
        }

        .update-item {
            display: flex;
            align-items: center;
            gap: 11px;
            color: inherit;
            text-decoration: none;
            cursor: pointer;
            padding: 12px 0;
            border-bottom: 1px solid #edf0ed;
        }

        .update-item:last-child { border-bottom: 0; }
        .update-item:hover h3 { color: var(--teal); }

        .update-thumb, .search-suggestion-thumb {
            width: 62px;
            height: 58px;
            flex: 0 0 62px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border-radius: 9px;
            background: linear-gradient(145deg, #d7ecee, #a9d9ed);
            color: var(--teal);
            font-size: 22px;
        }
        .search-suggestion-thumb { margin: 0; }
        .update-thumb img, .search-suggestion-thumb img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }
        .update-copy { min-width: 0; flex: 1; }
        .update-copy .tag { margin-bottom: 5px; }

        .tag {
            display: inline-block;
            margin-bottom: 6px;
            padding: 4px 8px;
            border-radius: 20px;
            background: #fff0e9;
            color: #b7472e;
            font-size: 10px;
            font-weight: bold;
        }

        .tag.orange {
            background: #fff4df;
            color: #a66b1a;
        }

        .update-item h3 {
            margin: 0 0 5px;
            color: #243c40;
            font-size: 12px;
            line-height: 1.4;
        }

        .update-item p {
            margin: 0;
            color: #899493;
            font-size: 10px;
        }

        .map-panel {
            display: flex;
            min-height: 420px;
            flex-direction: column;
            background: white;
        }
        .map-panel .panel-heading { flex: 0 0 auto; padding: 16px 18px 13px; }
        .map-heading-copy h2 { margin: 0; font-size: 15px; }
        .map-heading-copy p { margin: 4px 0 0; color: var(--muted); font-size: 10px; }
        .map-region { padding: 6px 10px; border: 1px solid var(--line); border-radius: 20px; color: var(--teal); font-size: 10px; font-weight: bold; }
        .map-stage { position: relative; min-height: 0; flex: 1; overflow: hidden; }
        #sigana-map { width: 100%; height: 380px; background: #e8f1f3; }
        #sigana-map .leaflet-tile-pane { filter: saturate(.82) contrast(.97); }
        #sigana-map .leaflet-control-zoom { overflow: hidden; border: 1px solid #dce5e3; border-radius: 10px; box-shadow: 0 4px 14px rgb(25 55 61 / 14%); }
        #sigana-map .leaflet-control-zoom a { width: 32px; height: 32px; color: var(--teal); line-height: 32px; }
        #sigana-map .leaflet-control-attribution { padding: 3px 7px; border-radius: 7px 0 0 0; background: rgb(255 255 255 / 88%); font-size: 9px; }
        #sigana-map .leaflet-popup-content-wrapper { border-radius: 11px; box-shadow: 0 8px 24px rgb(25 55 61 / 18%); }
        #sigana-map .leaflet-popup-content { margin: 12px 14px; color: #19373d; font-size: 12px; line-height: 1.45; }
        #sigana-map .leaflet-popup-content strong { display: block; margin-bottom: 4px; }
        #sigana-map .leaflet-popup-content .map-popup-location { color: #788889; font-size: 11px; }
#sigana-map .sigana-disaster-marker { background: transparent; border: 0; }
        #sigana-map .sigana-disaster-marker span { display: grid; width: 38px; height: 38px; place-items: center; border: 3px solid #fff; border-radius: 50%; box-shadow: 0 3px 10px rgb(24 48 54 / 35%); color: #fff; font-size: 19px; line-height: 1; }
        .map-legend-control {
            position: absolute;
            z-index: 500;
            right: 12px;
            bottom: 32px;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 9px 11px;
            border: 1px solid rgb(220 229 227 / 90%);
            border-radius: 10px;
            background: rgb(255 255 255 / 94%);
            box-shadow: 0 4px 14px rgb(25 55 61 / 12%);
            color: #536466;
            font-size: 10px;
            pointer-events: none;
        }
        .map-legend-dot { width: 9px; height: 9px; border: 2px solid white; border-radius: 50%; background: #e64e3f; box-shadow: 0 0 0 1px #e64e3f; }
        .map-legend-control strong { color: var(--teal); font-size: 11px; }
        .map-art {
            position: absolute;
            inset: 0;
            overflow: hidden;
            background:
                linear-gradient(25deg, transparent 45%, rgba(255,255,255,.2) 46%, transparent 47%),
                linear-gradient(130deg, transparent 62%, rgba(255,255,255,.18) 63%, transparent 64%),
                #a9d9ed;
        }

        .land {
            position: absolute;
            background: #d9dfc7;
            border: 1px solid rgba(125, 155, 137, .65);
            box-shadow: inset 0 0 20px rgba(255,255,255,.35);
        }

        .land.one {
            top: 5%;
            left: 13%;
            width: 28%;
            height: 22%;
            border-radius: 55% 38% 48% 35%;
            transform: rotate(-15deg);
        }

        .land.two {
            top: 36%;
            left: 3%;
            width: 29%;
            height: 17%;
            border-radius: 45% 50% 35% 55%;
            transform: rotate(12deg);
        }

        .land.three {
            top: 49%;
            left: 32%;
            width: 22%;
            height: 12%;
            border-radius: 50% 40% 55% 35%;
            transform: rotate(-8deg);
        }

        .land.four {
            top: 57%;
            left: 53%;
            width: 24%;
            height: 14%;
            border-radius: 40% 55% 35% 50%;
            transform: rotate(8deg);
        }

        .land.five {
            top: 24%;
            left: 66%;
            width: 28%;
            height: 20%;
            border-radius: 40% 55% 45% 50%;
            transform: rotate(-12deg);
        }

        .land.six {
            top: 78%;
            left: 22%;
            width: 61%;
            height: 10%;
            border-radius: 50%;
            transform: rotate(-4deg);
        }

        .map-label {
            position: absolute;
            color: #567274;
            font-size: 11px;
            text-shadow: 0 1px 2px white;
        }

        .label-indonesia { top: 57%; left: 42%; font-weight: bold; }
        .label-malaysia { top: 40%; left: 26%; }
        .label-papua { top: 68%; right: 7%; }

        .quake {
            position: absolute;
            width: 23px;
            height: 23px;
            border: 1px solid rgba(210, 41, 36, .65);
            border-radius: 50%;
            background: rgba(240, 61, 51, .72);
            box-shadow: 0 0 0 7px rgba(240, 61, 51, .14);
        }

        .q1 { top: 56%; left: 20%; }
        .q2 { top: 63%; left: 35%; }
        .q3 { top: 51%; left: 48%; }
        .q4 { top: 67%; left: 61%; }
        .q5 { top: 44%; left: 72%; }
        .q6 { top: 72%; left: 82%; }
        .q7 { top: 38%; left: 56%; }
        .q8 { top: 76%; left: 46%; }
        .q9 { top: 55%; left: 89%; }

        .map-title {
            position: absolute;
            top: 15px;
            left: 16px;
            padding: 9px 12px;
            border: 1px solid rgba(255,255,255,.75);
            border-radius: 9px;
            background: rgba(255,255,255,.88);
            font-size: 12px;
            font-weight: bold;
        }

        .map-legend {
            position: absolute;
            bottom: 14px;
            left: 16px;
            padding: 8px 10px;
            border-radius: 8px;
            background: rgba(255,255,255,.88);
            color: #5b6a6b;
            font-size: 10px;
        }

        .map-legend i {
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 4px;
            border-radius: 50%;
            background: #ef463b;
        }

        .map-button {
            position: absolute;
            right: 14px;
            bottom: 14px;
            padding: 10px 14px;
            border: 0;
            border-radius: 20px;
            background: white;
            color: var(--teal);
            font-size: 11px;
            font-weight: bold;
            text-decoration: none;
        }

        .logout-form { margin: 12px 0 0; }

        .logout-button {
            display: block;
            width: 100%;
            margin-top: 12px;
            padding: 12px 14px;
            box-sizing: border-box;
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 9px;
            background: transparent;
            color: #e2eff0;
            font: inherit;
            font-size: 13px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

.logout-button:hover {
    background: rgba(255, 255, 255, .12);
        }
        .notification-wrap {
            position: relative;
            z-index: 1101;
        }

        .notification-toggle {
            position: relative;
            cursor: pointer;
        }

        .notification-toggle svg {
            width: 18px;
            height: 18px;
        }

        .notification-badge[hidden] { display: none !important; }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -3px;
            min-width: 17px;
            height: 17px;
            display: grid;
            place-items: center;
            padding: 0 4px;
            border: 2px solid white;
            border-radius: 20px;
            background: #e64e3f;
            color: white;
            font-size: 9px;
            font-weight: bold;
        }

        .notification-menu {
            position: absolute;
            z-index: 1102;
            top: calc(100% + 12px);
            right: 0;
            width: min(350px, calc(100vw - 32px));
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: white;
            box-shadow: 0 12px 35px rgb(20 45 50 / 16%);
        }

        .notification-menu[hidden] {
            display: none;
        }

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px;
            border-bottom: 1px solid var(--line);
        }

        .notification-header h2 {
            margin: 0;
            font-size: 15px;
        }

        .notification-header button {
            padding: 0;
            border: 0;
            background: transparent;
            color: var(--teal);
            font-size: 11px;
            font-weight: bold;
            cursor: pointer;
        }
        .notification-list {
            max-height: min(330px, calc(100vh - 220px));
            overflow-y: auto;
        }

        .notification-item {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 14px;
            border-bottom: 1px solid #edf0ed;
            background: white;
            color: var(--text);
        }

        .notification-link {
            min-width: 0;
            flex: 1;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: inherit;
            text-decoration: none;
        }

        .notification-link:hover { opacity: .82; }
        .notification-mark-form { flex: 0 0 auto; margin: 0; }
        .notification-mark-form button {
            padding: 5px 7px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: var(--teal);
            font: inherit;
            font-size: 10px;
            cursor: pointer;
        }
        .notification-mark-form button:hover { background: #e7f1f0; }

        .notification-item.unread {
            background: #f2f8f8;
        }

        .notification-dot {
            width: 9px;
            height: 9px;
            flex: 0 0 auto;
            margin-top: 4px;
            border-radius: 50%;
            background: #e64e3f;
        }

        .notification-item:not(.unread) .notification-dot {
            display: none;
        }

        .notification-copy {
            display: grid;
            flex: 1;
            min-width: 0;
            gap: 4px;
        }

        .notification-copy strong {
            font-size: 12px;
            line-height: 1.4;
        }

        .notification-copy .notification-summary {
            display: -webkit-box;
            overflow: hidden;
            color: #788889;
            font-size: 11px;
            line-height: 1.4;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .notification-copy time {
            color: #9aa4a3;
            font-size: 10px;
        }

        .notification-footer {
            display: block;
            padding: 12px;
            color: var(--teal);
            text-align: center;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
        }

        .notification-footer:hover {
            background: #f8faf8;
        }

        @media (max-width: 950px) {
            .app { grid-template-columns: 260px minmax(0, 1fr); }
            .main { padding: 22px; }
            .content-grid { grid-template-columns: 1fr; }
            .map-panel { min-height: 360px; }
        }

        @media (max-width: 680px) {
            .app { display: block; }

            .sidebar {
                min-height: auto;
                padding: 12px;
            }

            .brand { padding: 0 6px 12px; }

            .nav {
                display: flex;
                gap: 6px;
                overflow-x: auto;
                padding-bottom: 4px;
            }

            .nav a {
                min-width: max-content;
                min-height: 38px;
                padding: 0 10px;
                font-size: 12px;
            }

            .sidebar-bottom { display: none; }
            .main { padding: 20px 14px; }

            .topbar {
            position: relative;
            z-index: 1100;
                align-items: flex-start;
                flex-direction: column;
            }

            .top-actions { width: 100%; }
            .search-wrap { flex: 1; min-width: 0; }
            .search-wrap .search { width: 100%; }
            .search-suggestions { left: 0; right: auto; width: min(390px, calc(100vw - 28px)); }

            .search-wrap { position: relative; z-index: 1105; }
        
        .user-menu-wrap { position: relative; z-index: 1103; }
        .user-avatar { cursor: pointer; font: inherit; font-weight: bold; overflow: hidden; }
        .user-avatar img, .profile-menu-avatar img { width: 100%; height: 100%; display: block; border-radius: 50%; object-fit: cover; }
        .user-avatar:hover, .user-avatar[aria-expanded="true"] { background: #c9e1e4; }
        .profile-menu {
            position: absolute; z-index: 1104; top: calc(100% + 12px); right: 0;
            width: min(300px, calc(100vw - 32px)); overflow: hidden;
            border: 1px solid var(--line); border-radius: 14px; background: white;
            box-shadow: 0 12px 35px rgb(20 45 50 / 16%);
        }
        .profile-menu[hidden] { display: none; }
        .profile-menu-heading { display: flex; align-items: center; gap: 12px; padding: 17px; border-bottom: 1px solid var(--line); }
        .profile-menu-avatar {
            width: 44px; height: 44px; flex: 0 0 44px; display: grid; place-items: center;
            border-radius: 50%; background: #dcebed; color: var(--teal); font-size: 17px; font-weight: bold;
        }
        .profile-menu-identity { min-width: 0; }
        .profile-menu-identity strong, .profile-menu-identity span { display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .profile-menu-identity strong { font-size: 13px; }
        .profile-menu-identity span { margin-top: 4px; color: var(--muted); font-size: 11px; }
        .profile-menu-links { padding: 7px; }
        .profile-menu-links a, .profile-menu-links button {
            width: 100%; display: block; padding: 11px 10px; border: 0; border-radius: 8px;
            background: transparent; color: var(--text); font: inherit; font-size: 12px;
            text-align: left; text-decoration: none; cursor: pointer;
        }
        .profile-menu-links a:hover, .profile-menu-links button:hover { background: #f2f7f6; }
        .profile-menu-links .profile-logout { color: #c84b37; }
        .profile-menu-links .profile-login {
            background: var(--teal);
            color: white;
            text-align: center;
            font-weight: bold;
        }
        .profile-menu-links .profile-login:hover { background: var(--teal-dark); }
        .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 8px;
            }

            .stat-card { padding: 12px; }
            .stat-card strong { font-size: 17px; }
            .map-panel { min-height: 320px; }
        }
        @media (max-width: 680px) {
            #sigana-map { height: 320px; }
            .map-panel { min-height: 360px; }
            .map-legend-control { right: 8px; bottom: 28px; padding: 8px 9px; }
        }
        @media (min-width: 681px) {
    html,
    body {
        height: 100%;
        overflow: hidden;
    }

    .app {
        height: 100vh;
        min-height: 0;
        overflow: hidden;
    }

    .sidebar {
        height: 100vh;
        min-height: 0;
        overflow-y: auto;
        overscroll-behavior: contain;
    }

    .main {
        height: 100vh;
        min-height: 0;
        overflow-y: auto;
        overscroll-behavior: contain;
    }
}

@media (max-width: 680px) {
    html,
    body {
        height: auto;
        overflow: auto;
    }

    .app {
        height: auto;
        min-height: 100vh;
        overflow: visible;
    }

    .sidebar {
        height: auto;
        min-height: auto;
        overflow: visible;
    }

    .main {
        height: auto;
        min-height: 0;
        overflow: visible;
    }
}
    
        /* Avatar foto pada dropdown profil: ukuran tetap dan crop lingkaran. */
        .profile-menu-avatar {
            position: relative;
            width: 44px;
            height: 44px;
            min-width: 44px;
            min-height: 44px;
            flex: 0 0 44px;
            overflow: hidden;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
        }
        .profile-menu-avatar img {
            position: absolute;
            inset: 0;
            display: block;
            width: 44px;
            height: 44px;
            min-width: 44px;
            max-width: none;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
        }
    
        /* Foto avatar lingkaran di toolbar dashboard. */
        .user-menu-wrap > .user-avatar {
            position: relative;
            width: 40px;
            height: 40px;
            min-width: 40px;
            min-height: 40px;
            flex: 0 0 40px;
            overflow: hidden;
            padding: 0;
            aspect-ratio: 1 / 1;
            border-radius: 50%;
        }
        .user-menu-wrap > .user-avatar img {
            position: absolute;
            inset: 0;
            display: block;
            width: 40px;
            height: 40px;
            min-width: 40px;
            max-width: none;
            object-fit: cover;
            object-position: center;
            border-radius: 50%;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/sigana-theme.css') }}?v=3">
    <script src="{{ asset('js/sigana-theme.js') }}" defer></script>
</head>

<body>
<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon" aria-hidden="true">
                <svg viewBox="0 0 32 32" fill="none">
                    <path d="M5 20c3 0 3-8 6-8s3 8 6 8 3-8 6-8"
                          stroke="currentColor" stroke-width="2.2"
                          stroke-linecap="round"/>
                    <circle cx="24" cy="8" r="2.5" fill="#e06445"/>
                </svg>
            </div>
            <div>
                <h2 class="brand-name">SIGANA</h2>
                <p class="brand-caption">Monitoring Bencana Alam</p>
            </div>
        </div>

        <nav class="nav" aria-label="Menu utama">
            <a class="active" href="{{ auth()->check() ? route('dashboard') : route('guest.home') }}">
                <span>⌂</span> Dashboard
            </a>
            <a href="{{ route('bencana.index') }}">
                <span>⚠</span> Bencana
            </a>
            <a href="{{ route('tips.index') }}">
                <span>♡</span> Tips &amp; darurat
            </a>
            <a href="{{ route('bantuan.index') }}">
                <span>◌</span> Bantuan
            </a>
            <a href="{{ route('profil.index') }}">
    <span>♙</span> Profil
</a>
        </nav>

        <div class="sidebar-bottom">
            <div class="emergency-card">
                <span>Keadaan darurat?</span>
                <strong>112</strong>
            </div>

            @if (auth()->check())
                <form class="logout-form" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit">Keluar dari akun</button>
                </form>
            @else
                <a class="logout-button" href="{{ route('login') }}">Masuk ke akun</a>
            @endif
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div class="welcome">
                <h1>Selamat datang, {{ auth()->user()->name ?? 'Pengguna' }}</h1>
                <p>Pantau kondisi kebencanaan di sekitar Anda.</p>
            </div>

            <div class="top-actions">
                <div class="search-wrap">
                    <label class="search" for="disasterSearch">
                        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="10.8" cy="10.8" r="6.5" stroke="currentColor" stroke-width="1.7"/>
                            <path d="m16 16 4.2 4.2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                        <input id="disasterSearch" type="search" placeholder="Cari kejadian atau wilayah" autocomplete="off"
                            role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="searchSuggestions">
                    </label>
                    <div class="search-suggestions" id="searchSuggestions" role="listbox" hidden></div>
                </div>

                <div class="notification-wrap">
            <button
                class="icon-button notification-toggle"
                id="notificationToggle"
                type="button"
                aria-label="Buka notifikasi"
                aria-expanded="false"
                aria-controls="notificationMenu"
            >
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9Z"
                        stroke="currentColor" stroke-width="1.7"
                        stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10 21h4"
                        stroke="currentColor" stroke-width="1.7"
                        stroke-linecap="round"/>
                </svg>
                <span class="notification-badge" id="notificationCount" @if ($unreadNotifications === 0) hidden @endif>{{ $unreadNotifications }}</span>
            </button>

            <section
                class="notification-menu"
                id="notificationMenu"
                aria-label="Daftar notifikasi"
                hidden
            >
                <header class="notification-header">
                    <h2>Notifikasi</h2>
                    <form id="markAllReadForm" method="POST" action="{{ route('notifications.read-all') }}">@csrf<button type="submit" id="markAllRead">Tandai semua dibaca</button></form>
                </header>

                <div class="notification-list">
                    @forelse ($notifications as $notification)
                        <article class="notification-item {{ $notification->is_read ? '' : 'unread' }}">
                            <a class="notification-link" href="{{ isset($notification->id) ? route('notifications.open', $notification->id) : (isset($notification->disaster_id) ? route('bencana.detail', $notification->disaster_id) : route('bencana.index')) }}">
                                <span class="notification-dot"></span>
                                <span class="notification-copy">
                                    <strong>{{ $notification->title }}</strong>
                                    <span class="notification-summary">{{ \Illuminate\Support\Str::limit(trim($notification->message), 110) }}</span>
                                    <time>{{ $notification->created_at ? \Illuminate\Support\Carbon::parse($notification->created_at, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y · H.i') . ' WIB' : 'Baru saja' }}</time>
                                </span>
                            </a>
                            @if (isset($notification->id) && ! $notification->is_read)
                                <form class="notification-mark-form" method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    <button type="submit" aria-label="Tandai notifikasi sudah dibaca">Tandai dibaca</button>
                                </form>
                            @endif
                        </article>
                    @empty
                        <p class="notification-empty">Belum ada notifikasi.</p>
                    @endforelse
                </div>

                <a class="notification-footer" href="{{ route('bencana.index') }}">
                    Lihat update terbaru
                </a>
            </section>
        </div>
                <div class="user-menu-wrap">
                    <button class="user-avatar" id="profileToggle" type="button" title="Buka menu profil"
                        aria-label="Buka menu profil" aria-expanded="false" aria-controls="profileMenu">
                        @if (auth()->check() && ($hasProfilePhoto ?? false))
                            <img src="{{ route('profil.photo') }}?v={{ session('profile_photo_version', '0') }}" alt="">
                        @else
                            {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                        @endif
                    </button>
                    <section class="profile-menu" id="profileMenu" aria-label="Menu profil" hidden>
                        <div class="profile-menu-heading">
                                                        <div class="profile-menu-avatar" aria-hidden="true">
                                @if (auth()->check() && ($hasProfilePhoto ?? false))
                                    <img src="{{ route('profil.photo') }}?v={{ session('profile_photo_version', '0') }}" alt="">
                                @else
                                    {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
                                @endif
                            </div>
                            <div class="profile-menu-identity">
                                <strong>{{ auth()->user()->name ?? 'Tamu' }}</strong>
                                <span>{{ auth()->user()->email ?? 'Anda sedang menggunakan akses tamu' }}</span>
                            </div>
                        </div>
                        <nav class="profile-menu-links" aria-label="Tautan akun">
                            @auth
                                <a href="{{ route('profil.index') }}">Lihat profil</a>
                                <a href="{{ route('profil.edit') }}">Edit profil</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="profile-logout" type="submit">Keluar dari akun</button>
                                </form>
                            @else
                                <a class="profile-login" href="{{ route('login') }}">Masuk ke akun</a>
                            @endauth
                        </nav>
                    </section>
                </div>
            </div>
        </header>

        <section class="stats" aria-label="Ringkasan bencana">
            <article class="stat-card red">
                <span>Kejadian aktif</span>
                <strong>[{{ $stats['active'] }}]</strong>
            </article>
            <article class="stat-card orange">
                <span>Sedang dipantau</span>
                <strong>[{{ $stats['monitored'] }}]</strong>
            </article>
            <article class="stat-card blue">
                <span>Wilayah terdampak</span>
                <strong>[{{ $stats['areas'] }}]</strong>
            </article>
            <article class="stat-card blue">
                <span>Pembaruan terakhir</span>
                <strong>[{{ $stats['latest'] }}]</strong>
            </article>
        </section>

        <section class="content-grid">
            <article class="panel" id="updates">
                <div class="panel-heading">
                    <h2>Update terbaru</h2>
                    <a href="{{ route('bencana.index') }}">Lihat semua</a>
                </div>

                <div class="updates">
                    @forelse ($disasters->take(5) as $disaster)
                        @php
                            $updateImageUrl = $disaster->photo
                                ? (\Illuminate\Support\Str::startsWith($disaster->photo, ['http://', 'https://', '/']) ? $disaster->photo : asset('storage/' . $disaster->photo))
                                : null;
                        @endphp
                        <a class="update-item" href="{{ route('bencana.detail', $disaster->id) }}">
                            <span class="update-thumb" aria-hidden="true">
                                @if ($updateImageUrl)
                                    <img src="{{ $updateImageUrl }}" alt="" loading="lazy">
                                @else
                                    📍
                                @endif
                            </span>
                            <span class="update-copy">
                                <span class="tag">{{ $disaster->category }}</span>
                                <h3>{{ $disaster->title }}</h3>
                                <p>Diunggah: {{ $disaster->created_at ? \Illuminate\Support\Carbon::parse($disaster->created_at, 'UTC')->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('j M Y · H.i') . ' WIB' : 'Waktu unggah tidak tersedia' }} · {{ $disaster->location }}</p>                            </span>
                        </a>
                    @empty
                        <p class="updates-empty">Belum ada kejadian bencana di database.</p>
                    @endforelse
                </div>
            </article>

            <article class="panel map-panel" id="map">
                <div class="panel-heading">
                    <div class="map-heading-copy">
                        <h2>Peta kejadian bencana</h2>
                        <p>Lokasi laporan bencana yang memiliki koordinat</p>
                    </div>
                    <span class="map-region">Indonesia</span>
                </div>
                <div class="map-stage">
                    <div id="sigana-map"></div>
                    <div class="map-legend-control" aria-label="Lokasi kejadian bencana">
                        <i class="map-legend-dot"></i>
                        <span>Lokasi kejadian</span>
                        <strong>{{ $mapDisasters->count() }}</strong>
                    </div>
                </div>
            </article>
        </section>
    </main>
</div>
<script>
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationMenu = document.getElementById('notificationMenu');

    function closeNotifications() {
        notificationMenu.hidden = true;
        notificationToggle.setAttribute('aria-expanded', 'false');
    }

    notificationToggle.addEventListener('click', function (event) {
        event.stopPropagation();
        const open = notificationMenu.hidden;
        notificationMenu.hidden = !open;
        notificationToggle.setAttribute('aria-expanded', String(open));
    });

    notificationMenu.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    document.addEventListener('click', closeNotifications);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeNotifications();
    });

    const profileToggle = document.getElementById('profileToggle');
    const profileMenu = document.getElementById('profileMenu');

    function closeProfileMenu() {
        profileMenu.hidden = true;
        profileToggle.setAttribute('aria-expanded', 'false');
    }

    profileToggle.addEventListener('click', function (event) {
        event.stopPropagation();
        const open = profileMenu.hidden;
        profileMenu.hidden = !open;
        profileToggle.setAttribute('aria-expanded', String(open));
    });

    profileMenu.addEventListener('click', function (event) { event.stopPropagation(); });
    document.addEventListener('click', closeProfileMenu);
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeProfileMenu();
    });

    const disasterSearch = document.getElementById('disasterSearch');
    const searchSuggestions = document.getElementById('searchSuggestions');
    const searchRecords = @json($disasters->map(fn ($disaster) => (array) $disaster)->values());

    function renderSearchSuggestions() {
        const query = disasterSearch.value.trim().toLocaleLowerCase('id');
        searchSuggestions.replaceChildren();
        if (!query) {
            searchSuggestions.hidden = true;
            disasterSearch.setAttribute('aria-expanded', 'false');
            return;
        }
        const matches = searchRecords.filter(function (item) {
            return [item.title, item.category, item.location]
                .some(value => String(value || '').toLocaleLowerCase('id').includes(query));
        }).slice(0, 6);
        if (matches.length === 0) {
            const empty = document.createElement('p');
            empty.className = 'search-empty';
            empty.textContent = 'Tidak ada kejadian atau wilayah yang cocok.';
            searchSuggestions.append(empty);
        } else {
            matches.forEach(function (item) {
                const link = document.createElement('a');
                link.className = 'search-suggestion';
                link.setAttribute('role', 'option');
                link.href = @json(url('/bencana')) + '/' + encodeURIComponent(item.id);
                const thumb = document.createElement('span');
                thumb.className = 'search-suggestion-thumb';
                thumb.setAttribute('aria-hidden', 'true');
                if (item.photo) {
                    const imagePath = String(item.photo);
                    const imageUrl = (imagePath.toLowerCase().startsWith('http://') || imagePath.toLowerCase().startsWith('https://') || imagePath.startsWith('/'))
                        ? imagePath
                        : @json(asset('storage')) + '/' + imagePath.split('/').map(encodeURIComponent).join('/');
                    const image = document.createElement('img');
                    image.src = imageUrl;
                    image.alt = '';
                    image.loading = 'lazy';
                    image.onerror = function () { thumb.textContent = '📍'; };
                    thumb.append(image);
                } else {
                    thumb.textContent = '📍';
                }
                const copy = document.createElement('span');
                copy.className = 'search-suggestion-copy';
                const title = document.createElement('strong');
                title.textContent = item.title;
                const meta = document.createElement('span');
                meta.className = 'search-suggestion-meta';
                meta.textContent = [item.category, item.location].filter(Boolean).join(' · ');
                const dates = document.createElement('span');
                dates.className = 'search-suggestion-dates';
                const uploadedAt = document.createElement('span');
                const eventTime = document.createElement('span');
                let occurredAt = 'Waktu kejadian belum tersedia';
                let newsAt = 'Waktu unggah belum tersedia';
                if (item.occurred_at) {
                    const rawDate = String(item.occurred_at);
                    const dateValue = /[zZ]|[+-]\d{2}:\d{2}$/.test(rawDate)
                        ? rawDate
                        : rawDate.replace(' ', 'T') + 'Z';
                    const date = new Date(dateValue);
                    if (!Number.isNaN(date.getTime())) {
                        occurredAt = new Intl.DateTimeFormat('id-ID', {
                            day: 'numeric', month: 'short', year: 'numeric',
                            hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta'
                        }).format(date) + ' WIB';
                    }
                }
                if (item.created_at) {
                    const created = new Date(String(item.created_at).replace(' ', 'T') + 'Z');
                    if (!Number.isNaN(created.getTime())) newsAt = new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', timeZone: 'Asia/Jakarta' }).format(created) + ' WIB';
                }
                uploadedAt.textContent = 'Diunggah · ' + newsAt;
                eventTime.textContent = 'Kejadian · ' + occurredAt;
                dates.append(uploadedAt, eventTime);
                copy.append(title, meta, dates);
                link.append(thumb, copy);
                searchSuggestions.append(link);
            });
        }
        searchSuggestions.hidden = false;
        disasterSearch.setAttribute('aria-expanded', 'true');
    }

    disasterSearch.addEventListener('input', renderSearchSuggestions);
    disasterSearch.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            searchSuggestions.hidden = true;
            disasterSearch.setAttribute('aria-expanded', 'false');
            return;
        }
        if (event.key === 'Enter') {
            const firstSuggestion = searchSuggestions.querySelector('a');
            if (firstSuggestion && !searchSuggestions.hidden) {
                event.preventDefault();
                window.location.href = firstSuggestion.href;
            }
        }
    });
    document.addEventListener('click', function (event) {
        if (!event.target.closest('.search-wrap')) {
            searchSuggestions.hidden = true;
            disasterSearch.setAttribute('aria-expanded', 'false');
        }
    });
</script>


<script>
    const notificationMenu = document.getElementById('notificationMenu');
    const notificationBadge = document.getElementById('notificationCount');

    function updateUnreadBadge(changeToZero = false) {
        if (!notificationBadge) return;
        const current = Number.parseInt(notificationBadge.textContent, 10) || 0;
        const next = changeToZero ? 0 : Math.max(0, current - 1);
        notificationBadge.textContent = String(next);
        notificationBadge.hidden = next === 0;
    }

    notificationMenu?.addEventListener('submit', async function (event) {
        const form = event.target.closest('.notification-mark-form, #markAllReadForm');
        if (!form) return;
        event.preventDefault();
        const button = form.querySelector('button');
        if (button) button.disabled = true;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                },
                body: new FormData(form)
            });
            if (!response.ok) throw new Error('Tidak dapat menyimpan status baca.');

            if (form.id === 'markAllReadForm') {
                notificationMenu.querySelectorAll('.notification-item').forEach(function (item) {
                    item.classList.remove('unread');
                    item.querySelector('.notification-dot')?.remove();
                    item.querySelector('.notification-mark-form')?.remove();
                });
                updateUnreadBadge(true);
            } else {
                const item = form.closest('.notification-item');
                item?.classList.remove('unread');
                item?.querySelector('.notification-dot')?.remove();
                form.remove();
                updateUnreadBadge();
            }
        } catch (error) {
            form.submit();
        }
    });
</script>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const map = L.map('sigana-map', { zoomControl: false }).setView([-2.5, 118], 4);
    L.control.zoom({ position: 'topright' }).addTo(map);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    const disasterPoints = @json($mapDisasters);
    const disasterMarkers = [];

    function makeDisasterPopup(disaster) {
        const content = document.createElement('div');
        const title = document.createElement('strong');
        title.textContent = disaster.title;
        const location = document.createElement('div');
        location.className = 'map-popup-location';
        location.textContent = disaster.location;
        content.append(title, location);
        return content;
    }

    function markerStyleForCategory(category) {
        const name = String(category || '').toLocaleLowerCase('id');
        if (name.includes('gunung') || name.includes('vulkan')) return { icon: '🌋', color: '#c84b37' };
        if (name.includes('tsunami')) return { icon: '🌊', color: '#2867a8' };
        if (name.includes('banjir')) return { icon: '💧', color: '#1685a0' };
        if (name.includes('gempa')) return { icon: '🏚️', color: '#b87818' };
        if (name.includes('longsor')) return { icon: '⛰️', color: '#795548' };
        return { icon: '⚠️', color: '#105461' };
    }

    disasterPoints.forEach(function (disaster) {
        const markerStyle = markerStyleForCategory(disaster.category);
        const disasterIcon = L.divIcon({
            className: 'sigana-disaster-marker',
            html: `<span style="background:${markerStyle.color}">${markerStyle.icon}</span>`,
            iconSize: [38, 38],
            iconAnchor: [19, 19],
            popupAnchor: [0, -20]
        });
        const marker = L.marker([disaster.latitude, disaster.longitude], { icon: disasterIcon })
            .addTo(map)
            .bindPopup(makeDisasterPopup(disaster), { maxWidth: 260 });
        disasterMarkers.push(marker);
    });

    if (disasterMarkers.length === 1) {
        map.setView(disasterMarkers[0].getLatLng(), 6);
    } else if (disasterMarkers.length > 1) {
        map.fitBounds(L.featureGroup(disasterMarkers).getBounds().pad(0.18), { maxZoom: 7 });
    }
</script>
</body>
</html>
