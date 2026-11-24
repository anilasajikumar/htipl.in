<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Registration Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 40px auto; background-color: #ffffff; padding: 20px; border-radius: 8px;">
        
        <!-- Logo -->
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('web_dashboard/images/logo1.png') }}" alt="Logo" style="max-width: 300px; width: 100%;">
        </div>

        <!-- Message -->
        <div style="padding: 10px 20px;">
            <h2 style="color: #333;">Hello {{ $student->name }},</h2>

            

            <p style="font-size: 16px; color: #555;">
                Your registration number is:
                <strong style="color: #222;">{{ $student->register_number }}</strong>.
            </p>

            <p style="font-size: 16px; color: #555;">
                Thank you and best wishes for your course!
            </p>
        </div>

        <!-- Footer -->
        <div style="text-align: center; font-size: 13px; color: #999; margin-top: 30px;">
            &copy; {{ date('Y') }} HTIPL. All rights reserved.
        </div>
    </div>
</body>
</html>
