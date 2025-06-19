function fetchProducts(page = 1) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../admin/get_products.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        var res = JSON.parse(this.responseText);
        var tbody = document.getElementById('productTable');
        tbody.innerHTML = '';
        res.data.forEach((product, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${(res.page - 1) * res.limit + index + 1}</td>
                    <td>${product.product_id}</td>
                    <td>${product.name}</td>
                    <td><img src="data:${product.mime_type};base64,${product.image_data}" width="60px"/></td>
                    <td>${parseInt(product.price).toLocaleString()} VNĐ</td>
                    <td>${product.quantity}</td>
                    <td>${product.sold_count}</td>
                    <td>
                        <button onclick="editProduct('${product.product_id}', ${product.quantity}, ${product.price})" class="update"><i class="fa-solid fa-pen"></i></button>
                        <button onclick="deleteProduct('${product.product_id}')" class="delete"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });

        var pag = document.getElementById('pagination');
        pag.innerHTML = '';

        var maxPagesToShow = 1;
        var startPage = Math.max(1, res.page - Math.floor(maxPagesToShow / 2));
        var endPage = startPage + maxPagesToShow - 1;

        if (endPage > res.total_pages) {
            endPage = res.total_pages;
            startPage = Math.max(1, endPage - maxPagesToShow + 1);
        }

        if (res.page > 1) {
            pag.innerHTML += `<button onclick="fetchProducts(${res.page - 1})"><i class="fa-solid fa-arrow-left"></i></button>`;
        }
        if (startPage > 1) {
            pag.innerHTML += `<button onclick="fetchProducts(1)">1</button>`;
            if (startPage > 2) {
                pag.innerHTML += `<span>...</span>`;
            }
        }
        for (var i = startPage; i <= endPage; i++) {
            pag.innerHTML += `<button onclick="fetchProducts(${i})" ${i === res.page ? 'style="font-weight:bold; background-color: #076614;"' : ''}>${i}</button>`;
        }
        if (endPage < res.total_pages) {
            if (endPage < res.total_pages - 1) {
                pag.innerHTML += `<span>...</span>`;
            }
            pag.innerHTML += `<button onclick="fetchProducts(${res.total_pages})">${res.total_pages}</button>`;
        }
        if (res.page < res.total_pages) {
            pag.innerHTML += `<button onclick="fetchProducts(${res.page + 1})"><i class="fa-solid fa-arrow-right"></i></button>`;
        }
    };
    xhr.send(`page=${page}`);
}

function editProduct(productID, currentQuantity, currentPrice) {
    var newQuantity = prompt("Nhập số lượng mới:", currentQuantity);
    var newPrice = prompt("Nhập giá mới:", currentPrice);

    if ((newQuantity !== null && !isNaN(newQuantity)) && (newPrice !== null && !isNaN(newPrice))) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../admin/update_product.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            alert(this.responseText);
            fetchProducts();
        };
        xhr.send(`productID=${productID}&quantity=${newQuantity}&price=${newPrice}`);
    }
}

function deleteProduct(productID) {
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../admin/delete_product.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            alert(this.responseText);
            fetchProducts();
        };
        xhr.send(`productID=${productID}`);
    }
}

window.onload = function () {
    fetchProducts();
};