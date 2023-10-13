<?php

namespace Database\Seeders;

use App\Enums\FormType;
use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::firstOrCreate([
            'key' => 'name',
        ],
        [
            'description' => 'Company Name',
            'value' => 'Aptree LMS',
            'form_type' => FormType::Textbox
        ]);

        Settings::firstOrCreate(['key' => 'logo'],
        [
            'description' => 'Application Logo',
            'value' => asset('img/logo.png'),
            'form_type' => FormType::Fileupload
        ]);


        Settings::firstOrCreate(['key' => 'text_primary'],
        [
            'description' => 'Primary Color (Text)',
            'value' => '#2F5662',
            'form_type' => FormType::Colorpicker
        ]);

        Settings::firstOrCreate(['key' => 'text_secondary'],
        [
            'description' => 'Secondary Color (Text)',
            'value' => '#EA580C',
            'form_type' => FormType::Colorpicker
        ]);

        Settings::firstOrCreate(['key' => 'api_video_api_key'],
        [
            'description' => '<p><a href="https://api.video/">api.video</a> API KEY.</p>',
            'value' => '',
            'form_type' => FormType::Textarea
        ]);

        Settings::firstOrCreate(['key' => 'full_access'],
        [
            'description' => 'Allow users full access to the available library (will be shown on the bottom of the users dashboard)',
            'value' => true,
            'form_type' => FormType::Checkbox,
        ]);
        Settings::firstOrCreate(['key' => 'team'],
        [
            'description' => 'Team/Group',
            'value' => 'Team',
            'form_type' => FormType::Textbox,
        ]);

    }

}
