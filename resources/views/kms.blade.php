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
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{ route('penimbangan.index', $id) }}">Penimbangan Anak</a></li>
                            <li class="breadcrumb-item active" aria-current="page">KMS Online</li>
                        </ol>
                    </nav>
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
                                        {{ $latest->bb_status }}<br>
                                        {{ $latest->bb_status !== 'Normal' ? 'Berat ideal antara '.$antropometri_bb->minus_2_sd.' - '.$antropometri_bb->plus_1_sd.' Kg' : ''}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tinggi Badan:</td>
                                    <td>
                                        <b>{{ $latest->tb }} Cm</b><br>
                                        {{ $latest->tb_status}}<br>
                                        @if ($latest->tb_status !== 'Normal' && $latest->tb_status !== 'Tinggi')
                                        Tinggi ideal antara {{ $antropometri_tb->minus_2_sd }} - {{ $antropometri_tb->plus_3_sd }} Cm
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
                            <div class="d-flex justify-content-center">
                                <small><i>* usia < 24 bulan menggunakan panjang badan</i></small>
                            </div>
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
            const weightData = [
                ...data.bb,
                {
                    name: '',
                    marker: {
                        enabled: true
                    },
                    color: 'black',
                    lineWidth: 0.2,
                    data: response.bb,
                    pointStart: 0,
                    enableMouseTracking: true
                }
            ];

            Highcharts.chart('weight-container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Berat Badan menurut Umur ({{ $profile->jenis_kelamin == "lk" ? "Laki-laki" : "Perempuan"}})'
                },
                subtitle: {
                    text: 'Sumber: PMK No.2 Tahun 2020'
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
                series: weightData,
                navigation: {
                    buttonOptions: {
                        enabled: false
                    }
                }
            });

            const heightData = [
                ...data.tb,
                {
                    name: '',
                    marker: {
                        enabled: true
                    },
                    color: 'black',
                    lineWidth: 0.2,
                    data: response.tb,
                    pointStart: 0,
                    enableMouseTracking: true
                }
            ];
            Highcharts.chart('hight-container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Tinggi Badan menurut Umur ({{ $profile->jenis_kelamin == "lk" ? "Laki-laki" : "Perempuan"}})'
                },
                subtitle: {
                    text: 'Sumber: PMK No.2 Tahun 2020'
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
                series: heightData,
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
