<!-- resources/views/emails/verify-account.blade.php -->

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            color: #3085d6;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
        }
        h6 {
            font-size: 18px;
            color: #555;
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 20px;
            font-size: 16px;
            color: #ffffff !important;
            background-color: #3085d6;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #2567a4;
        }
        .footer {
            font-size: 14px;
            color: #888;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Xin chào, {{ $account->full_name }}</h2>
        <p>Tài khoản của bạn đã được đăng ký sử dụng trong hệ thống bảo trì thiết bị!</p>
        <p>Không chia sẻ thông tin này cho bất kì ai để bảo vệ quyền lợi cá nhân!</p>
        <h6><strong>Tên đăng nhập:</strong> {{ $account->user_name }}</h6>
        <h6><strong>Mật khẩu:</strong> {{ $password }}</h6>
        
        <p>Vui lòng nhấn vào nút dưới đây để xác nhận tài khoản của bạn:</p>
        
        <a href="{{ route('verify', $account->email) }}" class="button">Xác nhận tài khoản</a>
        
        <p class="footer">Nếu bạn không đăng ký tài khoản này, vui lòng bỏ qua email này.</p>
    </div>
</body>
</html>
