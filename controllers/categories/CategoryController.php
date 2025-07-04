<?php
require_once(__DIR__ . '/../BaseController.php');
require_once(__DIR__ . '/../../models/category.php');

class CategoryController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllCategories()
    {
        try {
            $categories = category::all($this->mysqli);
            $categories_array = array_map(fn($c) => $c->toArray(), $categories);
            $this->success($categories_array);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function getCategory($id)
    {
        try {
            $category = category::find($this->mysqli, $id);
            if (!$category) {
                throw new Exception("Category not found");
            }
            $this->success($category->toArray());
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function addCategory($data)
    {
        try {
            $required = ['name'];
            foreach ($required as $field) {
                if (!isset($data[$field])) {
                    throw new Exception("Missing required field: $field");
                }
            }
            $category = category::create($this->mysqli, $data);
            $this->success($category->toArray());
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function updateCategory($id, $data)
    {
        try {
            $category = category::update($this->mysqli, $id, $data);
            $this->success($category->toArray());
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function deleteAllCategories()
    {
        try {
            $deleted = category::deleteAll($this->mysqli);
            if ($deleted) {
                $this->success("All categories deleted.");
            } else {
                $this->error("Failed to delete all categories.");
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    public function deleteCategory($id)
    {
        try {
            $deleted = category::delete($this->mysqli, $id);
            if ($deleted) {
                $this->success(["deleted_id" => $id]);
            } else {
                $this->error("Delete failed or category not found.");
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
