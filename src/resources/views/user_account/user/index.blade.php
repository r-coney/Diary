<h2>ユーザ一覧</h2>

@foreach ($userList as $user)
    {{ $user->name }}
    {{ $user->email }}
    <a href="{{ route('userAccount.user.detail', ['id' => $user->id]) }}">詳細</a>
@endforeach
