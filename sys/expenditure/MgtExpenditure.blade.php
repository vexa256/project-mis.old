<!--begin::Card body-->
<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {!! Alert(
    $icon = 'fa-info',
    $class = 'alert-primary',
    $Title = 'Let\'s manage project expenditure ',
    $Msg = 'Add, remove and edit the project expenditure records',
    ) !!}
</div>
<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'Record Expenditure', $Icon = 'fa-plus') }}
    <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
        <thead>
            <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                <th> Project </th>
                <th> Module </th>
                <th> Activity </th>
                <th> Category </th>
                <th> Narrative</th>
                <th>Budget line</th>
                <th>Amount Spent</th>
                <th>Financial Quarter</th>
                <th>Financial Year</th>
                <th>Expected out comes</th>
                <th class="bg-dark text-light"> Update </th>
                <th class="bg-danger fw-bolder text-light"> Delete </th>



            </tr>
        </thead>
        <tbody>
            @isset($Expenditures)
            @foreach ($Expenditures as $data)
            <tr>

                <td>{{ $data->ProjectName }}</td>
                <td>{{ $data->ProjectModuleName }}</td>
                <td>{{ $data->ActivityName }}</td>
                <td>{{ $data->ExpenditureGroup }}</td>
                <td>{{ $data->ExpenditureNarrative }}</td>
                <td>{{ $data->BudgetLine }}</td>
                <td>{{ $data->AmountSpentInUsd }}</td>


                <td>{{ $data->FinancialQuarter }}</td>
                <td>{{ $data->FinancialYear }}</td>
                <td>{{ $data->ExpectedOutComes }}</td>





                <td>

                    <a data-bs-toggle="modal" class="btn shadow-lg btn-dark btn-sm admin" href="#Update{{ $data->id }}">

                        <i class="fas fa-edit" aria-hidden="true"></i>
                    </a>

                </td>


                <td>

                    {!! ConfirmBtn(
                    $data = [
                    'msg' => 'You want to delete this record',
                    'route' => route('DeleteData', [
                    'id' => $data->id,
                    'TableName' => 'project_activity_expenditures',
                    ]),
                    'label' => '<i class="fas fa-trash"></i>',
                    'class' => 'btn btn-danger btn-sm deleteConfirm',
                    ],
                    ) !!}

                </td>




            </tr>
            @endforeach
            @endisset



        </tbody>
    </table>
</div>



@isset($Expenditures)
@foreach ($Expenditures as $up)
{{ UpdateModalHeader($Title = 'Update the selected  record', $ModalID = $up->id) }}
<form action="{{ route('MassUpdate') }}" class="" method="POST">
    @csrf

    <div class="row">
        <div class="mb-3 col-md-3">
            <label id="label" for="" class="required mt-3 form-label">Select
                Financial Year
            </label>
            <select required name="FinancialYear" class="form-select   form-select-solid" data-control="select2" data-placeholder="Select a option">


                <option value="">
                </option>

                @for ($i = date('Y') - 5; $i <= date('Y') + 10; $i++) <option value="{{ $i }}">
                    {{ $i }}</option>
                    @endfor


            </select>

        </div>

        <div class="mb-3 col-md-3">
            <label id="label" for="" class="required mt-3 form-label">Select
                Financial Quater
            </label>
            <select required name="FinancialQuarter" class="form-select   form-select-solid" data-control="select2" data-placeholder="Select a option">


                <option value=""></option>
                <option value="1">Q1</option>
                <option value="2">Q2</option>
                <option value="3">Q3</option>
                <option value="4">Q4</option>
                <option value="5">Q5</option>
                <option value="6">Q6</option>
                <option value="7">Q7</option>
                <option value="8">Q8</option>
                <option value="9">Q9</option>
                <option value="10">Q10</option>
                <option value="11">Q11</option>
                <option value="12">Q12</option>

            </select>

        </div>
        <div class="mb-3 col-md-3">
            <label id="label" for="" class="required mt-3 form-label">Select
                Activity
            </label>
            <select required name="AID" class="form-select   form-select-solid" data-control="select2" data-placeholder="Select a option">
                <option value=""> </option>
                @isset($Activities)
                @foreach ($Activities as $up2)
                <option value="{{ $up2->AID }}">
                    {{ $up2->ActivityName }}

                </option>
                @endforeach
                @endisset

            </select>

        </div>

        <div class="mb-3 col-md-3">
            <label id="label" for="" class="required mt-3 form-label">Select
                Expenditure Category
            </label>
            <select required name="ExpenditureGroup" class="form-select   form-select-solid" data-control="select2" data-placeholder="Select a option">
                <option value=""> </option>
                @isset($ExpednditureGroups)
                @foreach ($ExpednditureGroups as $uwp)
                <option value="{{ $uwp->ExpenditureGroup }}">
                    {{ $uwp->ExpenditureGroup }}

                </option>
                @endforeach
                @endisset

            </select>

        </div>

        <input type="hidden" name="id" value="{{ $up->id }}">

        <input type="hidden" name="TableName" value="project_activity_expenditures">

        {{ RunUpdateModalFinal($ModalID = $up->id, $Extra = '', $csrf = null, $Title = null, $RecordID = $up->id, $col = '4', $te = '12', $TableName = 'project_activity_expenditures') }}
    </div>


    {{ _UpdateModalFooter() }}

</form>
@endforeach
@endisset


@include('expenditure.NewExpenditure')
