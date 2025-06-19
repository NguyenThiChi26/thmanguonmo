<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 py-4">
                    <h1 class="h3 mb-0">
                        <i class="fas fa-shopping-cart mr-2"></i>Giỏ hàng
                        <?php if (!empty($cart)): ?>
                            <span class="badge badge-primary badge-pill ml-2"><?php echo count($cart); ?></span>
                        <?php endif; ?>
                    </h1>
                </div>

                <div class="card-body p-4">
                    <?php if (!empty($cart)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover shopping-cart-table">
                                <thead>
                                    <tr>
                                        <th scope="col" width="60%">Sản phẩm</th>
                                        <th scope="col" class="text-center">Số lượng</th>
                                        <th scope="col" class="text-center">Giá</th>
                                        <th scope="col" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0;
                                    foreach ($cart as $id => $item): 
                                        $itemTotal = $item['price'] * $item['quantity'];
                                        $total += $itemTotal;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($item['image']): ?>
                                                        <div class="cart-image-wrapper mr-3">
                                                            <img src="/<?php echo $item['image']; ?>" 
                                                                 alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>" 
                                                                 class="cart-image">
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h5 class="mb-1">
                                                            <?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                                                        </h5>
                                                        <span class="text-muted mb-1">
                                                            <?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="quantity-control">
                                                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?php echo $id; ?>, -1)">-</button>
                                                    <span class="mx-2"><?php echo $item['quantity']; ?></span>
                                                    <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(<?php echo $id; ?>, 1)">+</button>
                                                </div>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                <?php echo number_format($itemTotal, 0, ',', '.'); ?> VNĐ
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-danger btn-sm" onclick="removeItem(<?php echo $id; ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right font-weight-bold">Tổng cộng:</td>
                                        <td class="text-right text-primary h5">
                                            <?php echo number_format($total, 0, ',', '.'); ?> VNĐ
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="/Product" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left mr-2"></i>Tiếp tục mua sắm
                            </a>
                            <a href="/Product/checkout" class="btn btn-primary">
                                Thanh toán<i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>

                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                            <h3 class="h4 mb-3">Giỏ hàng của bạn đang trống</h3>
                            <p class="text-muted mb-4">Hãy thêm sản phẩm vào giỏ hàng để tiến hành mua sắm.</p>
                            <a href="/Product" class="btn btn-primary">
                                <i class="fas fa-shopping-bag mr-2"></i>Mua sắm ngay
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.shopping-cart-table th {
    font-weight: 500;
    border-top: none;
}

.cart-image-wrapper {
    width: 80px;
    height: 80px;
    overflow: hidden;
    border-radius: 8px;
}

.cart-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.quantity-control {
    display: inline-flex;
    align-items: center;
}

.quantity-control button {
    width: 30px;
    height: 30px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .shopping-cart-table {
        font-size: 0.9rem;
    }

    .cart-image-wrapper {
        width: 60px;
        height: 60px;
    }
}
</style>

<script>
function updateQuantity(productId, change) {
    fetch(`/Product/updateCart?id=${productId}&change=${change}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Không thể cập nhật số lượng sản phẩm');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi khi cập nhật giỏ hàng');
    });
}

function removeItem(productId) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        fetch(`/Product/removeFromCart?id=${productId}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Không thể xóa sản phẩm khỏi giỏ hàng');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi khi xóa sản phẩm khỏi giỏ hàng');
        });
    }
}
</script>

<?php include 'app/views/shares/footer.php'; ?>