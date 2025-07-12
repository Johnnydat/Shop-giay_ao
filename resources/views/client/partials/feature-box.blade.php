<div class="container-fluid py-5 bg-light-gradient">
    <div class="container">
        <div class="row g-4">
            <!-- Box 1: Giao hàng miễn phí -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card feature-card feature-card-blue h-100 border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="feature-icon-wrapper me-4">
                            <div class="feature-icon bg-primary">
                                <i class="fas fa-shipping-fast text-white"></i>
                            </div>
                        </div>
                        <div class="feature-content flex-grow-1">
                            <h5 class="card-title fw-bold text-dark mb-2">GIAO HÀNG MIỄN PHÍ HỎA TỐC</h5>
                            <p class="card-text text-muted mb-0">Miễn phí vận chuyển toàn quốc</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 2: Miễn phí trả hàng -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card feature-card feature-card-green h-100 border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="feature-icon-wrapper me-4">
                            <div class="feature-icon bg-success">
                                <i class="fas fa-undo-alt text-white"></i>
                            </div>
                        </div>
                        <div class="feature-content flex-grow-1">
                            <h5 class="card-title fw-bold text-dark mb-2">MIỄN PHÍ TRẢ HÀNG</h5>
                            <p class="card-text text-muted mb-0">Điều khoản và điều kiện áp dụng</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Box 3: Cập nhật tin tức -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card feature-card feature-card-orange h-100 border-0 shadow-sm">
                    <div class="card-body d-flex align-items-center p-4">
                        <div class="feature-icon-wrapper me-4">
                            <div class="feature-icon bg-warning">
                                <i class="fas fa-bell text-white"></i>
                            </div>
                        </div>
                        <div class="feature-content flex-grow-1">
                            <h5 class="card-title fw-bold text-dark mb-2">CẬP NHẬT TIN TỨC</h5>
                            <p class="card-text text-muted mb-0">Theo dõi chúng tôi trên các kênh truyền thông</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    /* Import Google Fonts */
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

    /* Root Variables */
    :root {
        --primary-blue: #4a90e2;
        --primary-green: #7ed321;
        --primary-orange: #f5a623;
        --light-blue: #e3f2fd;
        --light-green: #e8f5e8;
        --light-orange: #fff3e0;
        --white: #ffffff;
        --text-dark: #2c3e50;
        --text-light: #7f8c8d;
        --shadow-light: 0 4px 20px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Base Styles */
    body {
        font-family: "Inter", sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .container-fluid {
        background: transparent;
    }

    /* Feature Box Base */
    .feature-box {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 2rem;
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-light);
        transition: var(--transition);
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .feature-box::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-color, #4a90e2) 0%, var(--accent-light, #e3f2fd) 100%);
        transition: var(--transition);
    }

    .feature-box:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-hover);
    }

    .feature-box:hover::before {
        height: 6px;
    }

    /* Feature Icon */
    .feature-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: var(--white);
        background: linear-gradient(135deg, var(--accent-color, #4a90e2) 0%, var(--accent-dark, #357abd) 100%);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        transition: var(--transition);
        flex-shrink: 0;
    }

    .feature-box:hover .feature-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    }

    /* Feature Content */
    .feature-content {
        flex: 1;
    }

    .feature-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
        line-height: 1.3;
    }

    .feature-subtitle {
        font-size: 0.95rem;
        font-weight: 400;
        color: var(--text-light);
        margin-bottom: 0;
        line-height: 1.4;
    }

    /* Delivery Box - Blue Theme */
    .feature-box-delivery {
        --accent-color: #4a90e2;
        --accent-dark: #357abd;
        --accent-light: #e3f2fd;
        background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
        border: 1px solid rgba(74, 144, 226, 0.1);
    }

    .feature-box-delivery:hover {
        background: linear-gradient(135deg, #ffffff 0%, #f0f7ff 100%);
    }

    /* Return Box - Green Theme */
    .feature-box-return {
        --accent-color: #7ed321;
        --accent-dark: #6bb91a;
        --accent-light: #e8f5e8;
        background: linear-gradient(135deg, #ffffff 0%, #f8fff8 100%);
        border: 1px solid rgba(126, 211, 33, 0.1);
    }

    .feature-box-return:hover {
        background: linear-gradient(135deg, #ffffff 0%, #f0fff0 100%);
    }

    /* News Box - Orange Theme */
    .feature-box-news {
        --accent-color: #f5a623;
        --accent-dark: #e8941a;
        --accent-light: #fff3e0;
        background: linear-gradient(135deg, #ffffff 0%, #fffbf5 100%);
        border: 1px solid rgba(245, 166, 35, 0.1);
    }

    .feature-box-news:hover {
        background: linear-gradient(135deg, #ffffff 0%, #fff8f0 100%);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .feature-box {
            padding: 1.5rem;
            gap: 1.25rem;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .feature-title {
            font-size: 1rem;
        }

        .feature-subtitle {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 768px) {
        .feature-box {
            flex-direction: column;
            text-align: center;
            padding: 2rem 1.5rem;
            gap: 1rem;
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .feature-title {
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
        }
    }

    @media (max-width: 576px) {
        .container {
            padding: 0 15px;
        }

        .feature-box {
            padding: 1.5rem 1rem;
        }

        .feature-title {
            font-size: 1rem;
        }

        .feature-subtitle {
            font-size: 0.85rem;
        }
    }

    /* Animation for icons */
    @keyframes pulse {
        0% {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        50% {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        }

        100% {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }
    }

    .feature-icon {
        animation: pulse 3s infinite;
    }

    /* Loading animation */
    @keyframes shimmer {
        0% {
            background-position: -200px 0;
        }

        100% {
            background-position: calc(200px + 100%) 0;
        }
    }

    .feature-box.loading {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200px 100%;
        animation: shimmer 1.5s infinite;
    }

    /* Accessibility */
    .feature-box:focus {
        outline: 2px solid var(--accent-color, #4a90e2);
        outline-offset: 2px;
    }

    /* High contrast mode */
    @media (prefers-contrast: high) {
        .feature-box {
            border: 2px solid var(--text-dark);
        }

        .feature-title {
            color: #000000;
        }

        .feature-subtitle {
            color: #333333;
        }
    }

    /* Reduced motion */
    @media (prefers-reduced-motion: reduce) {

        .feature-box,
        .feature-icon {
            transition: none;
            animation: none;
        }

        .feature-box:hover {
            transform: none;
        }

        .feature-box:hover .feature-icon {
            transform: none;
        }
    }
</style>
