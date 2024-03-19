<?php

namespace App\Filament\Exports;

use App\Models\Pendaftaran;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PendaftaranExporter extends Exporter
{
    protected static ?string $model = Pendaftaran::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('calonPesertaDidik.nama')
                ->label('Nama Lengkap Calon Peserta Didik'),
            ExportColumn::make('nomor'),
            ExportColumn::make('jalur.nama')
                ->label('Jalur'),
            ExportColumn::make('gelombang.nama')
                ->label('Gelombang'),
            ExportColumn::make('pilihanKesatu.kode')
                ->label('Pilihan Pertama'),
            ExportColumn::make('pilihanKedua.kode')
                ->label('Pilihan Kedua'),
            ExportColumn::make('diterima.kode')
                ->label('Diterima pada Jurusan'),
            ExportColumn::make('status')
                ->label('Status')
                ->state(fn (Pendaftaran $record) => isset($record->status) ? $record->status->getLabel() : '-' ),

            ExportColumn::make('calonPesertaDidik.asalSekolah.nama')
                ->label('Asal Sekolah'),
            ExportColumn::make('calonPesertaDidik.lp')
                ->label('Jenis Kelamin')
                ->state(fn (Pendaftaran $record) => isset($record->lp) ? $record->lp->getLabel() : '-' ),
            ExportColumn::make('calonPesertaDidik.nisn')
                ->label('NISN'),
            ExportColumn::make('calonPesertaDidik.kewarganegaraan')
                ->label('Kewarganegaraan'),
            ExportColumn::make('calonPesertaDidik.nik')
                ->label('NIK'),
            ExportColumn::make('calonPesertaDidik.kk')
                ->label('No. Kartu Keluarga'),
            ExportColumn::make('calonPesertaDidik.tempat_lahir')
                ->label('Tempat Lahir'),
            ExportColumn::make('calonPesertaDidik.tanggal_lahir')
                ->label('Tanggal Lahir'),
            ExportColumn::make('calonPesertaDidik.no_reg_akta')
                ->label('No. Reg Akta'),
            ExportColumn::make('calonPesertaDidik.agama.nama')
                ->label('Agama'),
            ExportColumn::make('calonPesertaDidik.berkebutuhanKhusus.nama')
                ->label('Berkebutuhan Khusus'),
            ExportColumn::make('calonPesertaDidik.alamat')
                ->label('Alamat'),
            ExportColumn::make('calonPesertaDidik.rt')
                ->label('RT'),
            ExportColumn::make('calonPesertaDidik.rw')
                ->label('RW'),
            ExportColumn::make('calonPesertaDidik.dusun')
                ->label('Dusun'),
            ExportColumn::make('calonPesertaDidik.desa_kelurahan')
                ->label('Desa/Kelurahan'),
            ExportColumn::make('calonPesertaDidik.kecamatan')
                ->label('Kecamatan'),
            ExportColumn::make('calonPesertaDidik.kabupaten_kota')
                ->label('kabupaten_kota'),
            ExportColumn::make('calonPesertaDidik.provinsi')
                ->label('provinsi'),
            ExportColumn::make('calonPesertaDidik.provinsi')
                ->label('provinsi'),
            ExportColumn::make('calonPesertaDidik.kode_pos')
                ->label('kode_pos'),
            ExportColumn::make('calonPesertaDidik.lintang')
                ->label('lintang'),
            ExportColumn::make('calonPesertaDidik.bujur')
                ->label('bujur'),
            ExportColumn::make('calonPesertaDidik.tempatTinggal.nama')
                ->label('Tempat Tinggal'),
            ExportColumn::make('calonPesertaDidik.modaTransportasi.nama')
                ->label('Moda Transportasi'),
            ExportColumn::make('calonPesertaDidik.anak_ke')
                ->label('Anak Ke'),
            ExportColumn::make('calonPesertaDidik.nomor_hp')
                ->label('No. HP'),
            ExportColumn::make('calonPesertaDidik.nomor_hp_ortu')
                ->label('No. HP Ortu'),
            ExportColumn::make('calonPesertaDidik.email')
                ->label('Email'),
            ExportColumn::make('calonPesertaDidik.username')
                ->label('Username'),
            ExportColumn::make('calonPesertaDidik.password')
                ->label('Password'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor pendaftaran selesai dan berhasil ekskpor ' . number_format($export->successful_rows) . ' baris data.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' baris gagal untuk impor.';
        }

        return $body;
    }
}
