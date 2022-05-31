# hauntpet/auth

Add the ability to authenticate using HauntID.

## Documentation
### Installation
```bash
composer require hauntpet/auth
```

### Register
```php
use HauntPet\Auth\Facades\HauntID;

$data = [
    'email' => $request->email,
    'password' => $request->password,
    'username' => $request->username,
    'birthday' => $request->birthday,
];
$response = HauntID::register($data);

if($response->ok()) {
    User::create(array_merge($data, [
        'haunt_id' => $response->json()['id'],
    ]));
}
```

### Login
```php
use HauntPet\Auth\Facades\HauntID;

$data = [
    'email' => $request->email,
    'password' => $request->password,
];
$response = HauntID::login($data);

if($response->ok()) {
    $user = User::where('haunt_id', '=', $response->json()['id'])->first();
}
```
