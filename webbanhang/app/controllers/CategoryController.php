<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }
    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        include 'app/views/category/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (!empty($name)) {
                if ($this->categoryModel->create($name, $description)) {
                    header('Location: /Category');
                    exit;
                }
            }
            include 'app/views/category/add.php';
        }
    }

    public function edit($id)
    {
        $editId = $id;
        include 'app/views/category/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (!empty($id) && !empty($name)) {
                if ($this->categoryModel->update($id, $name, $description)) {
                    header('Location: /Category');
                    exit;
                }
            }
            echo "Đã xảy ra lỗi khi cập nhật danh mục.";
        }
    }

    public function delete($id)
    {
        if ($this->categoryModel->delete($id)) {
            header('Location: /Category');
            exit;
        } else {
            echo "Đã xảy ra lỗi khi xóa danh mục.";
        }
    }
}
