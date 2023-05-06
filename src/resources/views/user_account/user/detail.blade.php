<h2>ユーザー詳細</h2>

<h3>名前</h3>
{{ $userData->name }}

<h3>メールアドレス</h3>
{{ $userData->email }}

<h3>登録日時</h3>
{{ $userData->registeredDateTime }}

<form action='{{ route('userAccount.user.delete', ['id' => $userData->id]) }}' method='post'>
    @method('DELETE')
    @csrf
    <input type="submit" value='削除'>
</form>