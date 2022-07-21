@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        Transactions
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th>Amount</th>
                                <th>Transaction fee</th>
                                <th>Type</th>
                                <th>Receiver</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $loop->iteration }}.</td>
                                    <td>{{ number_format($transaction->amount) }} RWF</td>
                                    <td>{{ $transaction->deducted_fee }} RWF</td>
                                    <td>{!!  $transaction->receiver_id==auth()->user()->id?"<label class='badge badge-success'>Received</label>":"<label class='badge badge-danger'>Sent</label>"  !!}</td>
                                    <td>
                                        {{ $transaction->receiver_id==auth()->user()->id?"Me":$transaction->sender->name.", ".$transaction->sender->email }}
                                    </td>
                                    <td>{{ $transaction->created_at->toDateTimeString() }}</td>
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
