<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Movie;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        Movie::create([
            'title' => 'Avengers: Endgame',
            'description' => 'Biệt Đội Siêu Anh Hùng 4: Tàn Cuộc (Avengers 4: Endgame) ra mắt vào tháng 4/2019 sẽ giải quyết triệt để những khúc mắc đã vạch ra suốt 22 bộ phim trước đó của Vụ trụ điện ảnh Marvel (MCU). Hai tháng sau đó, Người Nhện 2 là khởi đầu hoàn toàn mới dành cho MCU. Sau sự kiện Thanos làm cho một nửa vũ trụ tan biến và khiến cho biệt đội Avengers thảm bại, những siêu anh hùng sống sót phải tham gia trận chiến cuối cùng trong Avengers: Endgame.',
            'duration' => 181,
            'poster' => 'img/avengers.jpg',
            'genre' => 'Action'
        ]);

        Movie::create([
            'title' => 'Inception',
            'description' =>'Dom Cobb có khả năng đi vào giấc mơ của người khác, nhờ khả năng đó mà anh đi vào giấc mơ của vợ anh. Họ đã có những tháng ngày hạnh phúc, vợ của anh tưởng đó là thế giới thực và mong muốn ở đó mãi mãi. Khi trở lại đời thực, cô không thể hòa nhập trở lại cuộc đời rất không lý tưởng này. Cô đã đi tìm cái chết. Những lần vì nhiệm vụ mà Cobb đi vào giấc mơ,anh gặp lại người vợ quá cố. Và một lần nữa, cô mong muốn anh ở lại cái thế giới mộng… ảo đó với cô. Cobb bị dằn vặt giữa hai thế giới, anh không thể phân biệt được đâu là thực, đâu là mơ nữa.',
            'genre' => 'Sci-fi thriller',
            'duration' => 148,
            'poster' => 'img/inception.jpg'
        ]);

        Movie::create([
            'title' => 'The Dark Knight',
            'description' => 'Batman phải đối mặt với Joker, một tên tội phạm điên ruổi theo sự hỗn loạn ở Gotham City.',
            'genre' => 'Action',
            'duration' => 152,
            'poster' => 'img/dark_knight.jpg'
        ]);
        Movie::create([
            'title' => 'Spider-Man: Far From Home',
            'description' => 'Peter Parker cùng các bạn trong lớp tham gia chuyến du lịch châu Âu. Tuy nhiên, kế hoạch của cậu đã bị gián đoạn khi Nick Fury xuất hiện để nhờ cậu giúp đỡ chống lại các sinh vật bí ẩn gọi là Elementals.',
            'genre' => 'Action',
            'duration' => 129,
            'poster' => 'img/Spider-man.jpg'
        ]);
        Movie::create([
            'title' => 'John Wick: Chapter 2',
            'description' => 'John Wick trở lại để trả thù cho cái chết của người bạn thân nhất của mình, nhưng phải đối mặt với một tổ chức sát thủ toàn cầu.',
            'genre' => 'Action',
            'duration' => 122,
            'poster' => 'img/john_wick_2.jpg'
        ]);
        Movie::create([
            'title' => 'Interstellar',
            'description' => 'Một nhóm nhà du hành vũ trụ sử dụng một lỗ sâu để vượt qua giới hạn của con người và khám phá các hành tinh có thể sinh sống được nhằm cứu nhân loại.',
            'genre' => 'Sci-fi',
            'duration' => 169,
            'poster' => 'img/interstellar.jpg'
        ]);
        Movie::create([
            'title' => 'The Matrix',
            'description' => 'Một lập trình viên máy tính phát hiện ra rằng thế giới mà anh ta sống chỉ là một mô phỏng do máy tính tạo ra và gia nhập cuộc chiến chống lại các máy móc kiểm soát nhân loại.',
            'genre' => 'Sci-fi',
            'duration' => 136,
            'poster' => 'img/matrix.jpg'
        ]);
        Movie::create([
            'title' => 'Guardians of the Galaxy',
            'description' => 'Một nhóm những kẻ ngoài vòng pháp luật không ngờ tới phải hợp lực để bảo vệ một viên đá quyền năng khỏi rơi vào tay kẻ xấu.',
            'genre' => 'Action',
            'duration' => 121,
            'poster' => 'img/guardians_galaxy.jpg'
        ]);
        Movie::create([
            'title' => 'Mad Max: Fury Road',
            'description' => 'Trong một thế giới hậu tận thế, Max Rockatansky hợp tác với Furiosa để giúp một nhóm phụ nữ trốn khỏi một tên độc tài và tìm kiếm vùng đất an toàn.',
            'genre' => 'Action',
            'duration' => 120,
            'poster' => 'img/mad_max_fury_road.jpg'
        ]);
        Movie::create([
            'title' => 'Blade Runner 2049',
            'description' => 'Một cảnh sát mới của lực lượng đặc nhiệm Blade Runner khám phá ra một bí mật lâu đời có thể đẩy xã hội vào hỗn loạn.',
            'genre' => 'Sci-fi',
            'duration' => 164,
            'poster' => 'img/blade_runner_2049.jpg'
        ]);
    }
}
