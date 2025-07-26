<main>
    <div>もくひょうをかえる？けす？</div>
    <form action="{{ route('edit.goal', ['id' => $result->id])}}" method="post">
        @csrf
        <label for="date">いつ？</label>
            <input type='date' class='form-control' name='date'  value="{{$result['date']}}"/>までに
        <label for="amount">いくら？</label>
            <input type='text' class='form-control' name='amount' value="{{$result['amount']}}"/>ためる！

        <button type="submit">かえる</button>
    </form>
</main>