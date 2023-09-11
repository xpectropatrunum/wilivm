<div class="table-responsive">
    <table class="table table-striped table-bordered mb-0 text-nowrap">
        <thead>
            <tr>
                <th>#</th>
                <th>TX ID</th>
                <th>Order</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Method</th>
                <th>Status</th>
                <th>{{ __('admin.created_date') }}</th>
                <th>Actions</th>



            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->tx_id }}</td>

                    <td><a href="/admin/orders?search={{ $item->order_id }}"
                            target="_blank">#{{ $item->order_id }}</a></td>

                    <td>{{ $item->order?->price }}</td>
                    <td>{{ $item->order?->discount }}</td>
                    <td>{{ ucfirst($item->method) }}</td>
                    <td>
                        <a href="javascript:{}" class="status-menu" cs="{{ $item->id }}">
                            @if ($item->status == 1)
                                <div class="badge badge-success">Paid</div>
                            @elseif ($item->status == 0)
                                <div class="badge badge-warning">Unpaid</div>
                            @elseif ($item->status == 2)
                                <div class="badge badge-danger">Refund</div>
                            @elseif ($item->status == 3)
                                <div class="badge badge-danger">Fraud</div>
                            @endif
                        </a>

                    </td>
                    <td>{{ $item->created_at }}</td>
                    <td class="project-actions">
                        @if ($item->order)
                            <a href="{{ route('admin.payments.edit', $item->id) }}">
                                <button type="button" class="btn btn-primary btn-sm">
                                    <i class="fas fa-pen"></i>
                                    Edit
                                </button>
                            </a>
                        @endif

                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>
</div>