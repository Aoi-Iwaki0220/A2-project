@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col col-md-offset-3 col-md-6">
        <nav class="card mt-5">
          <div class="card-header">ログイン</div>
          <div class="card-body">
            @if($errors->any())
              <div class="alert alert-danger">
                @foreach($errors->all() as $message)
                  <p>{{ $message }}</p>
                @endforeach
              </div>
            @endif
            <form action="{{ route('login') }}" method="POST">
              @csrf
                <div class="form-group">
                    <label for="mailaddress">メールアドレス</label>
                    <input type="text" class="form-control" id="mailaddress" name="mailaddress" value="{{ old('mailaddress') }}" />
                </div>
                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" class="form-control" id="password" name="password" />
                </div>
                <div class="text-center">
                    <a href="">パスワードをわすれたひとはこちら</a>
                </div>
                <div>
                    <label>ユーザー区分</label>
                    <select name="user_type" required>
                        <option value="parent">保護者）（ほごしゃ）</option>
                        <option value="child">こども</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit" >ログイン</button>
                </div>
                <div class="text-center">
                    <a href="{{ route('register') }}">はじめてのひとはこちら</a>
                </div>
            </form>
          </div>
        </nav>
      </div>
    </div>
  </div>
@endsection