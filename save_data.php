<?php
// Ensure the directory exists
if (!file_exists('student_data')) {
    mkdir('student_data', 0777, true);
}

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    // Create a filename with timestamp
    $filename = 'student_data/' . date('Y-m-d_H-i-s') . '_' . preg_replace('/[^a-zA-Z0-9]/', '_', $data['name']) . '.json';
    
    // Save the data
    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    
    echo "Data saved successfully.";
} else {
    http_response_code(400);
    echo "Invalid data received.";
}
?>