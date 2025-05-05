$(document).ready(function () {
    let searchHistory = [];

    // Gửi yêu cầu tìm kiếm
    $('#search-form').on('submit', function (e) {
        e.preventDefault();

        let keyword = $('#search-input').val().trim();
        let url = $('#grid-images').data('url');

        if (keyword === '') return;

        $.ajax({
            url: url,
            type: "GET",
            data: { search: keyword },
            beforeSend: function () {
                $('#image-list').html('<p>Đang tải...</p>');
            },
            success: function (data) {
                $('#image-list').html(data);

                // Tái khởi tạo hiệu ứng khi load xong ảnh mới
                reinitializeObserver();

                // Lưu từ khóa tìm kiếm vào lịch sử nếu chưa có
                if (!searchHistory.includes(keyword)) {
                    searchHistory.push(keyword);
                    updateSearchHistoryDropdown();
                }
            },
            error: function () {
                $('#image-list').html('<p class="text-danger">Không thể tải danh sách ảnh.</p>');
            }
        });
    });

    // Tái khởi tạo IntersectionObserver cho các ảnh mới
    function reinitializeObserver() {
        const images = document.querySelectorAll(".item_image");

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("show");
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });

        images.forEach(image => observer.observe(image));
    }

    // Gọi lại observer khi trang được load lần đầu
    reinitializeObserver();
});

