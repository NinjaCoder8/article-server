<?php
require_once __DIR__ . '/models/Article.php';
require_once __DIR__ . '/services/ResponseService.php';
require_once __DIR__ . '/connection/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);
    global $mysqli;
    try {
        $articles = Article::findByCategory($mysqli, $category_id);
        $articles_array = array_map(fn($a) => $a->toArray(), $articles);
        echo ResponseService::success_response($articles_array);
    } catch (Exception $e) {
        echo ResponseService::error_response($e->getMessage());
    }
} else {
    echo ResponseService::error_response('category_id is required');
}
