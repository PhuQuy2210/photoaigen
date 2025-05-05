<div class="container mt-5">
    <div class="alert alert-primary text-center" role="alert">
        <h1 class="display-4">Bạn Có một Đơn Đặt Hàng!</h1>
    </div>
    <div class="card">
        <div class="card-header">
            Thông Tin Đơn Hàng
        </div>
        <div class="card-body">
            <h5 class="card-title">Cảm ơn bạn đã đặt hàng tại cửa hàng của chúng tôi!</h5>
            <p class="card-text">Dưới đây là thông tin đơn hàng của bạn:</p>
            <ul class="list-group">
                <li class="list-group-item"><strong>Tên khách hàng:</strong> {{ $name }}</li>
                <li class="list-group-item"><strong>Số điện thoại:</strong> {{ $phone }}</li>
                <li class="list-group-item"><strong>Địa chỉ giao hàng:</strong> {{ $address }}</li>
                <li class="list-group-item"><strong>Tổng số sản phẩm:</strong> {{ $totalProducts }}</li>
                <li class="list-group-item"><strong>Tổng giá trị đơn hàng:</strong> {{ $totalAmount }} VNĐ</li>
            </ul>
            <hr>
            <p class="card-text">Chúng tôi sẽ xử lý đơn hàng của bạn và thông báo khi hàng được giao.</p>
            <p class="card-text">Nếu bạn có bất kỳ câu hỏi nào, hãy liên hệ với chúng tôi qua email hoặc số điện thoại bên dưới.</p>
            <p class="card-text"><strong>Trân trọng!</strong></p>
        </div>
        <div class="card-footer text-muted">
            <p>Liên hệ: haquy2210@example.com</p>
            <p>Số điện thoại: 0123 456 789</p>
        </div>
    </div>
</div>