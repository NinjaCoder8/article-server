<?php

require_once(__DIR__ . '/../BaseController.php');
require_once(__DIR__ . '/../models/Article.php');

class ArticleController
{

    public function getAllArticles()
    {
        global $mysqli;
        try {
            $articles = Article::all($mysqli);
            $articles_array = ArticleService::articlesToArray($articles);
            echo ResponseService::success_response($articles_array);
        } catch (Exception $e) {
            echo ResponseService::error_response($e->getMessage());
        }
    }

    public function getArticle($id)
    {
        global $mysqli;
        try {
            $article = Article::find($mysqli, $id);
            if (!$article) {
                throw new Exception("Article not found");
            }
            echo ResponseService::success_response($article->toArray());
        } catch (Exception $e) {
            echo ResponseService::error_response($e->getMessage());
        }
    }

    public function addArticle($data)
    {
        global $mysqli;
        try {
            $required = ['name', 'author', 'description'];
            foreach ($required as $field) {
                if (!isset($data[$field])) {
                    throw new Exception("Missing required field: $field");
                }
            }
            $article = Article::create($mysqli, $data);
            echo ResponseService::success_response($article->toArray());
        } catch (Exception $e) {
            echo ResponseService::error_response($e->getMessage());
        }
    }

    public function updateArticle($id, $data)
    {
        global $mysqli;
        try {
            $article = Article::update($mysqli, $id, $data);
            echo ResponseService::success_response($article->toArray());
        } catch (Exception $e) {
            echo ResponseService::error_response($e->getMessage());
        }
    }

    public function deleteAllArticles()
    {
        global $mysqli;
        try {
            $deleted = Article::deleteAll($mysqli);
            if ($deleted) {
                echo ResponseService::success_response("All articles deleted.");
            } else {
                echo ResponseService::error_response("Failed to delete all articles.");
            }
        } catch (Exception $e) {
            echo ResponseService::error_response($e->getMessage());
        }
    }

    public function deleteArticle($id)
    {
        global $mysqli;
        try {
            $deleted = Article::delete($mysqli, $id);
            if ($deleted) {
                echo ResponseService::success_response(["deleted_id" => $id]);
            } else {
                echo ResponseService::error_response("Delete failed or article not found.");
            }
        } catch (Exception $e) {
            echo ResponseService::error_response($e->getMessage());
        }
    }
}

//To-Do:

//1- Try/Catch in controllers ONLY!!!  //done
//2- Find a way to remove the hard coded response code (from ResponseService.php) // done
//3- Include the routes file (api.php) in the (index.php) -- In other words, seperate the routing from the index (which is the engine) // done
//4- Create a BaseController and clean some imports 