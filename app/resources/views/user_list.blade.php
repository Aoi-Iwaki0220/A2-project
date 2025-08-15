@extends('layouts.app')

@section('content')
<h4>管理者用ユーザー検索</h4>

    <form method="GET" action="{{ route('search.user') }}" class="mb-4">
        @csrf
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
            <th>区分</th>
            <th>登録日</th>
            <th>紐づく相手</th>
        </tr>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user instanceof App\Models\UserParent ? '保護者' : 'こども' }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                @if ($user instanceof App\Models\UserParent)
                    {{ $user->child ? $user->child->name : '未紐づけ' }}
                @elseif ($user instanceof App\Models\Child)
                    {{ $user->parent ? $user->parent->name : '未紐づけ' }}
                @endif
            </td>
            </tr>
        @endforeach
    </table>
@endsection