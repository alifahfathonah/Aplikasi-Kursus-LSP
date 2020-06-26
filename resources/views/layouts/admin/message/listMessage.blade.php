@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Message</div>
    <div class="card-body">
    @if (!$messages->isEmpty())
        <table class="table">
            <thead class="table table-hover">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Date</th>
                    <th class="text-center" scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                @if($message->read == true)
                <tr>
                    <th scope="row">{{$loop -> iteration + $skipped}}</th>
                    <td>{{$message -> nama}}</td>
                    <td>{{$message -> email}}</td>
                    <td>{{$message -> phone}}</td>
                    <td>{{$message->created_at->format("D, d M Y | H:i")}}</td>
                    <td class="text-center">
                        <a href="message/{{$message->id}}"><i class="las la-pen-square la-2x"></i></a>
                    </td>
                </tr>
                @else
                <tr style="background-color: whitesmoke">
                    <th scope="row"><b>{{$loop -> iteration + $skipped}}</b></th>
                    <td><b>{{$message -> nama}}</b></td>
                    <td><b>{{$message -> email}}</b></td>
                    <td><b>{{$message -> phone}}</b></td>
                    <td><b>{{$message->created_at->format("D, d M Y | H:i")}}</b></td>
                    <td class="text-center">
                        <a href="message/{{$message->id}}"><i class="las la-pen-square la-2x"></i></a>
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        {{ $messages->links() }}

    @else
        <h5>You don't have any message</h5>
    @endif
    </div>
</div>
@endsection