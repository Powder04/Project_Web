var apiBase = "https://provinces.open-api.vn/api";
var provinces = [];

// Khởi tạo dữ liệu khi load trang
async function initProvinces() {
  var r = await fetch(`${apiBase}/?depth=3`);
  provinces = await r.json();
  var pSel = document.getElementById("province");
  provinces.forEach((p) => {
    var opt = new Option(p.name, p.name); // Option(Text hiển thị, value, defaultSelected, selected)
    pSel.add(opt);
  });
}

// Cập nhật danh sách quận/huyện theo tỉnh
function onProvinceChange() {
  var code = this.value;
  var p = provinces.find((x) => x.name == code);
  var dSel = document.getElementById("district");
  dSel.innerHTML = '<option value="">-- Chọn Quận/Huyện --</option>';
  document.getElementById("ward").innerHTML =
    '<option value="">-- Chọn Phường/Xã --</option>';
  document.getElementById("ward").disabled = true;

  if (p) {
    p.districts.forEach((d) => dSel.add(new Option(d.name, d.name)));
    dSel.disabled = false;
  } else {
    dSel.disabled = true;
  }
}

// Cập nhật danh sách phường/xã theo quận/huyện
function onDistrictChange() {
  var province = provinces.find(
    (p) => p.name == document.getElementById("province").value
  );
  var district = province?.districts.find((d) => d.name == this.value);
  var wSel = document.getElementById("ward");
  wSel.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
  if (district?.wards) {
    district.wards.forEach((w) => wSel.add(new Option(w.name, w.name)));
    wSel.disabled = false;
  } else {
    wSel.disabled = true;
  }
}

async function loadCart() {
    var res = await fetch('../api/get_cart.php');
    var data = await res.json();

    var dropdown = document.getElementById("cart");
    if(data.length === 0) {
        dropdown.innerHTML = "<div style='margin-top: 30px;'><p style='text-align: center;'>Giỏ hàng trống</p></div>";
    } else {
        var x = 0;
        var bill = data.map((item, index) => {x += parseInt(item.total_price);});
        dropdown.innerHTML = data.map((item, index) =>
                `<div class="cart-item">
                    <p>${index+1}</p>
                    <p><img style="width: 60px;" src="${item.image}"/></p>
                    <p>${item.name}</p>
                    <p>x${item.quantity}</p>
                    <p>${parseInt(item.total_price).toLocaleString()}VNĐ</p>
                    <button onclick="removeItem(${index}, event)">Xóa</button>
                </div>`).join('');
        dropdown.innerHTML += 
                `<div id="pay">
                    <h3>Tổng thanh toán: ${x.toLocaleString()}VNĐ</h3>
                    <button type="submit">Thanh Toán</button>
                </div>`;
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

function toggleQR() {
  var payment_method = document.getElementById("payment_method").value;
  if(payment_method === "Chuyển khoản qua ngân hàng") {
    document.getElementById("bankQR").style.display = "block";
    document.getElementById("momoQR").style.display = "none";
  }
  else if(payment_method === "Thanh toán qua Momo") {
    document.getElementById("momoQR").style.display = "block";
    document.getElementById("bankQR").style.display = "none";
  }
  else {
    document.getElementById("bankQR").style.display = "none";
    document.getElementById("momoQR").style.display = "none";
  }
}

document.getElementById("province").addEventListener("change", onProvinceChange);
document.getElementById("district").addEventListener("change", onDistrictChange);
document.addEventListener("DOMContentLoaded", loadCart);
initProvinces();