<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#FFFFFF">
    <title>Safe Evacuation & Shelter System</title>
    
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="css/leaflet@1.9.4/dist/leaflet.css">
    <!-- Leaflet Routing Machine CSS -->
    <link rel="stylesheet" href="css/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        #map {
            height: 100vh;
            width: 100%;
            z-index: 1;
            margin-left: 320px;
            transition: margin-left 0.3s ease-in-out;
            position: relative;
        }

        #map .leaflet-container {
            z-index: 1;
        }

        #map .leaflet-pane {
            z-index: 1;
        }

        body.sidebar-closed #map {
            margin-left: 0;
        }
        /* For Control Panel */
        .control-panel {
            position: fixed;
            top: 0;
            left: 0;
            width: 320px;
            height: 100vh;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.98);
            border-right: 1px solid rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            overflow-y: auto;
            font-size: 0.9rem;
            transition: transform 0.3s ease-in-out;
            box-shadow: 2px 0 20px rgba(0, 0, 0, 0.1);
        }

        .control-panel.closed {
            transform: translateX(-100%);
        }

        .control-panel .btn {
            font-size: 0.85rem;
            padding: 10px 15px;
            margin-bottom: 8px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .control-panel .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .control-panel h5, .control-panel h6 {
            font-size: 1rem;
            margin-bottom: 12px;
        }

        .control-panel .nav-section {
            margin-bottom: 15px;
        }

        .sidebar-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        /* Evacuation Shelters */
        .sidebar-header h5 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: #2c3e50;
        }

        .status-indicator {
            margin-bottom: 15px;
            padding: 8px 12px;
            background: rgba(40, 167, 69, 0.1);
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        .shelter-info {
            font-size: 0.8rem;
            color: #000305ff;
        }
        .legend {
            position: fixed;
            bottom: 3px;
            right: 50px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            max-width: 200px;
            font-size: 0.8rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 3px 0;
            font-size: 0.80rem;
        }

        .legend-icon {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 1px solid white;
            flex-shrink: 0;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .control-panel {
                width: 280px;
                padding: 15px;
                font-size: 0.85rem;
            }

            #map {
                margin-left: 280px;
            }

            body.sidebar-closed #map {
                margin-left: 0;
            }

            .control-panel-toggle {
                left: 300px;
            }

            body.sidebar-closed .control-panel-toggle {
                left: 10px;
            }

            .legend {
                bottom: 10px;
                right: 10px;
                max-width: 150px;
                padding: 8px;
                font-size: 0.7rem;
            }

            .legend-icon {
                width: 14px;
                height: 14px;
            }

            .control-panel h5 {
                font-size: 1.1rem;
                margin-bottom: 15px;
            }

            .control-panel .btn {
                font-size: 0.9rem;
                padding: 8px 12px;
                margin-bottom: 8px;
            }

            .shelter-info {
                padding: 12px;
                margin-bottom: 12px;
            }

            .shelter-info h6 {
                font-size: 1rem;
            }

            .nav-section h6 {
                font-size: 0.9rem;
            }

            .search-container .input-group {
                flex-direction: column;
            }

            .search-container .form-control {
                border-radius: 8px !important;
                margin-bottom: 8px;
            }

            .search-container .btn {
                border-radius: 8px !important;
                width: 100%;
            }

            .search-suggestions {
                position: fixed;
                top: auto;
                left: 10px;
                right: 10px;
                max-height: 150px;
            }

            .routing-controls {
                position: fixed;
                top: auto;
                bottom: 30px;
                left: 10px;
                right: 10px;
                max-width: none;
                padding: 12px;
                border-radius: 10px;
            }

            .legend {
                position: fixed;
                bottom: 10px;
                left: 10px;
                right: 10px;
                max-width: none;
                padding: 12px;
                border-radius: 10px;
                max-height: 25vh;
                overflow-y: auto;
            }

            .legend h6 {
                font-size: 0.9rem;
                margin-bottom: 8px;
            }

            .legend-item {
                font-size: 0.8rem;
                margin: 3px 0;
            }

            .legend-icon {
                width: 16px;
                height: 16px;
            }

            .alert-panel {
                position: fixed;
                top: 10px;
                left: 10px;
                right: 10px;
                max-width: none;
                z-index: 1001;
            }

            .alert-card {
                padding: 12px;
                margin-bottom: 8px;
                border-radius: 8px;
            }

            .status-indicator {
                padding: 8px;
                margin-bottom: 12px;
            }

            .status-dot {
                width: 10px;
                height: 10px;
            }

            /* Mobile-specific button adjustments */
            .btn {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Mobile search results */
            #searchResults {
                font-size: 0.8rem;
            }


            .data-item {
                padding: 8px;
                margin-bottom: 6px;
                font-size: 0.8rem;
            }

            /* Mobile routing info */
            .routing-info {
                font-size: 0.8rem;
                padding: 8px;
            }

            .geolocation-status {
                font-size: 0.8rem;
                padding: 6px;
            }

            /* Mobile map controls */
            .leaflet-control {
                border-radius: 6px;
            }

            .leaflet-control a {
                padding: 8px;
                font-size: 14px;
            }

            .leaflet-control-zoom a {
                width: 32px;
                height: 32px;
                line-height: 16px;
            }

            /* Mobile popup adjustments */
            .custom-popup {
                max-width: 250px;
                font-size: 0.9rem;
            }

            .popup-title {
                font-size: 1rem;
            }

            .popup-info {
                font-size: 0.8rem;
            }
        }

        /* Small Mobile Devices */
        @media (max-width: 480px) {
            .control-panel {
                padding: 12px;
                max-height: 65vh;
            }

            .control-panel h5 {
                font-size: 1rem;
            }

            .btn {
                font-size: 0.8rem;
                padding: 6px 10px;
            }

            .shelter-info {
                padding: 10px;
            }

            .shelter-info h6 {
                font-size: 0.9rem;
            }

            .legend {
                max-height: 20vh;
                padding: 10px;
            }

            .legend-item {
                font-size: 0.75rem;
            }

            .routing-controls {
                padding: 10px;
            }

            .routing-controls h6 {
                font-size: 0.9rem;
            }

            .routing-info {
                font-size: 0.75rem;
            }

            .geolocation-status {
                font-size: 0.75rem;
            }

            .alert-panel {
                top: 5px;
                left: 5px;
                right: 5px;
            }

            .alert-card {
                padding: 10px;
                font-size: 0.9rem;
            }
        }

        /* Landscape Mobile */
        @media (max-width: 768px) and (orientation: landscape) {
            .control-panel {
                max-height: 50vh;
                top: 5px;
                left: 5px;
                right: 5px;
            }

            .legend {
                max-height: 20vh;
                bottom: 5px;
                left: 5px;
                right: 5px;
            }

            .routing-controls {
                bottom: 5px;
                left: 5px;
                right: 5px;
            }
        }

        /* Tablet Adjustments */
        @media (min-width: 769px) and (max-width: 1024px) {
            .control-panel {
                max-width: 320px;
                padding: 18px;
            }

            .control-panel h5 {
                font-size: 1.2rem;
            }

            .btn {
                font-size: 0.95rem;
                padding: 10px 16px;
            }

            .legend {
                padding: 18px;
            }

            .routing-controls {
                padding: 18px;
                max-width: 280px;
            }
        }

        /* Touch Device Optimizations */
        @media (hover: none) and (pointer: coarse) {
            .btn {
                min-height: 44px;
                touch-action: manipulation;
            }

            .control-panel::-webkit-scrollbar {
                width: 8px;
            }

            .control-panel::-webkit-scrollbar-thumb {
                background: rgba(255, 255, 255, 0.4);
                border-radius: 4px;
            }

            .search-suggestions .suggestion-item {
                min-height: 44px;
                padding: 12px;
            }

            .data-item {
                min-height: 44px;
            }
        }

        /* Mobile Navigation Improvements */
        @media (max-width: 768px) {
            /* Collapsible sections for mobile */
            .nav-section {
                border-top: 1px solid rgba(0, 0, 0, 0.1);
                margin-top: 12px;
                padding-top: 12px;
            }

            .nav-section h6 {
                cursor: pointer;
                user-select: none;
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 8px;
            }

            .nav-section h6::after {
                content: '▼';
                font-size: 0.8rem;
                transition: transform 0.3s ease;
            }

            .nav-section.collapsed h6::after {
                transform: rotate(-90deg);
            }

            .nav-section.collapsed .btn {
                display: none;
            }

            /* Mobile-friendly spacing */
            .control-panel > * {
                margin-bottom: 12px;
            }

            .control-panel > *:last-child {
                margin-bottom: 0;
            }

                    /* Mobile search improvements */
        .search-container {
            margin-bottom: 12px;
        }

        .search-container .form-control {
            font-size: 14px;
            height: 38px;
            padding: 8px 12px;
            border-radius: 6px;
        }

        .search-container .input-group {
            gap: 6px;
        }

        .search-container .btn {
            border-radius: 6px;
            height: 38px;
            font-size: 0.85rem;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 600;
            background: rgba(0, 123, 255, 0.8);
            border: 1px solid rgba(0, 123, 255, 0.3);
            color: #FFFFFF;
            transition: all 0.3s ease;
        }

        .search-container .btn:hover {
            background: rgba(0, 123, 255, 1);
            border-color: rgba(0, 123, 255, 0.5);
            transform: translateY(-1px);
        }

        .search-container .btn:active {
            transform: translateY(0);
        }

        /* Mobile search suggestions improvements */
        .search-suggestions {
            position: fixed;
            top: auto;
            left: 10px;
            right: 10px;
            max-height: 150px;
            z-index: 1002;
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(15px);
        }

        .search-suggestions .suggestions-header {
            padding: 10px 12px;
            background: rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 12px;
            color: rgba(0, 0, 0, 0.7);
        }

        .search-suggestions .suggestion-item {
            padding: 12px;
            min-height: 44px; /* Touch-friendly height */
            font-size: 14px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .search-suggestions .suggestion-item:hover,
        .search-suggestions .suggestion-item.selected {
            background: rgba(0, 123, 255, 0.2);
            border-left: 3px solid #007bff;
        }

        .search-suggestions .suggestion-icon {
            width: 20px;
            font-size: 14px;
        }

        .search-suggestions .suggestion-text {
            font-size: 14px;
            line-height: 1.4;
        }

        .search-suggestions .suggestion-type {
            font-size: 10px;
            padding: 3px 6px;
        }

        /* Mobile search results improvements */
        #searchResults {
            margin-top: 8px;
            font-size: 12px;
            color: rgba(0, 0, 0, 0.7);
            text-align: center;
        }

        /* Mobile search results container */
        .shelter-search-result {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
            border-left: 4px solid #007bff;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 44px; /* Touch-friendly height */
        }

        .shelter-search-result:hover {
            background: rgba(0, 0, 0, 0.1);
            transform: translateX(2px);
        }

        .shelter-search-result.selected {
            border-left-color: #28a745;
            background: rgba(40, 167, 69, 0.2);
        }

        /* Mobile search loading indicator */
        .search-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: rgba(0, 0, 0, 0.7);
        }

        .search-loading .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-top: 2px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        /* Mobile search empty state */
        .search-empty {
            text-align: center;
            padding: 20px;
            color: rgba(0, 0, 0, 0.5);
        }

        .search-empty i {
            font-size: 24px;
            margin-bottom: 10px;
            opacity: 0.5;
        }

        .search-empty h6 {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .search-empty p {
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .search-empty .btn {
            margin: 5px;
            font-size: 0.8rem;
            padding: 6px 12px;
        }

        /* Search loading state improvements */
        .search-loading {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            color: rgba(255, 255, 255, 0.7);
            flex-direction: column;
            gap: 15px;
        }

        .search-loading .spinner {
            width: 30px;
            height: 30px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top: 3px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .search-loading span {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Search results improvements */
        .shelter-search-result {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #007bff;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 44px;
        }

        .shelter-search-result:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .shelter-search-result.selected {
            border-left-color: #28a745;
            background: rgba(40, 167, 69, 0.2);
        }

        .shelter-search-result strong {
            color: #212529;
            font-size: 0.95rem;
        }

        .shelter-search-result small {
            color: rgba(0, 0, 0, 0.7);
            font-size: 0.8rem;
        }

        .shelter-search-result .badge {
            font-size: 0.7rem;
            padding: 4px 8px;
        }

        /* Spin animation for loading spinner */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mobile search highlight improvements */
        .search-highlight {
            background-color: rgba(255, 193, 7, 0.4);
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: 600;
        }

        /* Mobile search input improvements */
        .search-container .form-control:focus {
            outline: none;
            border-width: 2px;
        }

        /* Mobile search button improvements */
        .search-container .btn:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.3);
        }

        /* Mobile search container spacing */
        .search-container {
            margin-bottom: 20px;
            padding: 0 2px;
        }

        /* Mobile search suggestions positioning */
        @media (max-width: 480px) {
            .search-suggestions {
                left: 5px;
                right: 5px;
                max-height: 120px;
            }

            .search-suggestions .suggestion-item {
                padding: 10px;
                min-height: 40px;
                font-size: 13px;
            }

            .search-suggestions .suggestion-text {
                font-size: 13px;
            }

            .search-suggestions .suggestion-type {
                font-size: 9px;
                padding: 2px 5px;
            }

            .search-container .form-control {
                height: 40px;
                padding: 8px 10px;
                font-size: 15px;
            }

            .search-container .btn {
                height: 40px;
                font-size: 13px;
            }
        }

        /* Extra small mobile devices */
        @media (max-width: 360px) {
            .search-container .form-control {
                height: 38px;
                padding: 6px 8px;
                font-size: 14px;
            }

            .search-container .btn {
                height: 38px;
                font-size: 12px;
            }

            .search-suggestions {
                max-height: 100px;
            }

            .search-suggestions .suggestion-item {
                padding: 8px;
                min-height: 36px;
                font-size: 12px;
            }
        }

        /* Mobile search loading state */
        .search-container .form-control:disabled {
            background: rgba(255, 255, 255, 0.05) !important;
            color: rgba(255, 255, 255, 0.5) !important;
            cursor: not-allowed;
        }

        .search-container .btn:disabled {
            background: rgba(0, 123, 255, 0.3) !important;
            cursor: not-allowed;
            transform: none;
        }

        /* Mobile search error state */
        .search-container .form-control.is-invalid {
            border-color: rgba(220, 53, 69, 0.6) !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.2);
        }

        .search-container .form-control.is-valid {
            border-color: rgba(40, 167, 69, 0.6) !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.2);
        }

            /* Mobile button grid for better organization */
            .btn-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
                margin-bottom: 12px;
            }

            .btn-grid .btn {
                margin-bottom: 0;
                text-align: center;
                font-size: 0.8rem;
                padding: 8px 6px;
            }

            /* Mobile status improvements */
            .status-indicator {
                background: rgba(255, 255, 255, 0.08);
                border-radius: 8px;
                padding: 10px;
            }

            /* Mobile shelter info improvements */
            .shelter-info {
                border-radius: 8px;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* Mobile capacity bar improvements */
            .capacity-bar {
                height: 6px;
                margin: 6px 0;
            }

            /* Mobile legend improvements */
            .legend {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(15px);
            }

            /* Mobile routing improvements */
            .routing-controls {
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(15px);
            }

            /* Mobile alert improvements */
            .alert-panel {
                background: transparent;
            }

            .alert-card {
                backdrop-filter: blur(15px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        }

        /* Extra Small Mobile Devices */
        @media (max-width: 360px) {
            .control-panel {
                padding: 10px;
                max-height: 60vh;
            }

            .btn {
                font-size: 0.75rem;
                padding: 5px 8px;
            }

            .control-panel h5 {
                font-size: 0.9rem;
            }

            .shelter-info h6 {
                font-size: 0.85rem;
            }

            .nav-section h6 {
                font-size: 0.8rem;
            }

            .legend {
                max-height: 18vh;
                padding: 8px;
            }

            .legend-item {
                font-size: 0.7rem;
            }

            .routing-controls {
                padding: 8px;
            }

            .routing-controls h6 {
                font-size: 0.8rem;
            }
        }

        /* High DPI Mobile Devices */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .status-dot {
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .legend-icon {
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .btn {
                border-width: 1px;
            }
        }

        /* Performance Optimizations */
        * {
            -webkit-tap-highlight-color: transparent;
        }

        #map {
            backface-visibility: hidden;
            perspective: 1000px;
        }

        .leaflet-container {
            font-family: inherit;
        }

        .leaflet-marker-icon,
        .leaflet-marker-shadow {
            will-change: transform;
        }

        /* Mobile Performance Optimizations */
        @media (max-width: 768px) {
            .control-panel {
                will-change: transform;
                transform: translateZ(0);
                backface-visibility: visible;
            }

            .btn {
                will-change: transform;
                transform: translateZ(0);
            }

            .shelter-info {
                will-change: transform;
                transform: translateZ(0);
            }

            /* Reduce animations on mobile */
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }

            .control-panel,
            .control-panel-toggle {
                animation-duration: 0.3s !important;
                transition-duration: 0.3s !important;
            }
        }

        /* Control Panel Toggle Styles */
        .control-panel {
            transition: transform 0.3s ease-in-out;
        }

        .control-panel.closed {
            transform: translateX(-100%);
        }

        .control-panel::-webkit-scrollbar {
            width: 6px;
        }

        .control-panel::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 3px;
        }

        .control-panel::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        .control-panel::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        .control-panel-toggle {
            position: fixed;
            top: 20px;
            left: 340px;
            z-index: 999;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        body.sidebar-closed .control-panel-toggle {
            left: 20px;
        }

        .control-panel-toggle:hover {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(0, 0, 0, 0.2);
            transform: scale(1.1);
        }

        .control-panel-toggle .toggle-icon {
            color: #212529;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .control-panel.closed + .control-panel-toggle .toggle-icon {
            transform: rotate(180deg);
        }

        /* Panel state indicator */
        .control-panel-toggle::after {
            content: '';
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.95);
            transition: all 0.3s ease;
            opacity: 1;
        }

        .control-panel.closed + .control-panel-toggle {
            left: 20px;
            z-index: 1001;
        }

        .control-panel.closed + .control-panel-toggle::after {
            background: #dc3545;
            opacity: 0.8;
        }

        /* Toggle button pulse animation when panel is closed */
        .control-panel.closed + .control-panel-toggle {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            }
            50% {
                box-shadow: 0 4px 20px rgba(220, 53, 69, 0.4);
            }
            100% {
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            }
        }

        /* Mobile toggle adjustments */
        @media (max-width: 768px) {
            .control-panel-toggle {
                top: 10px;
                right: 10px;
                left: auto;
                width: 45px;
                height: 45px;
            }

            .control-panel.closed + .control-panel-toggle {
                left: 10px;
                right: auto;
            }

            .control-panel-toggle .toggle-icon {
                font-size: 16px;
            }

            .control-panel.closed {
                transform: translateX(-100%);
            }
        }

        /* Animation for smooth open/close */
        .control-panel {
            transform-origin: left center;
        }

        .control-panel.closing {
            animation: slideOut 0.3s ease-in-out forwards;
        }

        .control-panel.opening {
            animation: slideIn 0.3s ease-in-out forwards;
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(-100%);
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
                opacity: 0.8;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .control-panel::-webkit-scrollbar {
            width: 6px;
        }

        .control-panel::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }

        .control-panel::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 3px;
        }

        .control-panel::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.5);
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
            background: rgba(0, 0, 0, 0.05);
        }

        .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .status-online { background-color: #28a745; }
        .status-offline { background-color: #dc3545; }
        .status-syncing { background-color: #ffc107; }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .shelter-info {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            font-size: 0.85rem;
        }

        .capacity-bar {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            overflow: hidden;
            margin: 8px 0;
        }

        .capacity-fill {
            height: 100%;
            transition: width 0.3s ease;
            border-radius: 4px;
        }

        .capacity-low { background-color: #28a745; }
        .capacity-medium { background-color: #ffc107; }
        .capacity-high { background-color: #dc3545; }

        .alert-panel {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 300px;
        }

        .alert-card {
            background: rgba(220, 53, 69, 0.95);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        
        .offline-notice {
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10000;
            display: none;
        }

        .nav-section {
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: 15px;
            padding-top: 15px;
        }

        .nav-section h6 {
            margin-bottom: 10px;
            color: #6c757d;
        }
        
        .saved-location-marker {
            background: transparent !important;
            border: none !important;
        }
        
        .user-location-marker {
            background: transparent !important;
            border: none !important;
        }
        
        .route-marker {
            background: transparent !important;
            border: none !important;
        }
        
        .custom-popup {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .popup-title {
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        .popup-info {
            color: #666;
            margin-bottom: 5px;
            font-size: 14px;
        }
        
        .data-item {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 8px;
            border-left: 4px solid #007bff;
            transition: all 0.3s ease;
        }
        
        .data-item:hover {
            background: rgba(0, 0, 0, 0.1);
            transform: translateX(2px);
        }
        
        .data-item.safe {
            border-left-color: #28a745;
        }
        
        .data-item.not-safe {
            border-left-color: #dc3545;
        }
        
        .data-item.location {
            border-left-color: #007bff;
        }

        /* Leaflet Map Controls Styling */
        .leaflet-control {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .leaflet-control a {
            color: #212529;
            background: rgba(0, 0, 0, 0.05);
            border: none;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .leaflet-control a:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #212529;
            text-decoration: none;
        }

        .leaflet-control-layers {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            color: #212529;
            position: fixed;
        }

        .leaflet-control-layers label {
            color: #212529;
            margin-bottom: 5px;
        }

        .leaflet-control-layers input[type="radio"] {
            margin-right: 8px;
        }

        .leaflet-control-zoom {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .leaflet-control-zoom a {
            background: rgba(0, 0, 0, 0.05);
            color: #212529;
            border: none;
            border-radius: 4px;
            margin: 2px;
        }

        .leaflet-control-zoom a:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #212529;
        }

        /* Move zoom controls to the right side */
        .leaflet-top.leaflet-left {
            left: auto !important;
            right: 10px !important;
            z-index: 1002 !important;
            pointer-events: auto !important;
            top: 10px !important;
        }

        .leaflet-control-zoom {
            z-index: 1002 !important;
            pointer-events: auto !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2) !important;
            margin-bottom: 10px !important;
            
        }

        .leaflet-control {
            z-index: 1002 !important;
            pointer-events: auto !important;
            margin-bottom: 10px !important;
        }

        .leaflet-top.leaflet-right {
            z-index: 1002 !important;
            pointer-events: auto !important;
            top: 10px !important;
        }

        /* Control spacing */
        .leaflet-bar.leaflet-control {
            margin-bottom: 10px !important;
        }

        .leaflet-bar.leaflet-control a {
            display: block !important;
            margin-bottom: 2px !important;
        }

        /* Adjust for desktop */
        @media (min-width: 769px) {
            .leaflet-top.leaflet-left {
                right: 10px;
                top: 10px;
            }
            
            .leaflet-top.leaflet-right {
                right: 10px;
                top: 10px;
            }
        }

        /* Adjust for mobile */
        @media (max-width: 768px) {
            .leaflet-top.leaflet-left {
                right: 10px;
                top: 10px;
            }
            
            .leaflet-top.leaflet-right {
                right: 10px;
                top: 10px;
            }
        }

        /* Search Bar Styling */
        .search-container {
            position: relative;
        }

        .search-highlight {
            background-color: rgba(255, 193, 7, 0.3);
            padding: 2px 4px;
            border-radius: 3px;
        }

        .shelter-search-result {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 8px;
            border-left: 4px solid #007bff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .shelter-search-result:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(2px);
        }

        .shelter-search-result.selected {
            border-left-color: #28a745;
            background: rgba(40, 167, 69, 0.2);
        }

        /* Autocomplete Suggestions Styling */
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1001;
            max-height: 200px;
            overflow-y: auto;
            backdrop-filter: blur(10px);
        }

        .search-suggestions::-webkit-scrollbar {
            width: 6px;
        }

        .search-suggestions::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }

        .search-suggestions::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .search-suggestions::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .suggestions-header {
            padding: 8px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px 8px 0 0;
        }

        .suggestion-item {
            padding: 10px 12px;
            cursor: pointer;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .suggestion-item:last-child {
            border-bottom: none;
            border-radius: 0 0 8px 8px;
        }

        .suggestion-item:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .suggestion-item.selected {
            background: rgba(0, 123, 255, 0.1);
            border-left: 3px solid #007bff;
        }

        .suggestion-icon {
            width: 16px;
            text-align: center;
            color: #6c757d;
        }

        .suggestion-text {
            flex: 1;
            color: #212529;
        }

        .suggestion-type {
            font-size: 11px;
            color: #6c757d;
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 6px;
            border-radius: 10px;
        }
        /* FOR LAPTOP Routing */
        
        /* Routing and Geolocation Controls */
        .routing-controls {
            position: absolute;
            top: 20px;
            right: 55px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            padding: 7px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            max-width: 250px;
            height: 35vh;
        }

        .routing-controls h6 {
            color: #212529;
            margin-bottom: 0;
            font-size: 12px;
        }

        .routing-info {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            padding: 5px;
            margin-bottom: 1px;
            font-size: 12px;
            color: #6c757d;
        }

        .routing-info .distance {
            color: #28a745;
            font-weight: bold;
        }

        .routing-info .duration {
            color: #ffc107;
            font-weight: bold;
        }

        .geolocation-status {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 10px;
            font-size: 12px;
        }

        .geolocation-status.accurate {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .geolocation-status.inaccurate {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .geolocation-status.unknown {
            background: rgba(108, 117, 125, 0.2);
            color: #6c757d;
        }

        /* Leaflet Routing Machine Styling */
        .leaflet-routing-container {
            background: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: 8px !important;
            color: #212529 !important;
            max-width: 320px !important;
        }

        .leaflet-routing-container h2 {
            color: #212529 !important;
            font-size: 16px !important;
        }

        .leaflet-routing-container h3 {
            color: #212529 !important;
            font-size: 14px !important;
        }

        .leaflet-routing-container .leaflet-routing-alt {
            background: rgba(0, 0, 0, 0.05) !important;
            border: none !important;
            color: #212529 !important;
        }

        .leaflet-routing-container .leaflet-routing-alt h3 {
            color: #212529 !important;
        }

        .leaflet-routing-container .leaflet-routing-alt tr {
            color: #212529 !important;
        }

        .leaflet-routing-container .leaflet-routing-alt td {
            color: #212529 !important;
        }

        .leaflet-routing-container .leaflet-routing-alt .leaflet-routing-alt-minimized {
            background: rgba(0, 0, 0, 0.05) !important;
        }

        .leaflet-routing-container .leaflet-routing-alt .leaflet-routing-alt-minimized:hover {
            background: rgba(0, 0, 0, 0.1) !important;
        }

        .leaflet-routing-container .leaflet-routing-geocoders {
            background: rgba(0, 0, 0, 0.05) !important;
        }

        .leaflet-routing-container .leaflet-routing-geocoders input {
            background: rgba(255, 255, 255, 0.9) !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            color: #212529 !important;
        }

        .leaflet-routing-container .leaflet-routing-geocoders input::placeholder {
            color: rgba(0, 0, 0, 0.6) !important;
        }

        .leaflet-routing-container .leaflet-routing-geocoders button {
            background: rgba(0, 123, 255, 0.8) !important;
            border: none !important;
            color: #FFFFFF !important;
        }

        .leaflet-routing-container .leaflet-routing-geocoders button:hover {
            background: rgba(0, 123, 255, 1) !important;
        }
        

        /* GIS Architecture Diagram Styles */
        .gis-architecture-diagram {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .tier {
            margin-bottom: 40px;
            text-align: center;
        }

        .tier-title {
            font-size: 1.2rem;
            font-weight: bold;
            color: #212529;
            margin-bottom: 5px;
            background: rgba(255, 255, 255, 0.8);
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            border: 2px solid #dee2e6;
        }

        .tier-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
            font-style: italic;
            margin-bottom: 20px;
        }

        /* Client Tier Styles */
        .client-tier {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #2196f3;
        }

        .client-boxes {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .client-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            min-width: 150px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(33, 150, 243, 0.3);
            transition: all 0.3s ease;
        }

        .client-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .client-box i {
            font-size: 2rem;
            color: #2196f3;
            margin-bottom: 10px;
        }

        .client-label {
            font-weight: bold;
            color: #212529;
            margin-bottom: 5px;
        }

        .client-type {
            font-size: 0.8rem;
            color: #6c757d;
            font-style: italic;
        }

        /* Middleware Tier Styles */
        .middleware-tier {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #ff9800;
        }

        .middleware-boxes {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .middleware-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            min-width: 200px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(255, 152, 0, 0.3);
            transition: all 0.3s ease;
        }

        .middleware-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .middleware-box i {
            font-size: 2rem;
            color: #ff9800;
            margin-bottom: 10px;
        }

        .middleware-label {
            font-weight: bold;
            color: #212529;
            margin-bottom: 10px;
        }

        .middleware-details {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .gis-functions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 15px;
        }

        .gis-function {
            background: rgba(255, 152, 0, 0.1);
            border-radius: 8px;
            padding: 10px;
            border: 1px solid rgba(255, 152, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .gis-function i {
            font-size: 1rem;
            color: #ff9800;
        }

        /* Server Tier Styles */
        .server-tier {
            background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
            border-radius: 12px;
            padding: 20px;
            border: 2px solid #9c27b0;
        }

        .server-boxes {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .server-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            min-width: 200px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(156, 39, 176, 0.3);
            transition: all 0.3s ease;
        }

        .server-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .server-box i {
            font-size: 2rem;
            color: #9c27b0;
            margin-bottom: 10px;
        }

        .server-label {
            font-weight: bold;
            color: #212529;
            margin-bottom: 10px;
        }

        .server-details {
            color: #6c757d;
            font-size: 0.8rem;
        }

        /* Connection Lines */
        .tier::after {
            content: '';
            display: block;
            width: 2px;
            height: 30px;
            background: linear-gradient(to bottom, #dee2e6, #adb5bd);
            margin: 20px auto;
            border-radius: 1px;
        }

        .tier:last-child::after {
            display: none;
        }

        /* Random Forest ML Styles */
        .ml-parameter-card {
            background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
            border: 2px solid #ffc107;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .ml-results-card {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            border: 2px solid #28a745;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .prediction-result {
            text-align: center;
            padding: 20px;
        }

        .risk-badge {
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin: 10px 0;
        }

        .risk-low { background-color: #d4edda; color: #155724; }
        .risk-medium { background-color: #fff3cd; color: #856404; }
        .risk-high { background-color: #f8d7da; color: #721c24; }
        .risk-critical { background-color: #d1ecf1; color: #0c5460; }

        .ml-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .metric-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        .metric-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #007bff;
        }

        .metric-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Mobile Responsive for GIS Architecture */
        @media (max-width: 768px) {
            .gis-architecture-diagram {
                padding: 15px;
                margin: 10px 0;
            }

            .client-boxes, .middleware-boxes, .server-boxes {
                flex-direction: column;
                align-items: center;
            }

            .client-box, .middleware-box, .server-box {
                min-width: auto;
                width: 100%;
                max-width: 280px;
            }

            .gis-functions {
                grid-template-columns: 1fr;
            }

            .tier-title {
                font-size: 1rem;
            }

            .tier-subtitle {
                font-size: 0.8rem;
            }
        }

        /* Animation for ML Results */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ml-result-animation {
            animation: fadeInUp 0.5s ease-out;
        }

        /* Progress bars for ML parameters */
        .parameter-progress {
            height: 8px;
            border-radius: 4px;
            background: rgba(255, 255, 255, 0.3);
            overflow: hidden;
            margin-top: 5px;
        }

        .parameter-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #28a745, #ffc107, #dc3545);
            transition: width 0.3s ease;
        }

        /* Legend Section Styles */
        .legend-section {
            margin-bottom: 0;
            padding: 0 0 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .legend-section:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .legend-section-title {
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .legend > h6 {
            text-align: left;  
            font-weight: bold;   
            margin-top: 0;
            margin-bottom: 10px;
        }


        /* Emergency Hotlines Styles */
        .emergency-hotlines {
            background: rgba(220, 53, 69, 0.1);
            border-radius: 8px;
            padding: 15px;
            border: 2px solid rgba(220, 53, 69, 0.3);
        }

        .hotline-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            margin-bottom: 8px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 6px;
            border-left: 4px solid #dc3545;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .hotline-item:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateX(2px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .hotline-item:last-child {
            margin-bottom: 0;
        }

        .hotline-number {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #dc3545;
            font-size: 0.9rem;
            background: rgba(220, 53, 69, 0.1);
            padding: 4px 8px;
            border-radius: 4px;
        }

        /* Mobile responsive for emergency hotlines */
        @media (max-width: 768px) {
            .hotline-item {
                flex-direction: column;
                align-items: flex-start;
            gap: 5px;
        }

            .hotline-number {
                align-self: flex-end;
            }

            .emergency-hotlines {
                padding: 10px;
            }
        }

        /* Emergency hotline click animation */
        .hotline-item:active {
            transform: scale(0.98);
        }

    </style>
</head>
<body>
    <!-- Offline Notice -->
    <div id="offlineNotice" class="offline-notice">
        <i class="fas fa-wifi-slash"></i> You are currently offline. Using cached data.
    </div>

    <!-- Map Container -->
    <div id="map"></div>

    <!-- Control Panel -->
    <div class="control-panel" id="controlPanel">
        <div class="sidebar-header">
            <h5><i class="fas fa-map-marker-alt"></i> Evacuation System</h5>
        <div class="status-indicator">
            <div id="statusDot" class="status-dot status-online"></div>
            <span id="statusText">Online</span>
            </div>
        </div>
        
        <!-- Search Bar -->
        <div class="search-container mb-3">
            <div class="input-group">
                <input type="text" id="barangaySearch" class="form-control w-100" placeholder="Search barangay or owner...">
            </div>
            <!-- Autocomplete Suggestions -->
            <div id="searchSuggestions" class="search-suggestions" style="display: none;">
                <div class="suggestions-header">
                    <small class="text-muted">Suggestions</small>
                </div>
                <div id="suggestionsList"></div>
            </div>
            <div id="searchResults" class="mt-2" style="display: none;">
                <small class="text-muted">Found <span id="resultCount">0</span> shelters</small>
            </div>
        </div>
        
        <div class="shelter-info">
            <h6><i class="fas fa-home"></i> Nearest Shelters</h6>
            <div id="nearestShelters">
                <p class="text-muted">Loading shelters...</p>
            </div>
        </div>

        <!-- Main Functions -->
        <button class="btn btn-primary w-100 mb-2" onclick="evacuationSystem.getCurrentLocation()">
            <i class="fas fa-location-arrow"></i> Get My Location
        </button>
        
        <button class="btn btn-outline-primary w-100 mb-2" onclick="evacuationSystem.loadCurrentLocation()">
            <i class="fas fa-database"></i> Load Saved Location
        </button>
        
        
        <!-- Emergency Hotlines Section -->
        <div class="nav-section">
            <h6 class="text-dark"><i class="fas fa-phone"></i> Emergency Hotlines</h6>
            <button class="btn btn-outline-danger w-100 mb-2" onclick="showEmergencyHotlines()">
                <i class="fas fa-phone-alt"></i> View Emergency Contacts
            </button>
            <div class="emergency-hotlines mt-2" id="emergencyHotlines" style="display: none;">
                <div class="hotline-item">
                    <strong><i class="fas fa-fire-extinguisher text-danger"></i> BFP</strong>
                    <div class="hotline-number">0961-178-4598</div>
                </div>
                <div class="hotline-item">
                    <strong><i class="fas fa-building text-info"></i> PDRRMO</strong>
                    <div class="hotline-number">0912-670-7777</div>
                </div>
                <div class="hotline-item">
                    <strong><i class="fas fa-city text-warning"></i> MDRRMO</strong>
                    <div class="hotline-number">0921-425-6862</div>
                </div>
                <div class="hotline-item">
                    <strong><i class="fas fa-plus text-danger"></i> RED CROSS</strong>
                    <div class="hotline-number">0917-806-8528</div>
                </div>
                <div class="hotline-item">
                    <strong><i class="fas fa-anchor text-primary"></i> COAST GUARD</strong>
                    <div class="hotline-number">0947-325-7245</div>
                </div>
            </div>
        </div>

        <!-- Login Section -->
        <div class="nav-section">
            <h6 class="text-dark"><i class="fas fa-user"></i> Account</h6>
            <?php if (!empty($_SESSION['user_id'])): ?>
                <div class="d-flex flex-column gap-2 mb-2">
                    <span class="badge bg-success text-center">Hello, <?= htmlspecialchars($_SESSION['username']) ?></span>
                    <?php if (!empty($_SESSION['is_admin'])): ?>
                        <a class="btn btn-sm btn-primary" href="admin/index.php">
                            <i class="fas fa-cog"></i> Admin Panel
                        </a>
                    <?php endif; ?>
                    <a class="btn btn-sm btn-outline-secondary" href="login.php?logout=1">
                <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-sign-in-alt"></i> Login
            </a>
            <?php endif; ?>
        </div>
            
    </div>

    <!-- Control Panel Toggle Button -->
    
    <div class="control-panel-toggle" id="controlPanelToggle" title="Toggle Control Panel">
        <i class="fas fa-chevron-left toggle-icon"></i>
    </div>
    

    <!-- Alert Panel -->
    <div class="alert-panel" id="alertPanel"></div>

    <!-- Routing Controls -->
    <div class="routing-controls" id="routingControls" style="display: none;">
        <h6><i class="fas fa-route"></i> Route Information</h6>
        
        <div class="geolocation-status" id="geolocationStatus">
            <i class="fas fa-crosshairs"></i>
            <span>Getting location...</span>
        </div>
        
        <div class="routing-info" id="routingInfo">
            <div><i class="fas fa-map-marker-alt"></i> <strong>From:</strong> <span id="routeFrom">Current Location</span></div>
            <div><i class="fas fa-flag-checkered"></i> <strong>To:</strong> <span id="routeTo">Select Destination</span></div>
            <div><i class="fas fa-road"></i> <strong>Distance:</strong> <span id="routeDistance" class="distance">-</span></div>
            <div><i class="fas fa-clock"></i> <strong>Duration:</strong> <span id="routeDuration" class="duration">-</span></div>
        </div>
        
        <button class="btn btn-outline-secondary btn-sm w-100 mb-2" onclick="evacuationSystem.clearRoute()">
            <i class="fas fa-times"></i> Clear Route
        </button>
        
        <button class="btn btn-primary btn-sm w-100" onclick="evacuationSystem.reverseRoute()">
            <i class="fas fa-exchange-alt"></i> Reverse Route
        </button>
    </div>

    <!-- Legend -->
    <div class="legend">
        <h6><i class="fas fa-info-circle"></i> Legend</h6>
        

        <!-- Shelter Markers -->
        <div class="legend-section">
            <h6 class="legend-section-title"><i class="fas fa-home"></i> Shelters</h6>
        <div class="legend-item">
            <i class="fas fa-map-marker-alt" style="color: #dc3545;"></i>
            <span>Full Capacity Shelter</span>
        </div>
        <div class="legend-item">
            <i class="fas fa-map-marker-alt" style="color: #F4A300;"></i>
            <span>High Capacity Shelter (16+)</span>
        </div>
        <div class="legend-item">
            <i class="fas fa-map-marker-alt" style="color: #008037;"></i>
            <span>Low Capacity Shelter (1-15)</span>
        </div>
        </div>

        <!-- Location Markers -->
        <div class="legend-section">
            <h6 class="legend-section-title"><i class="fas fa-map-marker-alt"></i> Locations</h6>
        <div class="legend-item">
            <i class="fas fa-map-marker-alt" style="color: #007bff;"></i>
            <span>Your Current Location</span>
        </div>
        <div class="legend-item">
            <div class="legend-icon" style="background-color: #6f42c1; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: bold;">S</div>
            <span>Saved Location</span>
        </div>
        <div class="legend-item">
            <div class="legend-icon" style="background-color: #28a745; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: bold;">🚗</div>
            <span>Pickup Point (Start)</span>
        </div>
        <div class="legend-item">
            <div class="legend-icon" style="background-color: #dc3545; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: bold;">📍</div>
            <span>Destination (End)</span>
        </div>
        </div>

        <!-- Route Elements -->
        <div class="legend-section">
            <h6 class="legend-section-title"><i class="fas fa-route"></i> Routes</h6>
        <div class="legend-item">
            <div class="legend-icon" style="background-color: #6f42c1; width: 8px; height: 8px; border-radius: 50%; border: 1px solid white;"></div>
            <span>Road Intersection</span>
        </div>
        <div class="legend-item">
            <div class="legend-icon" style="background-color: #ffc107; display: flex; align-items: center; justify-content: center; color: white; font-size: 8px; font-weight: bold;">↶</div>
            <span>Turn Point</span>
        </div>
        <div class="legend-item">
            <div class="legend-icon" style="background-color: #17a2b8; width: 3px; height: 3px; border-radius: 50%; border: 1px solid white;"></div>
            <span>Route Line</span>
        </div>
        <div class="legend-item">
            <div class="legend-icon" style="background-color: #e83e8c; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: bold;">📍</div>
            <span>Geolocation Point</span>
        </div>
    </div>
    </div>

    </div>

    <!-- Scripts -->
    <script src="js/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine -->
    <script src="js/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <!-- Turf.js for geospatial analysis -->
    <script src="js/@turf/turf@6.5.0/turf.min.js"></script>
    <script src="js/evacuation-system.js?v=<?php echo time(); ?>"></script>
    <script src="js/offline-evacuation-enhanced.js?v=<?php echo time(); ?>"></script>

    
    <script>
        // Control Panel Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const controlPanel = document.getElementById('controlPanel');
            const toggleButton = document.getElementById('controlPanelToggle');
            let isPanelOpen = true;

            // Toggle control panel function
            function toggleControlPanel() {
                if (isPanelOpen) {
                    // Close panel
                    controlPanel.classList.add('closing');
                    document.body.classList.add('sidebar-closed');
                    setTimeout(() => {
                        controlPanel.classList.remove('closing');
                        controlPanel.classList.add('closed');
                        // Refresh map to adjust to new size
                        if (window.evacuationSystem && window.evacuationSystem.map) {
                            setTimeout(() => {
                                window.evacuationSystem.map.invalidateSize();
                            }, 100);
                        }
                    }, 300);
                    isPanelOpen = false;
                } else {
                    // Open panel
                    controlPanel.classList.remove('closed');
                    document.body.classList.remove('sidebar-closed');
                    controlPanel.classList.add('opening');
                    setTimeout(() => {
                        controlPanel.classList.remove('opening');
                        // Refresh map to adjust to new size
                        if (window.evacuationSystem && window.evacuationSystem.map) {
                            setTimeout(() => {
                                window.evacuationSystem.map.invalidateSize();
                            }, 100);
                        }
                    }, 300);
                    isPanelOpen = true;
                }
            }

            // Toggle button click event
            toggleButton.addEventListener('click', toggleControlPanel);



            // Auto-hide panel on mobile when scrolling map
            let touchStartY = 0;
            let touchStartX = 0;
            let isScrolling = false;
            let lastTap = 0;
            let tapCount = 0;

            document.addEventListener('touchstart', function(e) {
                touchStartY = e.touches[0].clientY;
                touchStartX = e.touches[0].clientX;
                isScrolling = false;
                
                // Double-tap detection for mobile toggle
                const currentTime = new Date().getTime();
                const tapLength = currentTime - lastTap;
                
                if (tapLength < 500 && tapLength > 0) {
                    tapCount++;
                    if (tapCount === 2) {
                        // Double-tap detected - toggle panel
                        if (window.innerWidth <= 768) {
                            toggleControlPanel();
                        }
                        tapCount = 0;
                    }
                } else {
                    tapCount = 1;
                }
                lastTap = currentTime;
            });

            document.addEventListener('touchmove', function(e) {
                if (!isScrolling) {
                    const touchY = e.touches[0].clientY;
                    const touchX = e.touches[0].clientX;
                    const deltaY = Math.abs(touchY - touchStartY);
                    const deltaX = Math.abs(touchX - touchStartX);

                    if (deltaY > deltaX && deltaY > 10) {
                        isScrolling = true;
                        // Auto-hide panel on mobile when scrolling
                        if (window.innerWidth <= 768 && isPanelOpen) {
                            setTimeout(() => {
                                if (isScrolling) {
                                    toggleControlPanel();
                                }
                            }, 1000);
                        }
                    }
                }
            });

            // Swipe left/right to toggle panel on mobile
            let swipeStartX = 0;
            let swipeStartY = 0;
            let isSwiping = false;

            document.addEventListener('touchstart', function(e) {
                swipeStartX = e.touches[0].clientX;
                swipeStartY = e.touches[0].clientY;
                isSwiping = false;
            });

            document.addEventListener('touchend', function(e) {
                if (!isSwiping && window.innerWidth <= 768) {
                    const swipeEndX = e.changedTouches[0].clientX;
                    const swipeEndY = e.changedTouches[0].clientY;
                    const deltaX = swipeEndX - swipeStartX;
                    const deltaY = Math.abs(swipeEndY - swipeStartY);
                    
                    // Horizontal swipe with minimal vertical movement
                    if (Math.abs(deltaX) > 50 && deltaY < 30) {
                        if (deltaX > 0 && !isPanelOpen) {
                            // Swipe right to open
                            toggleControlPanel();
                        } else if (deltaX < 0 && isPanelOpen) {
                            // Swipe left to close
                            toggleControlPanel();
                        }
                    }
                }
            });

            // Mobile Navigation Enhancement
            // Add click handlers for collapsible sections on mobile
            const navSections = document.querySelectorAll('.nav-section h6');

            // Handle orientation change
            window.addEventListener('orientationchange', function() {
                setTimeout(function() {
                    // Recalculate positions after orientation change
                    if (window.innerWidth <= 768) {
                        // Force layout recalculation
                        document.body.offsetHeight;
                    }
                }, 100);
            });

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth <= 768) {
                        // Mobile layout adjustments
                        const controlPanel = document.querySelector('.control-panel');
                        const legend = document.querySelector('.legend');
                        const routingControls = document.querySelector('.routing-controls');
                        
                        if (controlPanel && legend && routingControls) {
                            // Ensure proper spacing on mobile
                            const controlHeight = controlPanel.offsetHeight;
                            const legendHeight = legend.offsetHeight;
                            const routingHeight = routingControls.offsetHeight;
                            
                            // Adjust legend position if needed
                            if (controlHeight + legendHeight + routingHeight > window.innerHeight * 0.8) {
                                legend.style.maxHeight = '20vh';
                            }
                        }
                    }
                }, 250);
            });

            // Touch-friendly improvements
            if ('ontouchstart' in window) {
                // Add touch feedback
                const buttons = document.querySelectorAll('.btn');
                buttons.forEach(btn => {
                    btn.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.95)';
                    });
                    
                    btn.addEventListener('touchend', function() {
                        this.style.transform = 'scale(1)';
                    });
                });

                // Improve scrolling on mobile
                const controlPanel = document.querySelector('.control-panel');
                if (controlPanel) {
                    controlPanel.style.webkitOverflowScrolling = 'touch';
                }
            }

            // Mobile-specific optimizations
            if (window.innerWidth <= 768) {
                // Optimize for mobile performance
                document.body.style.webkitTextSizeAdjust = '100%';
                
                // Prevent zoom on input focus (iOS)
                const inputs = document.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    input.style.fontSize = '16px';
                });

                // Mobile search improvements
                const searchInput = document.getElementById('barangaySearch');
                
                if (searchInput) {
                    // Improve mobile search experience
                    searchInput.addEventListener('focus', function() {
                        // Ensure proper positioning on mobile
                        setTimeout(() => {
                            this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 300);
                    });

                    // Mobile search suggestions improvements
                    searchInput.addEventListener('input', function() {
                        if (this.value.length > 0) {
                            // Show suggestions with mobile-friendly positioning
                            const suggestions = document.getElementById('searchSuggestions');
                            if (suggestions) {
                                suggestions.style.display = 'block';
                                // Ensure suggestions are visible on mobile
                                setTimeout(() => {
                                    suggestions.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                                }, 100);
                            }
                            
                            // Load suggestions as user types
                            if (typeof evacuationSystem !== 'undefined' && evacuationSystem.loadSuggestions) {
                                evacuationSystem.loadSuggestions(this.value);
                            }

                            // Trigger auto-search
                            if (typeof evacuationSystem !== 'undefined' && evacuationSystem.autoSearch) {
                                evacuationSystem.autoSearch();
                            }
                        } else {
                            // Hide suggestions if input is empty
                            const suggestions = document.getElementById('searchSuggestions');
                            if (suggestions) {
                                suggestions.style.display = 'none';
                            }

                            // Clear search if input is empty
                            if (typeof evacuationSystem !== 'undefined' && evacuationSystem.autoSearch) {
                                evacuationSystem.autoSearch();
                            }
                        }
                    });

                    // Close suggestions when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!searchInput.contains(e.target) && !e.target.closest('.search-suggestions')) {
                            const suggestions = document.getElementById('searchSuggestions');
                            if (suggestions) {
                                suggestions.style.display = 'none';
                            }
                        }
                    });

                    // Mobile keyboard handling
                    searchInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            // Trigger immediate search (no debounce)
                            if (typeof evacuationSystem !== 'undefined' && evacuationSystem.searchBarangay) {
                                evacuationSystem.searchBarangay();
                            }
                        }
                    });
                }
            }

            // General search functionality for all devices
            const generalSearchInput = document.getElementById('barangaySearch');
            if (generalSearchInput) {
                // Add input event listener for real-time suggestions and auto-search
                generalSearchInput.addEventListener('input', function() {
                    if (this.value.length > 0) {
                        // Show suggestions
                        const suggestions = document.getElementById('searchSuggestions');
                        if (suggestions) {
                            suggestions.style.display = 'block';
                        }
                        
                        // Load suggestions as user types
                        if (typeof evacuationSystem !== 'undefined' && evacuationSystem.loadSuggestions) {
                            evacuationSystem.loadSuggestions(this.value);
                        }

                        // Trigger auto-search
                        if (typeof evacuationSystem !== 'undefined' && evacuationSystem.autoSearch) {
                            evacuationSystem.autoSearch();
                        }
                    } else {
                        // Hide suggestions if input is empty
                        const suggestions = document.getElementById('searchSuggestions');
                        if (suggestions) {
                            suggestions.style.display = 'none';
                        }

                        // Clear search if input is empty
                        if (typeof evacuationSystem !== 'undefined' && evacuationSystem.autoSearch) {
                            evacuationSystem.autoSearch();
                        }
                    }
                });

                // Add focus event listener
                generalSearchInput.addEventListener('focus', function() {
                    if (this.value.length > 0) {
                        const suggestions = document.getElementById('searchSuggestions');
                        if (suggestions) {
                            suggestions.style.display = 'block';
                        }
                    }
                });

                // Add blur event listener to hide suggestions after a delay
                generalSearchInput.addEventListener('blur', function() {
                    setTimeout(() => {
                        const suggestions = document.getElementById('searchSuggestions');
                        if (suggestions) {
                            suggestions.style.display = 'none';
                        }
                    }, 200);
                });

                // Add Enter key handler for immediate search
                generalSearchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        // Trigger immediate search (no debounce)
                        if (typeof evacuationSystem !== 'undefined' && evacuationSystem.searchBarangay) {
                            evacuationSystem.searchBarangay();
                        }
                    }
                });
            }
        });
    </script>
    <script>


       if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('./sw.js')
            .then(() => console.log('✅ Service worker active'))
            .catch(err => console.error('Service worker registration failed:', err));
        }


        // Emergency Hotlines Functions
        function showEmergencyHotlines() {
            const hotlinesDiv = document.getElementById('emergencyHotlines');
            if (hotlinesDiv) {
                const isVisible = hotlinesDiv.style.display !== 'none';
                hotlinesDiv.style.display = isVisible ? 'none' : 'block';
                
                // Add click handlers for hotline numbers
                if (!isVisible) {
                    addHotlineClickHandlers();
                }
            }
        }

        function addHotlineClickHandlers() {
            const hotlineItems = document.querySelectorAll('.hotline-item');
            hotlineItems.forEach(item => {
                item.addEventListener('click', function() {
                    const number = this.querySelector('.hotline-number').textContent;
                    copyToClipboard(number);
                    showHotlineCopied(this);
                });
            });
        }

        function copyToClipboard(text) {
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(() => {
                    console.log('Copied to clipboard:', text);
                });
                } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
            }
        }

        function showHotlineCopied(element) {
            const originalBg = element.style.backgroundColor;
            element.style.backgroundColor = '#d4edda';
            element.style.borderLeftColor = '#28a745';
            
            // Show temporary success message
            const successMsg = document.createElement('div');
            successMsg.innerHTML = '<i class="fas fa-check"></i> Copied!';
            successMsg.style.cssText = 'position: absolute; top: 5px; right: 5px; font-size: 0.8rem; color: #28a745; font-weight: bold;';
            successMsg.className = 'hotline-copied-message';
            
            element.style.position = 'relative';
            element.appendChild(successMsg);
            
            setTimeout(() => {
                element.style.backgroundColor = originalBg;
                element.style.borderLeftColor = '#dc3545';
                const msg = element.querySelector('.hotline-copied-message');
                if (msg) {
                    msg.remove();
                }
            }, 2000);
        }

    </script>
</body>
</html>