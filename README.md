# Niên luận cơ sở Mạng máy tính và Truyền thông dữ liệu - Website bán sản phẩm len có sẵn

## Giới thiệu
- Đây là website bán các sản phẩm từ len (móc khóa, balo, phụ kiện tóc, ...)

- Người xem trang web ở chế độ khách chỉ có thể lướt xem các sản phẩm của shop
- Người xem trang web ở chế độ người dùng có thể xem sản phẩm, mua hàng, xem thông tin và lịch sử đơn hàng đã mua, 
cập nhật thông tin tài khoản, gửi góp ý
- Admin có thể xem được các thống kê, quản lý sản phẩm, người dùng, đơn hàng và phản hồi

## Tính năng chính
- Trang chủ hiển thị 12 sản phẩm có lượt bán cao nhất
- Đăng nhập / Đăng ký tài khoản
- Trang sản phẩm hiển thị danh sách sản phẩm còn hàng, có thể lọc theo loại sản phẩm, lượt bán, giá bán
- Trang thanh toán
- Trang thông tin khách hàng, có thể xem thông tin và lịch sử đơn hàng đã đặt
- Trang cập nhật thông tin
- Trang gửi góp ý
- Phần Admin:
    + Xem thống kê
    + Quản lý sản phẩm: Thêm / sửa / xóa; lọc sản phẩm theo loại, giá, lượt bán
    + Quản lý người dùng: Thêm / sửa / xóa / phân quyền / chỉnh sửa trạng thái, lọc theo phân quyền, xem danh sách 
    đơn hàng của mỗi người dùng
    + Quản lý đơn hàng: Xem danh sách đơn hàng (có thể lọc theo trạng thái đơn), xem chi tiết của từng đơn hàng và
    cập nhật lại trạng thái đơn
    + Quản lý phản hồi: Xem danh sách các phản hồi mà khách hàng đã gửi (có thể lọc theo trạng thái), 
    chỉnh sửa trạng thái xử lý

## Cài đặt

### Yêu cầu
- Visual Studio Code
- XAMPP
- Trình duyệt (Chrome, Edge, Firefox)

### Hướng dẫn cài đặt
1. Clone project: `https://github.com/Powder04/Project_Web`

2. Cấu hình bổ sung:
    - Apache (httpd.conf): Thêm đoạn dưới đây vào cuối file:
        Alias /project E:\Project_Web
        <Directory E:\Project_Web>
            Options Indexes FollowSymLinks ExecCGI Includes
            AllowOverride All
            Require all granted
        </Directory>
    *P/s: Ổ đĩa E:\Project_Web(Tên đường dẫn này thay bằng tên đường dẫn lưu trữ project clone về phía trên) 

    - PHP (php.ini): chỉnh sửa:
        upload_max_filesize = 128M
        post_max_size = 128M
        max_execution_time = 300

    - MySQL (my.ini): chỉnh sửa:
        max_allowed_packet = 256M

3. Import database: 
    - Mở phpMyAdmin
    - Import file `project.sql`

4. Cấu hình database:
    - Chỉnh `includes/mysqlConnect.php` cho đúng user/pass DB

5. Chạy local:
    - Mở trình duyệt tại `http://localhost/project`

## Tài khoản mẫu
**User:**
    Email: jinxjinx123@gmail.com
    Password: Jinx2004

**Admin:**
    Email: tiemlencuakyu@gmail.com
    Password: @TiemlencuaKyu12

## Cấu trúc thư mục
- `/account/`: Các file insert dữ liệu vào DB (hóa đơn, góp ý, đăng ký, cập nhật thông tin, đăng nhập) 
- `/admin/`: Giao diện quản trị viên
- `/api/`: Các API xử lý AJAX
- `/assets/`: css / images / javascript
- `/includes/`: File kết nối DB, logout
- `/pages/`: Giao diện khách hàng, khách vãng lai
- `/uploads/`: Ảnh sản phẩm

## Liên hệ tác giả
Họ và tên: Lưu Trần Nhã Khuê
MSSV: B2204942
Email: khueb2204942@student.ctu.edu.vn