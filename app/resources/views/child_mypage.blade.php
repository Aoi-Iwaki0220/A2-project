@extends('layouts.app')
@section('content')
    <div class="profile" style="display: flex; align-items: center;">
        @if (!empty($child->image))
            <img src="{{ asset($child->image) }}" alt="アイコン" style="width:20%; height:20%; border-radius:50%;">
        @else
            <img src="character1.png"  style="width:20%; height:20%; border-radius:50%;">
        @endif
        <div>
            <h4>ユーザー名</h4>
                <span>{{ $child->name ?? '未登録'}}</span>
            <h4>ニックネーム</h4>
                <span>{{ $child->nickname ?? '未登録'}}</span>
        </div>
        <div>
            <h4>プロフィール</h4>
                <span>{{ $child->profile ?? '未登録'}}</span>
        </div>
    </div>
        <div>
            <div>
                <button type="button" onclick="invitationCode()">しょうたいコードをつくる</button>
                <span id="invite-code" style="margin-left: 10px; background-color: #ccc; "></span>
            </div>

            <button type="button" onclick="location.href='{{ route('edit.child',)}}'">
            へんしゅうする
            </button>
    </div>
    <div style="background-color: #ccc; width: 200px; height: 200px; "></div>
    <div>
        <button type="button" onclick="location.href='{{ route('create.spend')}}'">
        つかったお金を <br>とうろくする
        </button>
        <button type="button" onclick="location.href='{{ route('create.income')}}'">
        もらったお金を <br>とうろくする
        </button>
    </div>
    <nav class="card mt-4">
        <div class="card-body">
            <h3>ほごしゃの じょうほう</h3>
            @if ($parent)
                @if (!empty($child->image))
                    <img src="{{ $parent->image ? asset($parent->image) : asset('default_icon.png') }}" alt="アイコン" style="width:20%; height:20%; border-radius:50%;">
                @else
                    <img src="character1.png"  style="width:45px; height: 45px; border-radius:50%;">
                @endif
                <p>ニックネーム: {{ $parent->nickname }}</p>
            @else
                <p>ほごしゃのじょうほうは ないよ</p>
            @endif
            <button type="button" onclick="location.href='{{ route('message.list')}}'">
                とどいたメッセージをみる
            </button>
        </div>
        </nav>
@endsection
@section('scripts')
        <script>
            function invitationCode() {
                fetch("{{ route('create.invitation') }}", {
                    method: "GET",
                    headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('invite-code').innerText = data.invite_code;
                    })
                    .catch(error => {
                    console.error("エラー:", error);
                    alert("招待コードの生成に失敗しました。");
                    });
            }
        </script>
@endsection

