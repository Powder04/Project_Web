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
                        <input type="number" min="0" max="${product.quantity}" value="0">
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

    if (isNaN(quantity) || quantity === 0) {
        alert("Vui lòng nhập số lượng hợp lệ!");
        return;
    }

    if (quantity > 50) {
        alert("Số lượng mua quá lớn. Vui lòng nhập lại số lượng.");
        return;
    }

    if (quantity > stock) {
        alert(`Chỉ còn ${stock} sản phẩm trong kho. Vui lòng nhập lại số lượng.`);
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