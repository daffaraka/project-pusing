@extends('layouts.template')

@section('content')
    <main>
        <div class="card">
            <div class="card-body">
                <form action="" method="get" class="my-4">
                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label for="">Date From</label>
                            <input type="date" name="date_from" class="form-control" value="{{ $request->date_from }}">
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="">Date To</label>
                            <input type="date" name="date_to" class="form-control" value="{{ $request->date_to }}">
                        </div>
                        <div class="col-md-2 form-group" style="margin-top:25px;">
                            <input type="submit" class="btn btn-primary" value="Search">
                            <a href="castinghistory" class="btn btn-dark">Refresh</a>

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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Carbon\Carbon::parse($item['date'])->isoFormat('dddd, D MMMM Y') }}</td>
                                    <td>
                                        @foreach ($item['auditors'] as $auditor)
                                            <li>{{ $auditor->auditor_name }} <a href=""
                                                    class="btn btn-primary my-3 btn-sm">Detail</a></li>
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
