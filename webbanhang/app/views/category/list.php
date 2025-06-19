<?php include 'app/views/shares/header.php'; ?>
<h1 class="mb-4 text-gradient">Danh sách danh mục</h1>
<div class="row mb-3">
    <div class="col">
        <a href="/Category/add" class="btn btn-gradient">
            <i class="fas fa-plus"></i> Thêm danh mục mới
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table custom-table align-middle">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên danh mục</th>
                <th scope="col">Mô tả</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody id="category-list">
            <!-- Danh sách danh mục sẽ được tải từ API và hiển thị tại đây -->
        </tbody>
    </table>
</div>

<?php include 'app/views/shares/footer.php'; ?>
<style>
    .text-gradient {
        background: linear-gradient(90deg, #0ea5e9 0%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
        letter-spacing: 1px;
    }
    .btn-gradient {
        background: linear-gradient(90deg, #fbbf24 0%, #f59e42 100%);
        color: #fff;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(251,191,36,0.10);
        transition: background 0.3s, box-shadow 0.3s;
    }
    .btn-gradient:hover {
        background: linear-gradient(90deg, #f59e42 0%, #fbbf24 100%);
        color: #fff;
        box-shadow: 0 4px 16px rgba(251,191,36,0.18);
    }
    .custom-table {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(56,189,248,0.10);
    }
    .custom-table thead {
        background: linear-gradient(90deg, #38bdf8 0%, #818cf8 100%);
        color: #fff;
        font-weight: 700;
        border: none;
    }
    .custom-table th, .custom-table td {
        border: none !important;
        vertical-align: middle;
        font-size: 1.05rem;
    }
    .custom-table tbody tr {
        transition: background 0.2s;
    }
    .custom-table tbody tr:hover {
        background: #f0fdfa;
    }
    .btn-warning {
        background: linear-gradient(90deg, #fbbf24 0%, #f59e42 100%) !important;
        color: #fff !important;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: background 0.3s;
    }
    .btn-warning:hover {
        background: linear-gradient(90deg, #f59e42 0%, #fbbf24 100%) !important;
        color: #fff !important;
    }
    .btn-danger {
        background: linear-gradient(90deg, #ef4444 0%, #f87171 100%) !important;
        color: #fff !important;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        transition: background 0.3s;
    }
    .btn-danger:hover {
        background: linear-gradient(90deg, #f87171 0%, #ef4444 100%) !important;
        color: #fff !important;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('/api/category')
            .then(response => response.json())
            .then(data => {
                const categoryList = document.getElementById('category-list');
                data.forEach((category, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><span class="badge badge-pill badge-info" style="font-size:1rem;background:linear-gradient(90deg,#38bdf8,#818cf8);color:#fff;">${index + 1}</span></td>
                        <td style="font-weight:600;color:#2563eb;">${category.name}</td>
                        <td style="color:#64748b;">${category.description}</td>
                        <td>
                            <a href="/Category/edit/${category.id}" class="btn btn-warning btn-sm mr-1">
                                <i class="fas fa-edit"></i> Sửa
                            </a>
                            <button class="btn btn-danger btn-sm" onclick="deleteCategory(${category.id})">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </td>
                    `;
                    categoryList.appendChild(row);
                });
            });
    });

    function deleteCategory(id) {
        if (confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
            fetch(`/api/category/${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message && data.message.includes('success')) {
                        location.reload();
                    } else {
                        alert('Xóa danh mục thất bại');
                    }
                });
        }
    }
</script>