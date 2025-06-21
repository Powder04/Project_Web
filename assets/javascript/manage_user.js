function fetchUser(page = 1) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../admin/get_user.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function () {
        var res = JSON.parse(this.responseText);
        var tbody = document.getElementById('userTable');
        tbody.innerHTML = '';
        res.data.forEach((user, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${(res.page - 1) * res.limit + index + 1}</td>
                    <td>${user.fullname}</td>
                    <td>${user.email}</td>
                    <td>${user.birthday}</td>
                    <td>
                        <input onclick="updateUser('${user.email}', 'status', 1)" type="radio" name="status" value="1" ${user.status == 1 ? 'checked' : ''}> Active
                        <input onclick="updateUser('${user.email}', 'status', 0)" type="radio" name="status" value="0" ${user.status == 0 ? 'checked' : ''}> Blocked
                    </td>
                    <td>
                        <select onchange="updateUser('${user.email}', 'role', this.value)" name="role">
                            <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
                            <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                        </select>
                    </td>
                    <td>${new Date(user.created_at).toLocaleDateString('vi-VN')}</td>
                    <td>${user.total_bill}</td>
                    <td>
                        <button onclick="editUser('${user.email}')" class="update"><i class="fa-solid fa-pen"></i></button>
                        <button onclick="deleteUser('${user.email}')" class="delete"><i class="fa-solid fa-trash"></i></button>
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
    xhttp.send(`page=${page}`);
}

function updateUser(email, field, value) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../admin/update_field_user.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function() {
        alert("Cập nhật thành công.");
    }
    xhttp.send(`email=${encodeURIComponent(email)}&field=${field}&value=${encodeURIComponent(value)}`);
}

// function editUser(email) {
//     var newEmail = prompt("Nhập email mới:", email);
//     var newFullname = prompt("Nhập họ và tên mới:", fullname);
//     var newBirthday = prompt("Nhập năm sinh mới:", birthday);

//     if (newEmail && newFullname && newBirthday) {
//         var xhttp = new XMLHttpRequest();
//         xhttp.open("POST", "../admin/update_user.php", true);
//         xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//         xhttp.onload = function() {
//             alert(this.responseText);
//             fetchUser();
//         };
//         xhttp.send(`old_email=${encodeURIComponent(email)}&email=${encodeURIComponent(newEmail)}&fullname=${encodeURIComponent(newFullname)}&birthday=${encodeURIComponent(newBirthday)}`);
//     }
// }

function deleteUser(email) {
    if (confirm("Bạn có chắc chắn muốn xóa khách hàng này?")) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "../admin/delete_user.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.onload = function () {
            alert(this.responseText);
            fetchUser();
        };
        xhttp.send(`email=${encodeURIComponent(email)}`);
    }
}

window.onload = function () {
    fetchUser();
};