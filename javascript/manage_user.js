function fetchUser(page = 1) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./get_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        var res = JSON.parse(this.responseText);
        var tbody = document.getElementById('userTable');
        tbody.innerHTML = '';
        res.data.forEach((user, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${(res.page - 1) * res.limit + index + 1}</td>
                    <td>${user.email}</td>
                    <td>${user.fullname}</td>
                    <td>${user.birthday}</td>
                    <td>${user.total_bill}</td>
                    <td>
                        <button onclick="edituser('${user.user_id}', ${user.quantity}, ${user.price})" class="update"><i class="fa-solid fa-pen"></i></button>
                        <button onclick="deleteuser('${user.user_id}')" class="delete"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>`;
        });

        var pag = document.getElementById('pagination');
        pag.innerHTML = '';

        var maxPagesToShow = 2;
        var startPage = Math.max(1, res.page - Math.floor(maxPagesToShow / 2));
        var endPage = startPage + maxPagesToShow - 1;

        if (endPage > res.total_pages) {
            endPage = res.total_pages;
            startPage = Math.max(1, endPage - maxPagesToShow + 1);
        }

        if (res.page > 1) {
            pag.innerHTML += `<button onclick="fetchUser(${res.page - 1})"><i class="fa-solid fa-arrow-left"></i></button>`;
        }
        if (startPage > 1) {
            pag.innerHTML += `<button onclick="fetchUser(1)">1</button>`;
            if (startPage > 2) {
                pag.innerHTML += `<span>...</span>`;
            }
        }
        for (var i = startPage; i <= endPage; i++) {
            pag.innerHTML += `<button onclick="fetchUser(${i})" ${i === res.page ? 'style="font-weight:bold; background-color: #076614;"' : ''}>${i}</button>`;
        }
        if (endPage < res.total_pages) {
            if (endPage < res.total_pages - 1) {
                pag.innerHTML += `<span>...</span>`;
            }
            pag.innerHTML += `<button onclick="fetchUser(${res.total_pages})">${res.total_pages}</button>`;
        }
        if (res.page < res.total_pages) {
            pag.innerHTML += `<button onclick="fetchUser(${res.page + 1})"><i class="fa-solid fa-arrow-right"></i></button>`;
        }
    };
    xhr.send(`page=${page}`);
}

// function editProduct(productID, currentQuantity, currentPrice) {
//     var newQuantity = prompt("Nhập số lượng mới:", currentQuantity);
//     var newPrice = prompt("Nhập giá mới:", currentPrice);

//     if ((newQuantity !== null && !isNaN(newQuantity)) && (newPrice !== null && !isNaN(newPrice))) {
//         var xhr = new XMLHttpRequest();
//         xhr.open("POST", "./update_product.php", true);
//         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         xhr.onload = function () {
//             alert(this.responseText);
//             fetchUser();
//         };
//         xhr.send(`productID=${productID}&quantity=${newQuantity}&price=${newPrice}`);
//     }
// }

// function deleteProduct(productID) {
//     if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
//         var xhr = new XMLHttpRequest();
//         xhr.open("POST", "./delete_product.php", true);
//         xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         xhr.onload = function () {
//             alert(this.responseText);
//             fetchUser();
//         };
//         xhr.send(`productID=${productID}`);
//     }
// }

window.onload = function () {
    fetchUser();
};