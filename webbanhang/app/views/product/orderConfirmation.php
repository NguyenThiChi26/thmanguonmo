<?php include 'app/views/shares/header.php'; ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <div class="success-animation mb-4">
                        <div class="checkmark">
                            <svg class="checkmark-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
                                <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                            </svg>
                        </div>
                    </div>

                    <h1 class="display-4 mb-4">Đặt hàng thành công!</h1>
                    <p class="lead text-muted mb-5">
                        Cảm ơn bạn đã mua sắm tại Fashion Store. Đơn hàng của bạn đã được xác nhận và đang được xử lý.
                    </p>

                    <div class="next-steps mb-5">
                        <h5 class="mb-4">Các bước tiếp theo</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="step-item">
                                    <i class="fas fa-envelope fa-2x text-primary mb-3"></i>
                                    <h6>1. Xác nhận email</h6>
                                    <p class="small text-muted">Bạn sẽ nhận được email xác nhận đơn hàng</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="step-item">
                                    <i class="fas fa-box fa-2x text-primary mb-3"></i>
                                    <h6>2. Đóng gói</h6>
                                    <p class="small text-muted">Đơn hàng sẽ được đóng gói cẩn thận</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="step-item">
                                    <i class="fas fa-shipping-fast fa-2x text-primary mb-3"></i>
                                    <h6>3. Vận chuyển</h6>
                                    <p class="small text-muted">Đơn hàng sẽ được giao trong 2-3 ngày</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <button class="btn btn-outline-primary mr-3" onclick="window.print()">
                            <i class="fas fa-print mr-2"></i>In đơn hàng
                        </button>
                        <a href="/Product" class="btn btn-primary">
                            <i class="fas fa-shopping-bag mr-2"></i>Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-animation {
    margin: 0 auto;
}

.checkmark {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: block;
    stroke-width: 2;
    stroke: #4bb71b;
    stroke-miterlimit: 10;
    box-shadow: inset 0 0 0 #4bb71b;
    animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    position: relative;
    margin: 0 auto;
}

.checkmark-circle {
    stroke-dasharray: 166;
    stroke-dashoffset: 166;
    stroke-width: 2;
    stroke-miterlimit: 10;
    stroke: #4bb71b;
    fill: none;
    animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
}

.checkmark-check {
    transform-origin: 50% 50%;
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    stroke-width: 3;
    stroke: #4bb71b;
    animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
}

@keyframes stroke {
    100% {
        stroke-dashoffset: 0;
    }
}

@keyframes scale {
    0%, 100% {
        transform: none;
    }
    50% {
        transform: scale3d(1.1, 1.1, 1);
    }
}

@keyframes fill {
    100% {
        box-shadow: inset 0 0 0 100px #4bb71b;
    }
}

.step-item {
    padding: 1.5rem;
    background: #fff;
    border-radius: 8px;
    height: 100%;
}

.order-info {
    background-color: #f8f9fa;
    border-radius: 8px;
}

@media print {
    .btn {
        display: none;
    }
}
</style>

<?php include 'app/views/shares/footer.php'; ?>