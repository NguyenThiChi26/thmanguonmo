<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
class ProductController
{
    private $productModel;
    private $db;
    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    private function isAdmin()
    {
        return SessionHelper::isAdmin();
    }
    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }
    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }
    public function add()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }
    public function save()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }
            $result = $this->productModel->addProduct(
                $name,
                $description,
                $price,
                $category_id,
                $image
            );
            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /Product');
            }
        }
    }
    public function edit($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $editId = $id;
        include 'app/views/product/edit.php';
    }
    public function update()
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }
            $edit = $this->productModel->updateProduct(
                $id,
                $name,
                $description,
                $price,
                $category_id,
                $image
            );
            if ($edit) {
                header('Location: /Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }
    public function delete($id)
    {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }
    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }
    public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image
            ];
        }
        header('Location: /Product/cart');
    }
    public function list()
    {
        $categoryModel = new CategoryModel($this->db);
        $categories = $categoryModel->getCategories();
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function search()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $search = $_GET['search'] ?? '';
            $sort = $_GET['sort'] ?? '';
            $category_id = $_GET['category_id'] ?? null;
            
            $categoryModel = new CategoryModel($this->db);
            $categories = $categoryModel->getCategories();
            $products = $this->productModel->getProducts($search, $sort, $category_id);

            // Trả về HTML để cập nhật giao diện
            ob_start();
            foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm hover-effect">
                        <?php if ($product->image): ?>
                            <div class="product-image-wrapper">
                                <img src="/<?php echo $product->image; ?>"
                                     alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                                     class="card-img-top product-image">
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="/Product/show/<?php echo $product->id; ?>" class="text-dark text-decoration-none">
                                    <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </h5>
                            
                            <p class="card-text text-muted mb-2">
                                <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                            </p>
                            
                            <div class="product-details">
                                <div class="price mb-2">
                                    <strong class="text-primary">
                                        <?php echo number_format($product->price, 0, ',', '.'); ?> VNĐ
                                    </strong>
                                </div>
                                
                                <span class="badge badge-info mb-3">
                                    <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </div>
                        </div>

                        <div class="card-footer bg-white border-top-0">
                            <div class="btn-group d-flex" role="group">
                                <?php if (SessionHelper::isAdmin()): ?>
                                <a href="/Product/edit/<?php echo $product->id; ?>"
                                   class="btn btn-outline-warning btn-sm flex-grow-1">
                                    <i class="fas fa-edit mr-1"></i>Sửa
                                </a>
                                <a href="/Product/delete/<?php echo $product->id; ?>"
                                   class="btn btn-outline-danger btn-sm flex-grow-1"
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    <i class="fas fa-trash-alt mr-1"></i>Xóa
                                </a>
                                <?php endif; ?>
                                <a href="/Product/addToCart/<?php echo $product->id; ?>"
                                   class="btn btn-outline-primary btn-sm flex-grow-1">
                                    <i class="fas fa-cart-plus mr-1"></i>Thêm vào giỏ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
            $html = ob_get_clean();
            echo json_encode(['html' => $html]);
            exit;
        }
    }
    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    public function updateCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? null;
            $change = $_GET['change'] ?? 0;

            if ($id && isset($_SESSION['cart'][$id])) {
                $newQuantity = $_SESSION['cart'][$id]['quantity'] + $change;

                if ($newQuantity > 0) {
                    $_SESSION['cart'][$id]['quantity'] = $newQuantity;
                    echo json_encode(['success' => true]);
                    return;
                } elseif ($newQuantity <= 0) {
                    unset($_SESSION['cart'][$id]);
                    echo json_encode(['success' => true]);
                    return;
                }
            }
            echo json_encode(['success' => false]);
        }
    }

    public function removeFromCart()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_GET['id'] ?? null;

            if ($id && isset($_SESSION['cart'][$id])) {
                unset($_SESSION['cart'][$id]);
                echo json_encode(['success' => true]);
                return;
            }
            echo json_encode(['success' => false]);
        }
    }

    public function checkout()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/checkout.php';
    }
    public function processCheckout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $email = $_POST['email'] ?? '';

            // Kiểm tra giỏ hàng 
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }
            // Bắt đầu giao dịch 
            $this->db->beginTransaction();
            try {
                // Lưu thông tin đơn hàng vào bảng orders
                $query = "INSERT INTO orders (name, phone, address,email) VALUES (:name, 
    :phone, :address, :email)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();
                // Lưu chi tiết đơn hàng vào bảng order_details 
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, 
    quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }
                // Xóa giỏ hàng sau khi đặt hàng thành công 
                unset($_SESSION['cart']);
                // Commit giao dịch 
                $this->db->commit();
                // Chuyển hướng đến trang xác nhận đơn hàng 
                header('Location: /Product/orderConfirmation');
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi 
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }
    public function orderConfirmation()
    {
        include 'app/views/product/orderConfirmation.php';
    }
}
