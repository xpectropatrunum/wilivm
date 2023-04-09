<div class="table-responsive">
    <table class="table table-striped table-bordered mb-0 text-nowrap">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Type</th>
                <th>Plan</th>
                <th>Os</th>
                <th>Location</th>
                <th>Cycle</th>
                <th>{{ __('admin.created_date') }}</th>
                <th>Expires At</th>
                <th>Transaction Status</th>
                <th>Service Status</th>
  

            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><a href="/admin/users?search={{ $item->user?->email }}"
                            target="_blank">{{ $item->user?->email }}</a></td>
                    <td>{{ $item->service->type }}</td>
                    <td>{{ $item->service->plan }}</td>
                    <td>{{ $item->service->os_->name }}</td>
                    <td>{{ $item->service->location_->name }}</td>
                    <td>{{ $item->cycle }} Months</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ date("Y-m-d H:i", $item->expires_at) }}</td>
                    <td>


                        @if ($item->transactions()->latest()->first()->status == 1)
                            <div class="badge badge-success">Paid</div>
                        @else
                            <div class="badge badge-warning">Unpaid</div>
                        @endif

                    </td>
                    <td>


                        @if ($item->service->status == 2)
                            <span class="badge bg-success">Active</span>
                        @elseif ($item->service->status == 5)
                            <span class="badge bg-warning">Proccessing</span>
                        @elseif ($item->service->status == 3)
                            <span class="badge bg-danger">Expired</span>
                        @elseif ($item->service->status == 4)
                            <span class="badge bg-danger">Canceled</span>
                        @else
                            <span class="badge bg-warning">not set</span>

                        @endif

                    </td>
                  

                </tr>
            @endforeach
        </tbody>
    </table>
</div>