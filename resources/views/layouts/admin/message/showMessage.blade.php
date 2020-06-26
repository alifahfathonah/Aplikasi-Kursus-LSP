@extends('layouts.admin.panel')

@section('konten')
<div class="card">
    <div class="card-header">Message</div>
    <div class="card-body">
        <form>
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="name" value="{{$message -> nama}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="email" value="{{$message -> email}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="phone" value="{{$message -> phone}}">
                </div>
            </div>
            <div class="form-group row">
                <label for="date" class="col-sm-2 col-form-label">Date</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="date" value="{{$message->created_at->format("D, d M Y | H:i")}}">
                </div>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message-read" rows="5" name="message" readonly>{{$message->pesan}}</textarea>
            </div>
        </form>
        <div class="text-right">
        <form action="{{$message -> id}}" method="POST" class="d-inline">
            @method('delete')
            @csrf
            <button type="submit" class="btn btn-danger tune-ico" id="delete-data"><i class="las la-trash la-lg"></i>Delete</button>
        </form>
        </div>
    </div>
</div>
@endsection