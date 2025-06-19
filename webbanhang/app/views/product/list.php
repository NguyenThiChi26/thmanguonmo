<?php include 'app/views/shares/header.php'; ?>
<h1 class="text-primary mb-4">Danh sách sản phẩm</h1>
<div class="row mb-3">
    <div class="col-md-6">
        <form id="search-form" class="input-group">
            <input type="text" id="search-input" class="form-control" placeholder="Tìm kiếm sản phẩm...">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
    <div class="col-md-6 text-right">
        <a href="/Product/add" class="btn btn-success">Thêm sản phẩm mới</a>
    </div>
</div>

<div class="row" id="product-list">
    <!-- Danh sách sản phẩm sẽ được tải từ API và hiển thị tại đây -->
</div>
<?php include 'app/views/shares/footer.php'; ?>
<style>
    #product-list .card {
        background: linear-gradient(135deg, #f8fafc 60%, #e0e7ff 100%);
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(60, 72, 88, 0.12);
        transition: transform 0.2s, box-shadow 0.2s;
        border: none;
    }

    #product-list .card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 8px 32px rgba(60, 72, 88, 0.18);
    }

    #product-list .card-img-top {
        border-top-left-radius: 18px;
        border-top-right-radius: 18px;
        width: 100%;
        height: 240px;
        object-fit: contain; /* Sửa từ cover thành contain để hiển thị toàn bộ hình ảnh */
        background: #fff;
        background-color: #fff;
        display: block;
        padding: 10px; /* Thêm padding để hình ảnh không bị dính sát viền */
    }

    #product-list .card-title a {
        color: #2d3a4a;
        font-weight: bold;
    }

    #product-list .card-title a:hover {
        color: #4f46e5;
        text-decoration: underline;
    }

    #product-list .card-footer {
        background: #f1f5f9;
        border-top: 1px solid #e0e7ff;
        border-bottom-left-radius: 18px;
        border-bottom-right-radius: 18px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    #product-list .btn-warning {
        background: #fbbf24;
        border: none;
        color: #fff;
    }

    #product-list .btn-warning:hover {
        background: #f59e42;
        color: #fff;
    }

    #product-list .btn-danger {
        background: #ef4444;
        border: none;
        color: #fff;
    }

    #product-list .btn-danger:hover {
        background: #dc2626;
        color: #fff;
    }
</style>
<script>
    let allProducts = [];

    function renderProducts(products) {
        const productList = document.getElementById('product-list');
        productList.innerHTML = '';
        if (products.length === 0) {
            productList.innerHTML = '<div class="col-12 text-center text-muted py-5">Không tìm thấy sản phẩm phù hợp.</div>';
            return;
        }
        products.forEach(product => {
            const productItem = document.createElement('div');
            productItem.className = 'col-md-4 mb-4';
            productItem.innerHTML = `
                <div class="card h-100">
                    <img src="${product.image ? '/' + product.image : '/uploads/default-product.jpg'}"
                        class="card-img-top" alt="${product.name}">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="/Product/show/${product.id}" class="text-decoration-none">
                                ${product.name}
                            </a>
                        </h5>
                        <p class="card-text text-truncate">${product.description}</p>
                        <p class="card-text">
                            <strong>Giá:</strong> ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(product.price)}
                        </p>
                        <p class="card-text"><small class="text-muted">Danh mục: ${product.category_name}</small></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <a href="/Product/edit/${product.id}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <button class="btn btn-danger btn-sm" onclick="deleteProduct(${product.id})">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </div>
                </div>
            `;
            productList.appendChild(productItem);
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        fetch('/api/product')
            .then(response => response.json())
            .then(data => {
                allProducts = data;
                renderProducts(allProducts);
            });

        document.getElementById('search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const keyword = document.getElementById('search-input').value.trim().toLowerCase();
            const filtered = allProducts.filter(product =>
                product.name.toLowerCase().includes(keyword) ||
                (product.description && product.description.toLowerCase().includes(keyword)) ||
                (product.category_name && product.category_name.toLowerCase().includes(keyword))
            );
            renderProducts(filtered);
        });
    });

    function deleteProduct(id) {
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
            fetch(`/api/product/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message && data.message.includes('success')) {
                        location.reload();
                    } else {
                        alert('Xóa sản phẩm thất bại');
                    }
                });
        }
    }
</script>