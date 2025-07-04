<?php
require_once __DIR__ . '/models/category.php';
require_once __DIR__ . '/services/ResponseService.php';
require_once __DIR__ . '/connection/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['article_id'])) {
    $article_id = intval($_GET['article_id']);
    global $mysqli;
    try {
        $category = category::findByArticle($mysqli, $article_id);
        if ($category) {
            echo ResponseService::success_response($category->toArray());
        } else {
            echo ResponseService::error_response('Category not found for this article');
        }
    } catch (Exception $e) {
        echo ResponseService::error_response($e->getMessage());
    }
} else {
    echo ResponseService::error_response('article_id is required');
}
