<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-4">
                    <h4 class="mb-0">
                        <i class="fas fa-user mr-2"></i>Thông tin thanh toán
                    </h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="/Product/processCheckout" id="checkoutForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập họ tên của bạn
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       pattern="[0-9]{10}" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập số điện thoại hợp lệ
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">
                                Vui lòng nhập email hợp lệ
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ giao hàng</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Vui lòng nhập địa chỉ giao hàng
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="/Product/cart" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left mr-2"></i>Quay lại giỏ hàng
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Xác nhận đặt hàng<i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-4">
                    <h4 class="mb-0">
                        <i class="fas fa-shopping-cart mr-2"></i>Đơn hàng của bạn
                    </h4>
                </div>
                <div class="card-body p-4">
                    <?php if (!empty($cart)): ?>
                        <div class="order-summary">
                            <?php 
                            $total = 0;
                            foreach ($cart as $item): 
                                $itemTotal = $item['price'] * $item['quantity'];
                                $total += $itemTotal;
                            ?>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h6 class="mb-0"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h6>
                                        <small class="text-muted">Số lượng: <?php echo $item['quantity']; ?></small>
                                    </div>
                                    <span class="text-dark">
                                        <?php echo number_format($itemTotal, 0, ',', '.'); ?> VNĐ
                                    </span>
                                </div>
                            <?php endforeach; ?>

                            <hr>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Tạm tính</span>
                                <span><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Phí vận chuyển</span>
                                <span>30.000 VNĐ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="h5">Tổng cộng</span>
                                <span class="h5 text-primary">
                                    <?php echo number_format($total + 30000, 0, ',', '.'); ?> VNĐ
                                </span>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-center mb-0">Không có sản phẩm trong giỏ hàng</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.form-control {
    padding: 0.75rem;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

.payment-methods {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 1rem;
}

.payment-methods .form-check {
    padding: 0.5rem 1.75rem;
}

.payment-methods .form-check:hover {
    background-color: #f8f9fa;
    border-radius: 4px;
    cursor: pointer;
}

.order-summary {
    font-size: 0.95rem;
}

.order-summary h6 {
    font-weight: 500;
}

@media (max-width: 768px) {
    .container {
        padding: 1rem;
    }
}
</style>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>

<?php include 'app/views/shares/footer.php'; ?>