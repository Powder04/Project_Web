function fetchFeedBack(page = 1) {
    var xhttp = new XMLHttpRequest();
    var status = document.getElementById("status").value;
    var params = `page=${page}`;
    xhttp.open("POST", "../admin/get_feedback.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function () {
        var res = JSON.parse(this.responseText);
        var tbody = document.getElementById('feedbackTable');
        tbody.innerHTML = '';
        res.data.forEach((feedback, index) => {
            tbody.innerHTML += `
                <tr>
                    <td>${(res.page - 1) * res.limit + index + 1}</td>
                    <td>${feedback.email}</td>
                    <td>${feedback.submitted_at}</td>
                    <td>${feedback.message}</td>
                    <td>
                        <select onchange="updateFeedback('${feedback.email}', this.value)" name="status" style="padding: 3px 10px;">
                            <option value="Đang xử lý" ${feedback.status === 'Đang xử lý' ? 'selected' : ''}>Đang xử lý</option>
                            <option value="Đã xử lý" ${feedback.status === 'Đã xử lý' ? 'selected' : ''}>Đã xử lý</option>
                        </select>
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
            pag.innerHTML += `<button onclick="fetchFeedBack(${res.page - 1})"><i class="fa-solid fa-arrow-left"></i></button>`;
        }
        if (startPage > 1) {
            pag.innerHTML += `<button onclick="fetchFeedBack(1)">1</button>`;
            if (startPage > 2) {
                pag.innerHTML += `<span>...</span>`;
            }
        }
        for (var i = startPage; i <= endPage; i++) {
            pag.innerHTML += `<button onclick="fetchFeedBack(${i})" ${i === res.page ? 'style="font-weight:bold; background-color: #076614;"' : ''}>${i}</button>`;
        }
        if (endPage < res.total_pages) {
            if (endPage < res.total_pages - 1) {
                pag.innerHTML += `<span>...</span>`;
            }
            pag.innerHTML += `<button onclick="fetchFeedBack(${res.total_pages})">${res.total_pages}</button>`;
        }
        if (res.page < res.total_pages) {
            pag.innerHTML += `<button onclick="fetchFeedBack(${res.page + 1})"><i class="fa-solid fa-arrow-right"></i></button>`;
        }
    };
    if(status !== "Tất cả") params += `&status=${encodeURIComponent(status)}`;
    xhttp.send(params);
}

function updateFeedback(email, status) {
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "../admin/update_feedback.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.onload = function() {
        alert("Cập nhật thành công.");
    }
    xhttp.send(`email=${encodeURIComponent(email)}&status=${encodeURIComponent(status)}`);
}

window.onload = function () {
    fetchFeedBack();
};