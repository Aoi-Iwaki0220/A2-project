@extends('layouts.app')
@section('content')
    <div class="profile" style="display: flex; align-items: center;">
        <div style="border-radius: 50%; background-color: #ccc; width: 80px; height: 80px; "></div>
        <div>
            <h4>ユーザー名</h4>
                <span style="color:#eee;">未登録</span>
            <h4>ニックネーム</h4>
                <span style="color:#eee;">未登録</span>
        </div>
        <div>
            <h4>プロフィール</h4>
                <span style="color:#eee;">未登録</span>
        </div>
    </div>
        <div>
            <div>
                <button type="button" onclick="invitationCode()">しょうたいコードをつくる</button>
                <span id="invite-code" style="margin-left: 10px; background-color: #ccc; "></span>
            </div>

        <a href="">
            <button type="button">へんしゅうする</button>
        </a>
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
@endsection
@section('scripts')
        <script>
            function invitationCode() {
                fetch("{{ route('create.invitation') }}", {
                    method: "GET",
                    headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": '{{ csrf_token() }}'
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

