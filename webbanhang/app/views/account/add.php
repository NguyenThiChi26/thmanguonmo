<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-4">Thêm người dùng mới</h2>
                    
                    <form action="/Account/save" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text"
                                   class="form-control"
                                   id="username"
                                   name="username"
                                   required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text"
                                   class="form-control"
                                   id="fullname"
                                   name="fullname"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   name="password"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label">Nhập lại mật khẩu</label>
                            <input type="password"
                                   class="form-control"
                                   id="confirmpassword"
                                   name="confirmpassword"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Vai trò</label>
                            <select class="form-select"
                                    id="role"
                                    name="role"
                                    required>
                                <option value="user">Người dùng</option>
                                <option value="admin">Quản trị viên</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/Account" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Thêm người dùng
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 8px;
}

.card-title {
    font-weight: 500;
}

.form-label {
    font-weight: 500;
}
</style>

<?php include 'app/views/shares/footer.php'; ?>