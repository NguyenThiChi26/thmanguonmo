<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="card-title mb-4">Thông tin người dùng</h2>

                    <form action="/Account/update" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text"
                                class="form-control"
                                value="<?php echo htmlspecialchars($account->username, ENT_QUOTES, 'UTF-8'); ?>"
                                disabled>
                            <input type="hidden" name="username" value="<?php echo htmlspecialchars($account->username, ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text"
                                class="form-control"
                                id="fullname"
                                name="fullname"
                                value="<?php echo htmlspecialchars($account->fullname, ENT_QUOTES, 'UTF-8'); ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu mới</label>
                            <input type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                placeholder="Nhập để thay đổi mật khẩu">
                        </div>

                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label">Nhập lại mật khẩu mới</label>
                            <input type="password"
                                class="form-control"
                                id="confirmpassword"
                                name="confirmpassword"
                                placeholder="Xác nhận mật khẩu mới">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?php echo htmlspecialchars($account->email ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel"
                                class="form-control"
                                id="phone"
                                name="phone"
                                value="<?php echo htmlspecialchars($account->phone ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control"
                                id="address"
                                name="address"
                                rows="2"><?php echo htmlspecialchars($account->address ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                        </div>
                        <?php if ($account->role === 'admin'): ?>
                            <div class="mb-3">
                                <label for="role" class="form-label">Vai trò</label>
                                <select class="form-select"
                                    id="role"
                                    name="role"
                                    <?php echo $account->role === 'admin' ? 'enable' : ''; ?>
                                    required>
                                    <option value="user" <?php echo $account->role === 'user' ? 'selected' : ''; ?>>Người dùng</option>
                                    <option value="admin" <?php echo $account->role === 'admin' ? 'selected' : ''; ?>>Quản trị viên</option>
                                </select>
                                <?php if ($account->role === 'admin'): ?>
                                    <input type="hidden" name="role" value="admin">
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label class="form-label">Ảnh đại diện hiện tại</label>
                            <?php if (!empty($account->image)): ?>
                                <div class="mb-2">
                                    <img src="/uploads/<?php echo htmlspecialchars($account->image, ENT_QUOTES, 'UTF-8'); ?>"
                                        class="img-thumbnail"
                                        style="max-width: 200px;"
                                        alt="Ảnh đại diện">
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Chưa có ảnh đại diện</p>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Cập nhật ảnh đại diện mới</label>
                            <input type="file"
                                class="form-control"
                                id="image"
                                name="image"
                                accept="image/*">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/Account" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i>Cập nhật
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