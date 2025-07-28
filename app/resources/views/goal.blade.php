
<main>
    <div>もくひょうをきめよう</div>
    <form action="{{ route('create.goal')}}" method="post">
        @csrf
        <label for="date">いつ？</label>
            <input type='date' class='form-control' name='date' />までに
        <label for="amount">いくら？</label>
            <input type='text' class='form-control' name='amount' />円 ためる！

        <button type="submit">きめた</button>
    </form>
</main>
