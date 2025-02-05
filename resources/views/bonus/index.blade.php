@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Bonuses
                </div>

                <div class="panel-body">
                    <a href="{{route('bonuses.create')}}">
                        <button class="btn btn-default">
                            + Add New Bonus
                        </button>
                    </a>
                    <table id="myTable" class="display">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Total Bonus</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bonuses as $i => $bonus)
                                <tr>
                                    <td>{{$i+1}}</td>
                                    <td>{{ 'Rp ' . number_format($bonus->total_bonus, 0, ',', '.') }}</td>
                                    <td>{{$bonus->created_at}}</td>
                                    <td>{{$bonus->updated_at}}</td>
                                    <td>
                                        <a href="{{ route('bonuses.edit', $bonus->id) }}" class="btn btn-warning btn-sm" 
                                            @if(auth()->user()->role !== 'admin') 
                                                onclick="return showRoleAlert();" 
                                            @endif
                                        >Edit</a>
                                        @if(auth()->user()->role !== 'admin') 
                                            <a href="{{ route('bonuses.edit', $bonus->id) }}" class="btn btn-danger btn-sm" onclick="return showRoleAlert();" >Delete</a>
                                        @else
                                        <form action="{{ route('bonuses.destroy', $bonus->id) }}" method="POST" style="display:inline;">
                                            {{ csrf_field() }}
                                            <input type="hidden" name='_method' value='DELETE'>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                        </form>
                                        
                                        @endif
                                        <a href="{{ route('bonuses.detail', $bonus->id) }}" class="btn btn-primary btn-sm">Detail</a>
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

@section('scriptText')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );

    function showRoleAlert() {
        // SweetAlert untuk menunjukkan pesan
        Swal.fire({
            title: 'Tidak bisa mengakses menu',
            text: 'Harap hubungi admin untuk mengubah role.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        return false;  // Prevents the action (Edit/Delete) from being executed
    }
</script>
@endsection