<?php
// Force Error Display (turn off if not testing)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Add Library
require 'library/Slim/Slim.php';
foreach(glob('library/AvGen/*.php') as $file) {
    require_once($file);
}

// Start Avatar Classes
$_POST['avatar']    = new Avatar();
$_POST['item']      = new AvatarItem();
$_POST['avatar']->setDB($database);
$_POST['item']->setDB($database);


/**
 * Creates basic fail/success
 * @param $success
 */
function successBool($success) {
    if($success) {
        //http_response_code(200);
        echo("true");
    } else {
        //http_response_code(500);
        echo("false");
    }
}

/**
*   Initiate Slim Framework
**/
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
    'log.enable' => true,
    'log.path' => './logs',
    'log.level' => \Slim\Log::DEBUG,
    //'view' => 'MyCustomViewClassName'
));

// Home Route
$app->get('/', function () {
    $home = file_get_contents("templates/html/avatar.html");
    echo($home);
});

/*
 * User Avatar Commands
 */
// Refresh Avatar Image
$app->get('/avatar/:user', function ($userId) {
    successBool($_POST['avatar']->refreshAvatar($userId));
});

// Add an Item
$app->get('/avatar/:user/add/:item', function ($userId, $itemId) {
    $_POST['item']->addItem($userId, $itemId);
    successBool($_POST['avatar']->refreshAvatar($userId));
});

// Remove All Items
$app->get('/avatar/:user/remove', function ($userId) {
    $_POST['item']->removeItemsByUser($userId);
    successBool($_POST['avatar']->refreshAvatar($userId));
});

// Remove Item
$app->get('/avatar/:user/remove/:item', function ($userId, $itemId) {
    $_POST['item']->removeItem($itemId);
    successBool($_POST['avatar']->refreshAvatar($userId));
});

/*
 * Item Commands
 */
// Items By Group
$app->get('/items/:group', function ($group) use ($app) {
    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', 'application/json');
    echo(json_encode($_POST['item']->getItemsByGroup($group)));
});
$app->get('/items/:group/user/:user', function ($group, $user) use ($app) {
    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', 'application/json');
    echo(json_encode($_POST['item']->getItemsByGroup($group, $user)));
});

// Items By User (w/ removable items)
$app->get('/items/u/:id', function ($userId) use ($app) {
    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', 'application/json');
    echo(json_encode($_POST['item']->getItemsByUser($userId, true)));
});

// Items By User (w/o removable items)
$app->get('/items/user/:id', function ($userId) use ($app) {
    $app->response->setStatus(200);
    $app->response->headers->set('Content-Type', 'application/json');
    echo(json_encode($_POST['item']->getItemsByUser($userId)));
});

$app->run();

/**
 * Resource Manual
 */
/*
// GET route
$app->get('/', function () {
    echo 'This is a GET route';
});

// POST route
$app->post('/post', function () {
    echo 'This is a POST route';
});

// PUT route
$app->put('/put', function () {
    echo 'This is a PUT route';
});

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete('/delete', function () {
    echo 'This is a DELETE route';
});
*/