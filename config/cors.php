<?php

return [
    'paths' => [
        'api/*',
        'sse',          // Thêm path SSE nếu dùng route riêng
        'sanctum/csrf-cookie'
    ],

    'allowed_methods' => [
        'GET',          // SSE chỉ cần GET
        'POST',         // Nếu có API khác
        'OPTIONS'       // Bắt buộc cho CORS preflight
    ],

    'allowed_origins' => [
        'http://192.168.1.10:5173', // Admin React
        'http://192.168.1.10:8080', // Nếu app Android chạy localhost giả lập
        'http://localhost:5173',      // Local Dev
    ],


    'allowed_origins_patterns' => [
        '/^http:\/\/192\.168\.20\.\d{1,3}(:\d+)?$/',
        '/^http:\/\/localhost(:\d+)?$/',
    ],

    'allowed_headers' => [
        'Content-Type',
        'Accept',
        'Authorization'  // Nếu dùng xác thực
    ],

    'exposed_headers' => [],

    'max_age' => 86400,  // Cache preflight 1 ngày (tối ưu hiệu năng)

    'supports_credentials' => false, // Không cần với SSE thông thường
];
