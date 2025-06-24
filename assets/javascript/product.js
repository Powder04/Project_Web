function fetchProduct(page = 1) {
    var type = document.getElementById("typeProduct").value;
    var sale = document.getElementById("saleProduct").value;
    var price = document.getElementById("priceProduct").value;

    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../api/product.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function() {
        var res = JSON.parse(this.responseText);
        var main = document.querySelector(".hero-container1");
        main.innerHTML = "";
        res.data.forEach((product) => {
            main.innerHTML += `
                <div class="product"
                    data-name="${product.name}" 
                    data-price="${product.price}"
                    data-stock="${product.quantity}" 
                    data-image="data:${product.mime_type};base64,${product.image_data}">
                    <img src="data:${product.mime_type};base64,${product.image_data}"/>
                    <p>${product.name}</p>
                    <div class="price-sold">
                        <span class="price">${parseInt(product.price).toLocaleString()}VNĐ</span>
                        <span class="sold">${product.sold_count} lượt bán</span>
                    </div>
                    <div class="quantity">
                        <label>Số lượng: </label>
                        <input type="number" min="0" max="99" value="1">
                    </div>
                    <div class="btn-product">
                        <button onclick="addToCart('${product.product_id}', this)">Thêm vào giỏ hàng</button>
                    </div>
                </div>
            `;
        });

        var pag = document.getElementById("pagination-product");
        pag.innerHTML = "";

        var maxPagesToShow = 1;
        var start = Math.max(1, res.page - Math.floor(maxPagesToShow / 2));
        var end = start + maxPagesToShow - 1;
        if (end > res.total_pages) {
            end = res.total_pages;
            start = Math.max(1, end - maxPagesToShow + 1);
        }

        if (res.page > 1) {
            pag.innerHTML += `<button onclick="fetchProduct(${res.page - 1})"><i class="fa-solid fa-arrow-left"></i></button>`;
        }
        if (start > 1) {
            pag.innerHTML += `<button onclick="fetchProduct(1)">1</button>`;
            if (start > 2) pag.innerHTML += `<span>...</span>`;
        }
        for (var i = start; i <= end; i++) {
            pag.innerHTML += `<button onclick="fetchProduct(${i})" ${i === res.page ? 'style="font-weight:bold; background-color: #076614;"' : ''}>${i}</button>`;
        }

        if (end < res.total_pages) {
            if (end < res.total_pages - 1) pag.innerHTML += `<span>...</span>`;
            pag.innerHTML += `<button onclick="fetchProduct(${res.total_pages})">${res.total_pages}</button>`;
        }

        if (res.page < res.total_pages) {
            pag.innerHTML += `<button onclick="fetchProduct(${res.page + 1})"><i class="fa-solid fa-arrow-right"></i></button>`;
        }
    };

    var postData = `page=${page}`;
    if (type !== "Tất cả") {
        postData += `&type=${encodeURIComponent(type)}`;
    }
    if (sale !== "Không") {
        postData += `&sale=${encodeURIComponent(sale)}`;
    }
    if (price !== "Không") {
        postData += `&price=${encodeURIComponent(price)}`;
    }
    xhttp.send(postData);
}

function fetchHistory(page = 1) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../api/get_bill.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function () {
        var res = JSON.parse(this.responseText);
        var tbody = document.getElementById('historyTable');
        document.getElementById("information").style.display = "none";
        document.getElementById("list_order").style.display = "block";
        document.getElementById("order_detail").style.display = "none";
        tbody.innerHTML = '';
        res.data.forEach((history, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${(res.page - 1) * res.limit + index + 1}</td>
                    <td>${history.email}</td>
                    <td>${history.name_customer}</td>
                    <td>${history.phone}</td>
                    <td>${history.order_date}</td>
                    <td>${parseInt(history.total_price).toLocaleString()} VNĐ</td>
                    <td>
                        <button class="btn1" onclick="detail(${history.id})">Xem chi tiết</button>
                    </td>
                </tr>`;
        });
    }
    xhttp.send(`page=${page}`);
}

function detail(order_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../api/get_detail.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function() {
        document.getElementById("information").style.display = "none";
        document.getElementById("list_order").style.display = "none";
        document.getElementById("order_detail").style.display = "block";

        var child1 = document.getElementById("child1");
        var item = JSON.parse(this.responseText).data_order;
        child1.innerHTML = `
                <input name="order_id" type="hidden" value="${item.id}">
                <p>Email:</p>
                <input value="${item.email}" readonly>
                <p>Họ và tên:</p>
                <input value="${item.name_customer}" readonly>
                <p>Số điện thoại:</p>
                <input value="${item.phone}" readonly>
                <p>Địa chỉ giao hàng:</p>
                <input value="${item.address}" readonly>
                <p>Phương thức thanh toán:</p>
                <input value="${item.payment_method}" readonly>
                <p>Tình trạng đơn hàng:</p>
                <input value="${item.order_status}" readonly>`;

        var bill = document.getElementById("bill");
        var res = JSON.parse(this.responseText);
        bill.innerHTML = '';
        res.data_detail.forEach((item, index) => {
            bill.innerHTML += `
                <tr class="bill">
                    <td>${item.product_id}</td>
                    <td>${item.product_name}</td>
                    <td><img src="data:${item.mime_type};base64,${item.image_data}" width="60px"/></td>
                    <td>x${item.quantity}</td>
                    <td>${parseInt(item.total_price).toLocaleString()}VNĐ</td>
                </tr>`;
        });
        document.getElementById("total").innerHTML = '';
        document.getElementById("total").innerHTML = `<h3>Tổng thanh toán: ${parseInt(item.total_price).toLocaleString()}VNĐ</h3>`;
    } 
    xhttp.send(`order_id=${order_id}`);
}

function backToList() {
    document.getElementById("list_order").style.display = "none";
    document.getElementById("information").style.display = "block";
    document.getElementById("order_detail").style.display = "none";
}

function backToHistory() {
    document.getElementById("information").style.display = "none";
    document.getElementById("list_order").style.display = "block";
    document.getElementById("order_detail").style.display = "none";
}

async function addToCart(product_id, button) { 
    // Kiểm tra đăng nhập
    var checkLogin = await fetch('../api/check_login.php');
    var loginStatus = await checkLogin.json();

    if (!loginStatus.login) {
        alert("Vui lòng đăng nhập để mua sản phẩm.");
        window.location.href = "../pages/login.html";
        return;
    }

    // Lấy thông tin sản phẩm
    var productElement = button.closest('.product');
    var name = productElement.dataset.name;
    var price = parseInt(productElement.dataset.price);
    var image = productElement.dataset.image;
    var stock = parseInt(productElement.dataset.stock); 
    var quantity = parseInt(productElement.querySelector('input[type="number"]').value);
    var total_price = price * quantity;

    if (quantity > stock) {
        alert(`Vượt quá số lượng sản phẩm trong kho. Vui lòng nhập lại số lượng.`);
        return;
    }

    var dataToSend = {product_id, image, name, price, quantity, stock, total_price};
    var res = await fetch('../api/add_to_cart.php', {
        method: "POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(dataToSend)
    });

    alert(`${name} được đặt thành công. Số lượng: ${quantity}`);
    loadCart();
    fetchProduct();
}

async function loadCart() {
    var res = await fetch('../api/get_cart.php');
    var data = await res.json();

    var dropdown = document.getElementById("cart-dropdown");
    if(data.length === 0) {
        dropdown.innerHTML = "<div class='cart'><p>Giỏ hàng trống</p></div>";
    } else {
        dropdown.innerHTML = data.map((item, index) =>
                `<div class="cart-item">
                    <p><img style="width: 60px;" src="${item.image}"/></p>
                    <p>${item.name}</p>
                    <p>x${item.quantity}</p>
                    <p>${parseInt(item.total_price).toLocaleString()}VNĐ</p>
                    <button class="del" onclick="removeItem(${index}, event)">Xóa</button>
                </div>`).join('');
    }
}

function removeItem(index, event) {
    event.stopPropagation();     
    event.preventDefault();   

    fetch('../api/remove_from_cart.php', {
        method: "POST",
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `index=${index}`
    }).then(() => loadCart());
}

var hideTimeout;
function showCartDropdown() {
    clearTimeout(hideTimeout);
    document.getElementById("cart-dropdown").style.display = "block";
    loadCart();
}

function hideCartDropdown() {
    hideTimeout = setTimeout(() => {
        document.getElementById("cart-dropdown").style.display = "none";
    }, 300);
}

function cancelHide() {
    clearTimeout(hideTimeout);
}

window.onload = function () {
    fetchProduct();
    loadCart();
};
document.addEventListener("DOMContentLoaded", );