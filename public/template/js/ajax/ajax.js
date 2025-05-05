function fetchData(url, params, targetElement) {
    console.log('Đang gọi AJAX với:', params);

    $.ajax({
        url: url,
        type: "GET",
        data: params,
        success: function (data) {
            $(targetElement).html(data); // Cập nhật phần tử chỉ định
        },
        error: function (xhr, status, error) {
            console.error('Lỗi khi tải dữ liệu:', xhr.responseText);
        }
    });
}

