@extends('layouts.app')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5">
          <div class="card-header">アカウントをつくる</div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="name">おなまえ</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" />
                </div>
                <div class="form-group">
                    <label for="nickname">ニックネーム</label>
                    <input type="text" class="form-control" id="nickname" name="nickname" value="{{ old('nickname') }}" />
                </div>
                <div class="form-group">
                    <label for="mailaddress">メールアドレス</label>
                    <input type="text" class="form-control" id="mailaddress" name="mailaddress">
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="password-confirm">パスワード(かくにん)
                    </label>
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation">
                </div>
                <div>
                    <label>ユーザー区分</label>
                    <select name="user_type" required>
                        <option value="child">こども</option>
                        <option value="parent">保護者（ほごしゃ）</option>

                    </select>
                </div>
                <div class="text-right">
                <button type="submit" >つくる</button>
              </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection