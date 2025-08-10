@extends('layouts.app')
@section('content')
    <form action="{{ $type == 'child' ? route('edit.child') : route('edit.parent') }}" method="post">
        @csrf
        <div class="profile" style="display: flex; align-items: center;">
            <div>
                <img id="selected-icon" src="{{ asset($user->image ?? 'character1.png') }}" alt="アイコン" style="width:20%; height:20%; border-radius:50%;">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#iconModal">
                アイコンをえらぶ
            </button>
            </div>


            <!-- アイコンのパスを送信 -->
            <input type="hidden" id="icon-input" name="image" value="{{ old('image', $user->image) }}">
        
                <label>名前</label><br>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"><br>

                <label>ニックネーム</label><br>
                    <input type="text" name="nickname" value="{{ old('nickname', $user->nickname) }}"><br>

                <label>プロフィール</label><br>
                    <textarea name="profile">{{ old('profile', $user->profile) }}</textarea><br>
        </div>
        <button type="submit">とうろくする</button>
    </form>

    <div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="iconModalLabel">アイコンを えらんでね</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
      </div>
    <img src="{{ asset('icon1.jpg') }}"
            alt="アイコン1"
            style="width: 80px; height: 80px; border-radius: 50%; cursor: pointer;"
            onclick="selectIcon('{{ asset('icon1.jpg') }}', 'icon1.jpg')">
    <img src="{{ asset('icon2.jpg') }}"
            alt="アイコン2"
            style="width: 80px; height: 80px; border-radius: 50%; cursor: pointer;"
            onclick="selectIcon('{{ asset('icon2.jpg') }}', 'icon2.jpg')">
    <img src="{{ asset('icon3.jpg') }}"
            alt="アイコン3"
            style="width: 80px; height: 80px; border-radius: 50%; cursor: pointer;"
            onclick="selectIcon('{{ asset('icon3.jpg') }}', 'icon3.jpg')">
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">とじる</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function selectIcon(iconUrl, iconPath) {
        document.getElementById('selected-icon').src = iconUrl;
        document.getElementById('icon-input').value = iconPath;
        const modal = bootstrap.Modal.getInstance(document.getElementById('iconModal'));
        modal.hide();
    }
    
</script>
@endsection
