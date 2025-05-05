// Thiết lập token CSRF cho tất cả các yêu cầu AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Hàm xóa sản phẩm
function removeRow(id, url) {
    if (confirm('Xóa mà không thể khôi phục. Bạn có chắc ?')) {
        $.ajax({
            type: 'DELETE',
            datatype: 'JSON',
            data: { id },  // Gửi ID của sản phẩm đến server
            url: url,      // Đường dẫn API xử lý việc xóa
            success: function (result) {
                if (result.error === false) {  // Nếu không có lỗi
                    alert(result.message);     // Hiển thị thông báo "Xóa thành công sản phẩm"
                    location.reload();         // Reload lại trang để cập nhật danh sách sản phẩm
                } else {
                    alert('Xóa lỗi vui lòng thử lại');
                }
            }
        })
    }
}

// Hàm thay đổi trạng thái tài khoản
function changeStatus(id, url) {
    if (confirm('Bạn có chắc muốn thay đổi trạng thái tài khoản này?')) {
        $.ajax({
            type: 'POST',
            datatype: 'JSON',
            data: { id: id },  // Gửi ID của tài khoản đến server
            url: url,
            success: function (result) {
                if (result.error === false) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert('Đổi trạng thái lỗi, vui lòng thử lại.');
                }
            }
        });
    }
}

// Hàm kiểm tra quyền và xóa tài khoản nếu đủ quyền
function checkPermission(roleId, userId, url) {
    checkRole(roleId)

    // Gọi hàm deleteUser nếu có đủ quyền
    deleteUser(userId, url);
    return true;
}






// Hàm kiểm tra quyền và thông báo
function checkRole(roleId) {
    if (roleId != 0) {
        alert("Bạn không đủ quyền để thực hiện chức năng này!!!");
        return false;
    }
}


// //upload ảnh 
// /*Upload File */
// $('#upload').change(function () {
//     const form = new FormData();
//     form.append('file', $(this)[0].files[0]);
//     $.ajax({
//         processData: false,
//         contentType: false,
//         type: 'POST',
//         dataType: 'JSON',
//         data: form,
//         url: '/admin/upload/services',
//         success: function (results) {
//             if (results.error === false) {
//                 $('#image_show').html('<a href="' + results.url + '" target = "_blank" > ' + '<img src="' + results.url + '" width="100px"></a>');
//                 $('#thumb').val(results.url);
//             } else {
//                 alert('Upload File Lỗi');
//             }
//         }
//     });
// });


// Hiển thị nút khi cuộn xuống 100px
document.addEventListener("DOMContentLoaded", function () {
    var scrollTopBtn = document.getElementById("scrollTop");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add("show");
        } else {
            scrollTopBtn.classList.remove("show");
        }
    });

    scrollTopBtn.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
});

// Cuộn về đầu trang với hiệu ứng mượt
function backToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Hiệu ứng cuộn mượt
    });
}

// Khi trang đã tải hoàn toàn
// window.addEventListener("load", function () {
//     // Đảm bảo vòng tải xuất hiện trong ít nhất 1 giây
//     setTimeout(function () {
//         document.querySelector(".spinner").style.display = "none";
//     }, 100); // 1000ms tương đương 1 giây
// });

// < !--JavaScript để kiểm tra mật khẩu trùng nhau-- >
function validatePasswords() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
        alert('Mật khẩu và Nhập lại mật khẩu không trùng khớp. Vui lòng kiểm tra lại.');
        return false; // Ngăn form submit nếu mật khẩu không trùng nhau
    }
    return true; // Cho phép form submit nếu mật khẩu trùng nhau
}

// Hàm gửi yêu cầu xóa tài khoản
function deleteUser(id, url) {
    if (confirm('Bạn có chắc muốn xóa tài khoản này?')) {
        $.ajax({
            type: 'DELETE',
            url: url,
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF token vào đây
            },
            datatype: 'JSON',
            success: function (result) {
                if (result.error === false) {
                    alert(result.message);
                    location.reload();
                } else {
                    alert('Xóa tài khoản thất bại, vui lòng thử lại.');
                }
            },
            error: function (xhr) {
                alert('Lỗi xảy ra: ' + xhr.statusText);
            }
        });
    }
}


// Xóa danh mục
function deleteDanhmuc(id, url) {
    if (confirm('Bạn có chắc muốn xóa danh mục này?')) {
        $.ajax({
            type: 'DELETE', // Phương thức DELETE
            datatype: 'JSON',
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF token vào đây
            },
            url: url,
            success: function (result) {
                if (result.error === false) {
                    alert(result.message);
                    location.reload(); // Reload lại trang sau khi xóa thành công
                } else {
                    alert('Xóa danh mục thất bại!');
                }
            },
            error: function () {
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            }
        });
    }
}

// Xóa ảnh
function delete_hinhanh(id, url) {
    if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
        $.ajax({
            type: 'DELETE', // Phương thức DELETE
            datatype: 'JSON',
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF token vào đây
            },
            url: url,
            success: function (result) {
                if (result.error === false) {
                    alert(result.message);
                    location.reload(); // Reload lại trang sau khi xóa thành công
                } else {
                    alert('Xóa ảnh thất bại!');
                }
            },
            error: function () {
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            }
        });
    }
}

// Xóa report
function delete_report(id, url) {
    if (confirm('Bạn có chắc muốn xóa report này?')) {
        $.ajax({
            type: 'DELETE', // Phương thức DELETE
            datatype: 'JSON',
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF token vào đây
            },
            url: url,
            success: function (result) {
                if (result.error === false) {
                    alert(result.message);
                    location.reload(); // Reload lại trang sau khi xóa thành công
                } else {
                    alert('Xóa report thất bại!');
                }
            },
            error: function () {
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            }
        });
    }
}

// Xóa ảnh report
function delete_report_img(idimg, url) {
    if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
        $.ajax({
            type: 'DELETE', // Phương thức DELETE
            datatype: 'JSON',
            data: {
                idimg: idimg,
                _token: $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF token vào đây
            },
            url: url,
            success: function (result) {
                if (result.error === false) {
                    alert(result.message);
                    window.location.href = '/admin/baocao/list';
                } else {
                    alert('Xóa ảnh thất bại!');
                }
            },
            error: function () {
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            }
        });
    }
}

// function delete_report_img_list(idimg, url) {
//     if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
//         $.ajax({
//             type: 'DELETE', // Phương thức DELETE
//             datatype: 'JSON',
//             data: {
//                 idimg: idimg,
//                 _token: $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF token vào đây
//             },
//             url: url,
//             success: function (result) {
//                 if (result.error === false) {
//                     alert(result.message);
//                     // Điều hướng về trang /admin/baocao/list sau khi xóa thành công
//                     window.location.href = '/admin/baocao/list';
//                 } else {
//                     alert('Xóa ảnh thất bại!');
//                 }
//             },
//             error: function () {
//                 alert('Có lỗi xảy ra, vui lòng thử lại.');
//             }
//         });
//     }
// }



// Xóa bản tin
function delete_tintuc(id, url) {
    if (confirm('Bạn có chắc muốn xóa tin này?')) {
        $.ajax({
            type: 'DELETE', // Phương thức DELETE
            datatype: 'JSON',
            data: {
                id: id,
                _token: $('meta[name="csrf-token"]').attr('content')  // Thêm CSRF token vào đây
            },
            url: url,
            success: function (result) {
                if (result.error === false) {
                    alert(result.message);
                    location.reload(); // Reload lại trang sau khi xóa thành công
                } else {
                    alert('Xóa tin thất bại!');
                }
            },
            error: function () {
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            }
        });
    }
}


// Xử lý trạng thái ảnh
function toggleActive(id, url) {
    $.ajax({
        type: 'POST', // Phương thức POST
        dataType: 'JSON',
        data: {
            id: id,
            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
        },
        url: url,
        success: function (result) {
            if (result.error === false) {
                alert(result.message);
                location.reload(); // Reload lại trang sau khi thay đổi trạng thái thành công
            } else {
                alert('Thay đổi trạng thái thất bại!');
            }
        },
        error: function () {
            alert('Có lỗi xảy ra, vui lòng thử lại.');
        }
    });
}

// // Tự động ẩn các alert thông báo sau 5 giây
// document.addEventListener('DOMContentLoaded', function () {
//     const alerts = document.querySelectorAll('.alert');
//     alerts.forEach(alert => {
//         setTimeout(() => {
//             alert.classList.add('fade'); // Thêm lớp fade để làm hiệu ứng mờ dần
//             alert.style.opacity = '0'; // Đảm bảo ẩn hoàn toàn
//             setTimeout(() => alert.remove(), 500); // Xóa phần tử khỏi DOM sau khi mờ
//         }, 5000); // 5 giây
//     });
// });






