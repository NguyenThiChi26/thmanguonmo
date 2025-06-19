<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-gradient">Danh sách người dùng</h2>
        <a href="/Account/add" class="btn btn-gradient">
            <i class="fas fa-plus-circle mr-2"></i>Thêm người dùng mới
        </a>
    </div>

    <div class="card shadow-custom">
        <div class="card-body p-0">
            <table class="table custom-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Tên đăng nhập</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($accounts as $account): ?>
                    <tr>
                        <td style="font-weight:600;color:#2563eb;">
                            <?php echo htmlspecialchars($account->username, ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td><?php echo htmlspecialchars($account->fullname, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($account->email ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($account->phone ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <span class="badge badge-role-<?php echo $account->role === 'admin' ? 'admin' : 'user'; ?>">
                                <?php echo htmlspecialchars($account->role, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <?php if ($_SESSION['role'] === 'admin'): ?>
                                    <?php if ($account->username !== $_SESSION['username']): ?>
                                        <a href="/Account/editUser/<?php echo $account->id; ?>"
                                           class="btn btn-action btn-edit">
                                            <i class="fas fa-edit mr-1"></i>Sửa
                                        </a>
                                    <?php else: ?>
                                        <a href="/Account/edit"
                                           class="btn btn-action btn-edit">
                                            <i class="fas fa-edit mr-1"></i>Sửa
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($account->role !== 'admin'): ?>
                                        <a href="/Account/delete/<?php echo $account->username; ?>"
                                           class="btn btn-action btn-delete"
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                                            <i class="fas fa-trash-alt mr-1"></i>Xóa
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
.shadow-custom {
    border: none;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(56,189,248,0.10);
    overflow: hidden;
}
.custom-table {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
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
    padding: 1rem 0.75rem;
}
.custom-table tbody tr {
    transition: background 0.2s;
}
.custom-table tbody tr:hover {
    background: #f0fdfa;
}
.badge-role-admin {
    background: linear-gradient(90deg, #ef4444 0%, #f87171 100%);
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.5em 1.1em;
    font-size: 1rem;
    box-shadow: 0 2px 8px rgba(239,68,68,0.10);
}
.badge-role-user {
    background: linear-gradient(90deg, #38bdf8 0%, #818cf8 100%);
    color: #fff;
    font-weight: 600;
    border-radius: 8px;
    padding: 0.5em 1.1em;
    font-size: 1rem;
    box-shadow: 0 2px 8px rgba(56,189,248,0.10);
}
.btn-action {
    border: none;
    border-radius: 8px;
    font-weight: 500;
    margin: 0 2px;
    padding: 0.4em 1em;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    font-size: 0.98rem;
    display: inline-flex;
    align-items: center;
}
.btn-edit {
    background: linear-gradient(90deg, #fbbf24 0%, #f59e42 100%);
    color: #fff;
}
.btn-edit:hover {
    background: linear-gradient(90deg, #f59e42 0%, #fbbf24 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(251,191,36,0.15);
}
.btn-delete {
    background: linear-gradient(90deg, #ef4444 0%, #f87171 100%);
    color: #fff;
}
.btn-delete:hover {
    background: linear-gradient(90deg, #f87171 0%, #ef4444 100%);
    color: #fff;
    box-shadow: 0 2px 8px rgba(239,68,68,0.15);
}
</style>

<?php include 'app/views/shares/footer.php'; ?>