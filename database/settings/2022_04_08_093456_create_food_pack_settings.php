<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateFoodPackSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('food-pack.status', '1');
    }
}
