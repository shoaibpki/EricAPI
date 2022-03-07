<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once('../config/Database.php');
require_once('../api/controller/ApiController.php');

$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$service = new Service($db);

// route for show all services
$app->get('/service/read', function () use ($service) {

    //  query
    $result = $service->read();

    // Get rows count
    $num = $result->rowCount();

    // check if any service
    if ($num > 0) {
        $service_arr = [];
        $service_arr['data'] = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $service_item = [
                'id' => $id,
                'ref' => $ref,
                'centre' => $centre,
                'services' => $services,
                'countrycode' => $countrycode
            ];

            // push to "data"
            array_push($service_arr['data'], $service_item);
        }

        // Turn to JSON & output
        echo json_encode($service_arr['data']);
    } else {
        echo json_encode([
            'msg' => 'Service not found'
        ]);
    }
});

// route for show specific service
$app->get('/service/read/{cc}', function ($request) use ($service) {

    // Get id
    $service->countryCode = $request->getAttribute('cc');

    // get service
    $result = $service->read_single();

    // Get rows count
    $num = $result->rowCount();

    // check if any service
    if ($num > 0) {
        $service_arr = [];
        $service_arr['data'] = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $service_item = [
                'id' => $id,
                'ref' => $ref,
                'centre' => $centre,
                'services' => $services,
                'countrycode' => $countrycode
            ];

            // push to "data"
            array_push($service_arr['data'], $service_item);
        }
        // Turn to JSON & output
        echo json_encode($service_arr['data']);
    } else {
        echo json_encode([
            'msg' => 'Service not found'
        ]);
    }
});

// route for Add service 
$app->post('/service/add', function ($request) use ($service) {

    $service->ref = $request->getParam('ref');
    $service->centre = $request->getParam('centre');
    $service->services = $request->getParam('services');
    $service->countryCode = $request->getParam('countrycode');

    if ($service->create()) {
        echo json_encode([
            'msg' => 'Post Created'
        ]);
    } else {
        echo json_encode([
            'msg' => 'Post not Created'
        ]);
    }
});

// route for update specific service
$app->put('/service/update/{ref}', function ($request) use ($service) {
    // Get ref
    $service->ref = $request->getAttribute('ref');

    // set properties
    $service->centre = $request->getParam('centre');
    $service->services = $request->getParam('services');
    $service->countryCode = $request->getParam('countrycode');

    if ($service->update()) {
        echo json_encode([
            'msg' => 'Service Updated'
        ]);
    } else {
        echo json_encode([
            'msg' => 'Service not Updated'
        ]);
    }
});
