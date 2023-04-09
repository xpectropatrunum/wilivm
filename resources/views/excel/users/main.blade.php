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
                        <div class="form-check">
                            <input type="checkbox"
                                data-url="{{ route('admin.users.verify', $item->id) }}"
                                data-id="{{ $item->id }}" class="form-check-input changeStatus3"
                                id="exampleCheck{{ $item->id }}"
                                @if ($item->verified) checked @endif>
                            <label class="form-check-label" for="exampleCheck{{ $item->id }}">
                                enable</label>
                        </div>
                    </td>

                    <td>
                        <div class="form-check">
                            <input type="checkbox"
                                data-url="{{ route('admin.users.status', $item->id) }}"
                                data-id="{{ $item->id }}" class="form-check-input changeStatus2"
                                id="exampleCheck2{{ $item->id }}"
                                @if ($item->status) checked @endif>
                            <label class="form-check-label" for="exampleCheck2{{ $item->id }}">
                                enable</label>
                        </div>
                    </td>

                    <td>{{ $item->created_at }}</td>
                 

                </tr>
            @endforeach
        </tbody>
    </table>
</div>