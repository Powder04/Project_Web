var currentYear = new Date().getFullYear();
var selected = document.querySelector("select");

for (var i = currentYear - 100; i <= currentYear; i++) {
  var opt = document.createElement("option");
  opt.setAttribute("value", `${i}`);
  opt.innerText = `${i}`;
  selected.append(opt);
}

function checkForm() {
  var pwd = document.getElementById("pwd").value;
  var repwd = document.getElementById("repwd").value;
  var birth = document.getElementById("birth").value;

  if (birth === "none") {
    alert("Vui lòng chọn năm sinh.");
    return false;
  }
  if (pwd !== repwd) {
    alert("Mật khẩu không trùng khớp. Vui lòng kiểm tra lại.");
    return false;
  }
  return true;
}

function togglePassword() {
  var passwordInput = document.getElementById("password");
  var icon = document.getElementById("toggleIcon");

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    icon.innerHTML = '<i class="fa-solid fa-eye"></i>';
  } else {
    passwordInput.type = "password";
    icon.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
  }
}