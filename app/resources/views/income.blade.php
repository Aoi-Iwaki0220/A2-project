<main>
    <div>もらったお金</div>
    <form action="{{route('create.income')}}" method="post">
        @csrf
        <label for="date">いつ？</label>
            <input type='date' class='form-control' name='date' />
        <label for="amount">いくらもらった？</label>
            <input type='text' class='form-control' name='amount' />
        <label for="type">もらった りゆうは？</label>
            <select name='type_id' class='form-control'>
                <option value='' hidden>カテゴリ</option>
                @foreach($types as $type)
                    <option value="{{ $type['id'] }}">{{ $type['name'] }}</option>
                @endforeach
            </select>
        <label for='comment' class='mt-2'>メモ</label>
            <textarea class='form-control' name='comment' ></textarea>

        <button type="submit">とうろくする</button>
    </form>
</main>
