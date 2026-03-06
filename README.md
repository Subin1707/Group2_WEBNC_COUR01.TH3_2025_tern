<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# HỆ THỐNG QUẢN LÝ RẠP CHIẾU PHIM

## Các thành viên trong nhóm
- **Nguyễn Mạnh Quyền-23010198**:Phát triển phần mềm
- **Nguyễn Huy Hiệp-23010178**:Phát triển phần mềm

## I. Giới thiệu Project

## GIỚI THIỆU DỰ ÁN
Trong thời đại công nghệ số, nhu cầu đặt vé và quản lý thông tin rạp chiếu phim trực tuyến ngày càng trở nên phổ biến. Các hệ thống đặt vé online giúp người dùng dễ dàng tra cứu lịch chiếu, chọn ghế và thanh toán nhanh chóng, đồng thời hỗ trợ rạp trong việc quản lý suất chiếu, phòng chiếu và doanh thu. Do đó, việc xây dựng một ứng dụng quản lý rạp chiếu phim là vô cùng cần thiết để đáp ứng nhu cầu thực tiễn.

### 🔧 Các chức năng chính

**🧑‍💼 1️⃣ Admin (CRUD)**

Admin có thể thực hiện các chức năng quản trị hệ thống:

🎞️ Movies – Quản lý phim: thêm, sửa, xóa, tìm kiếm.

🏢 Theaters – Quản lý rạp chiếu: thêm, sửa, xóa, tìm kiếm.

🎦 Rooms – Quản lý phòng chiếu: thêm, sửa, xóa, tìm kiếm.

🕒 Showtimes – Quản lý lịch chiếu: tạo, chỉnh sửa, xóa, tìm kiếm.

👥 Users – Quản lý người dùng: thêm, sửa, xóa, tìm kiếm.

💬 Comments – Quản lý bình luận: xem, xóa, tìm kiếm.

🧾 Bookings – Quản lý đặt vé: xem danh sách vé đã đặt, chỉnh sửa thông tin, xóa hoặc tìm kiếm theo khách hàng hoặc phim.

**🎫 2️⃣ Khách Hàng (Customer)**

Khách hàng có thể:

👀 Xem phim đang chiếu và sắp chiếu, xem chi tiết và lịch chiếu.

🏷️ Đặt vé theo rạp, suất chiếu, chọn ghế và xác nhận thanh toán.

💬 Bình luận và đánh giá phim sau khi xem.

📜 Xem lịch sử đặt vé và quản lý tài khoản cá nhân.

**🛠️ Công nghệ sử dụng**

Framework: Laravel 12 + Laravel Breeze

Ngôn ngữ: PHP, CSS

Cơ sở dữ liệu: MySQL

Môi trường: XAMPP

Frontend: Blade Template + DataTables

Công cụ: Composer, Artisan CLI

## II. Thiết kế các đối tượng

### User (Người dùng)

**1. Giới thiệu:**
Lớp User đại diện cho tài khoản người dùng trong hệ thống quản lý rạp chiếu phim. Mỗi người dùng có thể là quản trị viên hoặc khách hàng. Người dùng đăng nhập bằng tài khoản để đặt vé, xem phim hoặc quản lý hệ thống.

**2. Thuộc tính:**

| Tên thuộc tính | Kiểu dữ liệu | Mô tả                       |
| -------------- | ------------ | --------------------------- |
| `id`           | String       | Mã định danh người dùng     |
| `name`         | String       | Họ và tên người dùng        |
| `email`        | String       | Địa chỉ email đăng nhập     |
| `password`     | String       | Mật khẩu tài khoản          |
| `role`         | String       | Vai trò (admin hoặc client) |


**3. Phương thức:**

| Tên phương thức | Mô tả                                      |
| --------------- | ------------------------------------------ |
| `get` / `set`   | Truy xuất và cập nhật thông tin người dùng |
| `toString()`    | Trả về thông tin tài khoản định dạng sẵn   |

### Movie (Phim)

**1. Giới thiệu:**
Lớp Movie lưu trữ thông tin chi tiết về các bộ phim trong rạp, bao gồm tiêu đề, mô tả, thể loại, thời lượng, hình ảnh poster, ngày công chiếu và trạng thái hiện tại.

**2. Thuộc tính:**

| Tên thuộc tính | Kiểu dữ liệu | Mô tả                                 |
| -------------- | ------------ | ------------------------------------- |
| `id`           | String       | Mã định danh phim                     |
| `title`        | String       | Tên phim                              |
| `description`  | String       | Mô tả nội dung phim                   |
| `genre`        | String       | Thể loại phim                         |
| `duration`     | int          | Thời lượng phim (phút)                |
| `poster`       | String       | Đường dẫn ảnh poster phim             |
| `releaseDate`  | Calendar     | Ngày công chiếu                       |
| `status`       | String       | Trạng thái (đang chiếu / ngừng chiếu) |

**3. Phương thức:**

| Tên phương thức | Mô tả                                |
| --------------- | ------------------------------------ |
| `get` / `set`   | Truy xuất và cập nhật thông tin phim |
| `toString()`    | Trả về thông tin phim định dạng sẵn  |

### Theater (Rạp chiếu)

**1. Giới thiệu:**
Lớp Theater mô tả thông tin về từng rạp chiếu trong hệ thống, bao gồm tên rạp, địa chỉ, thành phố, số điện thoại và tổng số phòng chiếu.

**2. Thuộc tính:**

| Tên thuộc tính | Kiểu dữ liệu | Mô tả                 |
| -------------- | ------------ | --------------------- |
| `id`           | String       | Mã rạp chiếu          |
| `name`         | String       | Tên rạp chiếu         |
| `address`      | String       | Địa chỉ rạp chiếu     |
| `city`         | String       | Thành phố             |
| `phone`        | String       | Số điện thoại liên hệ |
| `totalRooms`   | int          | Tổng số phòng chiếu   |

**3. Phương thức:**

| Tên phương thức | Mô tả                          |
| --------------- | ------------------------------ |
| `get` / `set`   | Truy xuất và chỉnh sửa dữ liệu |
| `toString()`    | Hiển thị thông tin rạp chiếu   |

### Room (Phòng chiếu)

**1. Giới thiệu:**
Lớp Room đại diện cho từng phòng chiếu phim thuộc một rạp cụ thể, bao gồm mã phòng, tên phòng và sức chứa tối đa.

**2. Thuộc tính:**

| Tên thuộc tính | Kiểu dữ liệu | Mô tả                         |
| -------------- | ------------ | ----------------------------- |
| `id`           | String       | Mã phòng chiếu                |
| `theaterId`    | String       | Mã rạp chiếu chứa phòng này   |
| `name`         | String       | Tên phòng chiếu               |
| `capacity`     | int          | Sức chứa tối đa (số ghế ngồi) |

**3. Phương thức:**

| Tên phương thức | Mô tả                            |
| --------------- | -------------------------------- |
| `get` / `set`   | Truy xuất và cập nhật dữ liệu    |
| `toString()`    | Trả về thông tin phòng định dạng |

### Showtime (Lịch chiếu phim)

**1. Giới thiệu:**
Lớp Showtime lưu trữ thông tin về các suất chiếu phim trong hệ thống, bao gồm mã phim, mã phòng, thời gian bắt đầu – kết thúc và giá vé.

**2. Thuộc tính:**

| Tên thuộc tính | Kiểu dữ liệu | Mô tả                    |
| -------------- | ------------ | ------------------------ |
| `id`           | String       | Mã lịch chiếu            |
| `movieId`      | String       | Mã phim được chiếu       |
| `roomId`       | String       | Mã phòng chiếu phim      |
| `startTime`    | Calendar     | Thời gian bắt đầu chiếu  |
| `endTime`      | Calendar     | Thời gian kết thúc chiếu |
| `price`        | double       | Giá vé xem phim          |

3. Phương thức:

| Tên phương thức | Mô tả                                 |
| --------------- | ------------------------------------- |
| `get` / `set`   | Truy xuất và cập nhật dữ liệu         |
| `toString()`    | Trả về thông tin suất chiếu định dạng |

### Booking (Đặt vé)

**1. Giới thiệu:**
Lớp Booking đại diện cho thông tin vé được khách hàng đặt trong hệ thống. Mỗi đặt vé liên kết với người dùng và suất chiếu cụ thể, đồng thời ghi nhận danh sách ghế và tổng tiền thanh toán.

**2. Thuộc tính:**

| Tên thuộc tính | Kiểu dữ liệu | Mô tả                          |
| -------------- | ------------ | ------------------------------ |
| `id`           | String       | Mã đặt vé                      |
| `userId`       | String       | Mã người dùng đặt vé           |
| `showtimeId`   | String       | Mã suất chiếu được đặt         |
| `seats`        | String       | Danh sách ghế đã chọn          |
| `totalPrice`   | double       | Tổng số tiền thanh toán        |
| `status`       | String       | Trạng thái (pending/confirmed) |


**3. Phương thức:**

| Tên phương thức | Mô tả                             |
| --------------- | --------------------------------- |
| `get` / `set`   | Truy xuất và cập nhật dữ liệu     |
| `toString()`    | Trả về thông tin vé định dạng sẵn |

### Interface CoId

**1. Giới thiệu:**
Interface CoId được sử dụng để chuẩn hóa các lớp có thuộc tính định danh (id). Giúp hệ thống có thể xử lý thống nhất các đối tượng theo mã định danh.

**2. Phương thức:**

| Phương thức     | Mô tả               |
| --------------- | ------------------- |
| `getId()`       | Trả về mã định danh |
| `setId(String)` | Gán mã định danh    |

### 🧩 Các Phương Thức Hoạt Động Chính Của Ứng Dụng Quản Lý Rạp Chiếu Phim

| STT | Tên Controller                        | Chức năng chính                              | Đối tượng liên quan     | Ghi chú                           |
| --- | ------------------------------------- | -------------------------------------------- | ----------------------- | --------------------------------- |
| 1   | `MovieController`                     | Quản lý phim (thêm, sửa, xóa, xem danh sách) | Movie                   | Chức năng trung tâm               |
| 2   | `TheaterController`                   | Quản lý thông tin rạp chiếu                  | Theater                 | Gắn với nhiều phòng chiếu         |
| 3   | `RoomController`                      | Quản lý phòng chiếu trong rạp                | Room, Theater           | Phòng thuộc từng rạp              |
| 4   | `ShowtimeController`                  | Quản lý lịch chiếu phim                      | Showtime, Movie, Room   | Liên kết nhiều bảng               |
| 5   | `BookingController`                   | Quản lý việc đặt vé xem phim                 | Booking, User, Showtime | Liên kết người dùng và lịch chiếu |
| 6   | `CommentController`                   | Quản lý bình luận phim của người xem         | Comment, Movie, User    | Bổ trợ tương tác người dùng       |
| 7   | `ProfileController`                   | Quản lý thông tin cá nhân người dùng         | User                    | Hỗ trợ chức năng khách hàng       |
| 8   | `DashboardController`                 | Hiển thị trang tổng quan quản trị hệ thống   | Admin, Movie, Booking   | Dành cho quản trị viên            |
| 9   | `HomeController`                      | Hiển thị trang chủ và các phim đang chiếu    | Movie, Showtime         | Giao diện chính của khách hàng    |
| 10  | `Auth\RegisteredUserController`       | Đăng ký tài khoản người dùng                 | User                    | Chức năng xác thực                |
| 11  | `Auth\AuthenticatedSessionController` | Đăng nhập và đăng xuất hệ thống              | User                    | Quản lý phiên đăng nhập           |
| 12  | `Auth\PasswordResetLinkController`    | Gửi liên kết đặt lại mật khẩu                | User                    | Xử lý quên mật khẩu               |
| 13  | `Auth\NewPasswordController`          | Tạo và lưu mật khẩu mới                      | User                    | Sau khi đặt lại mật khẩu          |
| 14  | `Auth\VerifyEmailController`          | Xác minh email người dùng                    | User                    | Bảo mật tài khoản                 |
| 15  | `AboutmeController`                   | Hiển thị trang giới thiệu về hệ thống        | Static Page             | Phụ trợ nội dung giới thiệu       |
| 16  | `Controller`                          | Lớp cơ sở chung cho các controller khác      | —                       | Mặc định của Laravel              |

#### Kết luận

Việc thiết kế hệ thống lớp như trên đáp ứng yêu cầu về phân tầng logic, đảm bảo tính dễ bảo trì, mở rộng và tích hợp với giao diện người dùng.

Các đối tượng trong hệ thống như phim, rạp, phòng chiếu, suất chiếu, đặt vé và người dùng được liên kết rõ ràng thông qua các khóa định danh (id), giúp việc truy xuất và lưu trữ dữ liệu trở nên hiệu quả.

Cấu trúc này hỗ trợ tốt cho các chức năng cốt lõi của hệ thống quản lý rạp chiếu phim, đồng thời đảm bảo khả năng mở rộng trong tương lai như thêm tính năng thanh toán trực tuyến, đánh giá phim, hay quản lý thành viên.

## III. Công nghệ sử dụng
##### Framework:

Hệ thống được phát triển trên nền tảng Laravel 12, sử dụng gói Laravel Breeze để xây dựng và quản lý chức năng xác thực người dùng. Laravel cung cấp kiến trúc MVC (Model – View – Controller) mạnh mẽ, giúp tổ chức mã nguồn rõ ràng, tách biệt các tầng logic và dễ dàng mở rộng trong quá trình phát triển hệ thống.

##### Ngôn ngữ:

Ứng dụng được xây dựng bằng PHP cho phần xử lý backend và CSS cho phần định dạng và thiết kế giao diện người dùng. Sự kết hợp này mang lại trải nghiệm trực quan, thân thiện và dễ dàng tùy chỉnh.

##### Backend:

Phần xử lý nghiệp vụ được phát triển bằng Laravel 12, vận hành theo mô hình MVC, tách biệt rõ ràng giữa tầng dữ liệu, xử lý và giao diện. Hệ thống sử dụng Eloquent ORM để thao tác cơ sở dữ liệu nhanh chóng, đồng thời áp dụng Middleware, Route Controller và Service Layer để tăng cường bảo mật, phân quyền và tối ưu hiệu suất xử lý.

##### Frontend:

Phần giao diện được xây dựng bằng Blade Template – engine mặc định của Laravel – giúp kết nối linh hoạt giữa dữ liệu và giao diện. Kết hợp với DataTables, hệ thống hiển thị dữ liệu động, hỗ trợ tìm kiếm, phân trang và sắp xếp trực quan, nâng cao trải nghiệm người dùng khi tra cứu và quản lý thông tin.

##### Cơ sở dữ liệu:

Hệ thống sử dụng MySQL để lưu trữ các dữ liệu như phim, rạp chiếu, phòng chiếu, lịch chiếu, người dùng và vé đặt. Cơ sở dữ liệu được thiết kế chuẩn hóa, đảm bảo tính toàn vẹn, dễ bảo trì và đạt hiệu suất cao trong truy xuất.

##### Môi trường:

Dự án được phát triển và chạy trên XAMPP, môi trường tích hợp gồm Apache, PHP và MySQL, giúp việc kiểm thử và triển khai ứng dụng trở nên thuận tiện, đồng bộ giữa các môi trường phát triển.

##### Công cụ:

Dự án sử dụng Composer để quản lý thư viện và phụ thuộc, cùng với Artisan CLI để tạo nhanh các thành phần như model, controller, migration và chạy các lệnh quản trị. Hai công cụ này giúp quá trình phát triển, build và bảo trì ứng dụng diễn ra hiệu quả, thống nhất.
