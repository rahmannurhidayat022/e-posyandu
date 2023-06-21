@extends("layouts.admin")
@section("title", "Kartu Menuju Sehat (KMS)")
@push('head')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endpush
@section("content")
<section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-5 text-center" style="font-size: 22px; color: rgb(51, 51, 51); font-weight: bold; fill: rgb(51, 51, 51);">Kartu Menuju Sehat (KMS) Online</h2>
                    <div class="table-responsive mb-5">
                        <h2 class="card-title d-flex gap-2 align-items-center mb-3">
                            <i class="ti {{ $profile->jenis_kelamin == 'lk' ? 'ti-gender-male' : 'ti-gender-female' }} fs-8 text-primary"></i>
                            Profil Anak
                        </h2>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>Nama anak:</td>
                                    <td><b>{{ $profile->nama }}</b></td>
                                </tr>
                                <tr>
                                    <td>Jenis kelamin:</td>
                                    <td><b>{{ $profile->jenis_kelamin == 'lk' ? 'Laki-laki' : 'Perempuan' }}</b></td>
                                </tr>
                                <tr>
                                    <td>Usia:</td>
                                    <td><b>{{ $latest->usia }} bulan</b> <small>({{ $age }})</small></td>
                                </tr>
                                <tr>
                                    <td>Berat Badan:</td>
                                    <td>
                                        <b>{{ $latest->bb }} Kg</b><br>
                                        {{ $latest->bb_status == 'obesitas' ? 'Risiko Berat Badan Lebih' : ($latest->bb_status == 'normal' ? 'Normal' : 'Kurang') }}<br>
                                        {{ $latest->bb_status !== 'normal' ? 'Berat ideal antara '.$antropometri->bb_min.' - '.$antropometri->bb_max.' Kg' : ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tinggi Badan:</td>
                                    <td>
                                        <b>{{ $latest->tb }} Cm</b><br>
                                        {{ $latest->tb_status == 'pendek' ? 'Pendek' : ($latest->bb_status == 'normal' ? 'Normal' : 'Tinggi') }}<br>
                                        @if ($latest->tb_status !== 'normal' && $latest->tb_status !== 'tinggi')
                                        Tinggi ideal antara {{ $antropometri->tb_min }} - {{ $antropometri->tb_max }} Cm
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Penimbangan terakhir:</td>
                                    <td>{{ $latest->created_at }}</td>
                                </tr>
                                <tr>
                                    <td>Posko penimbangan</td>
                                    <td>{{ $latest->posko->nama }} / RW {{ $latest->posko->rw }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <small><i>* Umur 16 hari keatas akan dibulatkan menjadi 1 bulan</i></small>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-5">
                            <figure id="weight-container"></figure>
                        </div>
                        <div class="col-12 mt-5">
                            <figure id="hight-container"></figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    let data = {};
    if ("{{ $profile->jenis_kelamin }}" === 'lk') {
        data = {
            bb: weightMale,
            tb: heightMale
        };
    } else if ("{{ $profile->jenis_kelamin }}" === 'pr') {
        data = {
            bb: weightFemale,
            tb: heightFemale
        };
    }

    $.ajax({
        url: '/kesehatan-anak/kms/{{ $id }}',
        success: function(response) {
            Highcharts.chart('weight-container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Berat Badan menurut Umur ({{ $profile->jenis_kelamin == "lk" ? "Laki-laki" : "Perempuan"}})'
                },
                subtitle: {
                    text: 'Sumber: Posyandu Kebon Jayanti'
                },
                xAxis: {
                    categories: []
                },
                tooltip: {
                    headerFormat: 'Umur: {point.x} Bulan<br>',
                    pointFormat: 'Berat: {point.y:.1f} Kg',
                    shared: true
                },
                legend: {
                    enabled: false
                },
                yAxis: {
                    title: {
                        text: 'Berat Badan (Kg)'
                    }
                },
                xAxis: {
                    gridLineWidth: 1,
                    title: {
                        text: 'Umur (Bulan)'
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        marker: {
                            enabled: false
                        },
                        enableMouseTracking: false,
                    },
                },
                series: data.bb,
                navigation: {
                    buttonOptions: {
                        enabled: false
                    }
                }
            });

            Highcharts.chart('hight-container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Tinggi Badan menurut Umur ({{ $profile->jenis_kelamin == "lk" ? "Laki-laki" : "Perempuan"}})'
                },
                subtitle: {
                    text: 'Sumber: Posyandu Kebon Jayanti'
                },
                xAxis: {
                    categories: []
                },
                tooltip: {
                    headerFormat: 'Umur: {point.x} Bulan<br>',
                    pointFormat: 'Tinggi: {point.y:.1f} Cm',
                    shared: true
                },
                legend: {
                    enabled: false
                },
                yAxis: {
                    title: {
                        text: 'Tinggi Badan (Cm)'
                    }
                },
                xAxis: {
                    gridLineWidth: 1,
                    title: {
                        text: 'Umur (Bulan)'
                    }
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: false
                        },
                        marker: {
                            enabled: false
                        },
                        enableMouseTracking: false,
                    },
                },
                series: data.tb,
                navigation: {
                    buttonOptions: {
                        enabled: false
                    }
                }
            });
        }
    })
</script>
@endpush
