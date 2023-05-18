@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 p-5">
                <div class="card">
                    <div class="card-header">
                      <h1>Dynamic Form</h1>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Form Name</label>
                            <input type="text" class="form-control" id="form-name" placeholder="Enter Form Name">
                        </div>
                        <blockquote class="blockquote mb-0">
                            <div id="builder"></div>
                        </blockquote>
                        <div class="p-3 text-center">
                            <button class="btn btn-danger" id="clearData" type="button">Clear Form</button>
                            <button class="btn btn-primary" id="saveData" type="button">Save</button>
                            <button class="btn btn-warning" id="cancelData" type="button" onclick="window.location.href='{{ route('list-form') }}'">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var fbEditor = document.getElementById("builder");
        var options = options = {
                showActionButtons: false,
                editOnAdd: true,
                disableFields: ['autocomplete','button', 'header', 'hidden', 'paragraph'],
                controlOrder: ['text','textarea', 'number', 'file', 'select', 'checkbox-group', 'radio-group'],
                disabledAttrs: ["access", "multiple", "description", "other", "toggle"],
                typeUserDisabledAttrs: {
                    'checkbox-group': [
                        'selected'
                    ]
                }
        };
        var formBuilder = $(fbEditor).formBuilder(options);

        document.getElementById('clearData').onclick = function() {
            formBuilder.actions.clearFields();
        };

        document.getElementById("saveData").addEventListener("click", (e) => {
            console.log("external save clicked");
            var result = formBuilder.actions.save();

            e.preventDefault();

            var formName = document.getElementById('form-name').value;

            if (formName == "") {
                return alert('Form Name Can Not Empty');
            }
    
            $.ajax({
                type:'POST',
                url:"{{ route('api-save-form') }}",
                data: {
                    result:result,
                    formName: formName
                },
                success:function(data)  {
                    window.location.href='{{ route('list-form') }}';
                }
            });

            console.log("result:", result);
        });
    });
</script>
@endsection