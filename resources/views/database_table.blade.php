@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 p-5">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        Table {{ $name }}
                        <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='{{ route('list-form') }}'">Back To list Form</button>
                      </h5>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    @foreach($field_name as $fn)
                                    <th>{{ $fn }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data_value as $key => $dv)
                                <tr>
                                    @foreach ($dv as $item)
                                        <td>{{ $item }}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
@endsection