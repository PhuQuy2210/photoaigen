// $(document).ready(function () {
//     let danhSachURL = $('meta[name="route-danhsach-anh"]').attr('content'); // Lấy URL từ meta

//     function loadStudentList() {
//         let danhmuc = $('#category_id').val();
//         let search = $('input[name="search"]').val();

//         console.log('Đang gọi AJAX với:', { category_id: danhmuc, search: search });

//         $.ajax({
//             url: danhSachURL,
//             type: "GET",
//             data: { category_id: danhmuc, search: search },
//             success: function (data) {
//                 $('#student-list').html(data); // Cập nhật danh sách ảnh
//             },
//             error: function (xhr, status, error) {
//                 console.error('Lỗi khi tải danh sách hình ảnh:', xhr.responseText);
//             }
//         });
//     }

//     // Bắt sự kiện thay đổi danh mục
//     $('#category_id').off("change").on("change", function () {
//         loadStudentList();
//     });

//     // Bắt sự kiện submit form tìm kiếm
//     $('#search-form').off("submit").on("submit", function (event) {
//         event.preventDefault(); // Ngăn load lại trang
//         loadStudentList();
//     });

//     // Bắt sự kiện nhập liệu vào ô tìm kiếm
//     $('input[name="search"]').off("input").on("input", function () {
//         loadStudentList();
//     });
// });

$(document).ready(function () {
    let danhSachURL = $('meta[name="route-danhsach-anh"]').attr('content'); // Lấy URL từ meta

    function loadStudentList(page = 1) {
        let danhmuc = $('#category_id').val();
        let search = $('input[name="search"]').val();

        console.log('Đang gọi AJAX với:', { category_id: danhmuc, search: search, page: page });

        $.ajax({
            url: danhSachURL,
            type: "GET",
            data: { category_id: danhmuc, search: search, page: page },
            success: function (data) {
                $('#student-list').html(data); // Cập nhật danh sách ảnh
            },
            error: function (xhr, status, error) {
                console.error('Lỗi khi tải danh sách hình ảnh:', xhr.responseText);
            }
        });
    }

    // Bắt sự kiện thay đổi danh mục
    $('#category_id').off("change").on("change", function () {
        loadStudentList();
    });

    // Bắt sự kiện submit form tìm kiếm
    $('#search-form').off("submit").on("submit", function (event) {
        event.preventDefault(); // Ngăn load lại trang
        loadStudentList();
    });

    // Bắt sự kiện nhập liệu vào ô tìm kiếm
    $('input[name="search"]').off("input").on("input", function () {
        loadStudentList();
    });

    // Bắt sự kiện click vào phân trang
    $(document).on("click", ".pagination a", function (event) {
        event.preventDefault(); // Ngăn load lại trang
        let page = $(this).attr('href').split('page=')[1]; // Lấy số trang từ URL
        if (page) {
            loadStudentList(page);
        }
    });
});
