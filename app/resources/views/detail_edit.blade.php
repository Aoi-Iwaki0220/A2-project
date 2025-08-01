<main>
    <div>へんしゅうする</div>

    @if (isset($income_result))
    <form action="{{ route('edit.income', ['id' => $income_result->id ]) }}" method="post">
        @csrf
        <label for="date">いつ？</label>
            <input type='date' class='form-control' name='date' value="{{ old('date', $income_result->date) }}"/>
        <label for="amount">いくらもらった？</label>
            <input type='text' class='form-control' name='amount' value="{{ old('amount', $income_result->amount) }}"/>
        <label for="type">もらった りゆうは？</label>
            <select name='type_id' class='form-control'>
                <option value='' hidden>カテゴリ</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ (isset($income_result) && $income_result->type_id == $type->id) ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        <label for='comment' class='mt-2'>メモ</label>
            <textarea class='form-control' name='comment' >{{ old('comment', $income_result->comment) }}</textarea>
        <button type="submit">とうろくする</button>

    @elseif (isset($spend_result))
    <form action="{{ route('edit.spend', ['id' => $spend_result->id ]) }}" method="post">
        @csrf
        <label for="date">いつ？</label>
            <input type='date' class='form-control' name='date' value="{{ old('date', $spend_result->date) }}"/>
        <label for="amount">いくらつかった？</label>
            <input type='text' class='form-control' name='amount' value="{{ old('amount', $spend_result->amount) }}"/>
        <label for="type">なにをかった？</label>
            <select name='type_id' class='form-control'>
                <option value='' hidden>カテゴリ</option>
                @foreach($types as $type)
                    <option value="{{ $type->id }}" {{ (isset($spend_result) && $spend_result->type_id == $type->id) ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        <label for='comment' class='mt-2'>メモ</label>
            <textarea class='form-control' name='comment' >{{ old('comment', $spend_result->comment) }}</textarea>        
        <button type="submit">とうろくする</button>
    </form>
    @endif
</main>
