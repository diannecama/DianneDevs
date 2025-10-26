<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#1E1E1E">
    <title>Offline Evacuation System - Enhanced</title>
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="manifest.json">
    <link href="css/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #FAFAFA;
            --secondary-color: #121212;
            --tertiary-color: #FFFFFF;
            --accent-color: #DADADA;
            --windy-blue: #0078D4;
            --windy-dark: #1E1E1E;
            --windy-light: #F0F0F0;
        }
        
        body {
            background-color: var(--windy-dark);
            color: var(--windy-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        
        /* Windy-style header */
        .windy-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: linear-gradient(135deg, var(--windy-dark), #2d2d2d);
            border-bottom: 1px solid #404040;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .windy-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .windy-logo i {
            font-size: 24px;
            color: var(--windy-blue);
        }
        
        .windy-logo h1 {
            font-size: 18px;
            margin: 0;
            font-weight: 600;
        }
        
        .status-indicators {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .status-badge {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-online {
            background-color: #28a745;
            color: white;
        }
        
        .status-offline {
            background-color: #dc3545;
            color: white;
        }
        
        .status-syncing {
            background-color: #ffc107;
            color: #212529;
        }
        
        /* Main map container */
        .map-container {
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
        }
        
        #map {
            width: 100%;
            height: 100%;
        }
        
        /* Windy-style control panel */
        .control-panel {
            position: fixed;
            top: 80px;
            left: 20px;
            z-index: 1000;
            background: rgba(30, 30, 30, 0.95);
            border-radius: 10px;
            padding: 15px;
            min-width: 280px;
            backdrop-filter: blur(10px);
            border: 1px solid #404040;
            transition: all 0.3s ease;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .control-panel.collapsed {
            transform: translateX(-100%);
        }
        
        .control-panel-toggle {
            position: fixed;
            top: 80px;
            left: 20px;
            z-index: 1001;
            background: var(--windy-blue);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .control-panel-toggle:hover {
            background: #005a9e;
            transform: scale(1.1);
        }
        
        .control-panel-toggle.collapsed {
            left: 20px;
        }
        
        .control-section {
            margin-bottom: 20px;
        }
        
        .control-section h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: var(--windy-blue);
            font-weight: 600;
        }
        
        .control-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
            padding: 5px 0;
        }
        
        .control-label {
            font-size: 12px;
            color: var(--windy-light);
        }
        
        .control-value {
            font-size: 12px;
            font-weight: 600;
            color: var(--windy-blue);
        }
        
        /* Layer controls */
        .layer-controls {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1000;
            background: rgba(30, 30, 30, 0.95);
            border-radius: 10px;
            padding: 15px;
            min-width: 200px;
            backdrop-filter: blur(10px);
            border: 1px solid #404040;
            transition: all 0.3s ease;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .layer-controls.collapsed {
            transform: translateX(100%);
        }
        
        .layer-controls-toggle {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 1001;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .layer-controls-toggle:hover {
            background: #1e7e34;
            transform: scale(1.1);
        }
        
        .layer-controls-toggle.collapsed {
            right: 20px;
        }
        
        .layer-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            padding: 5px;
            border-radius: 5px;
            transition: background-color 0.2s;
        }
        
        .layer-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .layer-item input[type="checkbox"] {
            accent-color: var(--windy-blue);
        }
        
        .layer-item label {
            font-size: 12px;
            cursor: pointer;
            flex: 1;
        }
        
        /* Data panel */
        .data-panel {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(30, 30, 30, 0.95);
            border-radius: 10px;
            padding: 15px;
            max-width: 350px;
            backdrop-filter: blur(10px);
            border: 1px solid #404040;
            max-height: 300px;
            overflow-y: auto;
        }
        
        .data-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 5px 0;
            border-bottom: 1px solid #404040;
        }
        
        .data-label {
            font-size: 12px;
            color: var(--windy-light);
        }
        
        .data-value {
            font-size: 12px;
            font-weight: 600;
            color: var(--windy-blue);
        }
        
        /* Offline indicator */
        .offline-indicator {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: none;
        }
        
        .offline-indicator.show {
            display: block;
        }
        
        /* Sync progress */
        .sync-progress {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            background: rgba(30, 30, 30, 0.95);
            border-radius: 10px;
            padding: 15px;
            min-width: 250px;
            backdrop-filter: blur(10px);
            border: 1px solid #404040;
            display: none;
        }
        
        .sync-progress.show {
            display: block;
        }
        
        .progress-bar {
            width: 100%;
            height: 4px;
            background-color: #404040;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 8px;
        }
        
        .progress-fill {
            height: 100%;
            background-color: var(--windy-blue);
            width: 0%;
            transition: width 0.3s ease;
        }
        
        /* Custom map styles */
        .leaflet-container {
            background-color: var(--windy-dark);
        }
        
        .leaflet-control-attribution {
            background-color: rgba(30, 30, 30, 0.8) !important;
            color: var(--windy-light) !important;
        }
        
        /* Custom popup styles */
        .custom-popup {
            background: rgba(30, 30, 30, 0.95);
            color: var(--windy-light);
            border: 1px solid #404040;
            border-radius: 8px;
            padding: 10px;
            min-width: 200px;
        }
        
        .popup-title {
            font-weight: 600;
            color: var(--windy-blue);
            margin-bottom: 5px;
        }
        
        .popup-info {
            font-size: 12px;
            margin-bottom: 3px;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .control-panel, .layer-controls {
                position: fixed;
                top: 60px;
                left: 10px;
                right: 10px;
                width: auto;
                min-width: auto;
                max-width: calc(100vw - 20px);
                max-height: 70vh;
            }
            
            .layer-controls {
                left: 10px;
                right: 10px;
            }
            
            .data-panel {
                position: fixed;
                bottom: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
                max-height: 40vh;
            }
            
            .windy-header {
                padding: 8px 10px;
            }
            
            .windy-logo h1 {
                font-size: 14px;
            }
            
            .status-indicators {
                gap: 5px;
            }
            
            .status-badge {
                font-size: 10px;
                padding: 3px 6px;
            }
            
            .control-panel-toggle, .layer-controls-toggle {
                width: 35px;
                height: 35px;
                font-size: 14px;
            }
            
            .control-panel-toggle {
                top: 60px;
                left: 10px;
            }
            
            .layer-controls-toggle {
                top: 60px;
                right: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .windy-logo h1 {
                font-size: 12px;
            }
            
            .status-indicators {
                flex-direction: column;
                gap: 3px;
            }
            
            .control-panel, .layer-controls {
                padding: 10px;
            }
            
            .control-section h3 {
                font-size: 12px;
            }
            
            .control-item, .data-item {
                font-size: 11px;
            }
            
            .control-panel-toggle, .layer-controls-toggle {
                width: 32px;
                height: 32px;
                font-size: 12px;
            }
        }
        
        /* Touch-friendly improvements */
        @media (hover: none) and (pointer: coarse) {
            .control-panel-toggle, .layer-controls-toggle {
                width: 44px;
                height: 44px;
                font-size: 18px;
            }
            
            .layer-item {
                padding: 8px;
                margin-bottom: 12px;
            }
            
            .control-item {
                padding: 8px 0;
            }
            
            .data-item {
                padding: 8px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Offline indicator -->
    <div id="offlineIndicator" class="offline-indicator">
        <i class="fas fa-wifi-slash"></i> Working Offline - Last sync: <span id="lastSyncTime">Unknown</span>
    </div>

    <!-- Windy-style header -->
    <div class="windy-header">
        <div class="windy-logo">
            <i class="fas fa-shield-alt"></i>
            <h1>Offline Evacuation System</h1>
        </div>
        <div class="status-indicators">
            <div id="connectionStatus" class="status-badge status-online">
                <i class="fas fa-wifi"></i> Online
            </div>
            <div id="syncStatus" class="status-badge status-syncing">
                <i class="fas fa-sync-alt fa-spin"></i> Syncing
            </div>
            <div id="gpsStatus" class="status-badge status-online">
                <i class="fas fa-map-marker-alt"></i> GPS Active
            </div>
        </div>
    </div>

    <!-- Main map container -->
    <div class="map-container">
        <div id="map"></div>
    </div>

    <!-- Control panel toggle button -->
    <button id="controlPanelToggle" class="control-panel-toggle" onclick="toggleControlPanel()">
        <i class="fas fa-cog"></i>
    </button>

    <!-- Control panel -->
    <div id="controlPanel" class="control-panel">
        <div class="control-section">
            <h3><i class="fas fa-cog"></i> System Status</h3>
            <div class="control-item">
                <span class="control-label">Connection:</span>
                <span id="connectionType" class="control-value">WiFi</span>
            </div>
            <div class="control-item">
                <span class="control-label">Data Age:</span>
                <span id="dataAge" class="control-value">2 min ago</span>
            </div>
            <div class="control-item">
                <span class="control-label">Offline Mode:</span>
                <span id="offlineMode" class="control-value">Ready</span>
            </div>
        </div>
        
        <div class="control-section">
            <h3><i class="fas fa-location-arrow"></i> Current Location</h3>
            <div class="control-item">
                <span class="control-label">Latitude:</span>
                <span id="currentLat" class="control-value">Getting...</span>
            </div>
            <div class="control-item">
                <span class="control-label">Longitude:</span>
                <span id="currentLng" class="control-value">Getting...</span>
            </div>
            <div class="control-item">
                <span class="control-label">Accuracy:</span>
                <span id="currentAccuracy" class="control-value">-</span>
            </div>
        </div>
        
        <div class="control-section">
            <h3><i class="fas fa-database"></i> Local Storage</h3>
            <div class="control-item">
                <span class="control-label">Map Tiles:</span>
                <span id="tilesStored" class="control-value">1,247</span>
            </div>
            <div class="control-item">
                <span class="control-label">Shelter Data:</span>
                <span id="sheltersStored" class="control-value">156</span>
            </div>
            <div class="control-item">
                <span class="control-label">Route Data:</span>
                <span id="routesStored" class="control-value">89</span>
            </div>
        </div>
        
        <div class="control-section">
            <h3><i class="fas fa-tools"></i> Data Management</h3>
            <div style="display: flex; gap: 5px; margin-bottom: 10px;">
                <button onclick="exportData()" style="flex: 1; padding: 5px; background: var(--windy-blue); color: white; border: none; border-radius: 5px; font-size: 10px;">
                    <i class="fas fa-download"></i> Export
                </button>
                <button onclick="loadSampleData()" style="flex: 1; padding: 5px; background: #28a745; color: white; border: none; border-radius: 5px; font-size: 10px;">
                    <i class="fas fa-database"></i> Sample
                </button>
                <button onclick="syncData()" style="flex: 1; padding: 5px; background: #ffc107; color: #212529; border: none; border-radius: 5px; font-size: 10px;">
                    <i class="fas fa-sync"></i> Sync
                </button>
            </div>
        </div>
    </div>

    <!-- Layer controls toggle button -->
    <button id="layerControlsToggle" class="layer-controls-toggle" onclick="toggleLayerControls()">
        <i class="fas fa-layers"></i>
    </button>

    <!-- Layer controls -->
    <div id="layerControls" class="layer-controls">
        <h3><i class="fas fa-layers"></i> Map Layers</h3>
        <div class="layer-item">
            <input type="checkbox" id="layerShelters" checked>
            <label for="layerShelters">Shelters</label>
        </div>
        <div class="layer-item">
            <input type="checkbox" id="layerRoutes" checked>
            <label for="layerRoutes">Safe Routes</label>
        </div>
        <div class="layer-item">
            <input type="checkbox" id="layerDangerZones" checked>
            <label for="layerDangerZones">Danger Zones</label>
        </div>
        <div class="layer-item">
            <input type="checkbox" id="layerBarangays" checked>
            <label for="layerBarangays">Barangay Boundaries</label>
        </div>
        <div class="layer-item">
            <input type="checkbox" id="layerTraffic" checked>
            <label for="layerTraffic">Traffic Status</label>
        </div>
    </div>

    <!-- Data panel -->
    <div class="data-panel">
        <h3><i class="fas fa-info-circle"></i> Real-time Data</h3>
        <div class="data-item">
            <span class="data-label">Available Shelters:</span>
            <span id="availableShelters" class="data-value">23</span>
        </div>
        <div class="data-item">
            <span class="data-label">Total Capacity:</span>
            <span id="totalCapacity" class="data-value">1,247</span>
        </div>
        <div class="data-item">
            <span class="data-label">Safe Routes:</span>
            <span id="safeRoutes" class="data-value">15</span>
        </div>
        <div class="data-item">
            <span class="data-label">Active Alerts:</span>
            <span id="activeAlerts" class="data-value">2</span>
        </div>
        <div class="data-item">
            <span class="data-label">Nearest Shelter:</span>
            <span id="nearestShelter" class="data-value">0.8 km</span>
        </div>
    </div>

    <!-- Sync progress -->
    <div id="syncProgress" class="sync-progress">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 12px;">Syncing Data...</span>
            <span id="syncPercentage" style="font-size: 12px; color: var(--windy-blue);">0%</span>
        </div>
        <div class="progress-bar">
            <div id="syncProgressFill" class="progress-fill"></div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; display: flex; justify-content: center; align-items: center; color: white; font-size: 18px;">
        <div style="text-align: center;">
            <div style="border: 4px solid #f3f3f3; border-top: 4px solid #3498db; border-radius: 50%; width: 50px; height: 50px; animation: spin 1s linear infinite; margin: 0 auto 20px;"></div>
            <div>Loading Enhanced Offline Evacuation System...</div>
        </div>
    </div>
    
    <style>
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- Bootstrap JS and dependencies -->
    <script src="js/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet JS -->
    <script src="js/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Enhanced Offline evacuation system -->
    <script src="js/offline-evacuation-enhanced.js"></script>
    
    <script>
        // Global functions for data management
        function exportData() {
            if (window.evacuationSystem) {
                const dataToExport = {
                    ...window.evacuationSystem.localData,
                    exportDate: new Date().toISOString(),
                    version: '1.0'
                };

                const dataStr = JSON.stringify(dataToExport, null, 2);
                const dataBlob = new Blob([dataStr], { type: 'application/json' });
                
                const link = document.createElement('a');
                link.href = URL.createObjectURL(dataBlob);
                link.download = `evacuation-data-${new Date().toISOString().split('T')[0]}.json`;
                link.click();
                
                alert('Data exported successfully!');
            }
        }

        function loadSampleData() {
            if (window.evacuationSystem) {
                window.evacuationSystem.loadSampleData();
                alert('Sample data loaded successfully!');
            }
        }

        function syncData() {
            if (window.evacuationSystem) {
                window.evacuationSystem.syncData();
            }
        }

        // Toggle control panel
        function toggleControlPanel() {
            const panel = document.getElementById('controlPanel');
            const toggle = document.getElementById('controlPanelToggle');
            
            panel.classList.toggle('collapsed');
            toggle.classList.toggle('collapsed');
            
            // Change icon
            const icon = toggle.querySelector('i');
            if (panel.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-right';
            } else {
                icon.className = 'fas fa-cog';
            }
        }

        // Toggle layer controls
        function toggleLayerControls() {
            const panel = document.getElementById('layerControls');
            const toggle = document.getElementById('layerControlsToggle');
            
            panel.classList.toggle('collapsed');
            toggle.classList.toggle('collapsed');
            
            // Change icon
            const icon = toggle.querySelector('i');
            if (panel.classList.contains('collapsed')) {
                icon.className = 'fas fa-chevron-left';
            } else {
                icon.className = 'fas fa-layers';
            }
        }

        // Mobile detection and auto-collapse
        function isMobile() {
            return window.innerWidth <= 768;
        }
        
        // Auto-collapse panels on mobile
        function handleMobileLayout() {
            if (isMobile()) {
                // Auto-collapse panels on mobile for better map visibility
                document.getElementById('controlPanel').classList.add('collapsed');
                document.getElementById('layerControls').classList.add('collapsed');
                
                // Update toggle button icons
                document.querySelector('#controlPanelToggle i').className = 'fas fa-chevron-right';
                document.querySelector('#layerControlsToggle i').className = 'fas fa-chevron-left';
            }
        }
        
        // Handle window resize
        window.addEventListener('resize', function() {
            handleMobileLayout();
        });
        
        // Initialize mobile layout
        document.addEventListener('DOMContentLoaded', function() {
            handleMobileLayout();
        });

        // Service Worker registration
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('./sw.js')
                .then(registration => {
                    console.log('Service Worker registered:', registration);
                })
                .catch(error => {
                    console.log('Service Worker registration failed:', error);
                });
        }
    </script>
</body>
</html>
