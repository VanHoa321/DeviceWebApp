<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Công việc bảo trì hoàn thành</title>
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
        p {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Công việc bảo trì đã hoàn thành</h2>
        <p><strong>Thiết bị:</strong> {{ $detail->device->name }} (Số hiệu: {{ $detail->device->code }})</p>
        <p><strong>Mô tả lỗi:</strong> {{ $detail->error_description }}</p>
        <p><strong>Người báo lỗi:</strong> {{ $reporter->full_name }}</p>
        <p><strong>Người bảo trì:</strong> {{ $user->full_name }}</p>
        <p><strong>Kết quả bảo trì:</strong> {{ $detail->expense }}</p>
        <p>Cảm ơn bạn đã thông báo về sự cố thiết bị. Công việc bảo trì đã được thực hiện thành công và thiết bị đã sẵn sàng hoạt động trở lại.</p>
    </div>
</body>
</html>
