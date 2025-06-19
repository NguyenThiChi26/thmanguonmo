<?php include 'app/views/shares/header.php'; ?>
<h1>Sửa sản phẩm</h1>
<form id="edit-product-form" enctype="multipart/form-data">
    <input type="hidden" id="id" name="id">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control"
            required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01"
            required>
    </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <!-- Các danh mục sẽ được tải từ API và hiển thị tại đây -->
        </select>
    </div>
    <div class="form-group">
        <label for="image">Hình ảnh sản phẩm:</label>
        <input type="file" id="image" name="image" class="form-control" accept="image/*">
        <small class="form-text text-muted">Chọn file ảnh mới (JPG, PNG, GIF) hoặc giữ nguyên ảnh cũ</small>
        <div id="current-image" class="mt-2" style="display: none;">
            <p>Ảnh hiện tại:</p>
            <img src="" alt="Current product image" style="max-width: 200px; max-height: 200px;">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>
<a href="/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
<?php include 'app/views/shares/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // const urlParams = new URLSearchParams(window.location.search); 
        const productId = <?= $editId ?>;
        fetch(`/api/product/${productId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('id').value = data.id;
                document.getElementById('name').value = data.name;
                document.getElementById('description').value = data.description;
                document.getElementById('price').value = data.price;
                document.getElementById('category_id').value = data.category_id;
                
                // Hiển thị ảnh hiện tại nếu có
                if (data.image) {
                    const currentImageDiv = document.getElementById('current-image');
                    currentImageDiv.style.display = 'block';
                    currentImageDiv.querySelector('img').src = '/' + data.image;
                }
            });
        fetch('/api/category')
            .then(response => response.json())
            .then(data => {
                const categorySelect = document.getElementById('category_id');
                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            });
        document.getElementById('edit-product-form').addEventListener('submit',
            function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                const productId = formData.get('id');
                const data = {
                    name: formData.get('name'),
                    description: formData.get('description'),
                    price: formData.get('price'),
                    category_id: formData.get('category_id')
                };

                fetch(`/api/product/${productId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.errors) {
                            let errorMessage = 'Lỗi:\n';
                            for (const [field, msg] of Object.entries(data.errors)) {
                                errorMessage += `- ${msg}\n`;
                            }
                            alert(errorMessage);
                        } else if (data.message && data.message.includes('success')) {
                            location.href = '/Product';
                        } else {
                            alert('Cập nhật sản phẩm thất bại');
                        }
                    });
            });
    });
</script>