@extends('layouts.app')

@section('content')
<h4>管理者用操作履歴検索</h4>

    <form method="GET" action="{{ route('search.userhistory') }}" class="mb-4">
            <div class="form-group">
                <label>ユーザー名</label>
                <input type="text" name="name" class="form-control" value="{{ $request->name }}">
            </div>

            <div class="form-group">
                <label>登録日（開始）</label>
                <input type="date" name="start_date" class="form-control" value="{{ $request->start_date }}">
            </div>

            <div class="form-group">
                <label>登録日（終了）</label>
                <input type="date" name="end_date" class="form-control" value="{{ $request->end_date }}">
            </div>

            <div class="form-group">
                <label>並び順</label>
                <select name="sort" class="form-control">
                    <option value="asc" {{ $request->sort === 'asc' ? 'selected' : '' }}>登録日（昇順）</option>
                    <option value="desc" {{ $request->sort === 'desc' ? 'selected' : '' }}>登録日（降順）</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">検索</button>
    </form>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>ユーザー名</th>
            <th>対象</th>
            <th>内容</th>
            <th>登録日</th>

        </tr>
        @foreach ($histories as $history)
        <tr>
            <td>{{ $history->id }}</td>
            <td>{{ $history->user_name }}</td>
            <td>{{ $history->action }}</td>
            <td>{{ $history->amount }}</td>
            <td>{{ \Carbon\Carbon::parse($history->created_at)->format('Y-m-d') }}</td>
        </tr>
        @endforeach
    </table>
    <nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item {{ $histories->onFirstPage() ? 'disabled' : '' }}">
        <a class="page-link" href="{{ $histories->previousPageUrl() ? $histories->previousPageUrl() . '&' . http_build_query(request()->except('page')) : '#' }}" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
        </a>
        </li>
            @php
                $start = max($histories->currentPage() - 2, 1);
                $end = min($start + 4, $histories->lastPage());
            @endphp
            @for ($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $histories->currentPage() == $i ? 'active' : '' }}">
                    <a class="page-link" href="{{ $histories->url($i) . '&' . http_build_query(request()->except('page')) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item {{ $histories->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $histories->nextPageUrl() ? $histories->nextPageUrl() . '&' . http_build_query(request()->except('page')) : '#' }}" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
    </ul>
    </nav>

@endsection