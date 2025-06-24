function fetchBill(page = 1) {
    var xhttp = new XMLHttpRequest();
    var email = getQueryParam("email");
    var status = document.getElementById("status").value;
    var params = `page=${page}`;
    if (email) params += `&email=${encodeURIComponent(email)}`;
    xhttp.open("POST", "../admin/get_bill.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function () {
        var res = JSON.parse(this.responseText);
        var tbody = document.getElementById('billTable');
        tbody.innerHTML = '';
        res.data.forEach((bill, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${(res.page - 1) * res.limit + index + 1}</td>
                    <td>${bill.email}</td>
                    <td>${bill.name_customer}</td>
                    <td>${bill.phone}</td>
                    <td>${bill.order_date}</td>
                    <td>${parseInt(bill.total_price).toLocaleString()} VNĐ</td>
                    <td>${bill.order_status}</td>
                    <td>
                        <button class="btn-product" onclick="detail(${bill.id})">Xem chi tiết</button>
                    </td>
                </tr>`;
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
            pag.innerHTML += `<button onclick="fetchBill(${res.page - 1})"><i class="fa-solid fa-arrow-left"></i></button>`;
        }
        if (startPage > 1) {
            pag.innerHTML += `<button onclick="fetchBill(1)">1</button>`;
            if (startPage > 2) {
                pag.innerHTML += `<span>...</span>`;
            }
        }
        for (var i = startPage; i <= endPage; i++) {
            pag.innerHTML += `<button onclick="fetchBill(${i})" ${i === res.page ? 'style="font-weight:bold; background-color: #076614;"' : ''}>${i}</button>`;
        }
        if (endPage < res.total_pages) {
            if (endPage < res.total_pages - 1) {
                pag.innerHTML += `<span>...</span>`;
            }
            pag.innerHTML += `<button onclick="fetchBill(${res.total_pages})">${res.total_pages}</button>`;
        }
        if (res.page < res.total_pages) {
            pag.innerHTML += `<button onclick="fetchBill(${res.page + 1})"><i class="fa-solid fa-arrow-right"></i></button>`;
        }
    };
    if(status !== "Tất cả") params += `&status=${encodeURIComponent(status)}`;
    xhttp.send(params);
}

function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

function detail(order_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../admin/get_detail.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function() {
        document.getElementById("list_order").style.display = "none";
        document.getElementById("order_detail").style.display = "block";

        var child1 = document.getElementById("child1");
        var item = JSON.parse(this.responseText).data_order;
        child1.innerHTML = `
            <form action="./update_order.php" method="post">
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
                <select name="order_status">
                    <option value="Đang xử lý" ${item.order_status === 'Đang xử lý' ? 'selected' : ''}>Đang xử lý</option>
                    <option value="Thành công" ${item.order_status === 'Thành công' ? 'selected' : ''}>Thành công</option>
                    <option value="Hủy đơn" ${item.order_status === 'Hủy đơn' ? 'selected' : ''}>Hủy đơn</option>
                </select>
                <button type="submit" style="margin: 10px 0px;">Cập nhật trạng thái</button>
            </form>`;

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
    document.getElementById("list_order").style.display = "block";
    document.getElementById("order_detail").style.display = "none";
    fetchBill();
}

window.onload = function () {
    fetchBill();
};