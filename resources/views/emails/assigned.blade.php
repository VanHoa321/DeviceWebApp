<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo công việc được giao</title>
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
        <h2>Thông báo thiết bị được giao bảo trì</h2>
        <p><strong>Người báo hỏng:</strong> {{ $reporter->full_name }}</p>
        <p><strong>Số điện thoại:</strong> {{ $reporter->phone }}</p>
        <p><strong>Email:</strong> {{ $reporter->email }}</p>
        <p><strong>Người phân công:</strong> {{ $taskmaster->full_name }}</p>
        <p><strong>Số điện thoại:</strong> {{ $taskmaster->phone }}</p>
        <p><strong>Email:</strong> {{ $taskmaster->email }}</p>
        <p><strong>Thời gian báo hỏng:</strong> {{ $maintenance->created_date }}</p>
        <p><strong>Mô tả phiếu báo hỏng:</strong> {{ $maintenance->description }}</p>
        <h4>Thông tin thiết bị phân công:</h4>
        <table>
            <thead>
                <tr>
                    <th>Tên thiết bị</th>
                    <th>Số hiệu thiết bị</th>
                    <th>Mô tả lỗi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $detail->device->name }}</td>
                    <td>{{ $detail->device->code }}</td>
                    <td>{{ $detail->error_description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
