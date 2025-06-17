var listPrice = document.getElementsByClassName('price');
for(var i = 0; i<listPrice.length; i++) {
    var newPrice = parseInt(listPrice[i].innerHTML, 10).toLocaleString('vi-VN');
    listPrice[i].innerHTML = newPrice + "VNĐ";
}

var currentYear = new Date().getFullYear();
var selected = document.querySelector('select');

for(var i = currentYear-100; i<=currentYear; i++) {
    var opt = document.createElement('option');
    opt.setAttribute('value', `${i}`);
    opt.innerText = `${i}`;
    selected.append(opt);
}

function checkForm() {
    var pwd = document.getElementById('pwd').value;
    var repwd = document.getElementById('repwd').value;
    var birth = document.getElementById('birth').value;

        if(birth === 'none') {
            alert("Vui lòng chọn năm sinh.");
            return false;
        }
        if(pwd !== repwd) {
            alert("Mật khẩu không trùng khớp. Vui lòng kiểm tra lại.");
            return false;
        }
    return true;
}