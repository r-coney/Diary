<h2>ユーザー登録</h2>

<form action='{{  route('userAccount.user.store') }}' method='post'>
    @csrf
    <div>
        <h3>名前</h3>
        <input type='text' name='name' />
    </div>
    <div>
        <h3>メールアドレス</h3>
        <input type='email' name='email' />
    </div>
    <div>
        <h3>パスワード</h3>
        <input type='password' name='password' />
    </div>
    <div>
        <h3>パスワード確認</h3>
        <input type='password' name='passwordConfirmation' />
    </div>
    <input type='submit' value='登録'>
</form>
