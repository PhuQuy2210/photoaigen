
// danh sách ảnh load lên 
// document.addEventListener('DOMContentLoaded', function () {
//     let page = 1; // Trang hiện tại
//     let loading = false; // Trạng thái đang tải
//     let allImagesLoaded = false; // Biến đánh dấu đã tải hết ảnh
//     const totalImages = parseInt(document.getElementById('grid-images').getAttribute('data-total-images')); // Tổng số ảnh
//     const gridWrapper = document.querySelector('.grid-wrapper');
//     const loadingIndicator = document.getElementById('loading');
//     const baseURL = window.location.origin;

//     const footer = document.querySelector('.footer-section');

//     const pathname = window.location.pathname;
//     const parts = pathname.split('/').filter(Boolean); // Lọc bỏ các phần tử rỗng
//     const duong_dan = parts[0];
//     const value = parts[1];

    // const applyFilters = () => {
    //     const activeFilter = document.querySelector('.filter-controls li.active').getAttribute('data-filter');
    //     const items = document.querySelectorAll('.item_image');

    //     items.forEach(item => {
    //         if (activeFilter === "*" || item.classList.contains(activeFilter.substring(1))) {
    //             item.style.display = "block";
    //         } else {
    //             item.style.display = "none";
    //         }
    //     });
    // };

//     // Xử lý sự kiện cuộn trang
//     window.addEventListener('scroll', async () => {
//         if (loading || allImagesLoaded) return; // Thoát nếu đang tải hoặc đã tải hết ảnh

//         const footerPosition = footer.getBoundingClientRect().top; // Vị trí của footer so với khung nhìn
//         const viewportHeight = window.innerHeight; // Chiều cao khung nhìn

//         if (footerPosition - viewportHeight <= 0) { // Kiểm tra cách footer 0px
//             loading = true; // Đặt trạng thái đang tải
//             loadingIndicator.style.display = 'block'; // Hiển thị spinner

//             page++; // Tăng trang
//             const response = await fetch(`/get-images?page=${page}&duong_dan=${duong_dan}&value=${value}`);
//             const data = await response.json();

//             if (data.images.length > 0) {
//                 data.images.forEach(image => {
//                     const categorySlug = image.category.name
//                         .normalize('NFD') // Tách các ký tự có dấu thành ký tự tổ hợp
//                         .replace(/[\u0300-\u036f]/g, '') // Loại bỏ dấu
//                         .toLowerCase()
//                         .replace(/đ/g, 'd') // Thay đ thành d
//                         .replace(/[^a-z0-9\s]/g, '') // Loại bỏ ký tự đặc biệt
//                         .replace(/\s+/g, '-'); // Thay khoảng trắng bằng -

//                     const directionClass = image.direction == '0' ? 'ngang' : 'doc';
//                     const imageHTML = `
//                         <div class="item_image ${categorySlug} ${directionClass}" data-id="${image.id}">
//                             <img class="if" src="${baseURL}/${image.url}" alt="ảnh minh họa">
//                             <div class="box-icon">
//                                 <div class="download-icon position-absolute top-0 start-0" title="Tải ảnh">
//                                     <a href="${image.url}" download>
//                                         <i class="bi bi-download"></i>
//                                         <span>Tải ảnh</span>
//                                     </a>
//                                 </div>
//                                 <div class="view-icon position-absolute start-0" title="Lượt xem">
//                                     <i class="bi bi-eye"></i>
//                                     <span>${image.view}</span>
//                                 </div>
//                                 <div class="like-icon position-absolute top-0 end-0" title="Thích ảnh" onclick="handleLike(${image.id}, this)">
//                                     <i class="bi ${image.userHasLiked ? 'bi-heart-fill text-danger' : 'bi-heart'}"></i>
//                                     <span>${image.like_count}</span>
//                                 </div>
//                                 <div class="report-icon position-absolute top-0 start-0" title="Báo cáo vi phạm">
//                                     <a href="/baocao/${image.id}">
//                                         <i class="bi bi-chat-left-text"></i>
//                                     </a>
//                                 </div>
//                             </div>
//                             <a href="${baseURL}/${image.url}" class="pf-icon position-absolute image-popup" title="Mở rộng">
//                                 <span class="icon_plus"></span>
//                             </a>
//                             <div class="pf-text">
//                                 <h4>${image.category.name}</h4>
//                             </div>
//                         </div>
//                     `;
//                     gridWrapper.insertAdjacentHTML('beforeend', imageHTML); // Thêm ảnh mới vào danh sách
//                 });

//                 // Áp dụng bộ lọc lại cho tất cả ảnh (bao gồm ảnh mới)
//                 applyFilters();

//                 // Khởi tạo lại popup
//                 $(document).ready(function () {
//                     $('.image-popup').magnificPopup({
//                         type: 'image',
//                         gallery: {
//                             enabled: true, // Bật tính năng chuyển ảnh
//                         },
//                         callbacks: {
//                             markupParse: function (template, values, item) {
//                                 // Lấy dữ liệu bổ sung từ phần tử HTML
//                                 var $imageElement = $(item.el).closest('.item_image');
//                                 var imageId = $imageElement.data('id');
//                                 var viewCount = $imageElement.find('.view-icon span').text();
//                                 var likeCount = $imageElement.find('.like-icon span').text();
//                                 var category = $imageElement.find('.pf-text h4').text();

//                                 // Thêm nút tải ảnh và thông tin chi tiết
//                                 values.title = `
//                                     <a href="${item.src}" download class="mfp-download"><i class="bi bi-download"></i></a>
//                                     <div class="popup-info">
//                                         <p><strong><i class="bi bi-tags"></i></strong> ${category}</p>
//                                         <p><strong><i class="bi bi-eye"></i></strong> ${viewCount}</p>
//                                         <p><strong><i class="bi bi-heart-fill"></i></strong> ${likeCount}</p>
//                                     </div>
//                                 `;
//                             }
//                         }
//                     });
//                 });
//             }

//             // Kiểm tra xem đã tải hết ảnh chưa
//             if (gridWrapper.children.length >= totalImages) {
//                 allImagesLoaded = true; // Đánh dấu đã tải hết
//             }

//             loading = false; // Đặt trạng thái lại
//             loadingIndicator.style.display = 'none'; // Ẩn spinner
//         }
//     });

//     // Gắn sự kiện bộ lọc ban đầu
//     const filterControls = document.querySelectorAll(".filter-controls li");
//     filterControls.forEach(control => {
//         control.addEventListener("click", function () {
//             filterControls.forEach(c => c.classList.remove("active"));
//             this.classList.add("active");
//             applyFilters(); // Áp dụng bộ lọc cho ảnh hiện tại và mới
//         });
//     });
// });




// kiểm tra đăng nhập mới được phép tải
// function handleCheckLogin() {
//     if (confirm(
//         "Bạn chưa đăng nhập. Vui lòng đăng nhập để tải ảnh. Bạn có muốn chuyển đến trang đăng nhập không?")) {
//         window.location.href = '/admin/users/login';
//     }
// }

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

// // hiệu ứng xuất hiện chậm 
// document.addEventListener("DOMContentLoaded", function () {
//     const observer = new IntersectionObserver((entries, observer) => {
//         entries.forEach(entry => {
//             if (entry.isIntersecting) {
//                 entry.target.classList.add("show");
//                 observer.unobserve(entry.target); // Ngừng theo dõi sau khi hiển thị
//             }
//         });
//     }, {
//         threshold: 0.2 // Kích hoạt khi 20% phần tử xuất hiện trong viewport
//     });

//     // Hàm quan sát ảnh mới
//     function observeNewImages() {
//         document.querySelectorAll(".item_image:not(.observed)").forEach(image => {
//             observer.observe(image);
//             image.classList.add("observed"); // Đánh dấu đã được quan sát
//         });
//     }

//     // Gọi quan sát ban đầu
//     observeNewImages();

//     // Khi tải thêm ảnh mới, gọi lại observeNewImages()
//     const gridWrapper = document.querySelector('.grid-wrapper');
//     const observerMut = new MutationObserver(() => {
//         observeNewImages();
//     });

//     observerMut.observe(gridWrapper, { childList: true });
// });

// document.addEventListener('DOMContentLoaded', function () {
//     let page = 1; // Trang hiện tại
//     let loading = false; // Trạng thái đang tải
//     let allImagesLoaded = false; // Biến đánh dấu đã tải hết ảnh
//     const totalImages = parseInt(document.getElementById('grid-images').getAttribute('data-total-images')); // Tổng số ảnh
//     const gridWrapper = document.querySelector('.grid-wrapper');
//     const loadingIndicator = document.getElementById('loading');
//     const baseURL = window.location.origin;
//     const footer = document.querySelector('.footer-section');

//     const pathname = window.location.pathname;
//     const parts = pathname.split('/').filter(Boolean); // Lọc bỏ các phần tử rỗng
//     const duong_dan = parts[0];
//     const value = parts[1];

//     const applyFilters = () => {
//         const activeFilter = document.querySelector('.filter-controls li.active').getAttribute('data-filter');
//         const items = document.querySelectorAll('.item_image');

//         items.forEach(item => {
//             if (activeFilter === "*" || item.classList.contains(activeFilter.substring(1))) {
//                 item.style.display = "block";
//             } else {
//                 item.style.display = "none";
//             }
//         });
//     };

//     // Hàm thêm ảnh mới và kích hoạt IntersectionObserver
//     const addImagesWithEffect = (images) => {
//         images.forEach(image => {
//             const categorySlug = image.category.name
//                 .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
//                 .toLowerCase().replace(/đ/g, 'd')
//                 .replace(/[^a-z0-9\s]/g, '').replace(/\s+/g, '-');

//             const directionClass = image.direction == '0' ? 'ngang' : 'doc';
//             const imageHTML = `
//                 <div class="item_image ${categorySlug} ${directionClass}" data-id="${image.id}">
//                     <img class="if" src="${baseURL}/${image.url}" alt="ảnh minh họa">
//                     <div class="box-icon">
//                         <div class="download-icon position-absolute top-0 start-0" title="Tải ảnh">
//                             <a href="${image.url}" download>
//                                 <i class="bi bi-download"></i>
//                                 <span>Tải ảnh</span>
//                             </a>
//                         </div>
//                         <div class="view-icon position-absolute start-0" title="Lượt xem">
//                             <i class="bi bi-eye"></i>
//                             <span>${image.view}</span>
//                         </div>
//                         <div class="like-icon position-absolute top-0 end-0" title="Thích ảnh" onclick="handleLike(${image.id}, this)">
//                             <i class="bi ${image.userHasLiked ? 'bi-heart-fill text-danger' : 'bi-heart'}"></i>
//                             <span>${image.like_count}</span>
//                         </div>
//                         <div class="report-icon position-absolute top-0 start-0" title="Báo cáo vi phạm">
//                             <a href="/baocao/${image.id}">
//                                 <i class="bi bi-chat-left-text"></i>
//                             </a>
//                         </div>
//                     </div>
//                     <a href="${baseURL}/${image.url}" class="pf-icon position-absolute image-popup" title="Mở rộng">
//                         <span class="icon_plus"></span>
//                     </a>
//                     <div class="pf-text">
//                         <h4>${image.category.name}</h4>
//                     </div>
//                 </div>
//             `;
//             gridWrapper.insertAdjacentHTML('beforeend', imageHTML);
//         });

//         // Áp dụng bộ lọc lại
//         applyFilters();

//         // Kích hoạt IntersectionObserver cho ảnh mới
//         document.querySelectorAll(".item_image").forEach(image => observer.observe(image));

//         // Khởi tạo lại popup cho ảnh mới
//         $(document).ready(function () {
//             $('.image-popup').magnificPopup({
//                 type: 'image',
//                 gallery: { enabled: true },
//                 callbacks: {
//                     markupParse: function (template, values, item) {
//                         var $imageElement = $(item.el).closest('.item_image');
//                         var viewCount = $imageElement.querySelector('.view-icon span').textContent;
//                         var likeCount = $imageElement.querySelector('.like-icon span').textContent;
//                         var category = $imageElement.querySelector('.pf-text h4').textContent;

//                         values.title = `
//                             <a href="${item.src}" download class="mfp-download"><i class="bi bi-download"></i></a>
//                             <div class="popup-info">
//                                 <p><strong><i class="bi bi-tags"></i></strong> ${category}</p>
//                                 <p><strong><i class="bi bi-eye"></i></strong> ${viewCount}</p>
//                                 <p><strong><i class="bi bi-heart-fill"></i></strong> ${likeCount}</p>
//                             </div>
//                         `;
//                     }
//                 }
//             });
//         });
//     };

//     // Xử lý sự kiện cuộn trang
//     window.addEventListener('scroll', async () => {
//         if (loading || allImagesLoaded) return;

//         const footerPosition = footer.getBoundingClientRect().top;
//         const viewportHeight = window.innerHeight;

//         if (footerPosition - viewportHeight <= 0) {
//             loading = true;
//             loadingIndicator.style.display = 'block';

//             page++;
//             const response = await fetch(`/get-images?page=${page}&duong_dan=${duong_dan}&value=${value}`);
//             const data = await response.json();

//             if (data.images.length > 0) {
//                 addImagesWithEffect(data.images);
//             }

//             if (gridWrapper.children.length >= totalImages) {
//                 allImagesLoaded = true;
//             }

//             loading = false;
//             loadingIndicator.style.display = 'none';
//         }
//     });

//     // Gắn sự kiện bộ lọc ban đầu
//     document.querySelectorAll(".filter-controls li").forEach(control => {
//         control.addEventListener("click", function () {
//             document.querySelectorAll(".filter-controls li").forEach(c => c.classList.remove("active"));
//             this.classList.add("active");
//             applyFilters();
//         });
//     });

//     // Hiệu ứng xuất hiện dần với IntersectionObserver
//     const observer = new IntersectionObserver((entries, observer) => {
//         entries.forEach(entry => {
//             if (entry.isIntersecting) {
//                 entry.target.classList.add("show");
//                 observer.unobserve(entry.target);
//             }
//         });
//     }, { threshold: 0.2 });

//     // Áp dụng hiệu ứng cho ảnh có sẵn
//     document.querySelectorAll(".item_image").forEach(image => observer.observe(image));
// });

