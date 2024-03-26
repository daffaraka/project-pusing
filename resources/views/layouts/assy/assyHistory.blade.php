@extends('layouts.template')
@section('content')
    <main>
        <a href="{{ url('/checksheetassy') }}" class="btn btn-outline-primary">+ CHECKSHEET</a>
        <a href="{{ url('/dashboardassy') }}" class="btn btn-outline-secondary">HISTORY</a>
        <div class="card">
            <div class="card-body">
                <form action="" method="get" class="my-4">
                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label for="">Date From</label>
                            <input type="date" id="date_from" name="date_from" class="form-control"
                                value="{{ $request->date_from }}">
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="">Date To</label>
                            <input type="date" id="date_to" name="date_to" class="form-control"
                                value="{{ $request->date_to }}">
                        </div>
                        <div class="col-md-2 form-group" style="margin-top:25px;">
                            <input type="submit" class="btn btn-primary" value="Search">
                            <a href="assy-history?" class="btn btn-dark">Refresh</a>

                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Auditor</th>
                                {{-- <th>Action</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Carbon\Carbon::parse($item['date'])->isoFormat('dddd, D MMMM Y') }}</td>
                                    <td>
                                        @foreach ($item['auditors'] as $auditor)
                                            <li>{{ $auditor->auditor_name }}
                                                <a href="{{ route('detailAssyHistory', ['id_user' => $auditor->id, 'date' => $item['date']]) }}"
                                                    class="btn btn-info my-3 btn-sm">Detail</a>
                                            </li>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('js')
    <!-- Di bagian head atau sebelum closing tag </body> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mengambil tanggal hari ini
            var today = new Date();
            today.setHours(0, 0, 0, 0); // Mengatur jam ke 00:00:00
            var tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1); // Mengambil tanggal besok

            // Mengubah format tanggal ke YYYY-MM-DD
            var tomorrowFormatted = tomorrow.toISOString().split('T')[0];

            // Menetapkan atribut 'max' pada input dengan id 'date_from'
            $('#date_from').attr('max', tomorrowFormatted);
        });
    </script>
    <!-- Di bagian head atau sebelum closing tag </body> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ketika nilai input tanggal 'date_from' berubah
            $('#date_from').change(function() {
                // Mengambil nilai tanggal dari 'date_from'
                var dateFromValue = $(this).val();

                // Mengatur nilai minimum untuk input tanggal 'date_to'
                $('#date_to').attr('min', dateFromValue);

                // Mengambil tanggal besok
                var tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1); // Mengambil tanggal besok
                var tomorrowFormatted = tomorrow.toISOString().split('T')[0];

                // Mengatur nilai maksimum untuk input tanggal 'date_to' sebagai hari sebelumnya
                var yesterday = new Date();
                yesterday.setDate(yesterday.getDate()); // Mengambil tanggal sebelumnya
                var yesterdayFormatted = yesterday.toISOString().split('T')[0];

                // Jika tanggal 'date_from' sama dengan hari ini, nonaktifkan tanggal besok di 'date_to'
                if (dateFromValue === tomorrowFormatted) {
                    $('#date_to').attr('max', dateFromValue);
                } else {
                    // Mengatur tanggal maksimum sebagai hari sebelumnya
                    $('#date_to').attr('max', yesterdayFormatted);
                }
            });
        });
    </script>
@endpush
