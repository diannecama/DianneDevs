<?php
// Export database data to JSON format for offline evacuation system
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$dbname = 'evacuation_system';
$username = 'root';
$password = '';

try {
    // Try to connect to database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Fetch shelters data
    $sheltersQuery = "SELECT * FROM shelters WHERE is_active = 1";
    $sheltersStmt = $pdo->prepare($sheltersQuery);
    $sheltersStmt->execute();
    $shelters = $sheltersStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Add current occupants (simulated for demo)
    foreach ($shelters as &$shelter) {
        $shelter['current_occupants'] = rand(0, intval($shelter['capacity']) * 0.8);
        $shelter['contact'] = '09' . rand(100000000, 999999999);
        $shelter['facilities'] = [];
        
        // Add facilities based on utilities
        if ($shelter['water_supply'] === 'Available') {
            $shelter['facilities'][] = 'Water';
        }
        if ($shelter['electricity'] === 'Available') {
            $shelter['facilities'][] = 'Electricity';
        }
        if ($shelter['building_condition'] === 'Good') {
            $shelter['facilities'][] = 'Medical';
        }
    }
    
    // Fetch current location data
    $locationQuery = "SELECT * FROM mycurrentlocation ORDER BY created_at DESC LIMIT 1";
    $locationStmt = $pdo->prepare($locationQuery);
    $locationStmt->execute();
    $currentLocation = $locationStmt->fetch(PDO::FETCH_ASSOC);
    
    // Create sample routes based on shelters
    $routes = [];
    if (count($shelters) > 0) {
        for ($i = 0; $i < min(3, count($shelters)); $i++) {
            $shelter = $shelters[$i];
            $routes[] = [
                'id' => $i + 1,
                'route_name' => "Route to " . $shelter['barangay'],
                'is_safe' => $shelter['is_safe_shelter'] == 1,
                'risk_level' => $shelter['is_safe_shelter'] == 1 ? 'low' : 'high',
                'distance' => rand(5, 25) / 10, // 0.5 to 2.5 km
                'estimated_time' => rand(10, 30),
                'path_coordinates' => json_encode([
                    [$currentLocation['latitude'], $currentLocation['longitude']],
                    [$shelter['latitude'], $shelter['longitude']]
                ])
            ];
        }
    }
    
    // Create danger zones based on hazard zones
    $dangerZones = [];
    $zoneId = 1;
    foreach ($shelters as $shelter) {
        if ($shelter['typhoon_zone'] === 'Yes' || $shelter['flood_zone'] === 'Yes' || 
            $shelter['landslide_zone'] === 'Yes' || $shelter['storm_surge_zone'] === 'Yes') {
            
            $zoneTypes = [];
            if ($shelter['typhoon_zone'] === 'Yes') $zoneTypes[] = 'Typhoon';
            if ($shelter['flood_zone'] === 'Yes') $zoneTypes[] = 'Flood';
            if ($shelter['landslide_zone'] === 'Yes') $zoneTypes[] = 'Landslide';
            if ($shelter['storm_surge_zone'] === 'Yes') $zoneTypes[] = 'Storm Surge';
            
            $dangerZones[] = [
                'id' => $zoneId++,
                'name' => $shelter['barangay'] . ' Hazard Zone',
                'type' => implode(', ', $zoneTypes),
                'risk_level' => 'High',
                'description' => 'Area prone to ' . strtolower(implode(', ', $zoneTypes)),
                'coordinates' => json_encode([
                    [$shelter['latitude'] - 0.001, $shelter['longitude'] - 0.001],
                    [$shelter['latitude'] + 0.001, $shelter['longitude'] - 0.001],
                    [$shelter['latitude'] + 0.001, $shelter['longitude'] + 0.001],
                    [$shelter['latitude'] - 0.001, $shelter['longitude'] + 0.001]
                ])
            ];
        }
    }
    
    // Create barangay data
    $barangays = [];
    $barangayNames = array_unique(array_column($shelters, 'barangay'));
    foreach ($barangayNames as $index => $barangayName) {
        $barangayShelters = array_filter($shelters, function($s) use ($barangayName) {
            return $s['barangay'] === $barangayName;
        });
        
        $barangays[] = [
            'id' => $index + 1,
            'name' => $barangayName,
            'population' => rand(1000, 5000),
            'shelter_count' => count($barangayShelters),
            'risk_level' => rand(0, 1) ? 'Low' : 'Medium'
        ];
    }
    
    // Prepare response
    $response = [
        'shelters' => $shelters,
        'routes' => $routes,
        'dangerZones' => $dangerZones,
        'barangays' => $barangays,
        'currentLocation' => $currentLocation,
        'exportDate' => date('Y-m-d H:i:s'),
        'version' => '1.0',
        'totalShelters' => count($shelters),
        'totalRoutes' => count($routes),
        'totalDangerZones' => count($dangerZones),
        'totalBarangays' => count($barangays)
    ];
    
    echo json_encode($response, JSON_PRETTY_PRINT);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database connection failed',
        'message' => $e->getMessage(),
        'fallback' => true
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
        'message' => $e->getMessage(),
        'fallback' => true
    ]);
}
?>
