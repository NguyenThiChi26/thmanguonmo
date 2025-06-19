<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <?php if ($product): ?>
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0">
                <li class="breadcrumb-item"><a href="/Product/list" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></li>
            </ol>
        </nav>

        <div class="card border-0 shadow-lg">
            <div class="row g-0">
                <div class="col-md-6">
                    <div class="product-image-container">
                        <?php if ($product->image): ?>
                            <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                                class="product-detail-image"
                                alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php else: ?>
                            <img src="/images/no-image.png"
                                class="product-detail-image"
                                alt="Không có ảnh">
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card-body p-4 p-lg-5">
                        <span class="badge bg-primary text-white mb-3 category-badge">
                            <?php echo !empty($product->category_name) ?
                                htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa có danh mục';
                            ?>
                        </span>

                        <h1 class="product-title mb-3">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </h1>

                        <div class="price-tag mb-4">
                            <?php echo number_format($product->price, 0, ',', '.'); ?> <span class="currency">VNĐ</span>
                        </div>

                        <div class="product-description mb-4">
                            <h5 class="description-title">Mô tả sản phẩm</h5>
                            <p class="text-muted">
                                <?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?>
                            </p>
                        </div>

                        <div class="product-actions">
                            <button onclick="window.location.href='/Product/addToCart/<?php echo $product->id; ?>'" 
                                    class="btn btn-primary btn-md add-to-cart-btn ml-3">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Thêm vào giỏ hàng
                            </button>
                            <a href="/Product/list" class="btn btn-outline-secondary btn-lg ml-3">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Quay lại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger text-center p-5 mt-4">
            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
            <h4>Không tìm thấy sản phẩm!</h4>
            <p class="mb-0">Sản phẩm này có thể đã bị xóa hoặc không tồn tại.</p>
            <a href="/Product/list" class="btn btn-outline-danger mt-3">Quay lại danh sách sản phẩm</a>
        </div>
    <?php endif; ?>
</div>

<style>
.product-image-container {
    height: 500px;
    overflow: hidden;
    position: relative;
}

.product-detail-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}

.product-detail-image:hover {
    transform: scale(1.05);
}

.category-badge {
    font-size: 0.9rem;
    padding: 0.5em 1em;
    border-radius: 20px;
    background-color: #3498db !important;
}

.product-title {
    font-size: 2rem;
    font-weight: 600;
    color: #2c3e50;
}

.price-tag {
    font-size: 2.5rem;
    font-weight: 700;
    color: #e74c3c;
}

.currency {
    font-size: 1.5rem;
    font-weight: 500;
}

.description-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.product-description p {
    line-height: 1.8;
    font-size: 1rem;
}

.add-to-cart-btn {
    padding: 1rem 2rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.breadcrumb {
    font-size: 0.9rem;
}

.breadcrumb-item a {
    color: #3498db;
}

.breadcrumb-item.active {
    color: #7f8c8d;
}
</style>

<?php include 'app/views/shares/footer.php'; ?>