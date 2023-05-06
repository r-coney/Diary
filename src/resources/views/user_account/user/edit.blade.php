<h2>日記編集</h2>

<form action='{{ route('userAccount.user.update', ['id' => $userData->id]) }}' method='post'>
    @method('PUT')
    @csrf
    <div>
        <h3>名前</h3>
        <input type='text' name='newName' value='{{ $userData->name }}'/>
    </div>
    <div>
        <h3>メールアドレス</h3>
        <input type='email' name='newEmail' value='{{ $userData->email }}' />
    </div>
    <div>
        <h3>パスワード</h3>
        <input type='password' name='newPassword' />
    </div>
    <div>
        <h3>パスワード確認</h3>
        <input type='password' name='newPasswordConfirmation' />
    </div>
    <div>
        <h3>現在のパスワード</h3>
        <input type='password' name='currentPassword' />
    </div>
    <input type='submit' value='編集'>
</form>