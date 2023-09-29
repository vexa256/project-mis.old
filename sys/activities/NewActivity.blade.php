<div class="modal fade" id="New">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title">Create a new project activity record and
                    attach it to the module


                    <span class="text-danger">
                        {{ $ModuleName }}
                    </span>



                </h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">

                <form action="{{ route('MassInsert') }}" class="row" method="POST">
                    @csrf

                    <div class="row">

                        <div class="mb-3 col-md-6 d-none">
                            <label id="label" for="" class="required mt-3 form-label">Select
                                Financial Year
                            </label>
                            <select required name="FinancialYear" class="form-select   form-select-solid" data-control="select2" data-placeholder="Select a option">


                                <option value="2022">2022
                                </option>

                                @for ($i = date('Y') - 5; $i <= date('Y') + 10; $i++) <option value="{{ $i }}">
                                    {{ $i }}</option>
                                    @endfor


                            </select>

                        </div>

                        <div class="mb-3 col-md-6 d-none">
                            <label id="label" for="" class="required mt-3 form-label">Select
                                Financial Quater
                            </label>
                            <select required name="FinancialQuater" class="form-select   form-select-solid" data-control="select2" data-placeholder="Select a option">


                                <option value="1">Q1</option>
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


                        @foreach ($Form as $data)
                        @if ($data['type'] == 'string')
                        {{ CreateInputText($data, $placeholder = null, $col = '4') }}
                        @elseif (
                        'smallint' == $data['type'] ||
                        'bigint' === $data['type'] ||
                        'integer' == $data['type'] ||
                        'bigint' == $data['type']
                        )
                        {{ CreateInputInteger($data, $placeholder = null, $col = '4') }}
                        @elseif ($data['type'] == 'date' || $data['type'] == 'datetime')
                        {{ CreateInputDate($data, $placeholder = null, $col = '4') }}
                        @endif
                        @endforeach

                    </div>

                    <div class="row">
                        @foreach ($Form as $data)
                        @if ($data['type'] == 'text')
                        {{ CreateInputEditor($data, $placeholder = null, $col = '12') }}
                        @endif
                        @endforeach

                    </div>


                    <input required type="hidden" name="AID" value="{{ md5(\Hash::make(uniqid() . 'AFC' . date('Y-m-d H:I:S'))) }}">


                    <input required type="hidden" name="MID" value="{{ $MID }}">


                    <input required type="hidden" name="PID" value="{{ $PID }}">



                    <input required type="hidden" name="TableName" value="project_ativities">





            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-dark">Save
                    Changes</button>

                </form>
            </div>

        </div>
    </div>
</div>
