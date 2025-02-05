@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Detail Bonus</div>
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
                            <label for="total_bonus" class="control-label">Total Bonus</label><br>
                            <label for="">{{ 'Rp ' . number_format($bonus->total_bonus, 0, ',', '.') }}</label>
                        </div>
                        <table id="myTable" class="display">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pegawai</th>
                                    <th>Persentase Bonus</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bonus_details as $i => $detail)
                                    <tr>
                                        <td>{{$i+1}}</td>
                                        <td>{{$detail->employee->name}}</td>
                                        <td>{{ $detail->persentase }} %</td>
                                        <td>{{'Rp ' . number_format(($bonus->total_bonus * $detail->persentase) / 100, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="form-group">
                            <a class="btn btn-default" href="{{route('bonuses.index')}}">Kembali</a>
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
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
@endsection