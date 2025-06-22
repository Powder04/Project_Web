function fetchProducts(page = 1) {
    var typeProduct = document.getElementById("type").value;
    var saleProduct = document.getElementById("sale").value;
    var priceProduct = document.getElementById("price").value;

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../admin/get_product.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function () {
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
                        <button onclick="editProduct('${product.product_id}')" class="update">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button onclick="deleteProduct('${product.product_id}')" class="delete"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>`;});

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
    var postData = `page=${page}`;
    if (typeProduct !== "Tất cả") {
        postData += `&typeProduct=${encodeURIComponent(typeProduct)}`;
    }
    if (saleProduct !== "Không") {
        postData += `&saleProduct=${encodeURIComponent(saleProduct)}`;
    }
    if (priceProduct !== "Không") {
        postData += `&priceProduct=${encodeURIComponent(priceProduct)}`;
    }
    xhttp.send(postData);
}

function editProduct(product_id) {
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '../admin/form_product.php';

    var inputId = document.createElement('input');
    inputId.type = 'hidden';
    inputId.name = 'product_id';
    inputId.value = product_id;
    form.appendChild(inputId);

    document.body.appendChild(form);
    form.submit();
}

function deleteProduct(productID) {
    if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "../admin/delete_product.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.onload = function () {
            alert(this.responseText);
            fetchProducts();
        };
        xhttp.send(`productID=${productID}`);
    }
}

window.onload = function () {
    fetchProducts();
};