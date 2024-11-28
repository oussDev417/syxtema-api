<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Badges\database\seeders\BadgeSeeder;
use Modules\Currency\database\seeders\CurrencySeeder;
use Modules\Language\database\seeders\LanguageSeeder;
use Modules\Frontend\database\seeders\FaqSectionSeeder;
use Modules\Frontend\database\seeders\HeroSectionSeeder;
use Modules\Frontend\database\seeders\AboutSectionSeeder;
use Modules\GlobalSetting\database\seeders\SeoInfoSeeder;
use Modules\Menubuilder\database\seeders\MenubuilderSeeder;
use Modules\GlobalSetting\database\seeders\EmailTemplateSeeder;
<<<<<<< Updated upstream
use Modules\Installer\database\seeders\InstallerDatabaseSeeder;
use Modules\BasicPayment\database\seeders\BasicPaymentInfoSeeder;
=======
>>>>>>> Stashed changes
use Modules\PaymentGateway\database\seeders\PaymentGatewaySeeder;
use Modules\GlobalSetting\database\seeders\CustomPaginationSeeder;
use Modules\GlobalSetting\database\seeders\MarketingSettingSeeder;
use Modules\GlobalSetting\database\seeders\GlobalSettingInfoSeeder;
use Modules\PageBuilder\database\seeders\PageBuilderDatabaseSeeder;
use Modules\Frontend\database\seeders\FeaturedInstructorSectionSeeder;
use Modules\InstructorRequest\database\seeders\InstructorRequestSeeder;
use Modules\CertificateBuilder\database\seeders\CertificateBuilderSeeder;
use Modules\CertificateBuilder\database\seeders\CertificateBuilderItemSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
<<<<<<< Updated upstream
            InstallerDatabaseSeeder::class,
=======
>>>>>>> Stashed changes
            LanguageSeeder::class,
            CurrencySeeder::class,
            GlobalSettingInfoSeeder::class,
            MarketingSettingSeeder::class,
<<<<<<< Updated upstream
            BasicPaymentInfoSeeder::class,
=======
>>>>>>> Stashed changes
            PaymentGatewaySeeder::class,
            CustomPaginationSeeder::class,
            EmailTemplateSeeder::class,
            SeoInfoSeeder::class,
            RolePermissionSeeder::class,
            AdminInfoSeeder::class,
            PageBuilderDatabaseSeeder::class,
            CertificateBuilderSeeder::class,
            CertificateBuilderItemSeeder::class,
            HeroSectionSeeder::class,
            AboutSectionSeeder::class,
            FeaturedInstructorSectionSeeder::class,
            FaqSectionSeeder::class,
            MenubuilderSeeder::class,
            // UserSeeder::class,
            InstructorRequestSeeder::class,
            BadgeSeeder::class
        ]);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
