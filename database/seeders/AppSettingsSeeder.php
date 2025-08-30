<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AppSetting;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_password',
                'value' => Hash::make('2771211'),
                'description' => 'Mật khẩu bảo vệ ứng dụng'
            ],
            [
                'key' => 'current_fund_balance',
                'value' => '0',
                'description' => 'Số dư quỹ hiện tại (VNĐ)'
            ],
            [
                'key' => 'app_name',
                'value' => 'Quỹ Đi Chợ - Family App',
                'description' => 'Tên ứng dụng'
            ],
            [
                'key' => 'user_names',
                'value' => json_encode(['Tôi', 'Anh Hai']),
                'description' => 'Tên các thành viên trong gia đình'
            ],
            [
                'key' => 'currency',
                'value' => 'VNĐ',
                'description' => 'Đơn vị tiền tệ'
            ],
            [
                'key' => 'session_timeout_hours',
                'value' => '24',
                'description' => 'Thời gian hết hạn phiên đăng nhập (giờ)'
            ]
        ];

        foreach ($settings as $setting) {
            AppSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'description' => $setting['description']
                ]
            );
        }
    }
}
