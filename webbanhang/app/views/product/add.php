<?php include 'app/views/shares/header.php'; ?>

<h1>Thêm sản phẩm mới</h1>
<form id="add-product-form" enctype="multipart/form-data">
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
        <small class="form-text text-muted">Chọn file ảnh (JPG, PNG, GIF)</small>
    </div>
    <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
</form>
<a href="/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách
    sản phẩm</a>
<?php include 'app/views/shares/footer.php'; ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
        document.getElementById('add-product-form').addEventListener('submit',
            function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch('/api/product', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(text => {
                        console.log('Raw response:', text); // Log the raw response text 
                        try {
                            const data = text;
                            if (data.message && data.message.includes('success')) {
                                location.href = '/Product';
                            } else {
                                alert('Thêm sản phẩm thất bại');
                            }
                        } catch (error) {
                            console.error('Error parsing JSON:', error);
                            alert('Lỗi: Không thể phân tích JSON từ phản hồi của máy chủ.');
                        }
                    });
            });
    });
</script>