<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo báo hỏng thiết bị</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 {
            color: #3085d6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thông báo báo hỏng thiết bị</h2>
        <p><strong>Người báo hỏng:</strong> {{ $user->full_name }}</p>
        <p><strong>Số điện thoại:</strong> {{ $user->phone }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Thời gian báo hỏng:</strong> {{ $maintenance->created_date }}</p>
        <p><strong>Mô tả phiếu báo hỏng:</strong> {{ $maintenance->description }}</p>
        <h4>Danh sách thiết bị báo hỏng:</h4>
        <table>
            <thead>
                <tr>
                    <th>Tên thiết bị</th>
                    <th>Số hiệu thiết bị</th>
                    <th>Mô tả lỗi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail as $report)
                <tr>
                    <td>{{ $report['name'] }}</td>
                    <td>{{ $report['code'] }}</td>
                    <td>{{ $report['error_description'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
