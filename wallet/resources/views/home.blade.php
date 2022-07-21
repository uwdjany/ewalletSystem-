@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Current balance: <b>{{ number_format(auth()->user()->balance) }} RWF</b>
                    </div>

                    <div class="card-body">
                        <div class="card-title"><b>Send money</b></div>
                        <form method="post" action="/transaction" class="form">
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">{{ $error }}</div>
                            @endforeach
                            @if(session("message"))
                                <div class="alert alert-success">
                                    {{ session("message") }}
                                </div>
                            @endif
                            @csrf
                            <div class="form-group">
                                <label for="email">Receiver email</label>
                                <input type="email" name="email" required id="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" required
                                       class="form-control @error('amount') is-invalid @enderror"
                                       value="{{ old('amount') }}" id="amount">
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="alert alert-info">
                                Please note that:<br>
                                ○ Rwf 1 - 10,000 (no transaction fee),<br>
                                ○ Rwf 10,000 - 100,000 (transaction fee of Rwf 200),<br>
                                ○ Rwf 100,000 - above (transaction fee of Rwf 1,000).<br>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
