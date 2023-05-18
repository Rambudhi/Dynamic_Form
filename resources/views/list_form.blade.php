@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 p-5">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        List Form
                        <button type="button" class="btn btn-sm btn-primary" onclick="window.location.href='{{ route('dynamic-form') }}'">Add Form Dynamic</button>
                      </h5>
                    <div class="card-body">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Form Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dynamic_form as $dynamicform)
                                <tr>
                                    <td class="col-md-9">{{ $dynamicform->form_name }}</td>
                                    <td class="col-md-3">
                                        <div class="btn-group flex-wrap">
                                            <button type="button" class="btn btn-success btn-lg-block" data-toggle="tooltip" title="DB" onclick="window.location.href='{{ route('data-base', ['id' => $dynamicform->id, 'name' => $dynamicform->form_name ]) }}'">
                                                <i class="fa fa-database"></i>
                                            </button> 
                                            <button type="button" class="btn btn-info btn-lg-block" data-toggle="tooltip" title="show" onclick="window.location.href='{{ route('form', $dynamicform->id) }}'">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-lg-block" data-toggle="tooltip" title="Hapus" id="deleteById" data-id="{{ $dynamicform->id }}" data-name="{{ $dynamicform->form_name }}">
                                                <i class="fa fa-trash-o"></i>
                                            </button> 
                                        </div>
                                    </td>
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
        
        $('#deleteById').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var name = $(this).data("name");   

            $.ajax({
                type:'POST',
                url:"{{ route('api-delete-form') }}",
                data: {
                    id:id,
                    name:name
                },
                success:function(data)  {
                    window.location.href='{{ route('list-form') }}';
                }
            });
        });
    });
</script>
@endsection