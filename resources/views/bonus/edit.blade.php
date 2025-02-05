@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Bonus</div>
                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form action="{{ route('bonuses.update', $bonus->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name='_method' value='PUT'>
                        
                        <div class="form-group{{ $errors->has('total_bonus') ? ' has-error' : '' }}">
                            <label for="total_bonus" class="control-label">Total Bonus</label>
                            <input id="total_bonus" type="text" class="form-control" name="total_bonus" value="{{ old('total_bonus', $bonus->total_bonus) }}" required>
                        </div>
                        
                        <button type="button" class="btn btn-primary" id="addBonus">Tambah Pegawai</button>
                        <br><br>

                        <div class="row mb-2 form-group bonus-row">
                            <div class="col-md-4">
                                <label class="control-label">Nama Pegawai</label>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Persentase</label>
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Nominal</label>
                            </div>
                            <div class="col-md-2"></div>
                        </div>
                        <div id="bonus-container" class="form-group">
                            @foreach($bonus_details as $detail)
                                <div class="row mb-2 form-group bonus-row">
                                    <div class="col-md-4">
                                        <select name="employee_id[]" class="form-control" required>
                                            <option value="" disabled>Pilih Employee</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}" {{ $employee->id == $detail->employee_id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="percentage[]" class="form-control percentage" placeholder="Persentase Bonus (%)" required min="0" max="100" value="{{ $detail->persentase }}">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control nominal" value="" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-btn">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a class="btn btn-default" href="{{route('bonuses.index')}}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scriptText')
<script>
    $(document).ready(function () {
        function calculateNominal() {
            let totalBonus = parseFloat($("#total_bonus").val()) || 0;
            
            $(".bonus-row").each(function () {
                let percentage = parseFloat($(this).find(".percentage").val()) || 0;
                let nominal = (totalBonus * percentage) / 100;
                $(this).find(".nominal").val(nominal.toFixed(2));
            });
        }

        // Panggil saat halaman dimuat
        calculateNominal();

        $("#total_bonus").on("input", calculateNominal);
        $(document).on("input", ".percentage", calculateNominal);

        $("#addBonus").on("click", function () {
            let newRow = `<div class="row mb-2 form-group bonus-row">
                <div class="col-md-4">
                    <select name="employee_id[]" class="form-control" required>
                        <option value="" disabled selected>Pilih Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="percentage[]" class="form-control percentage" placeholder="Persentase Bonus (%)" required min="0" max="100">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control nominal" value="" readonly>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-btn">Hapus</button>
                </div>
            </div>`;

            $("#bonus-container").append(newRow);
        });

        $(document).on("click", ".remove-btn", function () {
            $(this).closest(".bonus-row").remove();
            calculateNominal();
        });
    });
</script>
@endsection
