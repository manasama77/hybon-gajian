<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property string $tipe_ijin
 * @property \Illuminate\Support\Carbon $from_date
 * @property \Illuminate\Support\Carbon $to_date
 * @property int $total_hari
 * @property string $keterangan
 * @property string|null $lampiran
 * @property int|null $is_approved
 * @property \App\Models\Karyawan|null $approved_by
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereFromDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereLampiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereTipeIjin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereToDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereTotalHari($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataIjin whereUpdatedAt($value)
 */
	class DataIjin extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property int $jumlah
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKasbon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKasbon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKasbon query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKasbon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKasbon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKasbon whereJumlah($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKasbon whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKasbon whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKasbon whereUpdatedAt($value)
 */
	class DataKasbon extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property int $periode_cutoff_id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string $clock_in
 * @property string|null $clock_out
 * @property int $jam_terlambat
 * @property int $menit_terlambat
 * @property string|null $foto_in
 * @property string|null $foto_out
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @property-read \App\Models\PeriodeCutoff $periode_cutoff
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereClockIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereClockOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereFotoIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereFotoOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereJamTerlambat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereMenitTerlambat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran wherePeriodeCutoffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataKehadiran whereUpdatedAt($value)
 */
	class DataKehadiran extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property \Illuminate\Support\Carbon $overtime_in
 * @property \Illuminate\Support\Carbon|null $overtime_out
 * @property int $jam_lembur
 * @property int $menit_lembur
 * @property int|null $is_approved
 * @property \App\Models\User|null $approved_by
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur approved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur notApproved()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereJamLembur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereMenitLembur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereOvertimeIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereOvertimeOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DataLembur whereUpdatedAt($value)
 */
	class DataLembur extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $karyawan_user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Karyawan> $karyawans
 * @property-read int|null $karyawans_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Departement withoutTrashed()
 */
	class Departement extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|HariLibur withoutTrashed()
 */
	class HariLibur extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $departement_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $join_date
 * @property string $tipe_gaji
 * @property string $gaji_pokok
 * @property string $gaji_harian
 * @property string $whatsapp
 * @property int $total_cuti
 * @property int $sisa_cuti
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataIjin> $data_ijin
 * @property-read int|null $data_ijin_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataKasbon> $data_kasbon
 * @property-read int|null $data_kasbon_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataKehadiran> $data_kehadiran
 * @property-read int|null $data_kehadiran_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataLembur> $data_lembur
 * @property-read int|null $data_lembur_count
 * @property-read \App\Models\Departement $departement
 * @property-read mixed $gaji_harian_idr
 * @property-read mixed $gaji_pokok_idr
 * @property-read mixed $status_karyawan
 * @property-read mixed $whatsapp_link
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RequestKehadiran> $request_kehadiran
 * @property-read int|null $request_kehadiran_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereDepartementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereGajiHarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereGajiPokok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereJoinDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereSisaCuti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereTipeGaji($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereTotalCuti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereWhatsapp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan withoutTrashed()
 */
	class Karyawan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $kehadiran_start
 * @property \Illuminate\Support\Carbon $kehadiran_end
 * @property \Illuminate\Support\Carbon $lembur_start
 * @property \Illuminate\Support\Carbon $lembur_end
 * @property int $hari_kerja
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataKehadiran> $data_kehadiran
 * @property-read int|null $data_kehadiran_count
 * @property-read mixed $status
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RequestKehadiran> $request_kehadiran
 * @property-read int|null $request_kehadiran_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff inactive()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff whereHariKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff whereKehadiranEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff whereKehadiranStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff whereLemburEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff whereLemburStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PeriodeCutoff whereUpdatedAt($value)
 */
	class PeriodeCutoff extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property int $periode_cutoff_id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string $clock_in
 * @property string $clock_out
 * @property int $jam_terlambat
 * @property int $menit_terlambat
 * @property string $alasan
 * @property bool|null $is_approved
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @property-read \App\Models\PeriodeCutoff $periode_cutoff
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereAlasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereClockIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereClockOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereJamTerlambat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereMenitTerlambat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran wherePeriodeCutoffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestKehadiran whereUpdatedAt($value)
 */
	class RequestKehadiran extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property int $periode_cutoff_id
 * @property string $tipe_gaji
 * @property int $gaji_pokok
 * @property string $gaji_harian
 * @property int $total_hari_kerja
 * @property string $gaji_kehadiran
 * @property int $total_cuti
 * @property int $total_sakit
 * @property int $total_hari_tidak_kerja
 * @property string $potongan_tidak_kerja
 * @property int $total_hari_ijin
 * @property string $potongan_ijin
 * @property int $jam_terlambat
 * @property int $menit_terlambat
 * @property string $potongan_terlambat
 * @property int $prorate
 * @property int $total_jam_lembur
 * @property int $total_menit_lembur
 * @property int $gaji_lembur
 * @property string $potongan_kasbon
 * @property string $take_home_pay
 * @property int $take_home_pay_rounded
 * @property string $file_pdf
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $gaji_harian_idr
 * @property-read mixed $gaji_kehadiran_idr
 * @property-read mixed $gaji_lembur_idr
 * @property-read mixed $gaji_pokok_idr
 * @property-read mixed $potongan_ijin_idr
 * @property-read mixed $potongan_terlambat_idr
 * @property-read mixed $potongan_tidak_kerja_idr
 * @property-read mixed $take_home_pay_idr
 * @property-read mixed $take_home_pay_rounded_idr
 * @property-read \App\Models\Karyawan $karyawan
 * @property-read \App\Models\PeriodeCutoff $periode_cutoff
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereFilePdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereGajiHarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereGajiKehadiran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereGajiLembur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereGajiPokok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereJamTerlambat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereMenitTerlambat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji wherePeriodeCutoffId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji wherePotonganIjin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji wherePotonganKasbon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji wherePotonganTerlambat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji wherePotonganTidakKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereProrate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTakeHomePay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTakeHomePayRounded($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTipeGaji($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTotalCuti($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTotalHariIjin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTotalHariKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTotalHariTidakKerja($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTotalJamLembur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTotalMenitLembur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereTotalSakit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SlipGaji whereUpdatedAt($value)
 */
	class SlipGaji extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DataLembur> $data_lemburs
 * @property-read int|null $data_lemburs_count
 * @property-read \App\Models\Karyawan|null $karyawan
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

