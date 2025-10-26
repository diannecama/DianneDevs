<?php
/**
 * Export Shelters Data to JSON
 * This script exports all shelter data from the database to a JSON file
 * for offline use in the evacuation system
 */

require_once 'app/Db.php';

try {
    $db = Db::getConnection();
    
    // Get all active shelters
    $stmt = $db->prepare("
        SELECT 
            shelter_id, barangay, owner_name, capacity,
            typhoon_zone, flood_zone, landslide_zone, liquefaction_zone,
            elevation, latitude, longitude,
            building_material_type, building_condition,
            water_supply, electricity, road_condition,
            estimated_travel_time, near_main_road, is_safe_shelter, is_active,
            created_at, updated_at
        FROM shelters 
        WHERE is_active = 1
        ORDER BY barangay, owner_name
    ");
    $stmt->execute();
    $shelters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get danger zones if they exist
    $dangerZones = [];
    try {
        $stmt = $db->prepare("SELECT * FROM danger_zones WHERE is_active = 1");
        $stmt->execute();
        $dangerZones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Danger zones table might not exist yet
        $dangerZones = [];
    }
    
    // Prepare the data structure
    $exportData = [
        'timestamp' => date('Y-m-d H:i:s'),
        'version' => '1.0',
        'shelters' => $shelters,
        'danger_zones' => $dangerZones,
        'total_shelters' => count($shelters),
        'total_danger_zones' => count($dangerZones)
    ];
    
    // Export to JSON file
    $jsonData = json_encode($exportData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents('data/shelters_offline.json', $jsonData);
    
    // Also create a minified version for faster loading
    $minifiedData = json_encode($exportData, JSON_UNESCAPED_UNICODE);
    file_put_contents('data/shelters_offline.min.json', $minifiedData);
    
    echo "✅ Successfully exported shelter data to JSON files:\n";
    echo "📁 data/shelters_offline.json (formatted)\n";
    echo "📁 data/shelters_offline.min.json (minified)\n";
    echo "📊 Total shelters: " . count($shelters) . "\n";
    echo "⚠️  Total danger zones: " . count($dangerZones) . "\n";
    echo "🕒 Export time: " . date('Y-m-d H:i:s') . "\n";
    
} catch (Exception $e) {
    echo "❌ Error exporting data: " . $e->getMessage() . "\n";
}
?>
