<?php

namespace App\Filament\Exports;

use App\Models\CalonPesertaDidik;
use App\Models\Pendaftaran;
use App\Models\Periodik;
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
            ExportColumn::make('calonPesertaDidik.nomor_pendaftaran')
                ->label('Nomor Pendaftaran'),
            ExportColumn::make('calonPesertaDidik.username')
                ->label('Username'),
            ExportColumn::make('calonPesertaDidik.password')
                ->label('Password'),

            ExportColumn::make('calonPesertaDidik.rapor.sum')
                ->label('Total Rapor'),
            ExportColumn::make('calonPesertaDidik.rapor.avg')
                ->label('Rata-rata Rapor'),
            ExportColumn::make('calonPesertaDidik.rapor.pai')
                ->label('PAI'),
            ExportColumn::make('calonPesertaDidik.rapor.pai_1')
                ->label('PAI 1'),
            ExportColumn::make('calonPesertaDidik.rapor.pai_2')
                ->label('PAI 2'),
            ExportColumn::make('calonPesertaDidik.rapor.pai_3')
                ->label('PAI 3'),
            ExportColumn::make('calonPesertaDidik.rapor.pai_4')
                ->label('PAI 4'),
            ExportColumn::make('calonPesertaDidik.rapor.pai_5')
                ->label('PAI 5'),
            ExportColumn::make('calonPesertaDidik.rapor.bindo')
                ->label('BINDO'),
            ExportColumn::make('calonPesertaDidik.rapor.bindo_1')
                ->label('BINDO 1'),
            ExportColumn::make('calonPesertaDidik.rapor.bindo_2')
                ->label('BINDO 2'),
            ExportColumn::make('calonPesertaDidik.rapor.bindo_3')
                ->label('BINDO 3'),
            ExportColumn::make('calonPesertaDidik.rapor.bindo_4')
                ->label('BINDO 4'),
            ExportColumn::make('calonPesertaDidik.rapor.bindo_5')
                ->label('BINDO 5'),
            ExportColumn::make('calonPesertaDidik.rapor.mtk')
                ->label('MTK'),
            ExportColumn::make('calonPesertaDidik.rapor.mtk_1')
                ->label('MTK 1'),
            ExportColumn::make('calonPesertaDidik.rapor.mtk_2')
                ->label('MTK 2'),
            ExportColumn::make('calonPesertaDidik.rapor.mtk_3')
                ->label('MTK 3'),
            ExportColumn::make('calonPesertaDidik.rapor.mtk_4')
                ->label('MTK 4'),
            ExportColumn::make('calonPesertaDidik.rapor.mtk_5')
                ->label('MTK 5'),
            ExportColumn::make('calonPesertaDidik.rapor.ipa')
                ->label('IPA'),
            ExportColumn::make('calonPesertaDidik.rapor.ipa_1')
                ->label('IPA 1'),
            ExportColumn::make('calonPesertaDidik.rapor.ipa_2')
                ->label('IPA 2'),
            ExportColumn::make('calonPesertaDidik.rapor.ipa_3')
                ->label('IPA 3'),
            ExportColumn::make('calonPesertaDidik.rapor.ipa_4')
                ->label('IPA 4'),
            ExportColumn::make('calonPesertaDidik.rapor.ipa_5')
                ->label('IPA 5'),
            ExportColumn::make('calonPesertaDidik.rapor.ips')
                ->label('IPS'),
            ExportColumn::make('calonPesertaDidik.rapor.ips_1')
                ->label('IPS 1'),
            ExportColumn::make('calonPesertaDidik.rapor.ips_2')
                ->label('IPS 2'),
            ExportColumn::make('calonPesertaDidik.rapor.ips_3')
                ->label('IPS 3'),
            ExportColumn::make('calonPesertaDidik.rapor.ips_4')
                ->label('IPS 4'),
            ExportColumn::make('calonPesertaDidik.rapor.ips_5')
                ->label('IPS 5'),
            ExportColumn::make('calonPesertaDidik.rapor.bing')
                ->label('BING'),
            ExportColumn::make('calonPesertaDidik.rapor.bing_1')
                ->label('BING 1'),
            ExportColumn::make('calonPesertaDidik.rapor.bing_2')
                ->label('BING 2'),
            ExportColumn::make('calonPesertaDidik.rapor.bing_3')
                ->label('BING 3'),
            ExportColumn::make('calonPesertaDidik.rapor.bing_4')
                ->label('BING 4'),
            ExportColumn::make('calonPesertaDidik.rapor.bing_5')
                ->label('BING 5'),
            ExportColumn::make('calonPesertaDidik.rapor.sakit')
                ->label('Sakit'),
            ExportColumn::make('calonPesertaDidik.rapor.izin')
                ->label('Izin'),
            ExportColumn::make('calonPesertaDidik.rapor.alpa')
                ->label('Alpa'),

            ExportColumn::make('calonPesertaDidik.periodik.tinggi')
                ->label('Tinggi'),
            ExportColumn::make('calonPesertaDidik.periodik.berat')
                ->label('Berat'),
            ExportColumn::make('calonPesertaDidik.periodik.lingkar_kepala')
                ->label('Lingkar Kepala'),
            ExportColumn::make('calonPesertaDidik.periodik.no_sepatu')
                ->label('No Sepatu'),
            ExportColumn::make('calonPesertaDidik.periodik.ukuran_baju')
                ->label('Ukuran Baju')
                ->state(fn (Pendaftaran $record) => isset($record->calonPesertaDidik->periodik->ukuran_baju) ? $record->calonPesertaDidik->periodik->ukuran_baju->getLabel() : '-' ),
            ExportColumn::make('calonPesertaDidik.periodik.tindik')
                ->label('Tindik'),
            ExportColumn::make('calonPesertaDidik.periodik.tato')
                ->label('Tato'),
            ExportColumn::make('calonPesertaDidik.periodik.cat_rambut')
                ->label('Cat Rambut'),

            ExportColumn::make('calonPesertaDidik.btq.penguji.name')
                ->label('Penguji'),
            ExportColumn::make('calonPesertaDidik.btq.kelancaran')
                ->label('kelancaran'),
            ExportColumn::make('calonPesertaDidik.btq.kefasihan')
                ->label('kefasihan'),
            ExportColumn::make('calonPesertaDidik.btq.tajwid')
                ->label('tajwid'),
            ExportColumn::make('calonPesertaDidik.btq.keterangan')
                ->label('keterangan'),

            ExportColumn::make('calonPesertaDidik.tes.minat_bakat')
                ->label('Minat Bakat'),
            ExportColumn::make('calonPesertaDidik.tes.khusus')
                ->label('Tes Khusus'),
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
