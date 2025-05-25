<?php
header('Content-Type: application/json');

session_start();

if (!isset($_SESSION['chart_data'])) {
    $_SESSION['chart_data'] = [
        'labels' => ["January", "February", "March", "April", "May"],
        'data' => [10, 20, 15, 25, 30]
    ];
}

$input = json_decode(file_get_contents('php://input'), true);

$label = $input['label'] ?? '';
$value = $input['value'] ?? null;

$response = ['success' => false, 'message' => ''];

if (empty($label) || !is_numeric($value)) {
    $response['message'] = 'Label and Value are required and Value must be numeric.';
} else {
    $_SESSION['chart_data']['labels'][] = $label;
    $_SESSION['chart_data']['data'][] = (float)$value;

    $response['success'] = true;
    $response['labels'] = $_SESSION['chart_data']['labels'];
    $response['data'] = $_SESSION['chart_data']['data'];
    $response['message'] = 'Data added successfully.';
}

echo json_encode($response);
?>
