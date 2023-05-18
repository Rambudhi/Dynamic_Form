@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 p-5">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        {{ $dynamic_form->form_name }} Form
                      </h5>
                    <div class="card-body">
                        <input type="hidden" id="json" name="json" value="{{ $dynamic_form->json }}">
                        <form method="post" id="dynamic-form">
                            <input type="hidden" id="db" name="db" value="{{ $dynamic_form->form_name }}">
                            <div id="builder"></div>
                            <div class="p-3 text-center">
                                <button class="btn btn-primary" id="saveData" type="button">Save</button>
                                <button class="btn btn-warning" id="cancelData" type="button" onclick="window.location.href='{{ route('list-form') }}'">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        $("input:checkbox").removeAttr('checked');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var json = document.getElementById('json');
        $('#builder').formRender({
            dataType: 'json',
            formData: json.value
        });

        $('#saveData').on('click', function(e) {
            e.preventDefault();
            const form = document.getElementById("dynamic-form");
            const formData = new FormData(form); 
            $.ajax({
                type:'POST',
                url:"{{ route('api-save') }}",
                data: new FormData(form),
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                success:function(data)  {
                    window.location.href='{{ route('list-form') }}';
                }
            });
        });
    });
</script>
@endsection