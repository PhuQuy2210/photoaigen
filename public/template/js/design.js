// bộ lọc ảnh
document.addEventListener("DOMContentLoaded", function () {
    const filterControls = document.querySelectorAll(".filter-controls li");
    const items = document.querySelectorAll(".item_image");

    filterControls.forEach(control => {
        control.addEventListener("click", function () {
            // Xóa lớp active khỏi tất cả các điều khiển và thêm vào điều khiển đã chọn
            filterControls.forEach(c => c.classList.remove("active"));
            this.classList.add("active");

            // Lấy giá trị filter từ điều khiển
            const filter = this.getAttribute("data-filter");

            items.forEach(item => {
                // Kiểm tra nếu item khớp với filter hoặc filter là "*"
                if (filter === "*" || item.classList.contains(filter.substring(1))) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    });
});

// tăng lượt xem
// document.addEventListener('DOMContentLoaded', function () {
//     const gridWrapper = document.getElementById('grid-images'); // Hoặc phần tử cha chứa các ảnh

//     // Delegation event: Lắng nghe sự kiện click trên gridWrapper
//     gridWrapper.addEventListener('click', function (e) {
//         // Kiểm tra nếu sự kiện xảy ra trên icon_plus
//         if (e.target && e.target.matches('.icon_plus')) {
//             const imageId = e.target.closest('.item_image').getAttribute('data-id'); // Lấy ID ảnh
//             const viewCountElement = e.target.closest('.item_image').querySelector('.bi-eye + span'); // Phần tử chứa số lượt xem

//             fetch(`/update-view/${imageId}`, {
//                 method: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                     'Content-Type': 'application/json'
//                 },
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.success) {
//                         viewCountElement.textContent = data.view; // Cập nhật số lượt xem
//                     }
//                 })
//                 .catch(error => console.error('Error:', error));
//         }
//     });
// });

// tăng lượt xem tránh spam
// document.addEventListener('DOMContentLoaded', function () {
//     const gridWrapper = document.getElementById('grid-images');

//     gridWrapper.addEventListener('click', function (e) {
//         if (e.target && e.target.matches('.icon_plus')) {
//             const itemImage = e.target.closest('.item_image');
//             const imageId = itemImage.getAttribute('data-id');
//             const viewCountElement = itemImage.querySelector('.bi-eye + span');

//             // Kiểm tra xem ảnh đã được mở rộng trước đó chưa
//             if (itemImage.getAttribute('data-viewed') === "true") return;

//             fetch(`/update-view/${imageId}`, {
//                 method: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                     'Content-Type': 'application/json'
//                 },
//             })
//             .then(response => response.json())
//             .then(data => {
//                 if (data.success) {
//                     viewCountElement.textContent = data.view;
//                     itemImage.setAttribute('data-viewed', 'true'); // Đánh dấu ảnh đã được xem
//                 }
//             })
//             .catch(error => console.error('Error:', error));
//         }
//     });
// });

// kiểm tra đăng nhập   
// function handleCheckLogin(isLoggedIn, imageId) {
//     if (isLoggedIn === "1") {
//         // Nếu người dùng đã đăng nhập
//         window.location.href = `/baocao/${imageId}`;
//     } else {
//         // Nếu người dùng chưa đăng nhập
//         if (confirm("Bạn chưa đăng nhập. Bạn có muốn chuyển đến trang đăng nhập không?")) {
//             window.location.href = '/admin/users/login';
//         }
//     }
// }

function handleCheckLogin(isLoggedIn, imageId) {
    if (isLoggedIn === "1") {
        window.location.href = `/baocao/${imageId}`;
    } else {
        Swal.fire({
            title: window.loginMessages.not_logged_in,
            html: `
                <p>${window.loginMessages.login_required_message}</p>
                <a href="/auth/google"
                    class="btn btn-primary btn-lg btn-block rounded-pill shadow-sm d-flex align-items-center justify-content-center mt-3">
                    <img src="/upload/logo/gg.png" alt="Google logo" width="20" height="20" class="me-2">
                    ${window.loginMessages.login_with_google}
                </a>
            `,
            icon: 'warning',
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: window.loginMessages.cancel,
            reverseButtons: true,
        });
    }
}


// kiểm tra đăng nhập để báo cáo   
// function handleCheckLogin(isLoggedIn, imageId) {
//     if (isLoggedIn === "1") {
//         // Nếu người dùng đã đăng nhập
//         window.location.href = `/baocao/${imageId}`;
//     } else {
//         // Nếu người dùng chưa đăng nhập
//         Swal.fire({
//             title: 'Chưa đăng nhập!',
//             html: `
//                 <p>Để sử dụng tính năng này, bạn cần đăng nhập. Vui lòng sử dụng Google để tiếp tục.</p>
//                 <a href="/auth/google"
//                     class="btn btn-primary btn-lg btn-block rounded-pill shadow-sm d-flex align-items-center justify-content-center mt-3">
//                     <img src="/upload/logo/gg.png" alt="Google logo" width="20" height="20" class="me-2">
//                     Đăng nhập với Google
//                 </a>
//             `,
//             icon: 'warning',
//             showCancelButton: true,
//             showConfirmButton: false, // Ẩn nút xác nhận mặc định
//             cancelButtonText: 'Hủy',
//             reverseButtons: true,
//         });
//     }
// }

function handleLike(imageId, likeElement) {
    fetch(`/like-image`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ image_id: imageId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật số lượt like trên giao diện
                const likeCountSpan = likeElement.querySelector('span');
                likeCountSpan.textContent = data.like_count;

                // Đổi biểu tượng trái tim và màu sắc
                const heartIcon = likeElement.querySelector('i');
                if (data.user_liked) {
                    heartIcon.classList.remove('bi-heart');
                    heartIcon.classList.add('bi-heart-fill', 'text-danger');
                } else {
                    heartIcon.classList.remove('bi-heart-fill', 'text-danger');
                    heartIcon.classList.add('bi-heart');
                }
            } else {
                Swal.fire({
                    title: window.loginMessages.not_logged_in,
                    html: `
                        <p>${window.loginMessages.login_required_message}</p>
                        <a href="/auth/google"
                            class="btn btn-primary btn-lg btn-block rounded-pill shadow-sm d-flex align-items-center justify-content-center mt-3">
                            <img src="/upload/logo/gg.png" alt="Google logo" width="20" height="20" class="me-2">
                            ${window.loginMessages.login_with_google}
                        </a>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    showConfirmButton: false, // Ẩn nút xác nhận mặc định
                    cancelButtonText: window.loginMessages.cancel,
                    reverseButtons: true,
                });
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            Swal.fire({
                title: 'Lỗi!',
                text: 'Không thể thực hiện thao tác. Vui lòng thử lại sau.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
}

// header fixed
document.addEventListener("DOMContentLoaded", function () {
    var header = document.querySelector(".bg-nav-header");
    var headerHeight = header.offsetHeight;

    window.addEventListener("scroll", function () {
        if (window.scrollY > headerHeight) {
            header.classList.add("fixed-header");
        } else {
            header.classList.remove("fixed-header");
        }
    });
});

// search history
document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("search-form");
    const searchInput = document.getElementById("search-input");
    const searchHistoryDropdown = document.getElementById("search-history-dropdown");

    // Lấy lịch sử tìm kiếm từ localStorage hoặc đặt mặc định
    let searchHistory = JSON.parse(localStorage.getItem("searchHistory")) || ["Thiên nhiên", "23"];

    // Hiển thị lịch sử tìm kiếm trong dropdown
    function renderSearchHistory() {
        const query = searchInput.value.trim().toLowerCase();

        // Xóa nội dung cũ
        searchHistoryDropdown.innerHTML = "";

        // Lọc lịch sử theo từ khóa người dùng nhập vào
        const filteredHistory = searchHistory.filter(item =>
            item.toLowerCase().includes(query)
        );

        if (filteredHistory.length === 0 || query === "") {
            searchHistoryDropdown.style.display = "none";
            return;
        }

        filteredHistory.forEach(item => {
            const div = document.createElement("div");
            div.className = "dropdown-item";
            div.textContent = item;
            div.style.cursor = "pointer";

            // Khi nhấp vào một mục trong dropdown
            div.onclick = function () {
                searchInput.value = item;
                searchHistoryDropdown.style.display = "none";
                searchForm.submit(); // Gửi form luôn nếu muốn
            };

            searchHistoryDropdown.appendChild(div);
        });

        searchHistoryDropdown.style.display = "block";
    }

    // Sự kiện nhập vào ô tìm kiếm
    searchInput.addEventListener("input", renderSearchHistory);

    // Hiển thị lịch sử khi nhấp vào ô tìm kiếm
    searchInput.addEventListener("focus", renderSearchHistory);

    // Ẩn dropdown khi click ra ngoài
    document.addEventListener("click", function (event) {
        if (!searchInput.contains(event.target) && !searchHistoryDropdown.contains(event.target)) {
            searchHistoryDropdown.style.display = "none";
        }
    });

    // Xử lý khi submit form tìm kiếm
    searchForm.addEventListener("submit", function (event) {
        const query = searchInput.value.trim();
        if (query) {
            // Nếu lịch sử không tồn tại từ khóa thì thêm vào
            if (!searchHistory.includes(query)) {
                searchHistory.unshift(query); // Thêm vào đầu danh sách
                if (searchHistory.length > 5) searchHistory.pop(); // Giới hạn 5 mục
                localStorage.setItem("searchHistory", JSON.stringify(searchHistory));
            }
            searchHistoryDropdown.style.display = "none";
        }
    });
});

// // hiển thị ảnh lên với tốc độ chậm
document.addEventListener("DOMContentLoaded", function () {
    const images = document.querySelectorAll(".item_image");

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("show");
                observer.unobserve(entry.target); // Ngừng theo dõi sau khi hiển thị
            }
        });
    }, {
        threshold: 0.2 // Kích hoạt khi 20% phần tử xuất hiện trong viewport
    });

    images.forEach(image => observer.observe(image));
});

// giao diện
// document.addEventListener("DOMContentLoaded", function () {
//     // Kiểm tra nếu có theme đã lưu
//     let savedTheme = localStorage.getItem("theme");
//     if (!savedTheme) {
//         savedTheme = "light"; // Mặc định là light
//     }
//     setTheme(savedTheme);

//     // Hàm đổi giao diện và lưu vào localStorage
//     window.setTheme = function (theme) {
//         document.documentElement.setAttribute("data-theme", theme);
//         localStorage.setItem("theme", theme);

//         // Đổi icon trên button
//         const icon = document.querySelector("#darkmode i");
//         if (theme === "dark") {
//             icon.classList.remove("bi-brightness-high-fill");
//             icon.classList.add("bi-moon");
//         } else {
//             icon.classList.remove("bi-moon");
//             icon.classList.add("bi-brightness-high-fill");
//         }

//         // Gửi AJAX lưu vào session nếu cần
//         fetch('/save-theme', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify({ theme: theme })
//         });
//     };
// });

// function setTheme(theme) {
//     document.documentElement.setAttribute("data-theme", theme);
//     localStorage.setItem("theme", theme);

//     // Đổi icon trên button
//     const icon = document.querySelector("#darkmode i");
//     if (theme === "dark") {
//         icon.classList.remove("bi-brightness-high-fill");
//         icon.classList.add("bi-moon");
//     } else {
//         icon.classList.remove("bi-moon");
//         icon.classList.add("bi-brightness-high-fill");
//     }

//     // Gửi AJAX lưu vào session nếu cần
//     fetch('/save-theme', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify({ theme: theme })
//     });
// }

//baatss đồng bộ nhanh hơn tý 
async function setTheme(theme) {
    document.documentElement.setAttribute("data-theme", theme);
    localStorage.setItem("theme", theme);

    // Đổi icon trên button
    const icon = document.querySelector("#darkmode i");
    if (theme === "dark") {
        icon.classList.remove("bi-brightness-high-fill");
        icon.classList.add("bi-moon");
    } else {
        icon.classList.remove("bi-moon");
        icon.classList.add("bi-brightness-high-fill");
    }

    // Gửi AJAX lưu vào session sau khi đã thay đổi theme
    try {
        await fetch('/save-theme', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ theme: theme })
        });
    } catch (error) {
        console.error("Lỗi khi lưu theme:", error);
    }
}

// Đảm bảo khi tải trang, theme được áp dụng ngay
document.addEventListener("DOMContentLoaded", function () {
    let savedTheme = localStorage.getItem("theme") || "light";
    setTheme(savedTheme);
});

//tối ưu nhất
// document.addEventListener("DOMContentLoaded", function () {
//     // Kiểm tra theme đã lưu trong localStorage và áp dụng ngay khi trang tải
//     let savedTheme = localStorage.getItem("theme") || "light";
//     document.documentElement.setAttribute("data-theme", savedTheme);
//     updateThemeIcon(savedTheme);
// });

// async function setTheme(theme) {
//     // Áp dụng theme ngay lập tức vào giao diện người dùng
//     document.documentElement.setAttribute("data-theme", theme);
//     localStorage.setItem("theme", theme);

//     // Cập nhật biểu tượng trên button
//     updateThemeIcon(theme);

//     // Gửi AJAX để lưu theme vào server sau khi đã thay đổi giao diện
//     try {
//         await sendThemeToServer(theme);
//     } catch (error) {
//         console.error("Lỗi khi lưu theme:", error);
//     }
// }

// function updateThemeIcon(theme) {
//     const icon = document.querySelector("#darkmode i");
//     if (theme === "dark") {
//         icon.classList.remove("bi-brightness-high-fill");
//         icon.classList.add("bi-moon");
//     } else {
//         icon.classList.remove("bi-moon");
//         icon.classList.add("bi-brightness-high-fill");
//     }
// }

// // Hàm gửi yêu cầu AJAX để lưu theme vào server
// function sendThemeToServer(theme) {
//     return fetch('/save-theme', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify({ theme: theme })
//     });
// }
