@extends('home')
@section('body')
    <style>
        .table-hover tr:hover td{
            background-color: #000;
        }
    </style>

    {!! Form::model($Company, array('url'=>'company','class' =>'form-horizontal')) !!}
        <div class="form-group form-group-sm">
            {!! Form::label("company_name", "Company Name",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-sm-10">
                {!! Form::text("company_name", null,
                [
                "id" => "company_name",
                "class" => "form-control",
                'autofocus' => 'true'
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("address", "Company Address",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-sm-10">
                {!! Form::text("address", null,
                [
                "id" => "address",
                "class" => "form-control"
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("company_contact_person", "Contact Person",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-sm-10">
                {!! Form::text("company_contact_person", null,
                [
                "id" => "company_contact_person",
                "class" => "form-control"
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("position", "Position",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-sm-10">
                {!! Form::text("position", null,
                [
                "id" => "position",
                "class" => "form-control"
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("company_contact_no", "Contact No.",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-sm-10">
                {!! Form::text("company_contact_no", null,
                [
                "id" => "company_contact_no",
                "class" => "form-control"
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            {!! Form::label("nature_of_business", "Nature of Business.",
            [
            "class" => "control-label col-sm-2"
            ]) !!}

            <div class="col-sm-10">
                {!! Form::text("nature_of_business", null,
                [
                "id" => "nature_of_business",
                "class" => "form-control"
                ]) !!}
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Save</button>
                <a href="{{ url('company/print') }}" class="btn btn-default" target="_blank">Print</a>
            </div>
        </div>

        <div class="panel panel-primary form-group-sm">
            <div class="panel-heading">Companies</div>
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th style="width:1%;"></th>
                    <th style="width:25%;">COMPANY NAME</th>
                    <th style="width:25%;">ADDRESS</th>
                    <th>CONTACT PERSON</th>
                    <th>POSITION</th>
                    <th>CONTACT NO.</th>
                    <th>NATURE OF BUSINESS</th>
                    <th class="text-center">ENGG.</th>
                    <th class="text-center">HM & TOURSIM</th>
                    <th class="text-center">CBA</th>
                    <th class="text-center">MOA CATEGORIES</th>
                </tr>
                </thead>
                <tbody>
                @foreach($Companies as $Comp)
                    <tr>
                        <td><span class="glyphicon glyphicon-remove" onclick="alert('La pa ni ga work ha. hehe');"></span></td>
                        <td>
                            <input type="hidden" name="arr_id[]" value="{{ $Comp->id }}" >
                            <input type="text" name="arr_company_name[]" class="form-control" value="{{ $Comp->company_name }}">
                        </td>
                        <td><input type="text" name="arr_address[]" class="form-control" value="{{ $Comp->address }}"></td>
                        <td><input type="text" name="arr_company_contact_person[]" class="form-control" value="{{ $Comp->company_contact_person }}"></td>
                        <td><input type="text" name="arr_position[]" class="form-control" value="{{ $Comp->position }}"></td>
                        <td><input type="text" name="arr_company_contact_no[]" class="form-control" value="{{ $Comp->company_contact_no }}"></td>
                        <td><input type="text" name="arr_nature_of_business[]" class="form-control" value="{{ $Comp->nature_of_business }}"></td>

                        <td class="text-center">
                            <input type="checkbox"
                                   data-college_id="1"
                                   data-company_id="{{ $Comp->id }}"
                                    @if( $Comp->colleges()->find(1) != null)
                                        checked="checked"
                                    @endif
                            >
                            <input type="hidden" name="arr_is_engg[]"
                                    @if( $Comp->colleges()->find(1) != null)
                                        value="1"
                                    @else
                                        value="0"
                                    @endif
                            >
                        </td>

                        <td class="text-center">
                            <input type="checkbox"
                                   data-college_id="2"
                                   data-company_id="{{ $Comp->id }}"
                                @if( $Comp->colleges()->find(2) != null)
                                    checked="checked"
                                @endif
                            >
                            <input type="hidden" name="arr_is_hm[]"
                                   @if( $Comp->colleges()->find(2) != null)
                                       value="1"
                                   @else
                                       value="0"
                                   @endif
                            >
                        </td>

                        <td class="text-center">
                            <input type="checkbox"
                                   data-college_id="3"
                                   data-company_id="{{ $Comp->id }}"
                                   @if( $Comp->colleges()->find(3) != null)
                                        checked="checked"
                                   @endif
                            >
                            <input type="hidden" name="arr_is_cba[]"
                                    @if( $Comp->colleges()->find(3) != null)
                                        value="1"
                                    @else
                                        value="0"
                                    @endif
                            >
                        </td>

                        <td class="text-center">
                            {!! Form::select(null, $MoaCategories, $Comp->moa_category_id, [
                                'class' => 'control-label moa-category',
                                'data-company_id' => $Comp->id
                            ]) !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    {!! Form::close() !!}

    <script type="text/javascript">
        $("input[type='checkbox']").change(function(){
            if ( $(this).is(":checked") ) {
                var is_checked = 1;
            } else {
                var is_checked = 0;
            }
            var college_id = $(this).data("college_id");
            var company_id = $(this).data("company_id");

            var form_data = {
                is_checked : is_checked,
                college_id : college_id,
                company_id : company_id,
                '_token' : '{{ csrf_token() }}'
            };

            $.post('{{ url('company/college') }}', form_data, function(data){
                console.log(data);
            });
        });

        $(".moa-category").change(function(){

            var moa_category_id = $(this).val();
            var company_id = $(this).data("company_id");

            var form_data = {
                moa_category_id : moa_category_id,
                company_id : company_id,
                '_token' : '{{ csrf_token() }}'
            };

            $.post('{{ url('company/moa-category') }}', form_data, function(data){
                console.log(data);
            });
        });

    </script>
@stop
