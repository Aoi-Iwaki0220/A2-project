
<main>
    <div>こどもと繋がる</div>
    <h4>こどもと繋ぐための招待コードを入力してください。</h4>
    <h5>招待コードはこどものマイページから発行できます。</h5>
    <form action="{{route('invitation')}}" method="POST" onsubmit="return confirm('〇〇と繋がります。よろしいですか？')">
        @csrf
        <label for="text">招待コードを入力</label>
            <input type='text' class='form-control' name='date' />
        <button type="submit">繋ぐ</button>
    </form>
</main>
