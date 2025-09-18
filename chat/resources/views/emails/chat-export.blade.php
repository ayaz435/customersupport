<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chat Export - {{ $user->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .chat-content {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 5px;
            white-space: pre-wrap;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            line-height: 1.4;
        }
        .footer {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Chat Export Report</h2>
        <p><strong>User:</strong> {{ $user->name }} ({{ $user->email }})</p>
        <p><strong>Export Date:</strong> {{ date('Y-m-d H:i:s') }}</p>
        @if($attachmentCount > 0)
            <p><strong>Media Files:</strong> {{ $attachmentCount }} file(s) attached</p>
            @if(isset($hasZip) && $hasZip)
                <p><em>Note: Media files have been compressed into a ZIP archive for easier download.</em></p>
            @endif
        @endif
    </div>

    <div class="chat-content">{{ $chatContent }}</div>

    <div class="footer">
        <p>This chat export was automatically generated from your customer support system.</p>
        <p>If you have any questions, please contact your system administrator.</p>
    </div>
</body>
</html>