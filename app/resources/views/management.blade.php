@extends('layouts.app')

@section('content')
    <main>
        
        <div class="card w-50">
            <h4>管理者用ホーム</h4>
                <button type="button" class="btn btn-primary" onclick="location.href='{{route('search.user')}}'">
                    ユーザー検索
                </button>
                <button type="button" onclick="location.href='{{route('search.userhistory')}}'">
                    操作履歴検索
                </button>
        </div>
    
    </main>
@endsection