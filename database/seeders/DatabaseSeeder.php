<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Technician;
use App\Models\ServiceComponent;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone_number' => '6281234567890'
        ]);

        // Create technician users
        $technicianUser1 = User::create([
            'name' => 'John Doe',
            'email' => 'technician@technician.com',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'phone_number' => '6281234567891'
        ]);

        $technicianUser2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@technician.com',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'phone_number' => '6281234567892'
        ]);

        // Create regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone_number' => '6281234567893'
        ]);

        // Create services
        Service::create([
            'name' => 'Basic Electronics Repair',
            'description' => 'Basic repair service for electronic devices',
            'price' => 100000, // Rp 100.000
            'duration' => 60,
        ]);

        Service::create([
            'name' => 'Advanced Electronics Repair',
            'description' => 'Advanced repair service for complex electronic devices',
            'price' => 200000, // Rp 200.000
            'duration' => 120,
        ]);

        // Create technicians
        Technician::create([
            'user_id' => $technicianUser1->id,
            'specialization' => 'Electronics',
            'bio' => '5 years of experience in electronics repair',
            'is_available' => true,
        ]);

        Technician::create([
            'user_id' => $technicianUser2->id,
            'specialization' => 'Computers',
            'bio' => '3 years of experience in computer repair',
            'is_available' => true,
        ]);

        // Create service components
        ServiceComponent::create([
            'name' => 'LCD Screen',
            'description' => 'High-quality LCD screen for smartphones',
            'price' => 500000, // Rp 500.000
            'stock' => 10,
        ]);

        ServiceComponent::create([
            'name' => 'Battery Pack',
            'description' => 'Standard battery pack for laptops',
            'price' => 300000, // Rp 300.000
            'stock' => 20,
        ]);

        echo "\n";
        echo "Database seeded successfully!\n";
        echo "You can login with these accounts:\n";
        echo "Admin: admin@admin.com / password\n";
        echo "Technician: technician@technician.com / password\n";
        echo "User: user@user.com / password\n";
    }
}
