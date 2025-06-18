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
                        <button onclick="editUser('${user.email}', '${user.fullname}', ${user.birthday})" class="update"><i class="fa-solid fa-pen"></i></button>
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
    xhr.send(`page=${page}`);
}

function editUser(email, fullname, birthday) {
    var newEmail = prompt("Nhập email mới:", email);
    var newFullname = prompt("Nhập họ và tên mới:", fullname);
    var newBirthday = prompt("Nhập năm sinh mới:", birthday);

    if (newEmail && newFullname && newBirthday) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./update_user.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            alert(this.responseText);
            fetchUser();
        };
        xhr.send(`old_email=${encodeURIComponent(email)}&email=${encodeURIComponent(newEmail)}&fullname=${encodeURIComponent(newFullname)}&birthday=${encodeURIComponent(newBirthday)}`);
    }
}

function deleteUser(email) {
    if (confirm("Bạn có chắc chắn muốn xóa khách hàng này?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "./delete_user.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            alert(this.responseText);
            fetchUser();
        };
        xhr.send(`email=${encodeURIComponent(email)}`);
    }
}

window.onload = function () {
    fetchUser();
};