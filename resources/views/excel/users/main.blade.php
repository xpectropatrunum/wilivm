<div class="table-responsive">
    <table class="table table-striped table-bordered mb-0 text-nowrap">
        <thead>
            <tr>
                <th>#</th>
                <th>Fullname</th>
                <th>Email</th>
                <th>Verified</th>
                <th>Enabled</th>
                <th>Created time</th>


            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        {{ $item->first_name }} {{ $item->last_name }}
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>

                        @if ($item->verified)
                            Yes
                        @else
                            No
                        @endif

                    </td>

                    <td>
                        @if ($item->status)
                            Yes
                        @else
                            No
                        @endif

                    </td>

                    <td>{{ $item->created_at }}</td>


                </tr>
            @endforeach
        </tbody>
    </table>
</div>
