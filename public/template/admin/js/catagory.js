document.getElementById('category_id').addEventListener('change', function () {
    const parentId = this.value; // Lấy ID danh mục cha được chọn
    const childOptions = document.querySelectorAll('#category_child option');

    // Hiển thị lại tất cả các option mặc định
    childOptions.forEach(option => {
        option.style.display = ''; // Hiển thị lại tất cả các option
        option.disabled = false; // Mở khóa tất cả các option
    });

    // Lọc danh mục con
    childOptions.forEach(option => {
        const optionParentId = option.getAttribute('data-parent-id');

        if (parentId !== "" && optionParentId !== parentId) {
            option.style.display = 'none'; // Ẩn các option không phù hợp
            option.disabled = true; // Khóa các option không phù hợp
        }
    });

    // Đặt lại giá trị danh mục con
    document.getElementById('category_child').value = "";
});

//lấy danh mục con gắn vào mô tả 
function addToDescription(subcategoryName) {
    const descriptionField = document.getElementById('description');
    const currentValue = descriptionField.value.trim(); // Lấy giá trị hiện tại trong textarea

    // Tách các danh mục hiện tại thành mảng
    let categories = currentValue ? currentValue.split(' - ') : [];

    // Kiểm tra nếu danh mục đã tồn tại thì không thêm lại
    if (!categories.includes(subcategoryName)) {
        categories.push(subcategoryName);
    }

    // Cập nhật giá trị mới với các danh mục cách nhau bởi dấu gạch
    descriptionField.value = categories.join(' - ');
}
