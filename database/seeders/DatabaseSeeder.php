<?php

namespace Database\Seeders;

use App\Models\DataKehadiran;
use App\Models\User;
use App\Models\Karyawan;
use App\Models\Departement;
use App\Models\PeriodeCutoff;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Role::create([
            'name' => 'admin',
        ]);

        Role::create([
            'name' => 'karyawan',
        ]);

        Departement::create([
            'name' => 'INFUSE',
        ]);

        Departement::create([
            'name' => 'OFFICE',
        ]);

        Departement::create([
            'name' => 'PASCA',
        ]);

        Departement::create([
            'name' => 'PRA FINISH',
        ]);

        Departement::create([
            'name' => 'MOLDING',
        ]);

        PeriodeCutoff::create([
            'kehadiran_start' => '2025-01-01',
            'kehadiran_end'   => '2025-01-31',
            'lembur_start'    => '2024-12-21',
            'lembur_end'      => '2025-01-20',
            'hari_kerja'      => 27,
            'is_active'       => true,
        ]);

        $admin = User::factory()->create([
            'name'  => 'Admin 1',
            'email' => 'admin1@hybon.com',
        ]);
        $admin->assignRole('admin');

        $admin = User::factory()->create([
            'name'  => 'Admin 2',
            'email' => 'admin2@hybon.com',
        ]);
        $admin->assignRole('admin');

        $user_karyawan_1 = User::factory()->create([
            'name'  => 'ADAM BULANAN BAGUS',
            'email' => 'adam1@gmail.com',
        ]);
        $user_karyawan_1->assignRole('karyawan');

        $user_karyawan_2 = User::factory()->create([
            'name'  => 'ADAM BULANAN JELEK',
            'email' => 'adam2@gmail.com',
        ]);
        $user_karyawan_2->assignRole('karyawan');

        $user_karyawan_3 = User::factory()->create([
            'name'  => 'ADAM HARIAN BAGUS',
            'email' => 'adam3@gmail.com',
        ]);
        $user_karyawan_3->assignRole('karyawan');

        $user_karyawan_4 = User::factory()->create([
            'name'  => 'ADAM HARIAN JELEK',
            'email' => 'adam4@gmail.com',
        ]);
        $user_karyawan_4->assignRole('karyawan');

        Karyawan::create([
            'user_id'        => $user_karyawan_1->id,
            'departement_id' => 1,
            'name'           => 'ADAM BULANAN BAGUS',
            'join_date'      => '2025-01-01',
            'tipe_gaji'      => 'bulanan',
            'gaji_pokok'     => 1_000_000,
            'gaji_harian'    => 0,
            'whatsapp'       => '082114578976',
            'total_cuti'     => 12,
            'sisa_cuti'      => 12,
            'is_active'      => true,
        ]);

        Karyawan::create([
            'user_id'        => $user_karyawan_2->id,
            'departement_id' => 1,
            'name'           => 'ADAM BULANAN JELEK',
            'join_date'      => '2025-01-01',
            'tipe_gaji'      => 'bulanan',
            'gaji_pokok'     => 1_000_000,
            'gaji_harian'    => 0,
            'whatsapp'       => '082114578976',
            'total_cuti'     => 12,
            'sisa_cuti'      => 12,
            'is_active'      => true,
        ]);

        Karyawan::create([
            'user_id'        => $user_karyawan_3->id,
            'departement_id' => 2,
            'name'           => 'ADAM HARIAN BAGUS',
            'join_date'      => '2025-01-01',
            'tipe_gaji'      => 'harian',
            'gaji_pokok'     => 0,
            'gaji_harian'    => 10_000,
            'whatsapp'       => '082114578976',
            'total_cuti'     => 12,
            'sisa_cuti'      => 12,
            'is_active'      => true,
        ]);

        Karyawan::create([
            'user_id'        => $user_karyawan_4->id,
            'departement_id' => 2,
            'name'           => 'ADAM HARIAN JELEK',
            'join_date'      => '2025-01-01',
            'tipe_gaji'      => 'harian',
            'gaji_pokok'     => 0,
            'gaji_harian'    => 10_000,
            'whatsapp'       => '082114578976',
            'total_cuti'     => 12,
            'sisa_cuti'      => 12,
            'is_active'      => true,
        ]);

        $arr_work_day = [];
        $startDate    = Carbon::parse('2025-01-01');
        $endDate      = Carbon::parse('2025-01-31');

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if (!$date->isSunday()) {
                $arr_work_day[] = $date->format('Y-m-d');
            }
        }

        foreach ($arr_work_day as $date) {
            DataKehadiran::create([
                'karyawan_id'       => 1,
                'periode_cutoff_id' => 1,
                'tanggal'           => $date,
                'clock_in'          => '09:00:00',
                'clock_out'         => '18:00:00',
                'jam_terlambat'     => 0,
                'foto_in'           => '#',
                'foto_out'          => '#',
            ]);

            DataKehadiran::create([
                'karyawan_id'       => 2,
                'periode_cutoff_id' => 1,
                'tanggal'           => $date,
                'clock_in'          => '09:15:01',
                'clock_out'         => '18:00:00',
                'jam_terlambat'     => 1,
                'foto_in'           => '#',
                'foto_out'          => '#',
            ]);

            DataKehadiran::create([
                'karyawan_id'       => 3,
                'periode_cutoff_id' => 1,
                'tanggal'           => $date,
                'clock_in'          => '09:00:00',
                'clock_out'         => '18:00:00',
                'jam_terlambat'     => 0,
                'foto_in'           => '#',
                'foto_out'          => '#',
            ]);

            DataKehadiran::create([
                'karyawan_id'       => 4,
                'periode_cutoff_id' => 1,
                'tanggal'           => $date,
                'clock_in'          => '10:00:01',
                'clock_out'         => '18:00:00',
                'jam_terlambat'     => 2,
                'foto_in'           => '#',
                'foto_out'          => '#',
            ]);
        }
    }
}
